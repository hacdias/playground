#include <stdio.h>
#include <stdlib.h>

int main()
{
    int i;

    for (i = 1; i <= 1000; i++) {

        if (i%4 == 0 && i%10 == 0 && i%25 == 0) {
            printf("%s\n", i);
        }
    }

    return 0;
}
