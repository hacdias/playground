#include <bits/stdc++.h>
using namespace std;

const int MOD = 1000000007;

int n, iter;
vector<vector<pair<int, int> > > graph;

int main() {
    scanf("%d\n", &n);
    graph.resize(n+1);

    for (int i = 1; i < n; i++) {
        int x, y, b;
        scanf("%d %d %d", &x, &y, &b);

        graph[x].push_back(make_pair(y, b));
        graph[y].push_back(make_pair(x, b));
    }

    int sum = 0;

    for (int i = 1; i <= n; i++) {
        queue<pair<int, int> > q;
        q.push(make_pair(i, INT_MIN));

        bool vis[n+1];

        while(!q.empty()){

            pair<int,int> v = q.front();
            q.pop();

            if (vis[v.first]) continue;
            vis[v.first] = true;

            if (i < v.first)
                sum += v.second % MOD;
            for (int j = 0; j < graph[i].size(); j++){
                pair<int,int> e = graph[i][j];
                q.push(make_pair(e.first, max(v.second, e.second)));
            }
        }
    }

    printf("%d\n", sum);
    return 0;
}
