#include <bits/stdc++.h>
using namespace std;
typedef long long int lli;

lli n, k, t, m, i;
vector<lli> plates;

int main() {
  scanf("%lld %lld", &n, &k);
  i = n;
  while (i--) {
    scanf("%lld", &t);
    plates.push_back(t);
  }

  plates.erase(unique(plates.begin(), plates.end()), plates.end());
  t = 0, m = 0, i = (int)plates.size();
  while (i--) {
    if (t == -1) {
      t = 0;
      m++;
    }

    t++;
    if (t == k-1) t = -1;
  }

  printf("%lld\n", m);
  return 0;
}
