#ifdef _MSC_VER
#define _CRT_SECURE_NO_WARNINGS
#endif
#include <stdio.h>

void main() {
	int i = 0,
		maior = -100, 
		maior2 = -100,
		num;

	while (i < 10)
	{
		printf("Insira o numero no. %d\n", ++i);
		scanf("%d", &num);

		if (num > maior2 && num < maior)
		{
			num = maior2;
		}
		else if (num > maior)
		{
			num = maior;

		}
	}

	printf("O maior num e: %d\n", maior);
	printf("O 2º maior num e: %d\n", maior2);
}