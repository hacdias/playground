#include <stdio.h>
#include <stdlib.h>

int main()
{
    int minutos, horas, mns;
    int *p, *q;

    p = &minutos;
    q = &horas;

    printf("Insira os minutos a converter para horas: ");
    scanf("%d", &mns);

    horasParaMinutos( mns, q, p);
    printf("%d minutos corresponde a %d horas e %d minutos.\n", mns, horas, minutos);

    return 0;
}

int horasParaMinutos( int minutosTotais, int *horas, int *minutos)
{
    int minutosTemp,
        horasTemp;

    minutosTemp = minutosTotais%60;
    horasTemp = (minutosTotais - minutosTemp) / 60;

    *horas = horasTemp;
    *minutos = minutosTemp;

    return 0;
}
