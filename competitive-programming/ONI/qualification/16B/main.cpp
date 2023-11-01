#include <iostream>
#include <numeric>
#include <algorithm>
#include <map>
#include <vector>
#include <cmath>
using namespace std;

typedef unsigned int UInt;

map<UInt, pair<UInt, UInt> > coordinates;
vector<UInt> positionsToGet;
UInt maximum, size = 10000;

void fillPositions() {
  UInt n = size*size, x = 0, c = 0, y = 0, i;

  for (i = 0; i < n; i++) {
    if(positionsToGet[c] == i+1) {
      coordinates[i+1] = make_pair(y, x);
      c++;
    }

    if (i+1 > maximum) return;
    if (y <= 0 || x+1 >= size)  {
      y = x+y+1;
      if (y >= size) {
        x = (y-size)+1;
        y -= x;
      } else {
        x = 0;
      }
    } else {
      x++;
      y--;
    }
  }
}

UInt sum(pair<UInt, UInt> &rectangle) {
  UInt sum = 0;

  UInt TLRow = coordinates[rectangle.first].first, TLCol = coordinates[rectangle.first].second,
    BRRow = coordinates[rectangle.second].first, BRCol = coordinates[rectangle.second].second,
    firstItem = rectangle.first, i, j, nextColItem = firstItem, tmp = firstItem;

  for (i = TLRow; i <= BRRow; i++) {
    for (j = TLCol; j <= BRCol; j++) {
      sum += tmp;
      tmp += i+j+2;

      if (j == TLCol) nextColItem += i+j+1;
      if (j == BRCol) tmp = nextColItem;
    }
  }

  return sum;
}

int main() {
  UInt N, i;
  cin >> N;
  pair<UInt, UInt> rectangles[N];

  for (i = 0; i < N; i++) {
    cin >> rectangles[i].first >> rectangles[i].second;

    positionsToGet.push_back(rectangles[i].first);
    positionsToGet.push_back(rectangles[i].second);

    if (rectangles[i].second > maximum) maximum = rectangles[i].second;
  }

  size = floor(sqrt(maximum*2));

  sort(positionsToGet.begin(), positionsToGet.end());
  positionsToGet.erase(unique(positionsToGet.begin(), positionsToGet.end()), positionsToGet.end());

  fillPositions();

  for (i = 0; i < N; i++) {
    cout << sum(rectangles[i]) << endl;
  }

  return 0;
}
