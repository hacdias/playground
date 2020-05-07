import * as vscode from 'vscode';
import { BackLink, BackLinksCollector } from './backlinks-collector';

class OpenCommand implements vscode.Command {
  title: string = "Open";
  command: string = "notes.openFile";
  arguments: any[] = [];

  constructor(file: BackLink) {
    this.arguments = [file.uri];
  }
}

class TreeItem extends vscode.TreeItem {
  constructor(label: string, command: OpenCommand) {
    super(label);
    this.command = command;
  }
}

export class BackLinksProvider implements vscode.TreeDataProvider<BackLink> {
  collector: BackLinksCollector;
  private _onDidChangeTreeData: vscode.EventEmitter<BackLink | undefined> = new vscode.EventEmitter<BackLink | undefined>();
  readonly onDidChangeTreeData: vscode.Event<BackLink | undefined> = this._onDidChangeTreeData.event;

  constructor(collector: BackLinksCollector) {
    this.collector = collector;
  }

  getTreeItem(link: BackLink): vscode.TreeItem {
    return new TreeItem(link.relativePath, new OpenCommand(link));
  }

  getChildren(element?: BackLink): Thenable<BackLink[]> {
    if (element) {
      return Promise.resolve([]);
    }

    return Promise.resolve(this.collector.get());
  }

  refresh(): void {
    this._onDidChangeTreeData.fire();
  }
}