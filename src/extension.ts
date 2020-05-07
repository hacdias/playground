import * as vscode from 'vscode';
import newNote from './commands/new-note';
import insertDate from './commands/insert-date';

export function activate(context: vscode.ExtensionContext) {
	const commands = [
		vscode.commands.registerCommand('notes.newNote', newNote),
		vscode.commands.registerCommand('notes.insertDate', insertDate)
	];

	context.subscriptions.push(...commands);
}

export function deactivate() {}
