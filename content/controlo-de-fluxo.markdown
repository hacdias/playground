---
weight: 5
type: page
title: Controlo de Fluxo
---

Este quarto capítulo tem como objetivo mostrar-lhe as formas de controlar o fluxo de uma aplicação, de um algoritmo, de um programa.

{{% concept %}}
**Controlo de Fluxo** refere-se ao controlo que se tem sobre a ordem de comandos a serem executados no decorrer de um programa.
{{% /concept %}}

Ao controlar o fluxo pode-se direcionar o utilizador para as ações que este escolheu e executar apenas trechos de código dependendo de uma determinada condição, controlando a ordem pela qual os comandos são executados.

Existem diversas estruturas que nos permitem controlar o fluxo de uma aplicação. A maioria das que são aqui abordadas são transversais à maioria das linguagens de programação existentes.

Antes de continuar aconselhamos a que reveja os **operadores relacionais e lógicos** no capítulo 3.

## Estrutura `if/else`

A primeira estrutura a abordar é a conhecida `if else` o que, numa tradução literal para Português, quer dizer "se caso contrário". Com esta estrutura, um determinado trecho de código pode ser executado dependendo do resultado de um teste lógico.

{{% concept %}}
Um **teste lógico** consiste na determinação da verdade ou falsidade de uma condição.
{{% /concept %}}

**Sintaxe**

```c
if (condição) {  
    // código a executar caso a condição seja verificada
} else {  
    // caso contrário, isto é executado.  
}  
```

**Exemplo**

Imagine que necessita criar um pequeno programa que deve imprimir se o valor de uma variável é maior, menor ou igual a 50. Como irá proceder? A criação deste algoritmo é deveras simples, bastando inicializar a variável e efetuar um teste lógico. Veja então como este problema poderia ser resolvido:

```c
#include <stdio.h>  

int main() {      
    int n = 25;   

    if (n >= 50) {  
        printf("O valor %d é maior ou igual a 50.", n);  
    } else {  
        printf("O valor %d é menor que 50.", n);  
    }  

    return 0;  
}  
```

Se executar o trecho de código anterior, a mensagem `O valor 25 é menor que 50.` será imprimida, pois não se verificou a condição `n >= 50`, executando-se o código dentro do bloco `else`.

Imagine agora que precisa verificar as seguintes três condições:

-   É maior que 50?
-   É igual a 50?
-   É menor que 50?

O caminho mais óbvio seria o seguinte:

```c
if (n > 50) {  
    printf("O valor %d é maior que 50.\n", n);  
}   

if (n < 50) {  
    printf("O valor %d é menor que 50.\n", n);  
}  

if (n == 50) {  
    printf("A variável é igual a 50.\n");  
}  
```

O algoritmo acima é um pouco repetitivo e extenso; pode ser simplificado ao ser agregado em apenas um teste sequencial como seguinte:

```c
if (n == 50) {  
    printf("A variável é igual a 50.\n"); //A
} else if (n < 50) {  
    printf("O valor %d é menor que 50.\n", n); //B
} else {  
    printf("O valor %d é maior que 50.\n", n); //C  
}  
```

Podemos "traduzir" o código anterior para uma linguagem corrente da seguinte forma: `Se n for igual a 50; então faz A, ou se n for menor que 50 faz B; caso contrário faz C`.

## Estrutura `while`

Outra estrutura para controlar o fluxo que é muito importante é a estrutura `while`, que em Português significa "enquanto". Esta estrutura permite repetir um determinado trecho de código enquanto uma condição for verdadeira.

**Sintaxe**

```c
while(condição) {  
   //Algo acontece  
}  
```

Ora vejamos um exemplo: precisa imprimir todos os números entre 0 e 100 (inclusive). Para isso não é necessário utilizar o comando `printf` 101 vezes, bastando utilizar a repetição `while`. Ora veja:

```c
#include <stdio.h>  

int main() {     
    int num = 0;  

    while(num <= 100) {
    	num++;
        printf("%d\n", num);
    }  

    return 0;  
}
```

Pode-se traduzir o trecho anterior para uma linguagem corrente da seguinte forma: \texttt{Enquanto num for menor ou igual a 100, imprime a variável num e incrementa-lhe um valor}.

