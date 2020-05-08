import * as vscode from 'vscode';
import { Indexer } from '../types/indexer';

function getData(collector: Indexer) {
  const links = collector.getIndex();

  const nodes: any[] = [];
  const edgesHelper: any = {};
  const edges: any[] = [];

  for (const from in links) {
    nodes.push({ id: from, label: links[from].title });

    for (const to of links[from].links) {
      edgesHelper[from] = edgesHelper[from] || [];
      edgesHelper[to] = edgesHelper[to] || [];
      if (!edgesHelper[from].includes(to) && !edgesHelper[to].includes(from)) {
        edgesHelper[from].push(to);
        edges.push({ from, to });
      }
    }
  }

  return { nodes, edges };
}

export default function openMindMap(collector: Indexer) {
  const panel = vscode.window.createWebviewPanel(
    'mindMap',
    'Mind Map',
    vscode.ViewColumn.Active,
    {
      enableScripts: true
    }
  );

  const updater = () => {
    panel.webview.postMessage(getData(collector));
  };

  // TODO: bundle vis.js
  panel.webview.html = getWebviewContent(getData(collector));

  collector.on('backLinksUpdated', updater);
  panel.onDidDispose(() => {
    collector.removeListener('backLinksUpdated', updater);
  });
}

function getWebviewContent(data: any) {
  return `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mind Map</title>
  <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
  <style type="text/css">
  #network {
    width: 100%;
    height: 100vh;
  }
  #network .vis-network {
    outline: 0 !important;
  }
  </style>
</head>
<body>
  <div id="network"></div>
  <script type="text/javascript">
    var container = document.getElementById('network');
    var options = {
    };
    var initialData = JSON.parse('${JSON.stringify(data)}');
    var network = new vis.Network(container, initialData, options);

    window.addEventListener('message', event => {
      var { nodes, edges } = event.data; // The JSON data our extension sent
      var nodes = new vis.DataSet(nodes);
      var edges = new vis.DataSet(edges);
      network.setData({ nodes, edges });
    });
</script>
</body>
</html>`;
}
