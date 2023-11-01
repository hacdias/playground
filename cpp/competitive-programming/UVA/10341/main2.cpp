#include <bits/stdc++.h>
using namespace std;

int p, q, r, s, t, u;

double val(double x) {
  return (p*exp(-x)+q*sin(x)+r*cos(x)+s*tan(x)+t*pow(x, 2)+u);
}

double find(double fi, double la) {
  if (la - fi < 1e-10) return fi;
  double mid = (fi+la)/2;
  (val(mid) > 0) ? fi = mid : la = mid;
  return find(fi, la);
}

int main() {
  while(scanf("%d %d %d %d %d %d", &p, &q, &r, &s, &t, &u) != EOF) {
    if (p*exp(-1)+q*sin(1)+r*cos(1)+s*tan(1)+t+u > 0 || p+r+u < 0) {
      printf("No solution\n");
      continue;
    }

    printf("%.4f\n", find(0.0, 1.0));
  }
  return 0;
}