## Estrutura `switch`

A estrutura `switch` está presente na maioria das linguagens de programação, que numa tradução literal para Português significa "interruptor". Esta estrutura é deveras útil quando temos que executar uma ação dependendo do valor de uma variável.

A estrutura de controlo `switch` pode ser utilizada como forma de abreviar um teste lógico `if else` longo.

**Sintaxe**

```c
switch(variavel) {
    case "valorUm":
        // Código da operação
        break;
    case "valorDois":
        // Código da operação
        break;

    //...

    default:
        // Código executado caso não seja validada
        // nenhuma das opções anteriores
        break;
}  
```

Imagine que tem que pedir ao utilizador um valor e que vai executar uma ação dependendo o valor que o utilizador escolheu. Esse menu tem 5 opções. Poderia resolver este problema da seguinte forma:

```c
#include <stdio.h>

int main() {
    int opcao;

    printf("Insira a opção:\n");
    scanf("%d", &opcao);

    switch(opcao) {
        case 1:
            printf("Escolheu a opção 1");
            break;
        case 2:
            printf("Escolheu a opção 2");
            break;
        case 3:
            printf("Escolheu a opção 3");
            break;
        case 4:
            printf("Escolheu a opção 4");
            break;
        case 5:
            printf("Escolheu a opção 5");
            break;
        default:
            printf("Opção inexistente.");
            break;        
    }

    return 0;
}
```

O código acima faz: em primeiro lugar, tudo depende do valor da variável `opcao`. Caso seja 1, será imprimida a mensagem `Escolheu a opção 1` e por aí a diante. Caso a opção inserida não exista no código, o código contido em `default` irá ser executado.

Mais à frente iremos falar mais sobre o `break`. Por agora não lhe dê muita importância, mas coloque-o sempre.

O algoritmo anteriormente reproduzido pode também tomar a forma de uma sequência de `if else`, embora com uma menor legibilidade. Ora veja:

```c
#include <stdio.h>

int main() {
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
}
```

## Estrutura `do/while`

Outra forma de controlar o fluxo a abordar é a estrutura `do while`, que tem um nome semelhante à já abordada `while`. A diferença existente entre essas duas estruturas é pequena, mas importante.

Ao contrário do que acontece na estrutura `while`, no `do while`, o código é executado primeiro e só depois é que a condição é testada. Se a condição for verdadeira, o código é executado novamente. Podemos concluir que esta estrutura obriga o código a ser **executado pelo menos uma vez**.

**Sintaxe**

```c
do
{
   //código a ser repetido
} while (condição);
```

Imagine agora que precisa criar uma pequena calculadora (ainda em linha de comandos) que receba dois número e que, posteriormente, efetua uma soma, subtração, multiplicação ou divisão. Esta calculadora, após cada cálculo deverá pedir ao utilizador para inserir se quer continuar a realizar cálculos ou não. Poderíamos proceder da seguinte forma:

```c
#include <stdio.h>

int main() {
  int calcular;

  do {

    char operacao;
    float num1,
        num2;

    // limpeza do buffer. ou __fpurge(stdin); em linux
    fflush(stdin);    

    printf("Escolha a operação [+ - * / ]: ");
    scanf("%c", &operacao);

    printf("Insira o primeiro número: ");
    scanf("%f", &num1);

    printf("Insira o segundo número: ");
    scanf("%f", &num2);

    switch(operacao) {
      case '+':
        printf("%.2f + %.2f = %.2f\n", num1, num2, num1 + num2);
        break;
      case '-':
        printf("%.2f - %.2f = %.2f\n", num1, num2, num1 - num2);
        break;
      case '*':
        printf("%.2f * %.2f = %.2f\n", num1, num2, num1 * num2);
        break;
      case '/':
        printf("%.2f / %.2f = %.2f\n", num1, num2, num1 / num2);
        break;
      default:
        printf("Digitou uma operação inválida.\n");
        break;
    }

    printf("Insira 0 para sair ou 1 para continuar: ");
    scanf("%d", &calcular);

  /* Verifica-se o valor da variável calcular. Se for 0 é considerado falso
  e o código não é executado mais vez nenhuma. Caso seja um número diferente
  de 0, a condição retornará um valor que representa true (todos os números
  exceto 0) e continuar-se-à a executar o código. */
  } while (calcular);

  return 0;

}
```

