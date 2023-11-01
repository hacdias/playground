using namespace std;

#include <stdio.h>
#include <algorithm>

int n, b, i, t, x, fi, la;
char m, a[100010];

int main() {
	scanf("%d %d %d\n", &n, &b, &i);
	for (x = 0; x < n; x++) scanf("%c\n", &a[x]);
	
	fi = --b;
	la = fi;
	
	while (i--) {
		scanf("%c %d\n", &m, &x);
		
		if (m == 'D') {
			b += x;
			la = max(la, b);
		} else {
			b -= x;
			fi = min(fi, b);
		}
	} 

	for (i = fi; i <= la; i++) if (a[i] == 'T') t++;
	printf("%d\n", t); 
	return 0;
}	