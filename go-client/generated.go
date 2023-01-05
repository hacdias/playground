package kubo

import (
	"context"
	"io"

	files "github.com/ipfs/go-ipfs-files"
)

type AddOptions struct {
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

func (c *Client) Add(ctx context.Context, f files.Node, options *AddOptions) ([]byte, error) {
	req := c.Request("add")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	if options != nil {
		req.Option("recursive", options.Recursive)
		req.Option("dereference-args", options.DereferenceArgs)
		req.Option("stdin-name", options.StdinName)
		req.Option("hidden", options.Hidden)
		req.Option("ignore", options.Ignore)
		req.Option("ignore-rules-path", options.IgnoreRulesPath)
		req.Option("quiet", options.Quiet)
		req.Option("quieter", options.Quieter)
		req.Option("silent", options.Silent)
		req.Option("progress", options.Progress)
		req.Option("trickle", options.Trickle)
		req.Option("only-hash", options.OnlyHash)
		req.Option("wrap-with-directory", options.WrapWithDirectory)
		req.Option("chunker", options.Chunker)
		req.Option("raw-leaves", options.RawLeaves)
		req.Option("nocopy", options.Nocopy)
		req.Option("fscache", options.Fscache)
		req.Option("cid-version", options.CidVersion)
		req.Option("hash", options.Hash)
		req.Option("inline", options.Inline)
		req.Option("inline-limit", options.InlineLimit)
		req.Option("pin", options.Pin)
	}
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

type BitswapStatOptions struct {
	// Print extra information.
	Verbose bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

func (c *Client) BitswapStat(ctx context.Context, options *BitswapStatOptions) ([]byte, error) {
	req := c.Request("bitswap/stat")
	if options != nil {
		req.Option("verbose", options.Verbose)
		req.Option("human", options.Human)
	}
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

type BitswapWantlistOptions struct {
	// Specify which peer to show wantlist for. Default: self.
	Peer string
}

func (c *Client) BitswapWantlist(ctx context.Context, options *BitswapWantlistOptions) ([]byte, error) {
	req := c.Request("bitswap/wantlist")
	if options != nil {
		req.Option("peer", options.Peer)
	}
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

type BlockPutOptions struct {
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

func (c *Client) BlockPut(ctx context.Context, f files.Node, options *BlockPutOptions) ([]byte, error) {
	req := c.Request("block/put")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	if options != nil {
		req.Option("cid-codec", options.CidCodec)
		req.Option("mhtype", options.Mhtype)
		req.Option("mhlen", options.Mhlen)
		req.Option("pin", options.Pin)
		req.Option("allow-big-block", options.AllowBigBlock)
		req.Option("format", options.Format)
	}
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

type BlockRmOptions struct {
	// Ignore nonexistent blocks.
	Force bool
	// Write minimal output.
	Quiet bool
}

func (c *Client) BlockRm(ctx context.Context, cid []string, options *BlockRmOptions) ([]byte, error) {
	req := c.Request("block/rm")
	req.Arguments(cid...)
	if options != nil {
		req.Option("force", options.Force)
		req.Option("quiet", options.Quiet)
	}
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

type BootstrapAddOptions struct {
	// Add default bootstrap nodes. (Deprecated, use 'default' subcommand instead).
	Default bool
}

func (c *Client) BootstrapAdd(ctx context.Context, peer []string, options *BootstrapAddOptions) ([]byte, error) {
	req := c.Request("bootstrap/add")
	req.Arguments(peer...)
	if options != nil {
		req.Option("default", options.Default)
	}
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

type BootstrapRmOptions struct {
	// Remove all bootstrap peers. (Deprecated, use 'all' subcommand).
	All bool
}

func (c *Client) BootstrapRm(ctx context.Context, peer []string, options *BootstrapRmOptions) ([]byte, error) {
	req := c.Request("bootstrap/rm")
	req.Arguments(peer...)
	if options != nil {
		req.Option("all", options.All)
	}
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

type CatOptions struct {
	// Byte offset to begin reading from.
	Offset int64
	// Maximum number of bytes to read.
	Length int64
	// Stream progress data. Default: true.
	Progress bool
}

func (c *Client) Cat(ctx context.Context, ipfsPath []string, options *CatOptions) ([]byte, error) {
	req := c.Request("cat")
	req.Arguments(ipfsPath...)
	if options != nil {
		req.Option("offset", options.Offset)
		req.Option("length", options.Length)
		req.Option("progress", options.Progress)
	}
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

type CidBasesOptions struct {
	// also include the single letter prefixes in addition to the code.
	Prefix bool
	// also include numeric codes.
	Numeric bool
}

func (c *Client) CidBases(ctx context.Context, options *CidBasesOptions) ([]byte, error) {
	req := c.Request("cid/bases")
	if options != nil {
		req.Option("prefix", options.Prefix)
		req.Option("numeric", options.Numeric)
	}
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

type CidCodecsOptions struct {
	// also include numeric codes.
	Numeric bool
	// list only codecs supported by go-ipfs commands.
	Supported bool
}

func (c *Client) CidCodecs(ctx context.Context, options *CidCodecsOptions) ([]byte, error) {
	req := c.Request("cid/codecs")
	if options != nil {
		req.Option("numeric", options.Numeric)
		req.Option("supported", options.Supported)
	}
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

type CidFormatOptions struct {
	// Printf style format string. Default: %s.
	F string
	// CID version to convert to.
	V string
	// CID multicodec to convert to.
	Mc string
	// Multibase to display CID in.
	B string
}

func (c *Client) CidFormat(ctx context.Context, cid []string, options *CidFormatOptions) ([]byte, error) {
	req := c.Request("cid/format")
	req.Arguments(cid...)
	if options != nil {
		req.Option("f", options.F)
		req.Option("v", options.V)
		req.Option("mc", options.Mc)
		req.Option("b", options.B)
	}
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

type CidHashesOptions struct {
	// also include numeric codes.
	Numeric bool
	// list only codecs supported by go-ipfs commands.
	Supported bool
}

func (c *Client) CidHashes(ctx context.Context, options *CidHashesOptions) ([]byte, error) {
	req := c.Request("cid/hashes")
	if options != nil {
		req.Option("numeric", options.Numeric)
		req.Option("supported", options.Supported)
	}
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

type CommandsOptions struct {
	// Show command flags.
	Flags bool
}

func (c *Client) Commands(ctx context.Context, options *CommandsOptions) ([]byte, error) {
	req := c.Request("commands")
	if options != nil {
		req.Option("flags", options.Flags)
	}
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

type ConfigOptions struct {
	// Set a boolean value.
	Bool bool
	// Parse stringified JSON.
	Json bool
}

func (c *Client) Config(ctx context.Context, key string, value string, options *ConfigOptions) ([]byte, error) {
	req := c.Request("config")
	req.Arguments(key)
	req.Arguments(value)
	if options != nil {
		req.Option("bool", options.Bool)
		req.Option("json", options.Json)
	}
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

type ConfigProfileApplyOptions struct {
	// print difference between the current config and the config that would be generated.
	DryRun bool
}

func (c *Client) ConfigProfileApply(ctx context.Context, profile string, options *ConfigProfileApplyOptions) ([]byte, error) {
	req := c.Request("config/profile/apply")
	req.Arguments(profile)
	if options != nil {
		req.Option("dry-run", options.DryRun)
	}
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

type DagExportOptions struct {
	// Display progress on CLI. Defaults to true when STDERR is a TTY.
	Progress bool
}

func (c *Client) DagExport(ctx context.Context, root string, options *DagExportOptions) ([]byte, error) {
	req := c.Request("dag/export")
	req.Arguments(root)
	if options != nil {
		req.Option("progress", options.Progress)
	}
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

type DagGetOptions struct {
	// Format that the object will be encoded as. Default: dag-json.
	OutputCodec string
}

func (c *Client) DagGet(ctx context.Context, ref string, options *DagGetOptions) ([]byte, error) {
	req := c.Request("dag/get")
	req.Arguments(ref)
	if options != nil {
		req.Option("output-codec", options.OutputCodec)
	}
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

type DagImportOptions struct {
	// Pin optional roots listed in the .car headers after importing. Default: true.
	PinRoots bool
	// No output.
	Silent bool
	// Output stats.
	Stats bool
	// Disable block size check and allow creation of blocks bigger than 1MiB. WARNING: such blocks won't be transferable over the standard bitswap. Default: false.
	AllowBigBlock bool
}

func (c *Client) DagImport(ctx context.Context, f files.Node, options *DagImportOptions) ([]byte, error) {
	req := c.Request("dag/import")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	if options != nil {
		req.Option("pin-roots", options.PinRoots)
		req.Option("silent", options.Silent)
		req.Option("stats", options.Stats)
		req.Option("allow-big-block", options.AllowBigBlock)
	}
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

type DagPutOptions struct {
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

func (c *Client) DagPut(ctx context.Context, f files.Node, options *DagPutOptions) ([]byte, error) {
	req := c.Request("dag/put")
	if d, ok := f.(files.Directory); ok {
		req.Body(files.NewMultiFileReader(d, false))
	} else {
		d := files.NewMapDirectory(map[string]files.Node{"": f})
		files.NewMultiFileReader(d, false)
		req.Body(files.NewMultiFileReader(d, false))
	}
	if options != nil {
		req.Option("store-codec", options.StoreCodec)
		req.Option("input-codec", options.InputCodec)
		req.Option("pin", options.Pin)
		req.Option("hash", options.Hash)
		req.Option("allow-big-block", options.AllowBigBlock)
	}
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

type DagStatOptions struct {
	// Return progressive data while reading through the DAG. Default: true.
	Progress bool
}

func (c *Client) DagStat(ctx context.Context, root string, options *DagStatOptions) ([]byte, error) {
	req := c.Request("dag/stat")
	req.Arguments(root)
	if options != nil {
		req.Option("progress", options.Progress)
	}
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

type DhtQueryOptions struct {
	// Print extra information.
	Verbose bool
}

func (c *Client) DhtQuery(ctx context.Context, peerid []string, options *DhtQueryOptions) ([]byte, error) {
	req := c.Request("dht/query")
	req.Arguments(peerid...)
	if options != nil {
		req.Option("verbose", options.Verbose)
	}
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

type DiagCmdsOptions struct {
	// Print extra information.
	Verbose bool
}

func (c *Client) DiagCmds(ctx context.Context, options *DiagCmdsOptions) ([]byte, error) {
	req := c.Request("diag/cmds")
	if options != nil {
		req.Option("verbose", options.Verbose)
	}
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

type DiagProfileOptions struct {
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

func (c *Client) DiagProfile(ctx context.Context, options *DiagProfileOptions) ([]byte, error) {
	req := c.Request("diag/profile")
	if options != nil {
		req.Option("output", options.Output)
		req.Option("collectors", options.Collectors)
		req.Option("profile-time", options.ProfileTime)
		req.Option("mutex-profile-fraction", options.MutexProfileFraction)
		req.Option("block-profile-rate", options.BlockProfileRate)
	}
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

type FilesChcidOptions struct {
	// Cid version to use. (experimental).
	CidVersion int
	// Hash function to use. Will set Cid version to 1 if used. (experimental).
	Hash string
}

func (c *Client) FilesChcid(ctx context.Context, path string, options *FilesChcidOptions) ([]byte, error) {
	req := c.Request("files/chcid")
	req.Arguments(path)
	if options != nil {
		req.Option("cid-version", options.CidVersion)
		req.Option("hash", options.Hash)
	}
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

type FilesCpOptions struct {
	// Make parent directories as needed.
	Parents bool
}

func (c *Client) FilesCp(ctx context.Context, source string, dest string, options *FilesCpOptions) ([]byte, error) {
	req := c.Request("files/cp")
	req.Arguments(source)
	req.Arguments(dest)
	if options != nil {
		req.Option("parents", options.Parents)
	}
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

type FilesLsOptions struct {
	// Use long listing format.
	Long bool
	// Do not sort; list entries in directory order.
	U bool
}

func (c *Client) FilesLs(ctx context.Context, path string, options *FilesLsOptions) ([]byte, error) {
	req := c.Request("files/ls")
	req.Arguments(path)
	if options != nil {
		req.Option("long", options.Long)
		req.Option("U", options.U)
	}
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

type FilesMkdirOptions struct {
	// No error if existing, make parent directories as needed.
	Parents bool
	// Cid version to use. (experimental).
	CidVersion int
	// Hash function to use. Will set Cid version to 1 if used. (experimental).
	Hash string
}

func (c *Client) FilesMkdir(ctx context.Context, path string, options *FilesMkdirOptions) ([]byte, error) {
	req := c.Request("files/mkdir")
	req.Arguments(path)
	if options != nil {
		req.Option("parents", options.Parents)
		req.Option("cid-version", options.CidVersion)
		req.Option("hash", options.Hash)
	}
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

type FilesReadOptions struct {
	// Byte offset to begin reading from.
	Offset int64
	// Maximum number of bytes to read.
	Count int64
}

func (c *Client) FilesRead(ctx context.Context, path string, options *FilesReadOptions) ([]byte, error) {
	req := c.Request("files/read")
	req.Arguments(path)
	if options != nil {
		req.Option("offset", options.Offset)
		req.Option("count", options.Count)
	}
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

type FilesRmOptions struct {
	// Recursively remove directories.
	Recursive bool
	// Forcibly remove target at path; implies -r for directories.
	Force bool
}

func (c *Client) FilesRm(ctx context.Context, path []string, options *FilesRmOptions) ([]byte, error) {
	req := c.Request("files/rm")
	req.Arguments(path...)
	if options != nil {
		req.Option("recursive", options.Recursive)
		req.Option("force", options.Force)
	}
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

type FilesStatOptions struct {
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

func (c *Client) FilesStat(ctx context.Context, path string, options *FilesStatOptions) ([]byte, error) {
	req := c.Request("files/stat")
	req.Arguments(path)
	if options != nil {
		req.Option("format", options.Format)
		req.Option("hash", options.Hash)
		req.Option("size", options.Size)
		req.Option("with-local", options.WithLocal)
	}
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

type FilesWriteOptions struct {
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

func (c *Client) FilesWrite(ctx context.Context, path string, f io.Reader, options *FilesWriteOptions) ([]byte, error) {
	req := c.Request("files/write")
	req.Arguments(path)
	req.FileBody(f)
	if options != nil {
		req.Option("offset", options.Offset)
		req.Option("create", options.Create)
		req.Option("parents", options.Parents)
		req.Option("truncate", options.Truncate)
		req.Option("count", options.Count)
		req.Option("raw-leaves", options.RawLeaves)
		req.Option("cid-version", options.CidVersion)
		req.Option("hash", options.Hash)
	}
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

type FilestoreLsOptions struct {
	// sort the results based on the path of the backing file.
	FileOrder bool
}

func (c *Client) FilestoreLs(ctx context.Context, obj []string, options *FilestoreLsOptions) ([]byte, error) {
	req := c.Request("filestore/ls")
	req.Arguments(obj...)
	if options != nil {
		req.Option("file-order", options.FileOrder)
	}
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

type FilestoreVerifyOptions struct {
	// verify the objects based on the order of the backing file.
	FileOrder bool
}

func (c *Client) FilestoreVerify(ctx context.Context, obj []string, options *FilestoreVerifyOptions) ([]byte, error) {
	req := c.Request("filestore/verify")
	req.Arguments(obj...)
	if options != nil {
		req.Option("file-order", options.FileOrder)
	}
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

type GetOptions struct {
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

func (c *Client) Get(ctx context.Context, ipfsPath string, options *GetOptions) ([]byte, error) {
	req := c.Request("get")
	req.Arguments(ipfsPath)
	if options != nil {
		req.Option("output", options.Output)
		req.Option("archive", options.Archive)
		req.Option("compress", options.Compress)
		req.Option("compression-level", options.CompressionLevel)
		req.Option("progress", options.Progress)
	}
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

type IdOptions struct {
	// Optional output format.
	Format string
	// Encoding used for peer IDs: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: b58mh.
	PeeridBase string
}

func (c *Client) Id(ctx context.Context, peerid string, options *IdOptions) ([]byte, error) {
	req := c.Request("id")
	req.Arguments(peerid)
	if options != nil {
		req.Option("format", options.Format)
		req.Option("peerid-base", options.PeeridBase)
	}
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

type KeyExportOptions struct {
	// The path where the output should be stored.
	Output string
	// The format of the exported private key, libp2p-protobuf-cleartext or pem-pkcs8-cleartext. Default: libp2p-protobuf-cleartext.
	Format string
}

func (c *Client) KeyExport(ctx context.Context, name string, options *KeyExportOptions) ([]byte, error) {
	req := c.Request("key/export")
	req.Arguments(name)
	if options != nil {
		req.Option("output", options.Output)
		req.Option("format", options.Format)
	}
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

type KeyGenOptions struct {
	// type of the key to create: rsa, ed25519. Default: ed25519.
	Type string
	// size of the key to generate.
	Size int
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

func (c *Client) KeyGen(ctx context.Context, name string, options *KeyGenOptions) ([]byte, error) {
	req := c.Request("key/gen")
	req.Arguments(name)
	if options != nil {
		req.Option("type", options.Type)
		req.Option("size", options.Size)
		req.Option("ipns-base", options.IpnsBase)
	}
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

type KeyImportOptions struct {
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
	// The format of the private key to import, libp2p-protobuf-cleartext or pem-pkcs8-cleartext. Default: libp2p-protobuf-cleartext.
	Format string
	// Allow importing any key type. Default: false.
	AllowAnyKeyType bool
}

func (c *Client) KeyImport(ctx context.Context, name string, f io.Reader, options *KeyImportOptions) ([]byte, error) {
	req := c.Request("key/import")
	req.Arguments(name)
	req.FileBody(f)
	if options != nil {
		req.Option("ipns-base", options.IpnsBase)
		req.Option("format", options.Format)
		req.Option("allow-any-key-type", options.AllowAnyKeyType)
	}
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

type KeyListOptions struct {
	// Show extra information about keys.
	L bool
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

func (c *Client) KeyList(ctx context.Context, options *KeyListOptions) ([]byte, error) {
	req := c.Request("key/list")
	if options != nil {
		req.Option("l", options.L)
		req.Option("ipns-base", options.IpnsBase)
	}
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

type KeyRenameOptions struct {
	// Allow to overwrite an existing key.
	Force bool
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

func (c *Client) KeyRename(ctx context.Context, name string, newname string, options *KeyRenameOptions) ([]byte, error) {
	req := c.Request("key/rename")
	req.Arguments(name)
	req.Arguments(newname)
	if options != nil {
		req.Option("force", options.Force)
		req.Option("ipns-base", options.IpnsBase)
	}
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

type KeyRmOptions struct {
	// Show extra information about keys.
	L bool
	// Encoding used for keys: Can either be a multibase encoded CID or a base58btc encoded multihash. Takes {b58mh|base36|k|base32|b...}. Default: base36.
	IpnsBase string
}

func (c *Client) KeyRm(ctx context.Context, name []string, options *KeyRmOptions) ([]byte, error) {
	req := c.Request("key/rm")
	req.Arguments(name...)
	if options != nil {
		req.Option("l", options.L)
		req.Option("ipns-base", options.IpnsBase)
	}
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

type KeyRotateOptions struct {
	// Keystore name to use for backing up your existing identity.
	Oldkey string
	// type of the key to create: rsa, ed25519. Default: ed25519.
	Type string
	// size of the key to generate.
	Size int
}

func (c *Client) KeyRotate(ctx context.Context, options *KeyRotateOptions) ([]byte, error) {
	req := c.Request("key/rotate")
	if options != nil {
		req.Option("oldkey", options.Oldkey)
		req.Option("type", options.Type)
		req.Option("size", options.Size)
	}
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

type LsOptions struct {
	// Print table headers (Hash, Size, Name).
	Headers bool
	// Resolve linked objects to find out their types. Default: true.
	ResolveType bool
	// Resolve linked objects to find out their file size. Default: true.
	Size bool
	// Enable experimental streaming of directory entries as they are traversed.
	Stream bool
}

func (c *Client) Ls(ctx context.Context, ipfsPath []string, options *LsOptions) ([]byte, error) {
	req := c.Request("ls")
	req.Arguments(ipfsPath...)
	if options != nil {
		req.Option("headers", options.Headers)
		req.Option("resolve-type", options.ResolveType)
		req.Option("size", options.Size)
		req.Option("stream", options.Stream)
	}
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

type MultibaseEncodeOptions struct {
	// multibase encoding. Default: base64url.
	B string
}

func (c *Client) MultibaseEncode(ctx context.Context, f io.Reader, options *MultibaseEncodeOptions) ([]byte, error) {
	req := c.Request("multibase/encode")
	req.FileBody(f)
	if options != nil {
		req.Option("b", options.B)
	}
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

type MultibaseListOptions struct {
	// also include the single letter prefixes in addition to the code.
	Prefix bool
	// also include numeric codes.
	Numeric bool
}

func (c *Client) MultibaseList(ctx context.Context, options *MultibaseListOptions) ([]byte, error) {
	req := c.Request("multibase/list")
	if options != nil {
		req.Option("prefix", options.Prefix)
		req.Option("numeric", options.Numeric)
	}
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

type MultibaseTranscodeOptions struct {
	// multibase encoding. Default: base64url.
	B string
}

func (c *Client) MultibaseTranscode(ctx context.Context, f io.Reader, options *MultibaseTranscodeOptions) ([]byte, error) {
	req := c.Request("multibase/transcode")
	req.FileBody(f)
	if options != nil {
		req.Option("b", options.B)
	}
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

type NamePublishOptions struct {
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

func (c *Client) NamePublish(ctx context.Context, ipfsPath string, options *NamePublishOptions) ([]byte, error) {
	req := c.Request("name/publish")
	req.Arguments(ipfsPath)
	if options != nil {
		req.Option("resolve", options.Resolve)
		req.Option("lifetime", options.Lifetime)
		req.Option("allow-offline", options.AllowOffline)
		req.Option("ttl", options.Ttl)
		req.Option("key", options.Key)
		req.Option("quieter", options.Quieter)
		req.Option("ipns-base", options.IpnsBase)
	}
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

type NameResolveOptions struct {
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

func (c *Client) NameResolve(ctx context.Context, name string, options *NameResolveOptions) ([]byte, error) {
	req := c.Request("name/resolve")
	req.Arguments(name)
	if options != nil {
		req.Option("recursive", options.Recursive)
		req.Option("nocache", options.Nocache)
		req.Option("dht-record-count", options.DhtRecordCount)
		req.Option("dht-timeout", options.DhtTimeout)
		req.Option("stream", options.Stream)
	}
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

type PinAddOptions struct {
	// Recursively pin the object linked to by the specified object(s). Default: true.
	Recursive bool
	// Show progress.
	Progress bool
}

func (c *Client) PinAdd(ctx context.Context, ipfsPath []string, options *PinAddOptions) ([]byte, error) {
	req := c.Request("pin/add")
	req.Arguments(ipfsPath...)
	if options != nil {
		req.Option("recursive", options.Recursive)
		req.Option("progress", options.Progress)
	}
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

type PinLsOptions struct {
	// The type of pinned keys to list. Can be "direct", "indirect", "recursive", or "all". Default: all.
	Type string
	// Write just hashes of objects.
	Quiet bool
	// Enable streaming of pins as they are discovered.
	Stream bool
}

func (c *Client) PinLs(ctx context.Context, ipfsPath []string, options *PinLsOptions) ([]byte, error) {
	req := c.Request("pin/ls")
	req.Arguments(ipfsPath...)
	if options != nil {
		req.Option("type", options.Type)
		req.Option("quiet", options.Quiet)
		req.Option("stream", options.Stream)
	}
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

type PinRemoteAddOptions struct {
	// Name of the remote pinning service to use (mandatory).
	Service string
	// An optional name for the pin.
	Name string
	// Add to the queue on the remote service and return immediately (does not wait for pinned status). Default: false.
	Background bool
}

func (c *Client) PinRemoteAdd(ctx context.Context, ipfsPath string, options *PinRemoteAddOptions) ([]byte, error) {
	req := c.Request("pin/remote/add")
	req.Arguments(ipfsPath)
	if options != nil {
		req.Option("service", options.Service)
		req.Option("name", options.Name)
		req.Option("background", options.Background)
	}
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

type PinRemoteLsOptions struct {
	// Name of the remote pinning service to use (mandatory).
	Service string
	// Return pins with names that contain the value provided (case-sensitive, exact match).
	Name string
	// Return pins for the specified CIDs (comma-separated).
	Cid []string
	// Return pins with the specified statuses (queued,pinning,pinned,failed). Default: [pinned].
	Status []string
}

func (c *Client) PinRemoteLs(ctx context.Context, options *PinRemoteLsOptions) ([]byte, error) {
	req := c.Request("pin/remote/ls")
	if options != nil {
		req.Option("service", options.Service)
		req.Option("name", options.Name)
		req.Option("cid", options.Cid)
		req.Option("status", options.Status)
	}
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

type PinRemoteRmOptions struct {
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

func (c *Client) PinRemoteRm(ctx context.Context, options *PinRemoteRmOptions) ([]byte, error) {
	req := c.Request("pin/remote/rm")
	if options != nil {
		req.Option("service", options.Service)
		req.Option("name", options.Name)
		req.Option("cid", options.Cid)
		req.Option("status", options.Status)
		req.Option("force", options.Force)
	}
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

type PinRemoteServiceLsOptions struct {
	// Try to fetch and display current pin count on remote service (queued/pinning/pinned/failed). Default: false.
	Stat bool
}

func (c *Client) PinRemoteServiceLs(ctx context.Context, options *PinRemoteServiceLsOptions) ([]byte, error) {
	req := c.Request("pin/remote/service/ls")
	if options != nil {
		req.Option("stat", options.Stat)
	}
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

type PinRmOptions struct {
	// Recursively unpin the object linked to by the specified object(s). Default: true.
	Recursive bool
}

func (c *Client) PinRm(ctx context.Context, ipfsPath []string, options *PinRmOptions) ([]byte, error) {
	req := c.Request("pin/rm")
	req.Arguments(ipfsPath...)
	if options != nil {
		req.Option("recursive", options.Recursive)
	}
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

type PinUpdateOptions struct {
	// Remove the old pin. Default: true.
	Unpin bool
}

func (c *Client) PinUpdate(ctx context.Context, fromPath string, toPath string, options *PinUpdateOptions) ([]byte, error) {
	req := c.Request("pin/update")
	req.Arguments(fromPath)
	req.Arguments(toPath)
	if options != nil {
		req.Option("unpin", options.Unpin)
	}
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

type PinVerifyOptions struct {
	// Also write the hashes of non-broken pins.
	Verbose bool
	// Write just hashes of broken pins.
	Quiet bool
}

func (c *Client) PinVerify(ctx context.Context, options *PinVerifyOptions) ([]byte, error) {
	req := c.Request("pin/verify")
	if options != nil {
		req.Option("verbose", options.Verbose)
		req.Option("quiet", options.Quiet)
	}
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

type PingOptions struct {
	// Number of ping messages to send. Default: 10.
	Count int
}

func (c *Client) Ping(ctx context.Context, peerId []string, options *PingOptions) ([]byte, error) {
	req := c.Request("ping")
	req.Arguments(peerId...)
	if options != nil {
		req.Option("count", options.Count)
	}
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

type RefsOptions struct {
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

func (c *Client) Refs(ctx context.Context, ipfsPath []string, options *RefsOptions) ([]byte, error) {
	req := c.Request("refs")
	req.Arguments(ipfsPath...)
	if options != nil {
		req.Option("format", options.Format)
		req.Option("edges", options.Edges)
		req.Option("unique", options.Unique)
		req.Option("recursive", options.Recursive)
		req.Option("max-depth", options.MaxDepth)
	}
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

type RepoGcOptions struct {
	// Stream errors.
	StreamErrors bool
	// Write minimal output.
	Quiet bool
	// Write no output.
	Silent bool
}

func (c *Client) RepoGc(ctx context.Context, options *RepoGcOptions) ([]byte, error) {
	req := c.Request("repo/gc")
	if options != nil {
		req.Option("stream-errors", options.StreamErrors)
		req.Option("quiet", options.Quiet)
		req.Option("silent", options.Silent)
	}
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

type RepoMigrateOptions struct {
	// Allow downgrading to a lower repo version.
	AllowDowngrade bool
}

func (c *Client) RepoMigrate(ctx context.Context, options *RepoMigrateOptions) ([]byte, error) {
	req := c.Request("repo/migrate")
	if options != nil {
		req.Option("allow-downgrade", options.AllowDowngrade)
	}
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

type RepoStatOptions struct {
	// Only report RepoSize and StorageMax.
	SizeOnly bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

func (c *Client) RepoStat(ctx context.Context, options *RepoStatOptions) ([]byte, error) {
	req := c.Request("repo/stat")
	if options != nil {
		req.Option("size-only", options.SizeOnly)
		req.Option("human", options.Human)
	}
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

type RepoVersionOptions struct {
	// Write minimal output.
	Quiet bool
}

func (c *Client) RepoVersion(ctx context.Context, options *RepoVersionOptions) ([]byte, error) {
	req := c.Request("repo/version")
	if options != nil {
		req.Option("quiet", options.Quiet)
	}
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

type ResolveOptions struct {
	// Resolve until the result is an IPFS name. Default: true.
	Recursive bool
	// Number of records to request for DHT resolution.
	DhtRecordCount int
	// Max time to collect values during DHT resolution eg "30s". Pass 0 for no timeout.
	DhtTimeout string
}

func (c *Client) Resolve(ctx context.Context, name string, options *ResolveOptions) ([]byte, error) {
	req := c.Request("resolve")
	req.Arguments(name)
	if options != nil {
		req.Option("recursive", options.Recursive)
		req.Option("dht-record-count", options.DhtRecordCount)
		req.Option("dht-timeout", options.DhtTimeout)
	}
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

type RoutingFindpeerOptions struct {
	// Print extra information.
	Verbose bool
}

func (c *Client) RoutingFindpeer(ctx context.Context, peerid []string, options *RoutingFindpeerOptions) ([]byte, error) {
	req := c.Request("routing/findpeer")
	req.Arguments(peerid...)
	if options != nil {
		req.Option("verbose", options.Verbose)
	}
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

type RoutingFindprovsOptions struct {
	// Print extra information.
	Verbose bool
	// The number of providers to find. Default: 20.
	NumProviders int
}

func (c *Client) RoutingFindprovs(ctx context.Context, key []string, options *RoutingFindprovsOptions) ([]byte, error) {
	req := c.Request("routing/findprovs")
	req.Arguments(key...)
	if options != nil {
		req.Option("verbose", options.Verbose)
		req.Option("num-providers", options.NumProviders)
	}
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

type RoutingGetOptions struct {
	// Print extra information.
	Verbose bool
}

func (c *Client) RoutingGet(ctx context.Context, key []string, options *RoutingGetOptions) ([]byte, error) {
	req := c.Request("routing/get")
	req.Arguments(key...)
	if options != nil {
		req.Option("verbose", options.Verbose)
	}
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

type RoutingProvideOptions struct {
	// Print extra information.
	Verbose bool
	// Recursively provide entire graph.
	Recursive bool
}

func (c *Client) RoutingProvide(ctx context.Context, key []string, options *RoutingProvideOptions) ([]byte, error) {
	req := c.Request("routing/provide")
	req.Arguments(key...)
	if options != nil {
		req.Option("verbose", options.Verbose)
		req.Option("recursive", options.Recursive)
	}
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

type RoutingPutOptions struct {
	// Print extra information.
	Verbose bool
}

func (c *Client) RoutingPut(ctx context.Context, key string, f io.Reader, options *RoutingPutOptions) ([]byte, error) {
	req := c.Request("routing/put")
	req.Arguments(key)
	req.FileBody(f)
	if options != nil {
		req.Option("verbose", options.Verbose)
	}
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

type StatsBitswapOptions struct {
	// Print extra information.
	Verbose bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

func (c *Client) StatsBitswap(ctx context.Context, options *StatsBitswapOptions) ([]byte, error) {
	req := c.Request("stats/bitswap")
	if options != nil {
		req.Option("verbose", options.Verbose)
		req.Option("human", options.Human)
	}
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

type StatsBwOptions struct {
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

func (c *Client) StatsBw(ctx context.Context, options *StatsBwOptions) ([]byte, error) {
	req := c.Request("stats/bw")
	if options != nil {
		req.Option("peer", options.Peer)
		req.Option("proto", options.Proto)
		req.Option("poll", options.Poll)
		req.Option("interval", options.Interval)
	}
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

type StatsRepoOptions struct {
	// Only report RepoSize and StorageMax.
	SizeOnly bool
	// Print sizes in human readable format (e.g., 1K 234M 2G).
	Human bool
}

func (c *Client) StatsRepo(ctx context.Context, options *StatsRepoOptions) ([]byte, error) {
	req := c.Request("stats/repo")
	if options != nil {
		req.Option("size-only", options.SizeOnly)
		req.Option("human", options.Human)
	}
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

type SwarmAddrsLocalOptions struct {
	// Show peer ID in addresses.
	Id bool
}

func (c *Client) SwarmAddrsLocal(ctx context.Context, options *SwarmAddrsLocalOptions) ([]byte, error) {
	req := c.Request("swarm/addrs/local")
	if options != nil {
		req.Option("id", options.Id)
	}
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

type SwarmPeersOptions struct {
	// display all extra information.
	Verbose bool
	// Also list information about open streams for each peer.
	Streams bool
	// Also list information about latency to each peer.
	Latency bool
	// Also list information about the direction of connection.
	Direction bool
}

func (c *Client) SwarmPeers(ctx context.Context, options *SwarmPeersOptions) ([]byte, error) {
	req := c.Request("swarm/peers")
	if options != nil {
		req.Option("verbose", options.Verbose)
		req.Option("streams", options.Streams)
		req.Option("latency", options.Latency)
		req.Option("direction", options.Direction)
	}
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

type VersionOptions struct {
	// Only show the version number.
	Number bool
	// Show the commit hash.
	Commit bool
	// Show repo version.
	Repo bool
	// Show all version information.
	All bool
}

func (c *Client) Version(ctx context.Context, options *VersionOptions) ([]byte, error) {
	req := c.Request("version")
	if options != nil {
		req.Option("number", options.Number)
		req.Option("commit", options.Commit)
		req.Option("repo", options.Repo)
		req.Option("all", options.All)
	}
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
