---
weight: 3
title: Operadores
type: page
description: "No mundo da programação os dados devem ser modelados, moldados, alterados. É com os operadores abordados neste capítulo que tudo isso pode ser feito. Os operadores abordados existem na maioria das linguagens de programação."
---

Neste capítulo são abordados os operadores, que são deveras importantes na modificação dos valores de variáveis.

{{% concept %}}
**Operadores** são símbolos para efetuar determinadas ações sobre variáveis. Na programação existem diversos tipos de operadores como, por exemplo, para efetuar operações aritméticas.
{{% /concept %}}

Alguns dos operadores também existem em outras áreas do conhecimento como matemática, por exemplo.

## Operadores aritméticos

Os operadores aritméticos são, tal como o próprio nome indica, utilizados para efetuar operações aritméticas, ou seja, operações matemáticas como somas, subtrações, multiplicações, entre outras.

| Nome                         | Símbolo | Exemplo          |
|------------------------------|---------|------------------|
| Soma                         | `+`     | 5 + 4 = 9        |
| Subtração                    | `-`     | 154 - 10 = 144   |
| Multiplicação                | `*`     | 5,55 * 10 = 55,5 |
| Divisão                      | `/`     | 40 / 2 = 20      |
| Resto inteiro de uma divisão | `%`     | 1500 % 11 = 4    |

## Operadores de atribuição