## Estrutura `for`

A última estrutura de controlo de fluxo a abordar, mas não o menos importante, é a estrutura `for`. Esta estrutura *loop* é um pouco mais complexa que as anteriores, mas muito útil e permite reutilizar código.

{{% concept %}}
O termo inglês **_loop_** refere-se a todas as estruturas que efetuam repetição: `while`, `do while` e `for`.
{{% /concept %}}

**Sintaxe**

```c
for(inicio_do_loop ; condição ; termino_de_cada_iteração) {
 //código a ser executado
}
```

Onde:

-   `inicio_do_loop` → uma ação que é executada no início do ciclo das repetições;
-   `condição` → a condição para que o código seja executado;
-   `termino_de_cada_iteração` → uma ação a executar no final de cada iteração.

Imagine agora que precisa de imprimir todos os números pares de 0 a 1000. Para isso poderia recorrer à estrutura `while` e a uma condição `if` da seguinte forma:

```c
#include <stdio.h>

int main() {
    int num = 0;

    while (num <= 1000) {
        if (num % 2 = 0) {
            printf("%d\n", num);
        }

        num++;
    }

    return 0;
}
```

Utilizando a estrutura `for`, o algoritmo acima poderia ser reduzido ao seguinte:

```c
#include <stdio.h>

int main() {
    for(int num = 0; num <= 1000; num++) {
        if (num % 2 = 0) {
            printf("%d\n", num);
        }
    }

    return 0;
}
```

## Interrupção do fluxo

As estruturas de controlo de fluxo são muito importantes, mas aprender como se as interrompe também o é. Por vezes é necessário interromper uma determinada repetição dependendo de um teste lógico interno à repetição.

### Terminar ciclo com `break`

O `break` permite que interrompamos o fluxo em *loops* e na estrutura `switch`. Se não colocarmos este comando no final de cada caso da estrutura `switch`, o código continuaria a ser executado, incluindo as restantes opções.

Imagine que por algum motivo precisa encontrar o primeiro número divisível por 17, 18 e 20 entre 1 e 1000000. Iria, provavelmente, utilizar a estrutura `for` para percorrer todos estes números. Veja como poderíamos fazer:

```c
#include <stdio.h>

int main() {      
		int num = 0;

        for (int count = 1; count <= 1000000; count++) {
            if(num == 0) {
                if((count % 17 == 0) && (count % 18 == 0) && (count % 20 == 0)) {
                    num = count;
                }
            }
        }

        printf("O número divisível por 17, 18 e 20 entre 1 e 1000000 é: %d", num);
        return 0;
}
```

Depois de encontrar o número em questão, que é 3060, é necessário continuar a executar o `loop`? Seriam executadas mais 996940 iterações (repetições). Tal não é necessário e podemos poupar os recursos consumidos, parando o ciclo de repetições. Ora veja:

```c
#include <stdio.h>

int main() {           
        int num = 0;

        for (int count = 1; count <= 1000000; count++) {
            if(num == 0 && (count%17==0) && (count%18==0) && (count%20==0)) {
                num = count;
                break;
            }
        }

        printf("O número divisível por 17, 18 e 20 entre 1 e 1000000 é: %d", num);
        return 0;
}
```

### Terminar iteração com `continue`

O comando `continue` é parecido ao anterior só que, em vez de cancelar todo o ciclo de repetições, salta para a próxima iteração, cancelando a atual.

Precisa de somar todos os números inteiros entre 0 e 1000 que não são múltiplos de 2 nem de 3. Para o fazer, irá ter que saltar todas as somas em que o número atual é múltiplo de 2 e 3. Veja então uma proposta de como poderia ficar:

```c
#include <stdio.h>

int main() {
    int sum = 0;

    for (int count = 1; count <= 1000; count++) {
        if(count%2 == 0 || count%3 == 0) {
            continue;
        }

        sum += count;
    }

    printf("Soma %d", sum);
    return 0;
}
```

O que acontece é se percorrem todos os números de 1 a 1000, e se for divisível por 2 ou por 3, salto para o próximo número. Caso esta condição não se verifique, adiciono o número atual à soma.
