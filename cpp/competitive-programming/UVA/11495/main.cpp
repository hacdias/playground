#include <bits/stdc++.h>
using namespace std;

int n, t, g[100000];

void merge(int fi, int la, int mid) {
  vector<int> x;
  int a = fi, b = mid;
  while (a < mid || b < la) {
    if (a >= mid) {
      x.push_back(g[b++]);
      continue;
    }

    if (b >= la || g[a] < g[b]) {
      x.push_back(g[a++]);
      continue;
    }

    x.push_back(g[b++]);
    t += mid - a;
  }
  for (int a = fi, b = 0; a < la; a++, b++) {
    g[a] = x[b];
  }
}

void mergeSort(int fi, int la) {
  if (la <= fi+1) return;
  int mid = (fi+la)/2;
  mergeSort(fi, mid);
  mergeSort(mid, la);
  merge(fi, la, mid);
}

int main() {
  while(scanf("%d", &n) && n != 0) {
    t = 0;
    for (int i = 0; i < n; i++) scanf("%d", &g[i]);
    mergeSort(0, n);
    (t%2 == 0) ? printf("Carlos\n") : printf("Marcelo\n");
  }
  return 0;
}
