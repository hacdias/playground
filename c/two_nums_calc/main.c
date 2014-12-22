#include <stdio.h>

int main()
{
    int num;
    
    do {
        printf("Insira 0 para cancelar e 1 para efetuar de novo:");
        scanf("%d", &num);
        
    } while (num);
    
    return 0;
}