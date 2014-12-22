#ifdef _MSC_VER
#define _CRT_SECURE_NO_WARNINGS
#endif
#include <stdio.h>
#include <math.h>

void main() 
{
	double a, b, c, delta, solutionOne, solutionTwo;

	puts("Give the value of \"a\":");
	scanf("%lf", &a);

	if (a != 0)
	{
		puts("Give the value of \"b\":");
		scanf("%lf", &b);

		puts("Give the value of \"c\":");
		scanf("%lf", &c);

		delta = (b * b) - (4 * a * c);

		if (delta < 0)
		{
			puts("The equation is impossible.");
		}
		else
		{
			delta = sqrt(delta);

			solutionOne = (-b + delta) / (2 * a);
			solutionTwo = (-b - delta) / (2 * a);

			if (solutionOne == solutionTwo)
			{
				printf("There is only one solution: %lf\n", solutionOne);
			} 
			else 
			{
				printf("There are two solutions: %lf and %lf\n", solutionOne, solutionOne);
			}
		}
	}
}