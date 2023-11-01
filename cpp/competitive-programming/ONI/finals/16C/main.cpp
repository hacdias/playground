#include <bits/stdc++.h>
using namespace std;

#define MAX_N 100000
#define MAX_M 500000

int G, N, M;

vector <int> g[MAX_N], s;
int p[MAX_N], sz[MAX_N], dp[MAX_N], vis[MAX_N];

void init() {
  for (int i = 0; i < n; i ++)
    p[i] = i, sz[i] = 1;
}

void contract(int u, int v) {
  if (u == v) return;
  sz[u] = 0, p[u] = v, sz[v] ++;
  for (auto w : g[u])
    g[v].push_back(w);
}

// Slight modification of subtask 2
int mx_wpath(int v) {
  if (dp[v] == -1) {
    dp[v] = sz[v];
    for (auto u : g[v])
      if (p[u] != v)
	dp[v] = max(dp[v], sz[v] + mx_wpath(p[u]));
  }
  return dp[v];
}

int mx_wcc() {
  int ans = 0;
  memset(dp, -1, sizeof dp);
  for (int i = 0; i < n; i ++)
    ans = max(ans, mx_wpath(i));
  return ans;
}

void pre_scc(int v) {
  if (vis[v]) return;
  vis[v] = 1;
  for (auto u : g[v])
    pre_scc(u);
  S.push_back(v);
}

void contract_scc(int u, int v) {
  if (vis[u]) return;
  vis[u] = 1;
  contract(u, v);
  for (auto w : h[u]) {
    contract_scc(w, v);
  }
}

int solve() {
  init();
  memset(vis, 0, sizeof vis);
  for (int i = 0; i < n; i ++) {
    pre_scc(i);
  }
  memset(vis, 0, sizeof vis);
  for (int i = n - 1; i >= 0; i --) {
    contract_scc(S[i], S[i]);
  }
  return mx_wcc();
}

int main() {
  scanf("%d", &G);
  scanf("%d %d", &N, &M);

  int a, b;

  for (int i = 0; i < M; i++) {
    scanf("%d %d", &a, &b);
    g[a].push_back(b);
  }

  printf("%d\n", solve());
  return 0;
}
