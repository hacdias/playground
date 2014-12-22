#ifdef _MSC_VER
#define _CRT_SECURE_NO_WARNINGS
#endif
#include <stdio.h>

void main()
{
	float nota;

	puts("Insira a sua nota:");
	scanf("%f", &nota);

	if (nota > 10 || nota < 0)
	{
		puts("Nota invalida.");
	}
	else if (nota > 7)
	{
		puts("Passou direito!");
	}
	else if (nota < 7 && nota >= 4)
	{
		puts("tem direito de fazer uma prova de recuperação");
	} 
	else
	{
		puts("Reprovou.");
	}
}