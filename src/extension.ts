import * as vscode from 'vscode';
import newNote from './commands/new-note';

export function activate(context: vscode.ExtensionContext) {
	const commands = [
		vscode.commands.registerCommand('notes.newNote', newNote),
	];

	context.subscriptions.push(...commands);
}

export function deactivate() {}
