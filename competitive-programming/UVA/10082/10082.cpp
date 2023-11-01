#include <bits/stdc++.h>
using namespace std;

char k[] = "`1234567890-=QWERTYUIOP[]\\ASDFGHJKL;'ZXCVBNM,./", s[10005];
int l, i;

char find(char c) {
  for (int i = 0; i < 47; i++) if (k[i] == c) return k[i-1];
  return c;
}

int main() {
  while (gets(s)) {
    l = strlen(s);
    for (i = 0; i < l; i++) s[i] = find(s[i]);
    puts(s);
  }

  return 0;
}
