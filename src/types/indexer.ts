import * as vscode from 'vscode';
import * as fs from 'fs-extra';
import * as path from 'path';
import { EventEmitter } from 'events';

export interface IndexEntry {
  path: string;
  title: string;
  links: string[];
};

const STATE_KEY = 'notes-index';

export class Indexer extends EventEmitter {
  index: { [path: string]: IndexEntry; } = {};
  backLinkCache: { [path: string]: IndexEntry[]; } = {};
	context: vscode.ExtensionContext;

	constructor(context: vscode.ExtensionContext) {
    super();
    this.context = context;

    const cachedIndex = context.workspaceState.get(STATE_KEY);

		if (cachedIndex) {
			console.debug('Index was cached');
			this.index = <{ [path: string]: IndexEntry; }>cachedIndex;
			this.buildBackLinksCache();
		} else {
			this.buildIndexFromScratch();
		}

		const onDelete = (uri: vscode.Uri) => {
			this.deleteFile(uri);
			this.buildBackLinksCache();
		};

		const onChange = (uri: vscode.Uri) => {
			this.parseFile(uri);
			this.buildBackLinksCache();
		};

		const mdWatch = vscode.workspace.createFileSystemWatcher('**/*.md');
		mdWatch.onDidChange(onChange);
		mdWatch.onDidCreate(onChange);
		mdWatch.onDidDelete(onDelete);

		const markdownWatch = vscode.workspace.createFileSystemWatcher('**/*.markdown');
		markdownWatch.onDidChange(onChange);
		markdownWatch.onDidCreate(onChange);
		markdownWatch.onDidDelete(onDelete);
  }
  
  getCurrentBackLinks (): IndexEntry[] {
    const editor = vscode.window.activeTextEditor;
		if (!editor) {
			return [];
		}

		const filename = editor.document.uri.path;
		return this.backLinkCache[filename] || [];
  }

  reset () {
		this.buildIndexFromScratch();
  }
  
  getIndex () {
    return this.index;
  }

	private async buildIndexFromScratch () {
    console.debug('Building index from scratch');
    const files = await vscode.workspace.findFiles('**/*');
    const mdFiles = files.filter(isMarkdown);
    const entries = await Promise.all(mdFiles.map(this.parseFile));
    this.buildIndexFromEntries(entries);
  }
  
  private async parseFile (uri: vscode.Uri): Promise<IndexEntry> {
    console.debug('Checking file', uri.path);
    const content = (await fs.readFile(uri.path)).toString();
    const links = matchAll(content, /\[(.*?)\]\((.*?)\)/g)
      .map(arr => arr[2])
      .filter((link: string) => !link.startsWith('http:') && !link.startsWith('https:'))
      .map((link: string) => path.resolve(path.dirname(uri.path), link));

    const titleMatch = content.match(/title: (.*)/);
    const title = titleMatch && titleMatch.length === 2
      ? titleMatch[1]
      : path.basename(uri.path);

    return {
      path: uri.path,
      title,
      links
    };
  }

  private deleteFile (uri: vscode.Uri) {
		console.log('Deleting file', uri.path);
    delete this.index[uri.path];
	}

  private buildIndexFromEntries (entries: IndexEntry[]) {
    console.debug('Building index from entries');
    const index: { [path: string]: IndexEntry; } = {};

    for (const entry of entries) {
      index[entry.path] = entry;
    }

    this.index = index;
    this.buildBackLinksCache();
  }

  private buildBackLinksCache () {
    console.debug('Storing on workspace state');
		this.context.workspaceState.update(STATE_KEY, this.index);

		console.debug('Regenerating cache');
		const cache: { [path: string]: IndexEntry[]; } = {};

		for (const from in this.index) {
			for (const to of this.index[from].links) {
				cache[to] = cache[to] || [];
				cache[to].push(this.index[from]);
			}
		}

    this.backLinkCache = cache;

    console.debug(cache);
    this.emit('backLinksUpdated', cache);
  }
}

function isMarkdown (uri: vscode.Uri): boolean {
	return uri.scheme === 'file' && (uri.path.endsWith('.md') || uri.path.endsWith('.markdown'));
}

function matchAll (text: string, pattern: RegExp) {
	const matches = [];
	let match;
	do {
			match = pattern.exec(text);
			if (match) {
				matches.push(match);
			}
	} while (match);
	return matches;
}
