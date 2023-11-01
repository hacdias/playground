#include <bits/stdc++.h>
using namespace std;

#define MAX 60000

bool marks[MAX];
int primes[7000], n;

int sieve() {
  int i, j;
  memset(marks, true, sizeof marks);
  marks[0] = false, marks[1] = false;

  for (i = 2; i < MAX; i++){
     if (marks[i] == true) {
       for (j = i*2; j < MAX; j+=i) {
         marks[j] = false;
       }
     }
  }

  for (i = 2, j = 0; i < MAX; i++) {
    if (marks[i] == true) {
      primes[j++] = i;
    }
  }

  return j-1;
}

int main() {
  int mark = sieve();

  while (scanf("%d", &n) && n) {
    printf("%d =", n);

    if (n < 0) {
      printf(" -1 x");
      n *= -1;
    }

    for (int i = 0; primes[i] < n && i < mark; i++) {
      while (n % primes[i] == 0) {
        n /= primes[i];
        (n > 1) ? printf(" %d x", primes[i]) : printf(" %d", primes[i]);
      }
    }

    if (n > 1) printf(" %d", n);
    printf("\n");
  }
  return 0;
}
