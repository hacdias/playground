#include <bits/stdc++.h>
using namespace std;

int x, s, m, a, b;
char word[1010], n_word[1010];

int main() {
  scanf("%d", &x);
  scanf("%s", word);

  for (int i = 0; word[i] != '\0'; i++) if (word[i+1] == '\0') s = i+1;
  for (int i = 0; i < x; i++) {
    a = -1, b = s, m = floor(s/2);
    if (s%2 != 0) m++;
    for (int j = 0; j < m; j++) {
      n_word[++a] = word[2*j];
      if (2*j+1 < s) n_word[--b] = word[2*j+1];
    }
    strncpy(word, n_word, s);
  }

  for (int i = 0; i < s; i++) printf("%c", word[i]);
  printf("\n");
  return 0;
}
