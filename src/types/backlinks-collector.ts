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
		const editor = vscode.window.activeTextEditor;
		if (!editor) {
			return [];
		}

		const filename = editor.document.uri.path;
		return (this.cache[filename] || []).map(path => {
			const relative = vscode.workspace.asRelativePath(path);
			const uri = vscode.Uri.file(path);
			return new BackLink(relative, uri);
		});
	}

	async start () {
		const files = await vscode.workspace.findFiles('**/*');
		const mdFiles = files.filter(isMarkdown);

		for (const file of mdFiles) {
			this.onFileChange(file);
		}

		this.generate();

		const onDelete = (uri: vscode.Uri) => {
			this.onFileDelete(uri);
			this.generate();
		};

		const onChange = (uri: vscode.Uri) => {
			this.onFileChange(uri);
			this.generate();
		};

		const mdWatch = vscode.workspace.createFileSystemWatcher('**/*.md');
		mdWatch.onDidChange(onChange);
		mdWatch.onDidCreate(onChange);
		mdWatch.onDidDelete(onDelete);

		const markdownWatch = vscode.workspace.createFileSystemWatcher('**/*.markdown');
		markdownWatch.onDidChange(onChange);
		markdownWatch.onDidCreate(onChange);
		markdownWatch.onDidDelete(onDelete);
	}

	private onFileChange (uri: vscode.Uri) {
		console.debug('Checking file', uri.path);
		const content = fs.readFileSync(uri.path).toString();
		const links = matchAll(content, /\[(.*?)\]\((.*?)\)/g)
			.map(arr => arr[2])
			.filter((link: string) => !link.startsWith('http:') && !link.startsWith('https:'))
			.map((link: string) => path.resolve(path.dirname(uri.path), link));
			
		if (links.length) {
			this.links[uri.path] = links;
		} else {
			delete this.links[uri.path];
		}
	}

	private onFileDelete (uri: vscode.Uri) {
		console.log('Deleting file', uri.path);
		delete this.links[uri.path];
	}

	private generate () {
		console.debug('Regenerating cache');
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
