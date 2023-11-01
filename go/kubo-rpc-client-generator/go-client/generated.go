package kubo

import (
	"context"
	"io"
	
	files "github.com/ipfs/go-ipfs-files"
)

type AddSettings struct {
	// Add directory paths recursively.
	Recursive bool
	// Symlinks supplied in arguments are dereferenced.
	DereferenceArgs bool
	// Assign a name if the file source is stdin.
	StdinName string
	// Include files that are hidden. Only takes effect on recursive add.
	Hidden bool
	// A rule (.gitignore-stype) defining which file(s) should be ignored (variadic, experimental).
	Ignore []string
	// A path to a file with .gitignore-style ignore rules (experimental).
	IgnoreRulesPath string
	// Write minimal output.
	Quiet bool
	// Write only final hash.
	Quieter bool
	// Write no output.
	Silent bool
	// Stream progress data.
	Progress bool
	// Use trickle-dag format for dag generation.
	Trickle bool
	// Only chunk and hash - do not write to disk.
	OnlyHash bool
	// Wrap files with a directory object.
	WrapWithDirectory bool
	// Chunking algorithm, size-[bytes], rabin-[min]-[avg]-[max] or buzhash. Default: size-262144.
	Chunker string
	// Use raw blocks for leaf nodes.
	RawLeaves bool
	// Add the file using filestore. Implies raw-leaves. (experimental).
	Nocopy bool
	// Check the filestore for pre-existing blocks. (experimental).
	Fscache bool
	// CID version. Defaults to 0 unless an option that depends on CIDv1 is passed. Passing version 1 will cause the raw-leaves option to default to true.
	CidVersion int
	// Hash function to use. Implies CIDv1 if not sha2-256. (experimental). Default: sha2-256.
	Hash string
	// Inline small blocks into CIDs. (experimental).
	Inline bool
	// Maximum block size to inline. (experimental). Default: 32.
	InlineLimit int
	// Pin locally to protect added files from garbage collection. Default: true.
	Pin bool
	// Add reference to Files API (MFS) at the provided path.
	ToFiles string
}

type AddOption func(*AddSettings) error

