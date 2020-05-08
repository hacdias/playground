import * as vscode from 'vscode';
import { Indexer, IndexEntry } from './indexer';

class OpenCommand implements vscode.Command {
  title: string = "Open";
  command: string = "notes.openFile";
  arguments: any[] = [];

  constructor(entry: IndexEntry) {
    this.arguments = [entry.path];
  }
}

class TreeItem extends vscode.TreeItem {
  constructor(label: string, command: OpenCommand) {
    super(label);
    this.command = command;
  }
}

export class BackLinksProvider implements vscode.TreeDataProvider<IndexEntry> {
  collector: Indexer;
  private _onDidChangeTreeData: vscode.EventEmitter<IndexEntry | undefined> = new vscode.EventEmitter<IndexEntry | undefined>();
  readonly onDidChangeTreeData: vscode.Event<IndexEntry | undefined> = this._onDidChangeTreeData.event;

  constructor(collector: Indexer) {
    this.collector = collector;
  }

  getTreeItem(entry: IndexEntry): vscode.TreeItem {
    return new TreeItem(entry.title, new OpenCommand(entry));
  }

  getChildren(element?: IndexEntry): Thenable<IndexEntry[]> {
    if (element) {
      return Promise.resolve([]);
    }

    return Promise.resolve(this.collector.getCurrentBackLinks());
  }

  refresh(): void {
    this._onDidChangeTreeData.fire();
  }
}