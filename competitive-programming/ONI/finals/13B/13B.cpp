#include <iostream>
#include <vector>
#include <numeric>
#include <string>
#include <functional>
using namespace std;

int main() {
  int N, i, col, row, col2, row2, cols = 0, rows = 0, impact = 0;
  cin >> N;
  pair<int, int> stars[N];

  for (i = 0; i < N; i++) {
    cin >> row >> col;
    stars[i] = make_pair(row, col);

    if (col > cols) cols = col;
    if (row > rows) rows = row;
  }

  int sky[++cols][++rows];
  int lsums[rows][cols];
  int csums[cols][rows];
  for (col = 0; col < cols; col++) for (row = 0; row < rows; row++) sky[col][row] = 0;
  for (row = 0; row < rows; row++) for (col = 0; col < cols; col++) lsums[row][col] = 0;
  for (col = 0; col < cols; col++) for (row = 0; row < rows; row++) csums[col][row] = 0;
  for (i = 0; i < N; i++) sky[stars[i].second][stars[i].first] = 1;
  for (row = 0; row < rows; row++) for (col = 0; col < cols; col++) {
    if (col == 0) {
      lsums[row][col] = sky[col][row];
      continue;
    }

    lsums[row][col] = lsums[row][col-1] + sky[col][row];
  }

  for (col = 0; col < cols; col++) for (row = 0; row < rows; row++) {
    if (row == 0) {
      csums[col][row] = sky[col][row];
      continue;
    }

    csums[col][row] = csums[col][row-1] + sky[col][row];
  }

  for (col = 0; col < cols; col++) for (row = 0; row < rows; row++) {
    for (col2 = 0; col2 < cols; col2++) for (row2 = 0; row2 < rows; row2++) {
      i = (lsums[row][col2] - lsums[row][col]) + (lsums[row2][col2] - lsums[row2][col]) + (csums[col][row2] - csums[col][row]) + (csums[col2][row2] - csums[col2][row]);
      if (sky[col][row]) i--;
      if (sky[col][row2]) i--;
      if (sky[col2][row]) i--;
      if (sky[col2][row2]) i--;
      if (i > impact) impact = i;
    }
  }

  cout << impact << endl;
  return 0;
}
