#include <bits/stdc++.h>
using namespace std;

const int MOD = 1000000007;

int main() {
    int n, sum = 0;
    scanf("%d", &n);

    int bel[n+50][n+50];
    memset(bel, 0, sizeof bel);
    for (int i = 0; i < n - 1; i++) {
        int x, y, b;
        scanf("%d %d %d", &x, &y, &b);

        bel[x][y] = b;
        bel[y][x] = b;
    }

    for (int i = 1; i <= n; i++)
        for (int j = i + 1; j <= n; j++)
                for (int k = 1; k <= n; k++) {
                    if (bel[i][k] != 0 && bel[k][j] != 0)
                        bel[i][j] = max(bel[i][j], max(bel[i][k], bel[k][j]));
                }

    for (int i = 1; i <= n; i++)
        for (int j = i + 1; j <= n; j++)
            sum += bel[i][j] % MOD;

    printf("%d\n", sum);
    return 0;
}
