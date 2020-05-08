import * as vscode from 'vscode';
import * as path from 'path';

export default function onWillSaveDocument (e: vscode.TextDocumentWillSaveEvent) {
  const ext = path.extname(e.document.fileName);
  if (ext !== '.md' && ext !== '.markdown') {
    return;
  }

  const edit = async () => {
    console.debug('Updating date');
    const firstLine = e.document.lineAt(0);
    
    if (firstLine.text.trim() !== '---') {
      // When there is no yaml frontmatter!
      const pos = new vscode.Position(0, 0);
      const edit = vscode.TextEdit.insert(pos, `---\ndate: ${new Date().toISOString()}\n---\n\n`);
      return [edit];
    }

    for (let i = 1; i < e.document.lineCount; i++) {
      const line = e.document.lineAt(i);
      const text = line.text.trim();

      if (text.startsWith('date:')) {
        // When we need to update the date.
        const start = new vscode.Position(i, 5);
        const end = new vscode.Position(i, text.length);
        const range = new vscode.Range(start, end);
        const edit = vscode.TextEdit.replace(range, ` ${new Date().toISOString()}`);
        return [edit];
      }

      if (text === '---') {
        // When it does not include date already.
        const pos = new vscode.Position(i, 0);
        const edit = vscode.TextEdit.insert(pos, `date: ${new Date().toISOString()}\n`);
        return [edit];
      }
    }

    return [];
  };

  e.waitUntil(edit());
}