Os operadores de atribuição servem para atribuir um determinado valor a uma variável ou constante. Existem vários operadores de atribuição e muitos deles funcionam como abreviatura para operações aritméticas. Estes operadores são [*syntactic sugar*](http://en.wikipedia.org/wiki/Syntactic_sugar), ou seja, têm uma sintaxe elegante de forma a serem facilmente entendidos pelos seres humanos.

| Nome                       | Símbolo                     | Exemplo   | Valor de `var` |
|----------------------------|-----------------------------|-----------|----------------|
| Atribuição                 | `=`                           | `var = 20`  | 20             |
| Adição e atribuição        | `+= (var = var + n)`          | `var += 5`  | 25             |
| Subtração e atribuição     | `-= (var = var - n)`          | `var -= 10` | 15             |
| Multiplicação e atribuição | `*= (var = var * n)`          | `var *= 4`  | 60             |
| Divisão e atribuição       | `/= (var = var / n)`          | `var /= 5`  | 12             |
| Resto inteiro e atribuição | `%= (var = var \% n)` | `var \%= 5` | 2              |

## Operadores relacionais

{{% alert %}}
Pode avançar esta e as secções mais à frente por agora. Mais tarde ser-lhe-á indicado para aqui voltar. Consultar [capítulo 4](/aprenda-a-programar/controlo-de-fluxo/).
{{% /alert %}}

Estes operadores (relacionais) permitem-nos estabelecer relações de comparação entre diversas variáveis.

| Nome           | Símbolo | Exemplo                                                               |
|----------------|---------|-----------------------------------------------------------------------|
| Igualdade      | `==`      | `x == y` retorna 1 se `x` for igual a `y` e 0 se tiverem valores diferentes |
| Diferente      | `!=`      | `x != y` retorna 1 se `x` for diferente de `y` ou 0 se `x` for igual a `y`      |
| Maior          | `>`       | `x > 40`                                                                |
| Maior ou Igual | `>=`      | `y \>= 25`                                                              |
| Menor          | `<`       | `y < 20`                                                                |
| Menor ou Igual | `<=`      | `x <= y`                                                                |

## Operadores lógicos

Os operadores lógicos são normalmente utilizados em testes lógicos quando é necessário incluir mais do que uma condição para que algo aconteça. Existem três operadores lógicos que aqui são abordados: `&&`, `||` e `!`. Estes operadores também são *syntactic sugar*.

| Nome          | Operador |
|---------------|--------|
| Operador "e"  | `&&`     |
| Operador "ou" | <code>&#124;&#124;</code>     |
| Negação       | `!`      |

### Operador `&&`

Na programação, o operador `&&` tem como função a conjugação de condições, ou seja, funciona da mesma forma que um "e" na Língua Portuguesa. Com este elemento, para que algo seja considerado verdadeiro, todos os elementos têm que o ser. Veja alguns exemplos em que este operador é utilizado para agregar condições:

```c
#include <stdio.h>

int main() {     
    int a;  
    a = 4;  

    if (a > 0 && a <= 10) {  
        printf("O número %d está entre 1 e 10.", num1);  
    }  

	return 0;
}
```

A condição acima pode ser transcrita para uma linguagem lógica da seguinte forma: "**Se** `a` for maior que 0 **e** menor ou igual a 10, então o código é executado".

Este operador pode ser utilizado mais do que uma vez no interior de um teste condições pois podemos intersetar duas ou mais condições, bastando apenas adicionar `&&` e a outra condição a ser adicionada.

### Operador `||`

À semelhança do operador anterior, o operador `||` também tem uma função que pode ser comparada a uma pequena palavra do Português: à palavra . Com este elemento, para que algo seja considerado verdadeiro, basta que um elemento o seja.

Com este operador, podemos executar um trecho de código que **satisfaz** uma das **várias condições** existentes. Por exemplo:

```c
#include <stdio.h>  

int main() {     
    int a;  
    a = 3;  

    if (a == 3 || a == 5) {  
        printf("O número é 3 ou 5.\n");  
    }  

    return 0;  
}  
```

Numa linguagem puramente lógica, podemos converter a condição anterior para o seguinte: "Se `a` for 3 **ou** 5, então a linha 8 é executada".

### Operador `!`

O operador `!` é utilizado para indicar a negação, ou numa linguagem corrente, "o contrário de". Quando é utilizado juntamente com uma condição, quer dizer que o código que está condicionado depende se a negação da condição é satisfeita, tal como o antónimo de uma palavra. Ora veja o seguinte exemplo:


```c
#include <stdio.h>  

int main() {     
    int a;  
    a = 0;  

    if (!a) {  
        printf("A variável é 0.\n");  
    }  

    return 0;  
}  
```

Relembrando que o número 0 é considerado o binário para falso e que, qualquer número diferente de 0 é, na linguagem C, considerado como verdadeiro, a condição acima pode ser traduzida para: "Se `a` **não** for diferente de 0, então executa o código".

### Operadores de decremento e incremento

Os operadores de incremento e decremento são dois operadores essenciais na vida de qualquer programador. Imagine que necessita de contar um número cujo qual nem o programador sabe o fim. Vai adicionar/subtrair valor a valor? Não, não é necessário.


```c
#include <stdio.h>  

int main() {     
    int num;  

    num = 1;  
    printf("O número é %d\n", num);  

    num = num + 1;  
    printf("O número é %d\n", num);  

    num += 1;  
    printf("O número é %d\n", num);  

    return 0;  
}   
```

O código acima imprime a frase "O número é x", onde *x* corresponde ao valor da variável `num` nesse momento. Este algoritmo faz com que a variável inicialmente tenha um valor de 1, passando por 2, chegando finalmente a 3. As linhas `num = num + 1` e `num += 1` são equivalentes.

Existe outra forma mais simples para adicionar/subtrair um valor a uma variável: através dos operadores `++` e `–`. Veja como ficaria o código anterior com estes operadores:

```c
#include <stdio.h>  

int main() {     
    int num;  

    num = 1;  
    printf("O número é %d\n", num);  

    num++;  
    printf("O número é %d\n", num);  

    num++;  
    printf("O número é %d\n", num);  

    return 0;  
}  
```

Este último trecho de código irá imprimir o mesmo que o código anterior. Agora, a diferença aparenta não ser imensa, porém estes operadores serão extremamente úteis em testes lógicos/de repetição.

Para remover uma unidade bastaria colocar `–` ao invés de `++`. Então podemos concluir que este operador torna o incremento/decremento mais rápido, mas só funciona quando o assunto é uma unidade. Veja o seguinte exemplo:

```c
#include <stdio.h>  

int main() {     
    int num;  

    num = 1;  
    printf("O número é %d\n", num);  

    num--;  
    printf("O número é %d\n", num);  

    return 0;  
}  
```

{{% moreabout title="Posição do operador" %}}
Estes operadores podem ocupar duas posições: antes ou depois do nome da variável, ou seja, posso colocar tanto `num++` como `++num`. Quando são utilizados isoladamente, não existe nenhuma diferença. Porém, quando estamos a efetuar uma atribuição, existem diferenças. Analise o seguinte exemplo:

```c
#include <stdio.h>  

int main() {     
    int a, b, c;  

    a = 0;  
    b = a++;  
    c = ++a;  

    printf("A: %d, B: %d, C: %d", a, b, c);  

    return 0;  
}  
```

Em primeiro lugar, são declaradas três variáveis: `a`, `b` e `c`. Seguidamente, é atribuído o valor 0 à primeira variável. Quando o valor `a++` é atribuído à variável `b`, esta fica com valor 0 ou 1? E o que acontece com a variável `a`? A variável `b` irá assumir o valor 0, e um valor é incrementado a `a` ficando esta com o valor 1, ou seja, `b = a++` é um atalho para o seguinte:

```c
b = a;  
a++;  
```

Depois desta atribuição, é atribuída à variável `c`, o valor `++a`, ou seja, primeiro é incrementado o valor da variável `a` e só depois é que o valor de esta é atribuído à variável `c`. Então, isto é um atalho para o seguinte:

```c
++a;  
c = a;
```
{{% /moreabout %}}
