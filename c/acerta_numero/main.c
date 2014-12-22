#include <stdio.h>
#include <time.h>

int main() {
    
   int number, 
           input, 
           state,
           amp;
    
    srand (time(NULL));
    number = (rand() % 10) + 1;
    
    state = 0;
    
    while(!state) {
        printf("Insira um número inteiro entre 1 e 10:\n");
        scanf("%d", &input);
        
        if (input < 1 || input > 10) {
            printf("O número que inseriu não está no intervalo pedido.");
        } else {
            
            if (input == number) {
                printf("Parabéns! Acertou no número que eu pensei.");
                state = 1;
            } else {
                amp = abs(input - number);

                if (amp == 1) {
                    printf("Extremamente perto.\n");
                } else if (amp == 2 || amp == 3) {
                    printf("Perto.\n");
                } else if (amp == 4 || amp == 5) {
                    printf("Podia estar mais perto.\n");
                } else if (amp == 6 || amp == 7) {
                    printf("Hmm... Um pouco longe.\n");
                } else if (amp == 8 || amp == 9) {
                    printf("Muito longe.\n");
                }
            }
        }
    }
    
    return 0;
}

