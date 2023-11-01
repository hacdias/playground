#include <bits/stdc++.h>
using namespace std;

typedef pair<int, int> pii;
int n, x, y, r, i, j;

int main() {
  scanf("%d", &n);
  vector< pii > lines;
  while (n--) {
    scanf("%d %d %d", &x, &y, &r);
    x *= -r;
    lines.push_back(make_pair(x-r, y));
    lines.push_back(make_pair(x, -y));
  }
  sort(lines.begin(), lines.end());
  set<int> cows, now; i = 0;
  while (i < (int)lines.size()) {
    for (j = i; lines[i].first == lines[j].first && j < (int)lines.size(); j++) {
      y = lines[j].second;
      if (y > 0) {
        now.insert(y);
        continue;
      }
      now.erase(-y);
    }

    if (!now.empty()) cows.insert(*now.begin());
    i = j;
  }

  printf("%d\n", (int)cows.size());
  return 0;
}
