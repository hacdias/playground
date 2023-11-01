using namespace std;
#include <iostream>
#include <cmath>

int main() {
  int c, i, j, n, d, k, w, y, stables;
  bool stable;
  cin >> c;

  for (i = 0; i < c; i++) {
    cin >> n;
    cin >> d;

    int numeros[n];

    for (j = 0; j < n; j++) {
      cin >> numeros[j];
    }

    stables = 0;

    for (k = 0; k < n; k++) {
      for (w = k + 1; w < n; w++) {
        if (numeros[k] == numeros[w]) {
          stable = true;

          if (k == w) {
            stable = false;
          }

          for (y = k; y < w; y++) {
            if (abs(numeros[y] - numeros[k]) > d) {
              stable = false;
            }
          }

          if (stable) {
            stables++;
          }
        }
      }
    }

    cout << stables << endl;
    
  }

  return 1;
}
