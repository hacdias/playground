#include <stdio.h>
#include <stdlib.h>

int main()
{
    printf("int : %d bytes\n", sizeof(int) );
    printf("short int: %d bytes\n", sizeof(short) );
    printf("long int: %d bytes\n", sizeof(long) );
    printf("signed int: %d bytes\n", sizeof(signed) );
    printf("unsigned int: %d bytes\n", sizeof(unsigned) );
    return 0;
}
