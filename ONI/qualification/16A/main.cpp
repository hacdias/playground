#include <iostream>
using namespace std;

int main() {
  unsigned int N, K, i, j, max, combos = 0;
  cin >> N >> K;
  char olimpians[N];

  for (i = 0; i < N; i++) {
    cin >> olimpians[i];
  }

  for (i = 0; i < N; i++) {
    if (olimpians[i] == 'M') {
      max = i+K;
      if (max >= N) max = N-1;

      for (j = i; j <= max; j++) {
        if (olimpians[j] == 'H') combos++;
      }
    }
  }

  cout << combos << endl;
  return 0;
}
