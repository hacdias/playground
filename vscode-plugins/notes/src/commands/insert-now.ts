import * as vscode from 'vscode';

export default function () {
  vscode.window.activeTextEditor?.insertSnippet(new vscode.SnippetString(new Date().toISOString()));
}