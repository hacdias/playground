#include <iostream>
#include <algorithm>
#include <map>
#include <vector>
using namespace std;

map<int, vector< vector<int> > > sums;
vector< vector<int> > ocean;

int L, C;

int sum(int h, int l, int c) {
  if (l < 0 || c < 0) return 0;
  if (sums[h][l][c] != -1) return sums[h][l][c];

  sums[h][l][c] = sum(h, l-1, c) + sum(h, l, c-1) - sum(h, l-1, c-1) + (ocean[l][c] > h ? 1 : 0);
  return sums[h][l][c];
}

bool check(int h, int l, int c) {
  for (int i = 0; i <= L-l; i++) for (int j = 0; j <= C-c; j++) {
    if (sum(h, i+l-1, j+c-1) - sum(h, i-1, j+c-1) - sum(h, i+l-1, j-1) + sum(h, i-1, j-1) == 0) return true;
  }

  return false;
}

int main() {
  int R, MAX = 0, i, j, l, c;
  cin >> L >> C;

  ocean.resize(L);
  fill(ocean.begin(), ocean.end(), vector<int>(C));

  for (i = 0; i < L; i++) {
    for (j = 0; j < C; j++) {
      cin >> ocean[i][j];
      MAX = max(MAX, ocean[i][j]);
    }
  }

  for (c = 0; c <= MAX; c++) {
    sums[c] = vector< vector<int> >(L);
    fill(sums[c].begin(), sums[c].end(), vector<int>(C));
    for(i = 0; i < L; i++) fill(sums[c][i].begin(), sums[c][i].end(), -1);
  }

  cin >> R;

  int fi, la, h;

  for (i = 0; i < R; i++) {
    cin >> l >> c;
    fi = 0;
    la = MAX;

    while (fi < la) {
      h = (fi+la) >> 1;
      if (check(h, l, c)) {
        la = h;
      } else {
        fi = h + 1;
      }
    }

    cout << fi+1 << endl;
  }

  return 0;
}
