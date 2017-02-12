#include <iostream>
#include <vector>
#include <cstdio>
#include <bits/stdc++.h>
using namespace std;

int t, x, y, f, s[1000100], a[1000100];

int main() {
  vector<int> oi;
  scanf("%d", &t);
  while(t--) {
    scanf("%d %d %d", &x, &y, &f);
    for (int i = 0; i < f; i++) scanf("%d %d", &s[i], &a[i]);
    sort(s, s+f);
    sort(a, a+f);
    (f%2 == 0) ? printf("(Street: %d, Avenue: %d)\n", s[(f-1)/2], a[(f-1)/2]) : printf("(Street: %d, Avenue: %d)\n", s[f/2], a[f/2]);
  }
  return 0;
}
