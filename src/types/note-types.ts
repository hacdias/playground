import * as vscode from 'vscode';

export interface Type {
  name: string;
  directory: string;
  make: (name: string) => string;
  range: vscode.Range;
};

export class Zettel implements Type {
  name: string = 'Zettel';
  directory: string = 'zettels';
  make: (name: string) => string = (name: string) => `---
date: ${new Date().toISOString()}
title: ${name}
tags: []
---\n\n`;
  range: vscode.Range = new vscode.Range(6, 0, 6, 0);
};

export class Talk implements Type {
  name: string = 'Talk';
  directory: string = 'talks';
  make: (name: string) => string = (name: string) => `---
date: ${new Date().toISOString()}
title: ${name}
speaker: 
talk: 
tags: []
---\n\n`;
  range: vscode.Range = new vscode.Range(3, 9, 3, 9);
};

export class Raw implements Type {
  name: string = 'Raw';
  directory: string = '';
  make: (name: string) => string = (name: string) => `---
date: ${new Date().toISOString()}
title: ${name}
tags: []
---\n\n`;
  range: vscode.Range = new vscode.Range(6, 0, 6, 0);
};
