#include <bits/stdc++.h>
using namespace std;

int N, iter;
vector<vector<pair<int, int> > > graph;

int transverse(int from, int to, int maximum, set<int> visited) {
    if (visited.find(to) != visited.end()) return -1;
    visited.insert(to);

    bool run = false;

    for (int i = 0; i < (int)graph[to].size(); i++) {
        run = true;
        if (graph[to][i].first == from) return max(maximum, graph[to][i].second);

        int val = transverse(from, i, max(maximum, graph[to][i].second), visited);
        if (val == -1) continue;

        maximum = max(maximum, val);
    }

    if (!run && from != to) return -1;

    return maximum;
}

int main() {
    scanf("%d\n", &N);
    graph.resize(N+1);

    for (int i = 1; i < N; i++) {
        int x, y, b;
        scanf("%d %d %d", &x, &y, &b);

        graph[x].push_back(make_pair(y, b));
        graph[y].push_back(make_pair(x, b));
    }

    int sum = 0;

    for (int i = 1; i <= N; i++) {
        for (int j = i + 1; j <= N; j++) {
            sum += transverse(i, j, 0, set<int>());
        }
    }

    sum %= 1000000007;
    printf("%d\n", sum);
    return 0;
}
