#include <bits/stdc++.h>
using namespace std;

int n, r, m, o, s[500];

int main() {
  scanf("%d", &n);
  while (n--) {
    scanf("%d", &r);
    for (int i = 0; i < r; i++) scanf("%d", &s[i]);
    sort(s, s+r);
    m = s[r >> 1];
    o = 0;
    for (int i = 0; i < r; i++) {
      o += abs(m-s[i]);
    }
    printf("%d\n", o);
  }
  return 0;
}
