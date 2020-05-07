import * as vscode from 'vscode';
import * as path from 'path';
import * as yaml from 'js-yaml';

export default function onWillSaveDocument (e: vscode.TextDocumentWillSaveEvent) {
  const ext = path.extname(e.document.fileName);
  if (ext !== '.md' && ext !== '.markdown') {
    return;
  }

  const edit = async () => {
    /*
    
    TODO const firstLine = e.document.lineAt(0);

    
    if (firstLine.text.trim() !== '---') {
      const edit = new vscode.WorkspaceEdit();
      edit.insert(e.document.uri, e.document.positionAt(0), `---\ndate: ${new Date().toISOString()}\n---\n`);
      console.debug('Insert at beginning');
      return [edit];
    }

    /* const text = e.document.getText();
    const [rawMeta, content] = text.split('\n---');
    let meta = null;

    try {
      meta = yaml.safeLoad(rawMeta);
    } catch (_) {}

    if (meta === null) {
      // Does not have metadata
    }

   /*  const newText = `---\n${yaml.safeDump(meta)}---\n\n${content?.trim()}`;
    
    const edit = new vscode.WorkspaceEdit();
    edit.replace(e.document.uri, new vscode.Range(e.document.getWordRangeAtPosition())) */
 
    /* const edit = new vscode.WorkspaceEdit();

    edit.replace();

    edit.insert(document.uri, firstLine.range.start, '42\n');

    return vscode.workspace.applyEdit(edit);

    vscode.window.showInformationMessage('Executing!');

    return null;  */
  };

  e.waitUntil(edit());
}