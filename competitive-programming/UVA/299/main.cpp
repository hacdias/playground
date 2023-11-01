#include <bits/stdc++.h>
using namespace std;

int n, l, s, t[50];

void bubbleSort() {
  bool swapped = false;
  do {
    swapped = false;
    for (int i = 1; i < l; i++) {
      if (t[i-1] > t[i]) {
        swap(t[i], t[i-1]);
        swapped = true;
        s++;
      }
    }
  } while(swapped);
}

bool sfn(int i, int j) {
  if (i < j) s++;
  return i < j;
}

int main() {
  scanf("%d", &n);
  while (n--) {
    scanf("%d", &l);
    for (int i = 0; i < l; i++) scanf("%d", &t[i]);
    s = 0;
    bubbleSort();
    printf("Optimal train swapping takes %d swaps.\n", s);
  }
  return 0;
}
