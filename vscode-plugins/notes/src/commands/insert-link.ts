import * as vscode from 'vscode';
import { Indexer } from '../types/indexer';

export default async function (indexer: Indexer) {
  const editor = vscode.window.activeTextEditor;
  if (!editor) {
    return;
  }

  const titles = indexer.getAllTitles();
  const title = await vscode.window.showQuickPick(titles);
  if (!title) {
    return;
  }

  const filename = vscode.workspace.asRelativePath(indexer.getIndexByTitle()[title].path);
  const link = `[${title}](${filename})`;
  editor.insertSnippet(new vscode.SnippetString(link));
}