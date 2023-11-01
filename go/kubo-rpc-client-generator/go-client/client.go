package kubo

import (
	"errors"
	"fmt"
	"net/http"
	"os"
	"path/filepath"
	"strings"

	"github.com/mitchellh/go-homedir"
	ma "github.com/multiformats/go-multiaddr"
	manet "github.com/multiformats/go-multiaddr/net"
)

const (
	DefaultPathName = ".ipfs"
	DefaultPathRoot = "~/" + DefaultPathName
	DefaultApiFile  = "api"
	EnvDir          = "IPFS_PATH"
)

// ErrApiNotFound if we fail to find a running daemon.
var ErrApiNotFound = errors.New("ipfs api address could not be found")

type Client struct {
	url         string
	httpcli     http.Client
	Headers     http.Header
	applyGlobal func(*requestBuilder)
}

// NewLocalClient constructs a new Client instance that communicates with the
// local IPFS Daemon. The daemon API address is pulled from $IPFS_PATH/api file.
// If $IPFS_PATH is not present, it defaults to ~/.ipfs
func NewLocalClient() (*Client, error) {
	baseDir := os.Getenv(EnvDir)
	if baseDir == "" {
		baseDir = DefaultPathRoot
	}

	return NewPathClient(baseDir)
}

// NewPathClient constructs a new Client instance by pulling the daemon API
// address from the specified ipfsPath. API file should be located at
// $ipfsPath/api
func NewPathClient(ipfsPath string) (*Client, error) {
	a, err := ReadApiAddress(ipfsPath)
	if err != nil {
		if os.IsNotExist(err) {
			err = ErrApiNotFound
		}
		return nil, err
	}
	return NewClient(a)
}

// ReadApiAddress reads the API file inside the specified ipfsPath.
func ReadApiAddress(ipfsPath string) (ma.Multiaddr, error) {
	baseDir, err := homedir.Expand(ipfsPath)
	if err != nil {
		return nil, err
	}

	apiFile := filepath.Join(baseDir, DefaultApiFile)

	api, err := os.ReadFile(apiFile)
	if err != nil {
		return nil, err
	}

	return ma.NewMultiaddr(strings.TrimSpace(string(api)))
}

// NewClient constructs a new Client instance with the specified endpoint.
func NewClient(a ma.Multiaddr) (*Client, error) {
	c := &http.Client{
		Transport: &http.Transport{
			Proxy:             http.ProxyFromEnvironment,
			DisableKeepAlives: true,
		},
	}

	return NewClientWithHTTP(a, c)
}

// NewClientWithHTTP constructs a new client instance with the specified endpoint
// and a custom HTTP client.
func NewClientWithHTTP(a ma.Multiaddr, c *http.Client) (*Client, error) {
	_, url, err := manet.DialArgs(a)
	if err != nil {
		return nil, err
	}

	if a, err := ma.NewMultiaddr(url); err == nil {
		_, host, err := manet.DialArgs(a)
		if err == nil {
			url = host
		}
	}

	return NewURLClientWithHTTP(url, c)
}

func NewURLClientWithHTTP(url string, c *http.Client) (*Client, error) {
	api := &Client{
		url:         url,
		httpcli:     *c,
		Headers:     make(map[string][]string),
		applyGlobal: func(*requestBuilder) {},
	}

	// We don't support redirects.
	api.httpcli.CheckRedirect = func(_ *http.Request, _ []*http.Request) error {
		return fmt.Errorf("unexpected redirect")
	}
	return api, nil
}

func (api *Client) Request(command string, args ...string) RequestBuilder {
	headers := make(map[string]string)
	if api.Headers != nil {
		for k := range api.Headers {
			headers[k] = api.Headers.Get(k)
		}
	}
	return &requestBuilder{
		command: command,
		args:    args,
		shell:   api,
		headers: headers,
	}
}
