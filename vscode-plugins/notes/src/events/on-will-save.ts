import * as vscode from 'vscode';
import * as path from 'path';
import updateDate from '../helpers/update-date';

export default function onWillSaveDocument (e: vscode.TextDocumentWillSaveEvent) {
  const ext = path.extname(e.document.fileName);
  if (ext !== '.md' && ext !== '.markdown') {
    return;
  }

  const config = vscode.workspace.getConfiguration('notes');
  const shouldUpdate = config.get('updateDateOnSave');

  if (!shouldUpdate || e.reason !== vscode.TextDocumentSaveReason.Manual) {
    return;
  }

  const edit = async () => {
    console.debug('Updating date');
    const edit = updateDate(e.document);
   
    if (edit) {
      return [edit];
    }

    return [];
  };

  e.waitUntil(edit());
}