#include <bits/stdc++.h>
using namespace std;

int a, n, c, q, l[1010], s[1000001];

int find(int fi, int la) {
  int mid = (fi+la)/2;
  if (fi == (la-1)) {
    if (abs(s[fi]-q) > abs(s[la]-q)) return s[la];
    return s[fi];
  }
  if (s[mid] > q) return find(fi, mid);
  if (s[mid] < q) return find(mid, la);
  return s[mid];
}

int main() {
  while(scanf("%d", &n) && n != 0) {
    printf("Case %d:\n", ++a);
    for(int i = 0; i < n; i++) scanf("%d", &l[i]);
    c = 0;
    for (int i = 0; i < n; i++) {
      for (int j = 0; j < n; j++) {
        if (i == j) continue;
        s[c++] = l[i] + l[j];
      }
    }
    sort(s, s+n*n-n);
    scanf("%d", &c);
    while(c--) {
      scanf("%d", &q);
      printf("Closest sum to %d is %d.\n", q, find(0, n*n-n));
    }
  }
  return 0;
}
