using namespace std;

#include <stdio.h>
#include <algorithm>

int n, i, j, m, a[100010], b[100010];

int main() {
	scanf("%d\n", &n);
	for (i = 0; i < n; i++) scanf("%d", &a[i]);
	sort(a, a+n);

	for (i = 0; i < n; i++) {
		b[i] = 1;
		for (j = 0; j < i; j++) if (a[i] % a[j] == 0)	b[i] = max(b[i], b[j]+1);
		m = max(m, b[i]); 
	}
	
	printf("%d\n", m);
	return 0;
}	