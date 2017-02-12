#include <bits/stdc++.h>
using namespace std;

int N;

int main() {
    scanf("%d\n", &N);

    int l1[N/2], l2[N/2];
    for (int i = 0; i < N/2; i++) scanf("%d", &l1[i]);
    for (int i = 0; i < N/2; i++) scanf("%d", &l2[i]);

    int c = 0;

    for (int j = 0; j < N/2; j++) {
        if (l1[j] != l2[j]) c++;
    }

    printf("%d\n", c);
    return 0;
}
