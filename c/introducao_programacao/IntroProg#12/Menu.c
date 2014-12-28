#include <stdio.h>
#include <stdlib.h>

int main()
{
    int option;

    printf("Insira a opção:\n");
    scanf("%d", &option);

    if (option == 1) {
        printf("Escolheu a opção 1");
    } else if (option == 2) {
        printf("Escolheu a opção 2");
    } else if (option == 3) {
        printf("Escolheu a opção 3");
    } else if (option == 4) {
        printf("Escolheu a opção 4");
    } else if (option == 5) {
        printf("Escolheu a opção 5");
    } else {
        printf("Opção inexistente.");
    }

    return 0;
