#include <stdio.h>
#include <stdlib.h>

int main()
{
    int numero = 5;
    int *ponteiro =  &numero;

    printf("%d e %d", numero, *ponteiro);

    return 0;
}
