import * as vscode from 'vscode';
import * as path from 'path';
import * as fs from 'fs-extra';
import slugify from 'slugify';
import { Type, Zettel, Talk, Raw } from '../types/note-types';

function getWorkSpaceUri () {
  let workspaceUri = '';
  if (vscode.workspace.workspaceFolders) {
    workspaceUri = vscode.workspace.workspaceFolders[0].uri.path.toString();
  }
  return workspaceUri;
}

const types: Type[] = [
  new Zettel(),
  new Raw(),
  new Talk()
];

const typesNames: string[] = types.map(type => type.name);

const typesByNames: { [name: string]: Type } = types.reduce((acc: { [name: string]: Type }, type: Type) => {
  acc[type.name] = type;
  return acc;
}, {});

export default async function newNote () {
  try {
    const title = (await vscode.window.showInputBox({
      prompt: 'Enter your new note title.',
      value: ''
    }))?.trim();

    if (!title) {
      console.debug('Note title was empty.');
      return false;
    }
    
    const slug = makeSlug(title);
    const typeName = (await vscode.window.showQuickPick(typesNames));

    if (!typeName) {
      console.debug('Type was empty.');
      return false;
    }

    const type = typesByNames[typeName];
    const filename = path.join(getWorkSpaceUri(), type.directory, `${slug}.md`);
    const exists = await fs.pathExists(filename);

    if (!exists) {
      await fs.outputFile(filename, type.make(title));
    }

    await vscode.window.showTextDocument(vscode.Uri.file(filename), {
      preserveFocus: false,
      preview: false
    });

    if (!exists && vscode.window.activeTextEditor) {
      vscode.window.activeTextEditor.revealRange(type.range);
      vscode.window.activeTextEditor.selection = new vscode.Selection(type.range.start, type.range.end);
    }
  } catch (err) {
    vscode.window.showErrorMessage('Error creating new note.');
  }
}

function makeSlug (text: string) {
  return slugify(text, {
    strict: true,
    lower: true
  });
}
