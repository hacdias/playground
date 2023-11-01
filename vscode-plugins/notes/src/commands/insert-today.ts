import * as vscode from 'vscode';

export default function () {
  const today = new Date();
  const year = today.getFullYear();
  const month = (today.getMonth() + 1).toString().padStart(2, '0');
  const day = today.getDate().toString().padStart(2, '0');
  const title = `${year}-${month}-${day}`;
  vscode.window.activeTextEditor?.insertSnippet(new vscode.SnippetString(title));
}