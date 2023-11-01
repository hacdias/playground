#include <bits/stdc++.h>
using namespace std;

const int MOD = 1000000007;

typedef pair<int, int> pii;
typedef vector<pii> vpii;
typedef vector<vpii> vvpii;

int main() {
    int n, sum = 0;
    scanf("%d", &n);
    vvpii adj(n + 1);

    for (int i = 0; i <= n; i++) adj[i] = vpii();
    for (int i = 0; i < n - 1; i++) {
        int x, y, b;
        scanf("%d %d %d", &x, &y, &b);

        adj[x].push_back(make_pair(y, b));
        adj[y].push_back(make_pair(x, b));
    }

    for (int i = 1; i <= n; i++) {
        queue<pii> q;
        q.push(make_pair(i, INT_MIN));

        bool vis[n + 1];
        memset(vis, false, sizeof(vis));

        while (!q.empty()) {
            pii v = q.front(); q.pop();

            if (vis[v.first]) continue;
            vis[v.first] = true;

            if (i < v.first) {
                sum += v.second % MOD;
            }

            for (int j = 0; j < adj[v.first].size(); j++) {
                pii e = adj[v.first][j];
                q.push(make_pair(e.first, max(e.second, v.second)));
            }
        }
    }

    printf("%d\n", sum);
    return 0;
}
