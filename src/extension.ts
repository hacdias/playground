import * as vscode from 'vscode';
import newNote from './commands/new-note';
import insertDate from './commands/insert-date';
import { BackLinksCollector } from './types/backlinks-collector';
import { BackLinksProvider } from './types/backlinks-provider';

import onWillSave from './events/on-will-save';

export function activate(context: vscode.ExtensionContext) {
	const commands = [
		vscode.commands.registerCommand('notes.newNote', newNote),
		vscode.commands.registerCommand('notes.insertDate', insertDate),
		vscode.commands.registerCommand('notes.openFile', (uri: vscode.Uri) => {
			vscode.window.showTextDocument(uri, {
				preserveFocus: false,
				preview: false
			});
		})
	];

	context.subscriptions.push(...commands);

	vscode.workspace.onWillSaveTextDocument(onWillSave);

	const collector = new BackLinksCollector(context);
	const provider = new BackLinksProvider(collector);

	const refreshProvider = () => { provider.refresh(); };

	vscode.window.registerTreeDataProvider('backlinks', provider);

	vscode.window.onDidChangeActiveTextEditor(refreshProvider);

	collector.onUpdate = refreshProvider;
	refreshProvider();
}

export function deactivate() {}
