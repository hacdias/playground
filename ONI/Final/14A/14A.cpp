#include <iostream>
using namespace std;

int main() {
  int L, C, i, j, r1, r2, c1, c2, temp;
  cin >> L >> C;

  char tabuleiro[L][C];
  int area = 0, qnt = 0;
  for (i = 0; i < L; i++) for (j = 0; j < C; j++) cin >> tabuleiro[i][j];
  for (r1 = 0; r1 < L; r1++) for (c1 = 0; c1 < C; c1++) {
    for (r2 = 0; r2 < L; r2++) for (c2 = 0; c2 < C; c2++) {
      for (i = r1; i <= r2; i++) {
        for (j = c1; j <= c2; j++) {
          if (i > r1) if (tabuleiro[i][j] == tabuleiro[i-1][j]) break;
          if (i < r2) if (tabuleiro[i][j] == tabuleiro[i+1][j]) break;
          if (j > c1) if (tabuleiro[i][j] == tabuleiro[i][j-1]) break;
          if (j < c2) if (tabuleiro[i][j] == tabuleiro[i][j+1]) break;
        }
        if (j != c2+1) break;
      }

      if (i != r2+1 || j != c2+1) continue;
      temp = (r2-r1+1)*(c2-c1+1);
      if (temp == area) qnt++;
      if (temp > area) {
          area = temp;
          qnt = 1;
      }

    }
  }

  cout << area << " " << qnt << endl;
  return 0;
}
