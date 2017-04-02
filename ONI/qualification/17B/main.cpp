using namespace std;

#include <stdio.h>
#include <algorithm>

struct Charco {
  int xi, xf, y;
};

bool comp(const Charco& c1, const Charco& c2) {
	return c1.xi < c2.xi;
}

int n, q, i, t, y1, y2;
Charco arr[100000];

int main() {
	scanf("%d %d", &n, &q);

	for (t = 0; t < n; t++) {
		scanf("%d %d %d %d\n", &arr[t].xi, &y1, &arr[t].xf, &y2);
		arr[t].y = y2-y1;
		arr[t].xf--;
	}

	sort(arr, arr+n, comp);

	while (q--) {
		scanf("%d", &t);
		int m = 0;

		for (i = 0; arr[i].xi <= t && i < n; i++) {
			if (arr[i].xf >= t) m += arr[i].y;
		}

		printf("%d\n", m); 
	}

	return 0;
}	