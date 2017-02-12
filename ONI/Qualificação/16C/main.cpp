#include <iostream>
using namespace std;

#define GOOD '0'
#define BAD '1'

int N, Q;

int biggestGroup(char *seats) {
  int first = -1, last = -1, largest = 0, temp, i;

  for (i = 0; i < N; i++) {
    if (seats[i] == GOOD && first == -1) first = i;
    if (seats[i] == BAD && first != -1) {
      last = i;
      temp = i - first;
      first = -1;
      if (temp > largest) largest = temp;
    }
  }

  if (largest == 0 && first == 0) largest = N;
  if (N - first > largest && last < first) largest = N - first;
  return largest;
}

int main() {
  int i, k;
  cin >> N >> Q;
  char action, seats[N];

  for (i = 0; i < N; i++) {
    cin >> seats[i];
  }

  for (i = 0; i < Q; i++) {
    cin >> action;

    if (action == 'P') {
      cin >> k;
      seats[--k] = BAD;
    } else if (action == 'A') {
      cin >> k;
      seats[--k] = GOOD;
    } else {
      cout << biggestGroup(seats) << endl;
    }
  }

  return 0;
}
