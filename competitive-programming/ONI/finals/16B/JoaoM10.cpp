#include <bits/stdc++.h>
using namespace std;

int l, c, a[1005][1005], q, rl, rc, s[1005][1005], h[1005*1005], cnt;

bool invcheck(int x, int z) {
  for (int i = 1; i <= l; i ++)
    for (int j = 1; j <= c; j ++) {
      s[i][j] = s[i][j - 1] + s[i - 1][j] - s[i - 1][j - 1] + (a[i][j] <= x ? 1 : 0);
      if (s[i][j] - s[i][j - rc] - s[i - rl][j] + s[i - rl][j - rc] == rl * rc)
        return false;
    }
  return true;
}

int main() {
  scanf("%d %d", &l, &c);
  for (int i = 1; i <= l; i ++)
    for (int j = 1; j <= c; j ++) {
      scanf("%d", &a[i][j]);
      h[cnt ++] = a[i][j];
    }
  sort(h, h + l*c);
  scanf("%d", &q);
  while (q --) {
    scanf("%d %d", &rl, &rc);
    printf("%d\n", *lower_bound(h, h + l*c, 1, invcheck) + 1);
  }
  return 0;
}
