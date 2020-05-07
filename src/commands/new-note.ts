import * as vscode from 'vscode';
import * as path from 'path';
import * as fs from 'fs-extra';
import slugify from 'slugify';

function getWorkSpaceUri () {
  let workspaceUri = '';
  if (vscode.workspace.workspaceFolders) {
    workspaceUri = vscode.workspace.workspaceFolders[0].uri.path.toString();
  }
  return workspaceUri;
}

export default async function newNote() {
  try {
    const name = (await vscode.window.showInputBox({
      prompt: 'Enter your new note name.',
      value: ''
    }))?.trim();

    if (!name) {
      console.debug('Note name was empty.');
      return false;
    }
    
    const slug = slugify(name, {
      strict: true,
      lower: true
    });


    const filename = path.join(getWorkSpaceUri(), `${slug}.md`);

    if (!await fs.pathExists(filename)) {
      // TODO: add templates
      const contents = `# ${name}\n\n`;
      await fs.outputFile(filename, contents);
    }

    await vscode.window.showTextDocument(vscode.Uri.file(filename), {
      preserveFocus: false,
      preview: false
    });

    // TODO: if created go to last line

    /* if (!fileAlreadyExists) {
      let editor = vscode.window.activeTextEditor;
      if (editor) {
        const lineNumber = 3;
        let range = editor.document.lineAt(lineNumber - 1).range;
        editor.selection = new vscode.Selection(range.start, range.end);
        editor.revealRange(range);
      }
    }
  }); */
  } catch (err) {
    vscode.window.showErrorMessage('Error creating new note.');
  }
}