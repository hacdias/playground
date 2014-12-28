#include <stdio.h>
#include <stdlib.h>

int main()
{
    float num1, num2, operacao;
    char opcao;

    printf("Digite dois números: ");
    scanf("%f %f", &num1, &num2);

    puts("Que operação deseja efetuar:");
    puts("A - Soma");
    puts("B - Subtração");
    puts("C - Divisão");
    puts("D - Multiplicação");

    printf("Insira a letra corresponde à opção: ");
    scanf(" %c", &opcao);

    switch (opcao) {

        case 'A':
        case 'a':
        operacao = num1 + num2;
        break;

        case 'B':
        case 'b':
        operacao = num1 - num2;
        break;

        case 'C':
        case 'c':
        operacao = num1 / num2;
        break;

        case 'D':
        case 'd':
        operacao = num1 * num2;
        break;

    }

    printf("O resultado da operação é %.3f", operacao);
    return 0;
}
