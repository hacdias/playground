#include <bits/stdc++.h>
using namespace std;

https://www.quora.com/What-is-the-most-simple-efficient-C++-code-for-Dijkstras-shortest-path-algorithm

typedef pair<int, int> ii;
typedef vector<ii> vii;
typedef vector<int> vi;

// DEPTH FIRST SEARCH (DFS)
const VISITED = 1;
const UNVISITED = -1;

vi dfs_num;
void dfs(int u) {
  dfs_num[u] = VISITED;
  for (int j = 0; j < (int)AdjList[u].size(); j++) {
    ii v = AdjList[u][j];
    if (dfs_num[v.first] == UNVISITED) {
      dfs(v.first);
    }
  }
}

// BUBBLE SORT
void bubbleSort() {
  bool swapped;
  do {
    swapped = false;
    for (int i = 1; i < n; i++) {
      if (g[i-1] > g[i]) {
        swap(g[i-1], g[i]);
        swapped = true; cnt++;
      }
    }
  } while(swapped);
}
