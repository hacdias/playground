#include <stdio.h>
#include <stdlib.h>

int main()
{
    signed int i = -100;

    while (i <= 100) {

        if ( i%5 == 0 && i%3 == 0) {
            printf("%d\n", i);
        }
        i++;
    }

    return 0;
}
