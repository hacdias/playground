#include <stdio.h>
#include <stdlib.h>

int resolverProblema() {
    int num;

    for (num = 0; num <= 1000000; num++) {

        if ( (num - 1) % 2 == 0 &&
            (num - 1) % 3 == 0 &&
            (num - 1) % 4 == 0 &&
            (num - 1) % 5 == 0 &&
            (num - 1) % 6 == 0 &&
            num % 7 == 0 ) {

            printf("%d\n", num);
        }
    }
}


int main()
{
    resolverProblema();
    return 0;
}
