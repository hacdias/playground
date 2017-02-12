#include <stdlib.h>
#include <stdio.h>
#include <stdbool.h>

bool isFireNumber(int number) {
  bool crescendo, decrescendo;
  int prev, curr, initial;

  crescendo = false;
  decrescendo = false;
  initial = number;
  prev = 0;
  curr = 0;

  while (number > 0) {
    prev = curr;
    curr = number % 10;

    if (number == initial) {
      number /= 10;
      continue;
    }

    number /= 10;

    if (curr > prev) {
      decrescendo = true;
    } else if (curr < prev) {
      crescendo = true;
    }
  }

  if (crescendo && decrescendo) {
    return true;
  }

  return false;
}

int main() {
  int a, b, c, i, fire;
  scanf("%d", &c);

  for (i = 0; i < c; i++) {
    fire = 0;
    scanf("%d %d", &a, &b);

    for (a = 0; a <= b; a++) {
      if (isFireNumber(a)) {
        fire++;
      }
    }

    printf("%d\n", fire);
  }

  return 0;
}
