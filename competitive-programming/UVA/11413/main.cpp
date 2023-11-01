#include <bits/stdc++.h>
using namespace std;

int n, m, c[1010], hi, lo;

bool simul(int a) {
  int t = 0, cu = 0;
  for (int i = 0; i < n; i++) {
    if (c[i] > a) return false;
    if (cu + c[i] > a) cu = 0;
    if (cu == 0) t++;
    cu += c[i];
    if (t > m) return false;
  }
  return true;
}

int main() {
  while(scanf("%d %d", &n, &m) != EOF) {
    for (int i = 0; i < n; i++) scanf("%d", &c[i]);

    hi = 1000000000, lo = 0;
    while (hi - lo > 0) {
      if (simul(hi)) {
        hi = lo+(hi-lo)/2;
      } else {
        lo = hi;
        hi = hi + hi/2;
      }
    }
    printf("%d\n", hi+1);
  }
  return 0;
}
