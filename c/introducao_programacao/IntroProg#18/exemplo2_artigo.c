#include <stdio.h>
#include <stdlib.h>
#include <windows.h>

int main()
{
    SetConsoleOutputCP(65001);

    int a, b, c;
    int *p, *q;

    a = 5;
    b = 4;

    p = &a;
    q = &b;
    c = *p + *q;

    printf("A soma de %d e %d é %d.", a, b, c);
    return 0;
}

int trocaDeValores( int *p, int *q)
{
    int temp;

    temp = *p;
    *p = *q;
    *q = temp;

    return 0;
}
