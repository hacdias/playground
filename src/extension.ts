import * as vscode from 'vscode';
import newNote from './commands/new-note';
import insertDate from './commands/insert-date';
import updateDate from './commands/update-date';
import openMindMap from './commands/open-mind-map';
import { BackLinksProvider } from './types/backlinks-provider';
import onWillSave from './events/on-will-save';

import { Indexer } from './types/indexer';

export function activate(context: vscode.ExtensionContext) {
	const indexer = new Indexer(context);
	const provider = new BackLinksProvider(indexer);
	const refreshProvider = () => { provider.refresh(); };
	vscode.window.registerTreeDataProvider('backlinks', provider);
	vscode.window.onDidChangeActiveTextEditor(refreshProvider);
	refreshProvider();

	indexer.on('backLinksUpdated', () => {
		refreshProvider();
	});

	vscode.workspace.onWillSaveTextDocument(onWillSave);

	const commands = [
		vscode.commands.registerCommand('notes.newNote', newNote),
		vscode.commands.registerCommand('notes.insertDate', insertDate),
		vscode.commands.registerCommand('notes.updateDate', updateDate),
		vscode.commands.registerCommand('notes.openMindMap', () => openMindMap(indexer)),
		vscode.commands.registerCommand('notes.openFile', (path: string) => {
			vscode.window.showTextDocument(vscode.Uri.file(path), {
				preserveFocus: false,
				preview: false
			});
		}),
		vscode.commands.registerCommand('notes.resetBackLinks', () => {
			indexer.reset();
		})
	];

	context.subscriptions.push(...commands);
}

export function deactivate() {}
