import * as vscode from 'vscode';
import updateDate from '../helpers/update-date';

export default function () {
  const doc = vscode.window.activeTextEditor?.document;
  if (!doc) {
    return;
  }

  const edit = updateDate(doc);
  if (!edit) {
    return;
  }

  const workEdits = new vscode.WorkspaceEdit();
  workEdits.set(doc.uri, [edit]);
  vscode.workspace.applyEdit(workEdits); 
}