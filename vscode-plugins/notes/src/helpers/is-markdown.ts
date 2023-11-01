import * as vscode from 'vscode';

export default function isMarkdown(uri: vscode.Uri): boolean {
	return uri.scheme === 'file' && (uri.path.endsWith('.md') || uri.path.endsWith('.markdown'));
}
