#include <bits/stdc++.h>
using namespace std;

int a, as, q, n, m, Q[105];
vector<int> s, ad;

void digits(int n, vector<int> &d) {
  d.clear();
  while (n) {
    d.push_back(n%10);
    n /= 10;
  }
  reverse(d.begin(), d.end());
}

void build(int la) {
  int el = 0, i;
  vector<int> d;

  while (el++ <= la) {
    i = 0;
    digits(el, d);

    for (vector<int>::iterator it = d.begin(); it != d.end(); it++) {
      if (*it != ad[i] && i != 0) i = 0;
      if (*it == ad[i]) {
        if (++i >= as) {
          s.push_back(el);
          break;
        }
      }
    }
  }
}

int pos(int n) {
  // bsearch
  for (unsigned int i = 0; i < s.size(); i++) if (s[i] > n) return (n-i);
  return n-s.size();
}

int main() {
  scanf("%d %d", &a, &q);
  digits(a, ad);
  as = floor(log10(a))+1;

  for (int i = 0; i < q; i++) {
    scanf("%d", &Q[i]);
    m = max(m, Q[i]);
  }

  build(m);
  for (int i = 0; i < q; i++) {
    printf("%d\n", pos(Q[i]));
  }

  return 0;
}
