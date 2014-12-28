#include <stdio.h>
#include <stdlib.h>
#include <math.h>

int main()
{
    float a, b, c, ans1, ans2, delta;

    printf("Insira o valor de a: ");
    a = receberNumero();

    printf("Insira o valor de b: ");
    b = receberNumero();

    printf("Insira o valor de c: ");
    c = receberNumero();

    delta = b * b - (4 * a * c);

    if (delta < 0) {
        printf("A equação é impossível!");
    } else {
        ans1 = (-b + sqrt(delta)) / (2 * a);
        ans2 = (-b - sqrt(delta)) / (2 * a);

        printf("AS SOLUÇÕES SÃO %.2f E %.2f\n", ans1, ans2);
    }

    return 0;
}
