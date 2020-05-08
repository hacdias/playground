import * as vscode from 'vscode';

export default function insertDate () {
  vscode.window.activeTextEditor?.insertSnippet(new vscode.SnippetString(new Date().toISOString()));
}