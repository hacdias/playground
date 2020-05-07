import * as vscode from 'vscode';

export default function newNote() {
  vscode.window.activeTextEditor?.insertSnippet(new vscode.SnippetString(new Date().toISOString()));
}