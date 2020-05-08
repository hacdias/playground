import * as vscode from 'vscode';
import * as fs from 'fs-extra';
import * as path from 'path';
import { EventEmitter } from 'events';
import isMarkdown from '../helpers/is-markdown';
import matchAll from '../helpers/match-all';

export interface IndexEntry {
  path: string;
  title: string;
  links: string[];
};

const STATE_KEY = 'notes-index';

export class Indexer extends EventEmitter {
  index: { [path: string]: IndexEntry; } = {};
  backLinkCache: { [path: string]: IndexEntry[]; } = {};
  indexByTitle: { [title: string]: IndexEntry; } = {};
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

    const onChange = async (uri: vscode.Uri) => {
      const entry = await this.parseFile(uri);
      this.index[entry.path] = entry;
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

  getCurrentBackLinks(): IndexEntry[] {
    const editor = vscode.window.activeTextEditor;
    if (!editor) {
      return [];
    }

    const filename = editor.document.uri.path;
    return this.backLinkCache[filename] || [];
  }

  getAllTitles(): string[] {
    return Object.values(this.index).map(e => e.title);
  }

  reset() {
    this.buildIndexFromScratch();
  }

  getIndex() {
    return this.index;
  }

  getIndexByTitle() {
    return this.indexByTitle;
  }

  private async buildIndexFromScratch() {
    console.debug('Building index from scratch');
    const files = await vscode.workspace.findFiles('**/*');
    const mdFiles = files.filter(isMarkdown);
    const entries = await Promise.all(mdFiles.map(this.parseFile));
    this.buildIndexFromEntries(entries);
  }

  private async parseFile(uri: vscode.Uri): Promise<IndexEntry> {
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

  private deleteFile(uri: vscode.Uri) {
    console.log('Deleting file', uri.path);
    delete this.index[uri.path];
  }

  private buildIndexFromEntries(entries: IndexEntry[]) {
    console.debug('Building index from entries');
    const index: { [path: string]: IndexEntry; } = {};

    for (const entry of entries) {
      index[entry.path] = entry;
    }

    this.index = index;
    this.buildBackLinksCache();
  }

  private buildBackLinksCache() {
    console.debug('Storing on workspace state');
    this.context.workspaceState.update(STATE_KEY, this.index);

    console.debug('Regenerating cache');
    const backLinkCache: { [path: string]: IndexEntry[]; } = {};
    const indexByTitle: { [title: string]: IndexEntry; } = {};

    for (const from in this.index) {
      indexByTitle[this.index[from].title] = this.index[from];

      for (let to of this.index[from].links) {
        const hash = to.lastIndexOf('#');
        if (hash !== -1) {
          to = to.substring(0, hash);
        }
        backLinkCache[to] = backLinkCache[to] || [];
        backLinkCache[to].push(this.index[from]);
      }
    }

    this.backLinkCache = backLinkCache;
    this.indexByTitle = indexByTitle;
    // console.debug(cache);
    this.emit('backLinksUpdated', backLinkCache);
  }
}
