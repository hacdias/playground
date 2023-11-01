#include <bits/stdc++.h>
using namespace std;

struct chain {
  int level;
  char str[50];
};

int M, A, m, n;
struct chain seq[100];

int getLevel(const char str[50]) {
  int cnt = 0;
  for (int i = 0; i < n; i++) for (int j = i+1; j < n; j++) if (str[i] > str[j]) cnt++;
  return cnt;
}

bool sortByMostSorted(const chain &c1, const chain &c2) {
  if (c1.level < c2.level) return true;
  return false;
}

int main() {
  scanf("%d", &M);
  while(M--) {
    scanf("%d %d", &n, &m);
    for (int i = 0; i < m; i++) {
      scanf("%s", seq[i].str);
      seq[i].level = getLevel(seq[i].str);
    }
    stable_sort(seq, seq+m, sortByMostSorted);
    for (int i = 0; i < m; i++) {
      printf("%s\n", seq[i].str);
    }
    if (M > 0) printf("\n");
  }
  return 0;
}
