import * as vscode from 'vscode';
import * as fs from 'fs-extra';
import * as path from 'path';

export class BackLink {
	relativePath: string;
	uri: vscode.Uri;

	constructor(relativePath: string, uri: vscode.Uri) {
		this.relativePath = relativePath;
		this.uri = uri;
	}
}

// TODO: implement cache.
export class BackLinksCollector {
	links: { [from: string] : string[]; } = {};
	cache: { [to: string]: string[]; } = {};
	context: vscode.ExtensionContext;
	onUpdate: Function = () => {};

	constructor(context: vscode.ExtensionContext) {
		this.context = context;
		this.start();
	}

	get (): BackLink[] {
		const filename = cleanPath(vscode.window.activeTextEditor?.document.fileName);
		return (this.cache[filename] || []).map(relativePath => {
			const uri = vscode.Uri.file(path.join(vscode.workspace?.rootPath || '', relativePath));
			return new BackLink(relativePath, uri);
		});
	}

	async start () {
		const files = await vscode.workspace.findFiles('**/*');
		const mdFiles = files.filter(isMarkdown);

		for (const file of mdFiles) {
			const content = fs.readFileSync(file.path).toString();
			this.update(file, content);
		}

		this.generate();

		vscode.workspace.onDidSaveTextDocument((e: vscode.TextDocument) => {
			const file = e.uri;
			const content = e.getText();
			this.update(file, content);
			this.generate();
		});
	}

	private update (file: vscode.Uri, content: string) {
		const links = matchAll(content, /\[(.*?)\]\((.*?)\)/g)
			.map(arr => cleanPath(arr[2]));

		const from = cleanPath(file.path);
		this.links[from] = links;
	}

	private generate () {
		const cache: { [to: string]: string[]; } = {};

		for (const from in this.links) {
			for (const to of this.links[from]) {
				cache[to] = cache[to] || [];
				cache[to].push(from);
			}
		}

		
		this.cache = cache;
		this.onUpdate();
	}
}

function isMarkdown (uri: vscode.Uri): boolean {
	return uri.scheme === 'file' && (uri.path.endsWith('.md') || uri.path.endsWith('.markdown'));
}

function matchAll (text: string, pattern: RegExp) {
	const matches = [];
	let match;
	do {
			match = pattern.exec(text);
			if (match) {
				matches.push(match);
			}
	} while (match);
	return matches;
}

function cleanPath (path?: string): string {
	if (!path) {
		return '';
	}

	const root = vscode.workspace.rootPath || '';
	path = vscode.workspace.asRelativePath(path);
	path = path.replace(root, '');

	if (path.startsWith('./')) {
		path = path.substr(2);
	}

	if (path.startsWith('/')) {
		path = path.substr(1);
	}

	return path;
}
