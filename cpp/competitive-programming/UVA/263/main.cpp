// UVA 263 - https://uva.onlinejudge.org/external/2/263.html
#include <bits/stdc++.h>
using namespace std;

vector<int> num, chain;
int n, l, a, b, c;

void dec(int n) {
  num.clear();
  while (n > 0) {
    num.push_back(n%10);
    n /= 10;
  }
}

void join(int &var) {
  var = 0;
  for (int i = 0; i < (int)num.size(); i++) var = var*10 + num[i];
}

int main() {
  while(scanf("%d", &n) && n != 0) {
    chain.clear();
    l = 0;
    printf("Original number was %d\n", n);
    while (find(chain.begin(), chain.end(), n) == chain.end()) {
      chain.push_back(n);
      dec(n);
      sort(num.begin(), num.end());
      join(a);
      reverse(num.begin(), num.end());
      join(b);
      n = b - a, l++;
      printf("%d - %d = %d\n", b, a, n);
    }
    printf("Chain length %d\n\n", l);
  }
  return 0;
}
