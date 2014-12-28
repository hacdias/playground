#include <stdio.h>
#include <stdlib.h>

int main()
{
    int a;
    a = 70;
    a *= 2;

    if (a > 100) {
        printf("%d é maior que 100.", a);
    } else if (a === 100) {
        printf("Parabéns. O número é 100.\n");
    } else {
        printf("%d é menor que 100.", a);
    }

    return 0;
}