func AddOptions(options ...AddOption) (*AddSettings, error) {
	settings := &AddSettings{
		Chunker: `size-262144`,
		Hash: `sha2-256`,
		InlineLimit: 32,
		Pin: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Add(ctx context.Context, f files.Node, options ...AddOption) ([]byte, error) {
	settings, err := AddOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("add")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	req.Option("recursive", settings.Recursive)
	req.Option("dereference-args", settings.DereferenceArgs)
	req.Option("stdin-name", settings.StdinName)
	req.Option("hidden", settings.Hidden)
	req.Option("ignore", settings.Ignore)
	req.Option("ignore-rules-path", settings.IgnoreRulesPath)
	req.Option("quiet", settings.Quiet)
	req.Option("quieter", settings.Quieter)
	req.Option("silent", settings.Silent)
	req.Option("progress", settings.Progress)
	req.Option("trickle", settings.Trickle)
	req.Option("only-hash", settings.OnlyHash)
	req.Option("wrap-with-directory", settings.WrapWithDirectory)
	req.Option("chunker", settings.Chunker)
	req.Option("raw-leaves", settings.RawLeaves)
	req.Option("nocopy", settings.Nocopy)
	req.Option("fscache", settings.Fscache)
	req.Option("cid-version", settings.CidVersion)
	req.Option("hash", settings.Hash)
	req.Option("inline", settings.Inline)
	req.Option("inline-limit", settings.InlineLimit)
	req.Option("pin", settings.Pin)
	req.Option("to-files", settings.ToFiles)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) BitswapLedger(ctx context.Context, peer string) ([]byte, error) {
	req := c.Request("bitswap/ledger")
	req.Arguments(peer)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) BitswapReprovide(ctx context.Context) ([]byte, error) {
	req := c.Request("bitswap/reprovide")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type BitswapStatSettings struct {
	// Print extra information.
	Verbose bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

type BitswapStatOption func(*BitswapStatSettings) error

func BitswapStatOptions(options ...BitswapStatOption) (*BitswapStatSettings, error) {
	settings := &BitswapStatSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) BitswapStat(ctx context.Context, options ...BitswapStatOption) ([]byte, error) {
	settings, err := BitswapStatOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("bitswap/stat")
	req.Option("verbose", settings.Verbose)
	req.Option("human", settings.Human)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type BitswapWantlistSettings struct {
	// Specify which peer to show wantlist for. Default: self.
	Peer string
}

type BitswapWantlistOption func(*BitswapWantlistSettings) error

func BitswapWantlistOptions(options ...BitswapWantlistOption) (*BitswapWantlistSettings, error) {
	settings := &BitswapWantlistSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) BitswapWantlist(ctx context.Context, options ...BitswapWantlistOption) ([]byte, error) {
	settings, err := BitswapWantlistOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("bitswap/wantlist")
	req.Option("peer", settings.Peer)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) BlockGet(ctx context.Context, cid string) ([]byte, error) {
	req := c.Request("block/get")
	req.Arguments(cid)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type BlockPutSettings struct {
	// Multicodec to use in returned CID. Default: raw.
	CidCodec string
	// Multihash hash function. Default: sha2-256.
	Mhtype string
	// Multihash hash length. Default: -1.
	Mhlen int
	// Pin added blocks recursively. Default: false.
	Pin bool
	// Disable block size check and allow creation of blocks bigger than 1MiB. WARNING: such blocks won't be transferable over the standard bitswap. Default: false.
	AllowBigBlock bool
	// Use legacy format for returned CID (DEPRECATED).
	Format string
}

type BlockPutOption func(*BlockPutSettings) error

func BlockPutOptions(options ...BlockPutOption) (*BlockPutSettings, error) {
	settings := &BlockPutSettings{
		CidCodec: `raw`,
		Mhtype: `sha2-256`,
		Mhlen: -1,
		Pin: false,
		AllowBigBlock: false,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) BlockPut(ctx context.Context, f files.Node, options ...BlockPutOption) ([]byte, error) {
	settings, err := BlockPutOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("block/put")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	req.Option("cid-codec", settings.CidCodec)
	req.Option("mhtype", settings.Mhtype)
	req.Option("mhlen", settings.Mhlen)
	req.Option("pin", settings.Pin)
	req.Option("allow-big-block", settings.AllowBigBlock)
	req.Option("format", settings.Format)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type BlockRmSettings struct {
	// Ignore nonexistent blocks.
	Force bool
	// Write minimal output.
	Quiet bool
}

type BlockRmOption func(*BlockRmSettings) error

func BlockRmOptions(options ...BlockRmOption) (*BlockRmSettings, error) {
	settings := &BlockRmSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) BlockRm(ctx context.Context, cid []string, options ...BlockRmOption) ([]byte, error) {
	settings, err := BlockRmOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("block/rm")
	req.Arguments(cid...)
	req.Option("force", settings.Force)
	req.Option("quiet", settings.Quiet)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) BlockStat(ctx context.Context, cid string) ([]byte, error) {
	req := c.Request("block/stat")
	req.Arguments(cid)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) Bootstrap(ctx context.Context) ([]byte, error) {
	req := c.Request("bootstrap")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type BootstrapAddSettings struct {
	// Add default bootstrap nodes. (Deprecated, use 'default' subcommand instead).
	Default bool
}

type BootstrapAddOption func(*BootstrapAddSettings) error

func BootstrapAddOptions(options ...BootstrapAddOption) (*BootstrapAddSettings, error) {
	settings := &BootstrapAddSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) BootstrapAdd(ctx context.Context, peer []string, options ...BootstrapAddOption) ([]byte, error) {
	settings, err := BootstrapAddOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("bootstrap/add")
	req.Arguments(peer...)
	req.Option("default", settings.Default)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) BootstrapAddDefault(ctx context.Context) ([]byte, error) {
	req := c.Request("bootstrap/add/default")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) BootstrapList(ctx context.Context) ([]byte, error) {
	req := c.Request("bootstrap/list")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type BootstrapRmSettings struct {
	// Remove all bootstrap peers. (Deprecated, use 'all' subcommand).
	All bool
}

type BootstrapRmOption func(*BootstrapRmSettings) error

func BootstrapRmOptions(options ...BootstrapRmOption) (*BootstrapRmSettings, error) {
	settings := &BootstrapRmSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) BootstrapRm(ctx context.Context, peer []string, options ...BootstrapRmOption) ([]byte, error) {
	settings, err := BootstrapRmOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("bootstrap/rm")
	req.Arguments(peer...)
	req.Option("all", settings.All)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) BootstrapRmAll(ctx context.Context) ([]byte, error) {
	req := c.Request("bootstrap/rm/all")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type CatSettings struct {
	// Byte offset to begin reading from.
	Offset int64
	// Maximum number of bytes to read.
	Length int64
	// Stream progress data. Default: true.
	Progress bool
}

type CatOption func(*CatSettings) error

func CatOptions(options ...CatOption) (*CatSettings, error) {
	settings := &CatSettings{
		Progress: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Cat(ctx context.Context, ipfsPath []string, options ...CatOption) ([]byte, error) {
	settings, err := CatOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("cat")
	req.Arguments(ipfsPath...)
	req.Option("offset", settings.Offset)
	req.Option("length", settings.Length)
	req.Option("progress", settings.Progress)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) CidBase32(ctx context.Context, cid []string) ([]byte, error) {
	req := c.Request("cid/base32")
	req.Arguments(cid...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type CidBasesSettings struct {
	// also include the single letter prefixes in addition to the code.
	Prefix bool
	// also include numeric codes.
	Numeric bool
}

type CidBasesOption func(*CidBasesSettings) error

func CidBasesOptions(options ...CidBasesOption) (*CidBasesSettings, error) {
	settings := &CidBasesSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) CidBases(ctx context.Context, options ...CidBasesOption) ([]byte, error) {
	settings, err := CidBasesOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("cid/bases")
	req.Option("prefix", settings.Prefix)
	req.Option("numeric", settings.Numeric)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type CidCodecsSettings struct {
	// also include numeric codes.
	Numeric bool
	// list only codecs supported by go-ipfs commands.
	Supported bool
}

type CidCodecsOption func(*CidCodecsSettings) error

func CidCodecsOptions(options ...CidCodecsOption) (*CidCodecsSettings, error) {
	settings := &CidCodecsSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) CidCodecs(ctx context.Context, options ...CidCodecsOption) ([]byte, error) {
	settings, err := CidCodecsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("cid/codecs")
	req.Option("numeric", settings.Numeric)
	req.Option("supported", settings.Supported)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type CidFormatSettings struct {
	// Printf style format string. Default: %s.
	F string
	// CID version to convert to.
	V string
	// CID multicodec to convert to.
	Mc string
	// Multibase to display CID in.
	B string
}

type CidFormatOption func(*CidFormatSettings) error

func CidFormatOptions(options ...CidFormatOption) (*CidFormatSettings, error) {
	settings := &CidFormatSettings{
		F: `%s`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) CidFormat(ctx context.Context, cid []string, options ...CidFormatOption) ([]byte, error) {
	settings, err := CidFormatOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("cid/format")
	req.Arguments(cid...)
	req.Option("f", settings.F)
	req.Option("v", settings.V)
	req.Option("mc", settings.Mc)
	req.Option("b", settings.B)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type CidHashesSettings struct {
	// also include numeric codes.
	Numeric bool
	// list only codecs supported by go-ipfs commands.
	Supported bool
}

type CidHashesOption func(*CidHashesSettings) error

func CidHashesOptions(options ...CidHashesOption) (*CidHashesSettings, error) {
	settings := &CidHashesSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) CidHashes(ctx context.Context, options ...CidHashesOption) ([]byte, error) {
	settings, err := CidHashesOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("cid/hashes")
	req.Option("numeric", settings.Numeric)
	req.Option("supported", settings.Supported)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type CommandsSettings struct {
	// Show command flags.
	Flags bool
}

type CommandsOption func(*CommandsSettings) error

func CommandsOptions(options ...CommandsOption) (*CommandsSettings, error) {
	settings := &CommandsSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Commands(ctx context.Context, options ...CommandsOption) ([]byte, error) {
	settings, err := CommandsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("commands")
	req.Option("flags", settings.Flags)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) CommandsCompletionBash(ctx context.Context) ([]byte, error) {
	req := c.Request("commands/completion/bash")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) CommandsCompletionFish(ctx context.Context) ([]byte, error) {
	req := c.Request("commands/completion/fish")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type ConfigSettings struct {
	// Set a boolean value.
	Bool bool
	// Parse stringified JSON.
	Json bool
}

type ConfigOption func(*ConfigSettings) error

func ConfigOptions(options ...ConfigOption) (*ConfigSettings, error) {
	settings := &ConfigSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Config(ctx context.Context, key string, value string, options ...ConfigOption) ([]byte, error) {
	settings, err := ConfigOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("config")
	req.Arguments(key)
	req.Arguments(value)
	req.Option("bool", settings.Bool)
	req.Option("json", settings.Json)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) ConfigEdit(ctx context.Context) ([]byte, error) {
	req := c.Request("config/edit")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type ConfigProfileApplySettings struct {
	// print difference between the current config and the config that would be generated.
	DryRun bool
}

type ConfigProfileApplyOption func(*ConfigProfileApplySettings) error

func ConfigProfileApplyOptions(options ...ConfigProfileApplyOption) (*ConfigProfileApplySettings, error) {
	settings := &ConfigProfileApplySettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) ConfigProfileApply(ctx context.Context, profile string, options ...ConfigProfileApplyOption) ([]byte, error) {
	settings, err := ConfigProfileApplyOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("config/profile/apply")
	req.Arguments(profile)
	req.Option("dry-run", settings.DryRun)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) ConfigReplace(ctx context.Context, f io.Reader) ([]byte, error) {
	req := c.Request("config/replace")
	req.FileBody(f)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) ConfigShow(ctx context.Context) ([]byte, error) {
	req := c.Request("config/show")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DagExportSettings struct {
	// Display progress on CLI. Defaults to true when STDERR is a TTY.
	Progress bool
}

type DagExportOption func(*DagExportSettings) error

func DagExportOptions(options ...DagExportOption) (*DagExportSettings, error) {
	settings := &DagExportSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DagExport(ctx context.Context, root string, options ...DagExportOption) ([]byte, error) {
	settings, err := DagExportOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("dag/export")
	req.Arguments(root)
	req.Option("progress", settings.Progress)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DagGetSettings struct {
	// Format that the object will be encoded as. Default: dag-json.
	OutputCodec string
}

type DagGetOption func(*DagGetSettings) error

func DagGetOptions(options ...DagGetOption) (*DagGetSettings, error) {
	settings := &DagGetSettings{
		OutputCodec: `dag-json`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DagGet(ctx context.Context, ref string, options ...DagGetOption) ([]byte, error) {
	settings, err := DagGetOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("dag/get")
	req.Arguments(ref)
	req.Option("output-codec", settings.OutputCodec)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DagImportSettings struct {
	// Pin optional roots listed in the .car headers after importing. Default: true.
	PinRoots bool
	// No output.
	Silent bool
	// Output stats.
	Stats bool
	// Disable block size check and allow creation of blocks bigger than 1MiB. WARNING: such blocks won't be transferable over the standard bitswap. Default: false.
	AllowBigBlock bool
}

type DagImportOption func(*DagImportSettings) error

func DagImportOptions(options ...DagImportOption) (*DagImportSettings, error) {
	settings := &DagImportSettings{
		PinRoots: true,
		AllowBigBlock: false,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DagImport(ctx context.Context, f files.Node, options ...DagImportOption) ([]byte, error) {
	settings, err := DagImportOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("dag/import")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	req.Option("pin-roots", settings.PinRoots)
	req.Option("silent", settings.Silent)
	req.Option("stats", settings.Stats)
	req.Option("allow-big-block", settings.AllowBigBlock)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DagPutSettings struct {
	// Codec that the stored object will be encoded with. Default: dag-cbor.
	StoreCodec string
	// Codec that the input object is encoded in. Default: dag-json.
	InputCodec string
	// Pin this object when adding.
	Pin bool
	// Hash function to use. Default: sha2-256.
	Hash string
	// Disable block size check and allow creation of blocks bigger than 1MiB. WARNING: such blocks won't be transferable over the standard bitswap. Default: false.
	AllowBigBlock bool
}

type DagPutOption func(*DagPutSettings) error

func DagPutOptions(options ...DagPutOption) (*DagPutSettings, error) {
	settings := &DagPutSettings{
		StoreCodec: `dag-cbor`,
		InputCodec: `dag-json`,
		Hash: `sha2-256`,
		AllowBigBlock: false,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DagPut(ctx context.Context, f files.Node, options ...DagPutOption) ([]byte, error) {
	settings, err := DagPutOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("dag/put")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	req.Option("store-codec", settings.StoreCodec)
	req.Option("input-codec", settings.InputCodec)
	req.Option("pin", settings.Pin)
	req.Option("hash", settings.Hash)
	req.Option("allow-big-block", settings.AllowBigBlock)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) DagResolve(ctx context.Context, ref string) ([]byte, error) {
	req := c.Request("dag/resolve")
	req.Arguments(ref)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DagStatSettings struct {
	// Return progressive data while reading through the DAG. Default: true.
	Progress bool
}

type DagStatOption func(*DagStatSettings) error

func DagStatOptions(options ...DagStatOption) (*DagStatSettings, error) {
	settings := &DagStatSettings{
		Progress: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DagStat(ctx context.Context, root string, options ...DagStatOption) ([]byte, error) {
	settings, err := DagStatOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("dag/stat")
	req.Arguments(root)
	req.Option("progress", settings.Progress)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DhtQuerySettings struct {
	// Print extra information.
	Verbose bool
}

type DhtQueryOption func(*DhtQuerySettings) error

func DhtQueryOptions(options ...DhtQueryOption) (*DhtQuerySettings, error) {
	settings := &DhtQuerySettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DhtQuery(ctx context.Context, peerid []string, options ...DhtQueryOption) ([]byte, error) {
	settings, err := DhtQueryOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("dht/query")
	req.Arguments(peerid...)
	req.Option("verbose", settings.Verbose)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DiagCmdsSettings struct {
	// Print extra information.
	Verbose bool
}

type DiagCmdsOption func(*DiagCmdsSettings) error

func DiagCmdsOptions(options ...DiagCmdsOption) (*DiagCmdsSettings, error) {
	settings := &DiagCmdsSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DiagCmds(ctx context.Context, options ...DiagCmdsOption) ([]byte, error) {
	settings, err := DiagCmdsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("diag/cmds")
	req.Option("verbose", settings.Verbose)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) DiagCmdsClear(ctx context.Context) ([]byte, error) {
	req := c.Request("diag/cmds/clear")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) DiagCmdsSetTime(ctx context.Context, time string) ([]byte, error) {
	req := c.Request("diag/cmds/set-time")
	req.Arguments(time)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type DiagProfileSettings struct {
	// The path where the output .zip should be stored. Default: ./ipfs-profile-[timestamp].zip.
	Output string
	// The list of collectors to use for collecting diagnostic data. Default: [goroutines-stack goroutines-pprof version heap bin cpu mutex block].
	Collectors []string
	// The amount of time spent profiling. If this is set to 0, then sampling profiles are skipped. Default: 30s.
	ProfileTime string
	// The fraction 1/n of mutex contention events that are reported in the mutex profile. Default: 4.
	MutexProfileFraction int
	// The duration to wait between sampling goroutine-blocking events for the blocking profile. Default: 1ms.
	BlockProfileRate string
}

type DiagProfileOption func(*DiagProfileSettings) error

func DiagProfileOptions(options ...DiagProfileOption) (*DiagProfileSettings, error) {
	settings := &DiagProfileSettings{
		Collectors: []string{"goroutines-stack", "goroutines-pprof", "version", "heap", "bin", "cpu", "mutex", "block"},
		ProfileTime: `30s`,
		MutexProfileFraction: 4,
		BlockProfileRate: `1ms`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) DiagProfile(ctx context.Context, options ...DiagProfileOption) ([]byte, error) {
	settings, err := DiagProfileOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("diag/profile")
	req.Option("output", settings.Output)
	req.Option("collectors", settings.Collectors)
	req.Option("profile-time", settings.ProfileTime)
	req.Option("mutex-profile-fraction", settings.MutexProfileFraction)
	req.Option("block-profile-rate", settings.BlockProfileRate)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) DiagSys(ctx context.Context) ([]byte, error) {
	req := c.Request("diag/sys")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesChcidSettings struct {
	// Cid version to use. (experimental).
	CidVersion int
	// Hash function to use. Will set Cid version to 1 if used. (experimental).
	Hash string
}

type FilesChcidOption func(*FilesChcidSettings) error

func FilesChcidOptions(options ...FilesChcidOption) (*FilesChcidSettings, error) {
	settings := &FilesChcidSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesChcid(ctx context.Context, path string, options ...FilesChcidOption) ([]byte, error) {
	settings, err := FilesChcidOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/chcid")
	req.Arguments(path)
	req.Option("cid-version", settings.CidVersion)
	req.Option("hash", settings.Hash)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesCpSettings struct {
	// Make parent directories as needed.
	Parents bool
}

type FilesCpOption func(*FilesCpSettings) error

func FilesCpOptions(options ...FilesCpOption) (*FilesCpSettings, error) {
	settings := &FilesCpSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesCp(ctx context.Context, source string, dest string, options ...FilesCpOption) ([]byte, error) {
	settings, err := FilesCpOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/cp")
	req.Arguments(source)
	req.Arguments(dest)
	req.Option("parents", settings.Parents)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) FilesFlush(ctx context.Context, path string) ([]byte, error) {
	req := c.Request("files/flush")
	req.Arguments(path)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesLsSettings struct {
	// Use long listing format.
	Long bool
	// Do not sort; list entries in directory order.
	U bool
}

type FilesLsOption func(*FilesLsSettings) error

func FilesLsOptions(options ...FilesLsOption) (*FilesLsSettings, error) {
	settings := &FilesLsSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesLs(ctx context.Context, path string, options ...FilesLsOption) ([]byte, error) {
	settings, err := FilesLsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/ls")
	req.Arguments(path)
	req.Option("long", settings.Long)
	req.Option("U", settings.U)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesMkdirSettings struct {
	// No error if existing, make parent directories as needed.
	Parents bool
	// Cid version to use. (experimental).
	CidVersion int
	// Hash function to use. Will set Cid version to 1 if used. (experimental).
	Hash string
}

type FilesMkdirOption func(*FilesMkdirSettings) error

func FilesMkdirOptions(options ...FilesMkdirOption) (*FilesMkdirSettings, error) {
	settings := &FilesMkdirSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesMkdir(ctx context.Context, path string, options ...FilesMkdirOption) ([]byte, error) {
	settings, err := FilesMkdirOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/mkdir")
	req.Arguments(path)
	req.Option("parents", settings.Parents)
	req.Option("cid-version", settings.CidVersion)
	req.Option("hash", settings.Hash)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) FilesMv(ctx context.Context, source string, dest string) ([]byte, error) {
	req := c.Request("files/mv")
	req.Arguments(source)
	req.Arguments(dest)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesReadSettings struct {
	// Byte offset to begin reading from.
	Offset int64
	// Maximum number of bytes to read.
	Count int64
}

type FilesReadOption func(*FilesReadSettings) error

func FilesReadOptions(options ...FilesReadOption) (*FilesReadSettings, error) {
	settings := &FilesReadSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesRead(ctx context.Context, path string, options ...FilesReadOption) ([]byte, error) {
	settings, err := FilesReadOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/read")
	req.Arguments(path)
	req.Option("offset", settings.Offset)
	req.Option("count", settings.Count)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesRmSettings struct {
	// Recursively remove directories.
	Recursive bool
	// Forcibly remove target at path; implies -r for directories.
	Force bool
}

type FilesRmOption func(*FilesRmSettings) error

func FilesRmOptions(options ...FilesRmOption) (*FilesRmSettings, error) {
	settings := &FilesRmSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesRm(ctx context.Context, path []string, options ...FilesRmOption) ([]byte, error) {
	settings, err := FilesRmOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/rm")
	req.Arguments(path...)
	req.Option("recursive", settings.Recursive)
	req.Option("force", settings.Force)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesStatSettings struct {
	// Print statistics in given format. Allowed tokens: <hash> <size> <cumulsize> <type> <childs>. Conflicts with other format options. Default: <hash>
	// Size: <size>
	// CumulativeSize: <cumulsize>
	// ChildBlocks: <childs>
	// Type: <type>.
	Format string
	// Print only hash. Implies '--format=<hash>'. Conflicts with other format options.
	Hash bool
	// Print only size. Implies '--format=<cumulsize>'. Conflicts with other format options.
	Size bool
	// Compute the amount of the dag that is local, and if possible the total size.
	WithLocal bool
}

type FilesStatOption func(*FilesStatSettings) error

func FilesStatOptions(options ...FilesStatOption) (*FilesStatSettings, error) {
	settings := &FilesStatSettings{
		Format: `<hash>
Size: <size>
CumulativeSize: <cumulsize>
ChildBlocks: <childs>
Type: <type>`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesStat(ctx context.Context, path string, options ...FilesStatOption) ([]byte, error) {
	settings, err := FilesStatOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/stat")
	req.Arguments(path)
	req.Option("format", settings.Format)
	req.Option("hash", settings.Hash)
	req.Option("size", settings.Size)
	req.Option("with-local", settings.WithLocal)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilesWriteSettings struct {
	// Byte offset to begin writing at.
	Offset int64
	// Create the file if it does not exist.
	Create bool
	// Make parent directories as needed.
	Parents bool
	// Truncate the file to size zero before writing.
	Truncate bool
	// Maximum number of bytes to read.
	Count int64
	// Use raw blocks for newly created leaf nodes. (experimental).
	RawLeaves bool
	// Cid version to use. (experimental).
	CidVersion int
	// Hash function to use. Will set Cid version to 1 if used. (experimental).
	Hash string
}

type FilesWriteOption func(*FilesWriteSettings) error

func FilesWriteOptions(options ...FilesWriteOption) (*FilesWriteSettings, error) {
	settings := &FilesWriteSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilesWrite(ctx context.Context, path string, f io.Reader, options ...FilesWriteOption) ([]byte, error) {
	settings, err := FilesWriteOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("files/write")
	req.Arguments(path)
	req.FileBody(f)
	req.Option("offset", settings.Offset)
	req.Option("create", settings.Create)
	req.Option("parents", settings.Parents)
	req.Option("truncate", settings.Truncate)
	req.Option("count", settings.Count)
	req.Option("raw-leaves", settings.RawLeaves)
	req.Option("cid-version", settings.CidVersion)
	req.Option("hash", settings.Hash)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) FilestoreDups(ctx context.Context) ([]byte, error) {
	req := c.Request("filestore/dups")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilestoreLsSettings struct {
	// sort the results based on the path of the backing file.
	FileOrder bool
}

type FilestoreLsOption func(*FilestoreLsSettings) error

func FilestoreLsOptions(options ...FilestoreLsOption) (*FilestoreLsSettings, error) {
	settings := &FilestoreLsSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilestoreLs(ctx context.Context, obj []string, options ...FilestoreLsOption) ([]byte, error) {
	settings, err := FilestoreLsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("filestore/ls")
	req.Arguments(obj...)
	req.Option("file-order", settings.FileOrder)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type FilestoreVerifySettings struct {
	// verify the objects based on the order of the backing file.
	FileOrder bool
}

type FilestoreVerifyOption func(*FilestoreVerifySettings) error

func FilestoreVerifyOptions(options ...FilestoreVerifyOption) (*FilestoreVerifySettings, error) {
	settings := &FilestoreVerifySettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) FilestoreVerify(ctx context.Context, obj []string, options ...FilestoreVerifyOption) ([]byte, error) {
	settings, err := FilestoreVerifyOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("filestore/verify")
	req.Arguments(obj...)
	req.Option("file-order", settings.FileOrder)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type GetSettings struct {
	// The path where the output should be stored.
	Output string
	// Output a TAR archive.
	Archive bool
	// Compress the output with GZIP compression.
	Compress bool
	// The level of compression (1-9).
	CompressionLevel int
	// Stream progress data. Default: true.
	Progress bool
}

type GetOption func(*GetSettings) error

func GetOptions(options ...GetOption) (*GetSettings, error) {
	settings := &GetSettings{
		Progress: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Get(ctx context.Context, ipfsPath string, options ...GetOption) ([]byte, error) {
	settings, err := GetOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("get")
	req.Arguments(ipfsPath)
	req.Option("output", settings.Output)
	req.Option("archive", settings.Archive)
	req.Option("compress", settings.Compress)
	req.Option("compression-level", settings.CompressionLevel)
	req.Option("progress", settings.Progress)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type IdSettings struct {
	// Optional output format.
	Format string
	// Encoding used for peer IDs: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: b58mh.
	PeeridBase string
}

type IdOption func(*IdSettings) error

func IdOptions(options ...IdOption) (*IdSettings, error) {
	settings := &IdSettings{
		PeeridBase: `b58mh`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Id(ctx context.Context, peerid string, options ...IdOption) ([]byte, error) {
	settings, err := IdOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("id")
	req.Arguments(peerid)
	req.Option("format", settings.Format)
	req.Option("peerid-base", settings.PeeridBase)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type KeyExportSettings struct {
	// The path where the output should be stored.
	Output string
	// The format of the exported private key, libp2p-protobuf-cleartext or pem-pkcs8-cleartext. Default: libp2p-protobuf-cleartext.
	Format string
}

type KeyExportOption func(*KeyExportSettings) error

func KeyExportOptions(options ...KeyExportOption) (*KeyExportSettings, error) {
	settings := &KeyExportSettings{
		Format: `libp2p-protobuf-cleartext`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) KeyExport(ctx context.Context, name string, options ...KeyExportOption) ([]byte, error) {
	settings, err := KeyExportOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("key/export")
	req.Arguments(name)
	req.Option("output", settings.Output)
	req.Option("format", settings.Format)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type KeyGenSettings struct {
	// type of the key to create: rsa, ed25519. Default: ed25519.
	Type string
	// size of the key to generate.
	Size int
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

type KeyGenOption func(*KeyGenSettings) error

func KeyGenOptions(options ...KeyGenOption) (*KeyGenSettings, error) {
	settings := &KeyGenSettings{
		Type: `ed25519`,
		IpnsBase: `base36`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) KeyGen(ctx context.Context, name string, options ...KeyGenOption) ([]byte, error) {
	settings, err := KeyGenOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("key/gen")
	req.Arguments(name)
	req.Option("type", settings.Type)
	req.Option("size", settings.Size)
	req.Option("ipns-base", settings.IpnsBase)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type KeyImportSettings struct {
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
	// The format of the private key to import, libp2p-protobuf-cleartext or pem-pkcs8-cleartext. Default: libp2p-protobuf-cleartext.
	Format string
	// Allow importing any key type. Default: false.
	AllowAnyKeyType bool
}

type KeyImportOption func(*KeyImportSettings) error

func KeyImportOptions(options ...KeyImportOption) (*KeyImportSettings, error) {
	settings := &KeyImportSettings{
		IpnsBase: `base36`,
		Format: `libp2p-protobuf-cleartext`,
		AllowAnyKeyType: false,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) KeyImport(ctx context.Context, name string, f io.Reader, options ...KeyImportOption) ([]byte, error) {
	settings, err := KeyImportOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("key/import")
	req.Arguments(name)
	req.FileBody(f)
	req.Option("ipns-base", settings.IpnsBase)
	req.Option("format", settings.Format)
	req.Option("allow-any-key-type", settings.AllowAnyKeyType)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type KeyListSettings struct {
	// Show extra information about keys.
	L bool
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

type KeyListOption func(*KeyListSettings) error

func KeyListOptions(options ...KeyListOption) (*KeyListSettings, error) {
	settings := &KeyListSettings{
		IpnsBase: `base36`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) KeyList(ctx context.Context, options ...KeyListOption) ([]byte, error) {
	settings, err := KeyListOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("key/list")
	req.Option("l", settings.L)
	req.Option("ipns-base", settings.IpnsBase)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type KeyRenameSettings struct {
	// Allow to overwrite an existing key.
	Force bool
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

type KeyRenameOption func(*KeyRenameSettings) error

func KeyRenameOptions(options ...KeyRenameOption) (*KeyRenameSettings, error) {
	settings := &KeyRenameSettings{
		IpnsBase: `base36`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) KeyRename(ctx context.Context, name string, newname string, options ...KeyRenameOption) ([]byte, error) {
	settings, err := KeyRenameOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("key/rename")
	req.Arguments(name)
	req.Arguments(newname)
	req.Option("force", settings.Force)
	req.Option("ipns-base", settings.IpnsBase)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type KeyRmSettings struct {
	// Show extra information about keys.
	L bool
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

type KeyRmOption func(*KeyRmSettings) error

func KeyRmOptions(options ...KeyRmOption) (*KeyRmSettings, error) {
	settings := &KeyRmSettings{
		IpnsBase: `base36`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) KeyRm(ctx context.Context, name []string, options ...KeyRmOption) ([]byte, error) {
	settings, err := KeyRmOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("key/rm")
	req.Arguments(name...)
	req.Option("l", settings.L)
	req.Option("ipns-base", settings.IpnsBase)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type KeyRotateSettings struct {
	// Keystore name to use for backing up your existing identity.
	Oldkey string
	// type of the key to create: rsa, ed25519. Default: ed25519.
	Type string
	// size of the key to generate.
	Size int
}

type KeyRotateOption func(*KeyRotateSettings) error

func KeyRotateOptions(options ...KeyRotateOption) (*KeyRotateSettings, error) {
	settings := &KeyRotateSettings{
		Type: `ed25519`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) KeyRotate(ctx context.Context, options ...KeyRotateOption) ([]byte, error) {
	settings, err := KeyRotateOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("key/rotate")
	req.Option("oldkey", settings.Oldkey)
	req.Option("type", settings.Type)
	req.Option("size", settings.Size)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) LogLevel(ctx context.Context, subsystem string, level string) ([]byte, error) {
	req := c.Request("log/level")
	req.Arguments(subsystem)
	req.Arguments(level)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) LogLs(ctx context.Context) ([]byte, error) {
	req := c.Request("log/ls")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type LsSettings struct {
	// Print table headers (Hash, Size, Name).
	Headers bool
	// Resolve linked objects to find out their types. Default: true.
	ResolveType bool
	// Resolve linked objects to find out their file size. Default: true.
	Size bool
	// Enable experimental streaming of directory entries as they are traversed.
	Stream bool
}

type LsOption func(*LsSettings) error

func LsOptions(options ...LsOption) (*LsSettings, error) {
	settings := &LsSettings{
		ResolveType: true,
		Size: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Ls(ctx context.Context, ipfsPath []string, options ...LsOption) ([]byte, error) {
	settings, err := LsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("ls")
	req.Arguments(ipfsPath...)
	req.Option("headers", settings.Headers)
	req.Option("resolve-type", settings.ResolveType)
	req.Option("size", settings.Size)
	req.Option("stream", settings.Stream)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) MultibaseDecode(ctx context.Context, f io.Reader) ([]byte, error) {
	req := c.Request("multibase/decode")
	req.FileBody(f)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type MultibaseEncodeSettings struct {
	// multibase encoding. Default: base64url.
	B string
}

type MultibaseEncodeOption func(*MultibaseEncodeSettings) error

func MultibaseEncodeOptions(options ...MultibaseEncodeOption) (*MultibaseEncodeSettings, error) {
	settings := &MultibaseEncodeSettings{
		B: `base64url`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) MultibaseEncode(ctx context.Context, f io.Reader, options ...MultibaseEncodeOption) ([]byte, error) {
	settings, err := MultibaseEncodeOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("multibase/encode")
	req.FileBody(f)
	req.Option("b", settings.B)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type MultibaseListSettings struct {
	// also include the single letter prefixes in addition to the code.
	Prefix bool
	// also include numeric codes.
	Numeric bool
}

type MultibaseListOption func(*MultibaseListSettings) error

func MultibaseListOptions(options ...MultibaseListOption) (*MultibaseListSettings, error) {
	settings := &MultibaseListSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) MultibaseList(ctx context.Context, options ...MultibaseListOption) ([]byte, error) {
	settings, err := MultibaseListOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("multibase/list")
	req.Option("prefix", settings.Prefix)
	req.Option("numeric", settings.Numeric)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type MultibaseTranscodeSettings struct {
	// multibase encoding. Default: base64url.
	B string
}

type MultibaseTranscodeOption func(*MultibaseTranscodeSettings) error

func MultibaseTranscodeOptions(options ...MultibaseTranscodeOption) (*MultibaseTranscodeSettings, error) {
	settings := &MultibaseTranscodeSettings{
		B: `base64url`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) MultibaseTranscode(ctx context.Context, f io.Reader, options ...MultibaseTranscodeOption) ([]byte, error) {
	settings, err := MultibaseTranscodeOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("multibase/transcode")
	req.FileBody(f)
	req.Option("b", settings.B)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type NamePublishSettings struct {
	// Check if the given path can be resolved before publishing. Default: true.
	Resolve bool
	// Time duration that the record will be valid for. Default: 24h.
	// This accepts durations such as "300s", "1.5h" or "2h45m". Valid time units are
	// "ns", "us" (or "µs"), "ms", "s", "m", "h".
	Lifetime string
	// When offline, save the IPNS record to the the local datastore without broadcasting to the network instead of simply failing.
	AllowOffline bool
	// Time duration this record should be cached for. Uses the same syntax as the lifetime option. (caution: experimental).
	Ttl string
	// Name of the key to be used or a valid PeerID, as listed by 'ipfs key list -l'. Default: self.
	Key string
	// Write only final hash.
	Quieter bool
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

type NamePublishOption func(*NamePublishSettings) error

func NamePublishOptions(options ...NamePublishOption) (*NamePublishSettings, error) {
	settings := &NamePublishSettings{
		Resolve: true,
		Lifetime: `24h`,
		Key: `self`,
		IpnsBase: `base36`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) NamePublish(ctx context.Context, ipfsPath string, options ...NamePublishOption) ([]byte, error) {
	settings, err := NamePublishOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("name/publish")
	req.Arguments(ipfsPath)
	req.Option("resolve", settings.Resolve)
	req.Option("lifetime", settings.Lifetime)
	req.Option("allow-offline", settings.AllowOffline)
	req.Option("ttl", settings.Ttl)
	req.Option("key", settings.Key)
	req.Option("quieter", settings.Quieter)
	req.Option("ipns-base", settings.IpnsBase)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type NameResolveSettings struct {
	// Resolve until the result is not an IPNS name. Default: true.
	Recursive bool
	// Do not use cached entries.
	Nocache bool
	// Number of records to request for DHT resolution.
	DhtRecordCount uint
	// Max time to collect values during DHT resolution eg "30s". Pass 0 for no timeout.
	DhtTimeout string
	// Stream entries as they are found.
	Stream bool
}

type NameResolveOption func(*NameResolveSettings) error

func NameResolveOptions(options ...NameResolveOption) (*NameResolveSettings, error) {
	settings := &NameResolveSettings{
		Recursive: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) NameResolve(ctx context.Context, name string, options ...NameResolveOption) ([]byte, error) {
	settings, err := NameResolveOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("name/resolve")
	req.Arguments(name)
	req.Option("recursive", settings.Recursive)
	req.Option("nocache", settings.Nocache)
	req.Option("dht-record-count", settings.DhtRecordCount)
	req.Option("dht-timeout", settings.DhtTimeout)
	req.Option("stream", settings.Stream)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinAddSettings struct {
	// Recursively pin the object linked to by the specified object(s). Default: true.
	Recursive bool
	// Show progress.
	Progress bool
}

type PinAddOption func(*PinAddSettings) error

func PinAddOptions(options ...PinAddOption) (*PinAddSettings, error) {
	settings := &PinAddSettings{
		Recursive: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinAdd(ctx context.Context, ipfsPath []string, options ...PinAddOption) ([]byte, error) {
	settings, err := PinAddOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/add")
	req.Arguments(ipfsPath...)
	req.Option("recursive", settings.Recursive)
	req.Option("progress", settings.Progress)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinLsSettings struct {
	// The type of pinned keys to list. Can be "direct", "indirect", "recursive", or "all". Default: all.
	Type string
	// Write just hashes of objects.
	Quiet bool
	// Enable streaming of pins as they are discovered.
	Stream bool
}

type PinLsOption func(*PinLsSettings) error

func PinLsOptions(options ...PinLsOption) (*PinLsSettings, error) {
	settings := &PinLsSettings{
		Type: `all`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinLs(ctx context.Context, ipfsPath []string, options ...PinLsOption) ([]byte, error) {
	settings, err := PinLsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/ls")
	req.Arguments(ipfsPath...)
	req.Option("type", settings.Type)
	req.Option("quiet", settings.Quiet)
	req.Option("stream", settings.Stream)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinRemoteAddSettings struct {
	// Name of the remote pinning service to use (mandatory).
	Service string
	// An optional name for the pin.
	Name string
	// Add to the queue on the remote service and return immediately (does not wait for pinned status). Default: false.
	Background bool
}

type PinRemoteAddOption func(*PinRemoteAddSettings) error

func PinRemoteAddOptions(options ...PinRemoteAddOption) (*PinRemoteAddSettings, error) {
	settings := &PinRemoteAddSettings{
		Background: false,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinRemoteAdd(ctx context.Context, ipfsPath string, options ...PinRemoteAddOption) ([]byte, error) {
	settings, err := PinRemoteAddOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/remote/add")
	req.Arguments(ipfsPath)
	req.Option("service", settings.Service)
	req.Option("name", settings.Name)
	req.Option("background", settings.Background)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinRemoteLsSettings struct {
	// Name of the remote pinning service to use (mandatory).
	Service string
	// Return pins with names that contain the value provided (case-sensitive, exact match).
	Name string
	// Return pins for the specified CIDs (comma-separated).
	Cid []string
	// Return pins with the specified statuses (queued,pinning,pinned,failed). Default: [pinned].
	Status []string
}

type PinRemoteLsOption func(*PinRemoteLsSettings) error

func PinRemoteLsOptions(options ...PinRemoteLsOption) (*PinRemoteLsSettings, error) {
	settings := &PinRemoteLsSettings{
		Status: []string{"pinned"},
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinRemoteLs(ctx context.Context, options ...PinRemoteLsOption) ([]byte, error) {
	settings, err := PinRemoteLsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/remote/ls")
	req.Option("service", settings.Service)
	req.Option("name", settings.Name)
	req.Option("cid", settings.Cid)
	req.Option("status", settings.Status)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinRemoteRmSettings struct {
	// Name of the remote pinning service to use (mandatory).
	Service string
	// Remove pins with names that contain provided value (case-sensitive, exact match).
	Name string
	// Remove pins for the specified CIDs.
	Cid []string
	// Remove pins with the specified statuses (queued,pinning,pinned,failed). Default: [pinned].
	Status []string
	// Allow removal of multiple pins matching the query without additional confirmation. Default: false.
	Force bool
}

type PinRemoteRmOption func(*PinRemoteRmSettings) error

func PinRemoteRmOptions(options ...PinRemoteRmOption) (*PinRemoteRmSettings, error) {
	settings := &PinRemoteRmSettings{
		Status: []string{"pinned"},
		Force: false,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinRemoteRm(ctx context.Context, options ...PinRemoteRmOption) ([]byte, error) {
	settings, err := PinRemoteRmOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/remote/rm")
	req.Option("service", settings.Service)
	req.Option("name", settings.Name)
	req.Option("cid", settings.Cid)
	req.Option("status", settings.Status)
	req.Option("force", settings.Force)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) PinRemoteServiceAdd(ctx context.Context, service string, endpoint string, key string) ([]byte, error) {
	req := c.Request("pin/remote/service/add")
	req.Arguments(service)
	req.Arguments(endpoint)
	req.Arguments(key)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinRemoteServiceLsSettings struct {
	// Try to fetch and display current pin count on remote service (queued/pinning/pinned/failed). Default: false.
	Stat bool
}

type PinRemoteServiceLsOption func(*PinRemoteServiceLsSettings) error

func PinRemoteServiceLsOptions(options ...PinRemoteServiceLsOption) (*PinRemoteServiceLsSettings, error) {
	settings := &PinRemoteServiceLsSettings{
		Stat: false,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinRemoteServiceLs(ctx context.Context, options ...PinRemoteServiceLsOption) ([]byte, error) {
	settings, err := PinRemoteServiceLsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/remote/service/ls")
	req.Option("stat", settings.Stat)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) PinRemoteServiceRm(ctx context.Context, service string) ([]byte, error) {
	req := c.Request("pin/remote/service/rm")
	req.Arguments(service)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinRmSettings struct {
	// Recursively unpin the object linked to by the specified object(s). Default: true.
	Recursive bool
}

type PinRmOption func(*PinRmSettings) error

func PinRmOptions(options ...PinRmOption) (*PinRmSettings, error) {
	settings := &PinRmSettings{
		Recursive: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinRm(ctx context.Context, ipfsPath []string, options ...PinRmOption) ([]byte, error) {
	settings, err := PinRmOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/rm")
	req.Arguments(ipfsPath...)
	req.Option("recursive", settings.Recursive)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinUpdateSettings struct {
	// Remove the old pin. Default: true.
	Unpin bool
}

type PinUpdateOption func(*PinUpdateSettings) error

func PinUpdateOptions(options ...PinUpdateOption) (*PinUpdateSettings, error) {
	settings := &PinUpdateSettings{
		Unpin: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinUpdate(ctx context.Context, fromPath string, toPath string, options ...PinUpdateOption) ([]byte, error) {
	settings, err := PinUpdateOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/update")
	req.Arguments(fromPath)
	req.Arguments(toPath)
	req.Option("unpin", settings.Unpin)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PinVerifySettings struct {
	// Also write the hashes of non-broken pins.
	Verbose bool
	// Write just hashes of broken pins.
	Quiet bool
}

type PinVerifyOption func(*PinVerifySettings) error

func PinVerifyOptions(options ...PinVerifyOption) (*PinVerifySettings, error) {
	settings := &PinVerifySettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) PinVerify(ctx context.Context, options ...PinVerifyOption) ([]byte, error) {
	settings, err := PinVerifyOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("pin/verify")
	req.Option("verbose", settings.Verbose)
	req.Option("quiet", settings.Quiet)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type PingSettings struct {
	// Number of ping messages to send. Default: 10.
	Count int
}

type PingOption func(*PingSettings) error

func PingOptions(options ...PingOption) (*PingSettings, error) {
	settings := &PingSettings{
		Count: 10,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Ping(ctx context.Context, peerId []string, options ...PingOption) ([]byte, error) {
	settings, err := PingOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("ping")
	req.Arguments(peerId...)
	req.Option("count", settings.Count)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RefsSettings struct {
	// Emit edges with given format. Available tokens: <src> <dst> <linkname>. Default: <dst>.
	Format string
	// Emit edge format: `<from> -> <to>`.
	Edges bool
	// Omit duplicate refs from output.
	Unique bool
	// Recursively list links of child nodes.
	Recursive bool
	// Only for recursive refs, limits fetch and listing to the given depth. Default: -1.
	MaxDepth int
}

type RefsOption func(*RefsSettings) error

func RefsOptions(options ...RefsOption) (*RefsSettings, error) {
	settings := &RefsSettings{
		Format: `<dst>`,
		MaxDepth: -1,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Refs(ctx context.Context, ipfsPath []string, options ...RefsOption) ([]byte, error) {
	settings, err := RefsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("refs")
	req.Arguments(ipfsPath...)
	req.Option("format", settings.Format)
	req.Option("edges", settings.Edges)
	req.Option("unique", settings.Unique)
	req.Option("recursive", settings.Recursive)
	req.Option("max-depth", settings.MaxDepth)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) RefsLocal(ctx context.Context) ([]byte, error) {
	req := c.Request("refs/local")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RepoGcSettings struct {
	// Stream errors.
	StreamErrors bool
	// Write minimal output.
	Quiet bool
	// Write no output.
	Silent bool
}

type RepoGcOption func(*RepoGcSettings) error

func RepoGcOptions(options ...RepoGcOption) (*RepoGcSettings, error) {
	settings := &RepoGcSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RepoGc(ctx context.Context, options ...RepoGcOption) ([]byte, error) {
	settings, err := RepoGcOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("repo/gc")
	req.Option("stream-errors", settings.StreamErrors)
	req.Option("quiet", settings.Quiet)
	req.Option("silent", settings.Silent)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) RepoLs(ctx context.Context) ([]byte, error) {
	req := c.Request("repo/ls")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RepoMigrateSettings struct {
	// Allow downgrading to a lower repo version.
	AllowDowngrade bool
}

type RepoMigrateOption func(*RepoMigrateSettings) error

func RepoMigrateOptions(options ...RepoMigrateOption) (*RepoMigrateSettings, error) {
	settings := &RepoMigrateSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RepoMigrate(ctx context.Context, options ...RepoMigrateOption) ([]byte, error) {
	settings, err := RepoMigrateOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("repo/migrate")
	req.Option("allow-downgrade", settings.AllowDowngrade)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RepoStatSettings struct {
	// Only report RepoSize and StorageMax.
	SizeOnly bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

type RepoStatOption func(*RepoStatSettings) error

func RepoStatOptions(options ...RepoStatOption) (*RepoStatSettings, error) {
	settings := &RepoStatSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RepoStat(ctx context.Context, options ...RepoStatOption) ([]byte, error) {
	settings, err := RepoStatOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("repo/stat")
	req.Option("size-only", settings.SizeOnly)
	req.Option("human", settings.Human)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) RepoVerify(ctx context.Context) ([]byte, error) {
	req := c.Request("repo/verify")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RepoVersionSettings struct {
	// Write minimal output.
	Quiet bool
}

type RepoVersionOption func(*RepoVersionSettings) error

func RepoVersionOptions(options ...RepoVersionOption) (*RepoVersionSettings, error) {
	settings := &RepoVersionSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RepoVersion(ctx context.Context, options ...RepoVersionOption) ([]byte, error) {
	settings, err := RepoVersionOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("repo/version")
	req.Option("quiet", settings.Quiet)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type ResolveSettings struct {
	// Resolve until the result is an IPFS name. Default: true.
	Recursive bool
	// Number of records to request for DHT resolution.
	DhtRecordCount int
	// Max time to collect values during DHT resolution eg "30s". Pass 0 for no timeout.
	DhtTimeout string
}

type ResolveOption func(*ResolveSettings) error

func ResolveOptions(options ...ResolveOption) (*ResolveSettings, error) {
	settings := &ResolveSettings{
		Recursive: true,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Resolve(ctx context.Context, name string, options ...ResolveOption) ([]byte, error) {
	settings, err := ResolveOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("resolve")
	req.Arguments(name)
	req.Option("recursive", settings.Recursive)
	req.Option("dht-record-count", settings.DhtRecordCount)
	req.Option("dht-timeout", settings.DhtTimeout)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RoutingFindpeerSettings struct {
	// Print extra information.
	Verbose bool
}

type RoutingFindpeerOption func(*RoutingFindpeerSettings) error

func RoutingFindpeerOptions(options ...RoutingFindpeerOption) (*RoutingFindpeerSettings, error) {
	settings := &RoutingFindpeerSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RoutingFindpeer(ctx context.Context, peerid []string, options ...RoutingFindpeerOption) ([]byte, error) {
	settings, err := RoutingFindpeerOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("routing/findpeer")
	req.Arguments(peerid...)
	req.Option("verbose", settings.Verbose)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RoutingFindprovsSettings struct {
	// Print extra information.
	Verbose bool
	// The number of providers to find. Default: 20.
	NumProviders int
}

type RoutingFindprovsOption func(*RoutingFindprovsSettings) error

func RoutingFindprovsOptions(options ...RoutingFindprovsOption) (*RoutingFindprovsSettings, error) {
	settings := &RoutingFindprovsSettings{
		NumProviders: 20,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RoutingFindprovs(ctx context.Context, key []string, options ...RoutingFindprovsOption) ([]byte, error) {
	settings, err := RoutingFindprovsOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("routing/findprovs")
	req.Arguments(key...)
	req.Option("verbose", settings.Verbose)
	req.Option("num-providers", settings.NumProviders)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RoutingGetSettings struct {
	// Print extra information.
	Verbose bool
}

type RoutingGetOption func(*RoutingGetSettings) error

func RoutingGetOptions(options ...RoutingGetOption) (*RoutingGetSettings, error) {
	settings := &RoutingGetSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RoutingGet(ctx context.Context, key []string, options ...RoutingGetOption) ([]byte, error) {
	settings, err := RoutingGetOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("routing/get")
	req.Arguments(key...)
	req.Option("verbose", settings.Verbose)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RoutingProvideSettings struct {
	// Print extra information.
	Verbose bool
	// Recursively provide entire graph.
	Recursive bool
}

type RoutingProvideOption func(*RoutingProvideSettings) error

func RoutingProvideOptions(options ...RoutingProvideOption) (*RoutingProvideSettings, error) {
	settings := &RoutingProvideSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RoutingProvide(ctx context.Context, key []string, options ...RoutingProvideOption) ([]byte, error) {
	settings, err := RoutingProvideOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("routing/provide")
	req.Arguments(key...)
	req.Option("verbose", settings.Verbose)
	req.Option("recursive", settings.Recursive)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type RoutingPutSettings struct {
	// Print extra information.
	Verbose bool
}

type RoutingPutOption func(*RoutingPutSettings) error

func RoutingPutOptions(options ...RoutingPutOption) (*RoutingPutSettings, error) {
	settings := &RoutingPutSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) RoutingPut(ctx context.Context, key string, f io.Reader, options ...RoutingPutOption) ([]byte, error) {
	settings, err := RoutingPutOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("routing/put")
	req.Arguments(key)
	req.FileBody(f)
	req.Option("verbose", settings.Verbose)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) Shutdown(ctx context.Context) ([]byte, error) {
	req := c.Request("shutdown")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type StatsBitswapSettings struct {
	// Print extra information.
	Verbose bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

type StatsBitswapOption func(*StatsBitswapSettings) error

func StatsBitswapOptions(options ...StatsBitswapOption) (*StatsBitswapSettings, error) {
	settings := &StatsBitswapSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) StatsBitswap(ctx context.Context, options ...StatsBitswapOption) ([]byte, error) {
	settings, err := StatsBitswapOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("stats/bitswap")
	req.Option("verbose", settings.Verbose)
	req.Option("human", settings.Human)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type StatsBwSettings struct {
	// Specify a peer to print bandwidth for.
	Peer string
	// Specify a protocol to print bandwidth for.
	Proto string
	// Print bandwidth at an interval.
	Poll bool
	// Time interval to wait between updating output, if 'poll' is true.
	// 
	// This accepts durations such as "300s", "1.5h" or "2h45m". Valid time units are:
	// "ns", "us" (or "µs"), "ms", "s", "m", "h". Default: 1s.
	Interval string
}

type StatsBwOption func(*StatsBwSettings) error

func StatsBwOptions(options ...StatsBwOption) (*StatsBwSettings, error) {
	settings := &StatsBwSettings{
		Interval: `1s`,
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) StatsBw(ctx context.Context, options ...StatsBwOption) ([]byte, error) {
	settings, err := StatsBwOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("stats/bw")
	req.Option("peer", settings.Peer)
	req.Option("proto", settings.Proto)
	req.Option("poll", settings.Poll)
	req.Option("interval", settings.Interval)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) StatsDht(ctx context.Context, dht []string) ([]byte, error) {
	req := c.Request("stats/dht")
	req.Arguments(dht...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) StatsProvide(ctx context.Context) ([]byte, error) {
	req := c.Request("stats/provide")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type StatsRepoSettings struct {
	// Only report RepoSize and StorageMax.
	SizeOnly bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

type StatsRepoOption func(*StatsRepoSettings) error

func StatsRepoOptions(options ...StatsRepoOption) (*StatsRepoSettings, error) {
	settings := &StatsRepoSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) StatsRepo(ctx context.Context, options ...StatsRepoOption) ([]byte, error) {
	settings, err := StatsRepoOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("stats/repo")
	req.Option("size-only", settings.SizeOnly)
	req.Option("human", settings.Human)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmAddrs(ctx context.Context) ([]byte, error) {
	req := c.Request("swarm/addrs")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmAddrsListen(ctx context.Context) ([]byte, error) {
	req := c.Request("swarm/addrs/listen")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type SwarmAddrsLocalSettings struct {
	// Show peer ID in addresses.
	Id bool
}

type SwarmAddrsLocalOption func(*SwarmAddrsLocalSettings) error

func SwarmAddrsLocalOptions(options ...SwarmAddrsLocalOption) (*SwarmAddrsLocalSettings, error) {
	settings := &SwarmAddrsLocalSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) SwarmAddrsLocal(ctx context.Context, options ...SwarmAddrsLocalOption) ([]byte, error) {
	settings, err := SwarmAddrsLocalOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("swarm/addrs/local")
	req.Option("id", settings.Id)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmConnect(ctx context.Context, address []string) ([]byte, error) {
	req := c.Request("swarm/connect")
	req.Arguments(address...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmDisconnect(ctx context.Context, address []string) ([]byte, error) {
	req := c.Request("swarm/disconnect")
	req.Arguments(address...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmFilters(ctx context.Context) ([]byte, error) {
	req := c.Request("swarm/filters")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmFiltersAdd(ctx context.Context, address []string) ([]byte, error) {
	req := c.Request("swarm/filters/add")
	req.Arguments(address...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmFiltersRm(ctx context.Context, address []string) ([]byte, error) {
	req := c.Request("swarm/filters/rm")
	req.Arguments(address...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmPeeringAdd(ctx context.Context, address []string) ([]byte, error) {
	req := c.Request("swarm/peering/add")
	req.Arguments(address...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmPeeringLs(ctx context.Context) ([]byte, error) {
	req := c.Request("swarm/peering/ls")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) SwarmPeeringRm(ctx context.Context, id []string) ([]byte, error) {
	req := c.Request("swarm/peering/rm")
	req.Arguments(id...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type SwarmPeersSettings struct {
	// display all extra information.
	Verbose bool
	// Also list information about open streams for each peer.
	Streams bool
	// Also list information about latency to each peer.
	Latency bool
	// Also list information about the direction of connection.
	Direction bool
}

type SwarmPeersOption func(*SwarmPeersSettings) error

func SwarmPeersOptions(options ...SwarmPeersOption) (*SwarmPeersSettings, error) {
	settings := &SwarmPeersSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) SwarmPeers(ctx context.Context, options ...SwarmPeersOption) ([]byte, error) {
	settings, err := SwarmPeersOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("swarm/peers")
	req.Option("verbose", settings.Verbose)
	req.Option("streams", settings.Streams)
	req.Option("latency", settings.Latency)
	req.Option("direction", settings.Direction)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) Update(ctx context.Context, args []string) ([]byte, error) {
	req := c.Request("update")
	req.Arguments(args...)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

type VersionSettings struct {
	// Only show the version number.
	Number bool
	// Show the commit hash.
	Commit bool
	// Show repo version.
	Repo bool
	// Show all version information.
	All bool
}

type VersionOption func(*VersionSettings) error

func VersionOptions(options ...VersionOption) (*VersionSettings, error) {
	settings := &VersionSettings{
	}
	for _, option := range options {
		err := option(settings)
		if err != nil {
			return nil, err
		}
	}
	return settings, nil
}

func (c *Client) Version(ctx context.Context, options ...VersionOption) ([]byte, error) {
	settings, err := VersionOptions(options...)
	if err != nil {
		return nil, err
	}
	req := c.Request("version")
	req.Option("number", settings.Number)
	req.Option("commit", settings.Commit)
	req.Option("repo", settings.Repo)
	req.Option("all", settings.All)
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

func (c *Client) VersionDeps(ctx context.Context) ([]byte, error) {
	req := c.Request("version/deps")
	res, err := req.Send(ctx)
	if err != nil {
		return nil, err
	}
	if res.Error != nil {
		return nil, res.Error
	}
	defer res.Close()
	return io.ReadAll(res.Output)
}

