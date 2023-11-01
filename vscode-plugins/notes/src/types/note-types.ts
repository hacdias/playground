import * as vscode from 'vscode';

export interface Type {
  name: string;
  make: (name: string) => string;
  range: vscode.Range;
};

export class Default implements Type {
  name: string = 'Default';
  make: (name: string) => string = (name: string) => `---
date: ${new Date().toISOString()}
title: ${name}
---\n\n`;
  range: vscode.Range = new vscode.Range(5, 0, 5, 0);
};

export class Talk implements Type {
  name: string = 'Talk';
  directory: string = 'talks';
  make: (name: string) => string = (name: string) => {
    let talk = name
    let speaker = ''

    if (name.includes('-')) {
      const parts = name.split(/-(.+)/);
      talk = parts[0].trim();
      speaker = parts[1].trim();
    }

    return `---
date: ${new Date().toISOString()}
title: ${name}
---

- **talk**: ${talk}
- **speaker**: ${speaker}
- **tags**:\n\n`
  };
  range: vscode.Range = new vscode.Range(9, 0, 9, 0);
};
