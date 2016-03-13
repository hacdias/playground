---
type: page
weight: 8
title: Apontadores
---

Este capítulo foca num tema que não tem a mesma significância em todas as linguagens de programação, mas é algo que torna mais clara a visão do funcionamento do computador e da gestão da memória RAM. O tema em questão é os apontadores.

Para os computadores, tudo se resume a *bits*, ou seja, a zeros e uns. Então, para os computadores, as diferenças que nós conhecemos entre os diversos tipos de dados (`char`, `int`, `double`, `float`, etc) são praticamente inexistentes.

Quando uma variável é declarada, uma porção de memória RAM é reservada. Então todas as variáveis/*arrays* têm um endereço único. Os apontadores são um tipo de variáveis que podem armazenar endereços da memória.

{{% concept %}}
**Apontadores**, também conhecidos por ponteiros ou *pointers*, são um tipo de dados que permite armazenar um endereço da memória, representados, geralmente, em números hexadecimais.
{{% /concept %}}

## Tamanho e endereço de uma variável

Primeiramente, deve-se recordar que todos os tipos de dados ocupam um espaço diferente na memória RAM e que para saber quantas *bytes* ocupam um determinado tipo se recorrer à função `sizeof`. Para saber o quanto ocupa qualquer variável do tipo `int`, faria o seguinte:

```
sizeof(int);
```

Para saber, por exemplo, a quantidade de *bytes* ocupadas pelos quatro tipos principais de dados e o endereço da variável utilizada, executaria o seguinte:

```c
#include <stdio.h>
#include <stdlib.h>

int main()
{
  char caractere;
  int inteiro;
  float Float;
  double Double;

  printf("Tipo\tNum de Bytes\tEndereço\n");
  printf("-------------------------------------\n");
  printf("Char\t%d byte \t\t%p\n", sizeof(caractere), &caractere);
  printf("Inteiro\t%d bytes \t%p\n", sizeof(inteiro), &inteiro);
  printf("Float\t%d bytes \t%p\n", sizeof(Float), &Float);
  printf("Double\t%d bytes \t%p\n", sizeof(Double), &Double);

  return 0;
}
```

O código acima irá gerar uma espécie de tabela e utiliza `%p` com a função `printf` de forma a imprimir um *pointer*. No meu caso, recebi algo semelhante ao seguinte:

|   Tipo  | N.º de Bytes | Endereço |
|:-------:|:------------:|:--------:|
|   Char  |    1 byte    | 0028FF1F |
| Inteiro |    4 bytes   | 0028FF18 |
|  Float  |    4 bytes   | 0028FF14 |
|  Double |    8 bytes   | 0028FF08 |

Relembro que o endereço que aparece na tabela é o endereço corresponde à posição da variável utilizada para saber o número de *bytes* que o tipo em questão ocupava.

Pode verificar que todos os tipos de dados, exceto o tipo `char`, ocupam mais do que um *byte* na memória RAM. Então, o endereço que é imprimido corresponde apenas ao **primeiro _byte_** ocupado pela variável.

Quando imprimiu o endereço das variáveis no excerto de código anterior, verificou que o endereço imprimido não contém apenas números, mas também letras. Ao tipo de numeração que visualizou dá-se o nome **hexadecimal**.

{{% moreabout title="Hexadecimal para Decimal" %}}

A numeração hexadecimal tem como base 16 dígitos, enquanto que a decimal tem como base 10 dígitos. A tabela 10.2 (nos anexos) mostra a correspondência entre um carácter hexadecimal a um carácter decimal.

Ir-se-á converter o número hexadecimal `0028FF1F` para decimal. Em primeiro lugar, ter-se-á que tirar os primeiros dois zeros que são, neste caso, desprezíveis.

De seguida é necessário conhecer o significado de cada dígito hexadecimal em número decimal que está presente nesse número. Em decimal, os números 2, 8, F e 1 são, respetivamente, 2, 8, 15 e 1.

Para efetuar a conversão, tem que multiplicar cada um desses números por uma potência de base 16 cujo expoente é igual à posição de cada um dos números (da direita para a esquerda). Então, tem-se:

```text
(2*16^5)+(8*16^4)+(15*16^3)+(15*16^2)+(1*16^1)+(15*16^0)=
= 2097152+524288+61440+3840+16+15 =
= 2686751
```
{{% /moreabout %}}

Sabendo que a variável `inteiro` ocupa 4 *bytes* e que o primeiro *byte* se localiza na posição 2686744 (em decimal), poderemos dizer que a variável completa ocupa os *bytes* cujas posições são 2686744, 2686745, 2686746 e 2686747 (em decimal).

## Declaração de apontadores

A declaração deste tipo de variáveis é bastante semelhante à declaração dos outros tipos de variáveis. A única diferença é que de deve colocar um * (asterisco) antes do nome da variável ou depois do tipo de dados. O tipo de dados de um apontadores deve ser igual ao tipo de dados da variável que para a qual ele vai apontar.

A declaração de apontadores faz-se da seguinte forma:

```
tipo* nome;
```

## Inicialização de apontadores

Tal como a declaração, a inicialização de um apontador é semelhante à das variáveis. Basta igualar um apontador ao endereço de uma outra variável. Para obter o endereço de outra variável basta colocar um "e" comercial antes do seu nome. Ora veja o seguinte exemplo:

```c
#include <stdio.h>
#include <stdlib.h>

int main() {
    int numero = 5;
    int* ponteiro =  &numero;

	// igual a: printf("%d e %p", numero, &numero);
    printf("%d e %p", numero, ponteiro);
    return 0;
}
```

No código acima, é declarada a variável `numero`, do tipo `int`, que é igual a 5. Seguidamente, é declarado um apontador denominado `ponteiro` e inicializado com o valor `&numero`, ou seja, com a posição da variável `numero`. Podemos dizer que "`ponteiro` aponta para `numero`". No final é imprimido o conteúdo da variável `numero` e o o apontador da mesma, armazenado na variável `ponteiro`.

Imagine agora que precisa efetuar a soma de duas variáveis utilizando apenas apontadores. Sim, este é um exemplo bizarro, mas que funciona.

{{% alert title="" %}}
Se está a ter problemas com a codificação dos caracteres no Windows, inclua a biblioteca `Windows.h` e altere a página de codificação da linha de comandos como é feito na linha seis do exemplo seguinte.
{{% /alert %}}

```c
#include <stdio.h>
#include <stdlib.h>
#include <windows.h>

int main() {
    SetConsoleOutputCP(65001);

    int a, b, c;
    int* p, q;

    a = 5;
    b = 4;

    p = &a;
    q = &b;
    c = *p + *q;

    printf("A soma de %d e %d é %d.", a, b, c);
    return 0;
}
```

No exemplo anterior são declaradas cinco variáveis. Três que contêm números inteiros (`a`, `b` e `c`) e duas que contêm endereços da memória RAM (`p` e `q`). Para efetuar a soma entre as variáveis `a` e `b` e armazenar a mesma na variável `c` utilizando apontadores, tem que se igualar os apontadores `p` e `q` ao endereço das variáveis `a` e `b`. De seguida, a variável `c` terá que ser igual à soma do conteúdo que para o qual os apontadores estão a apontar (`*p + *q`).

Imagine agora que precisa de um procedimento que troque os valores de duas variáveis. Inicialmente, poderia pensar em fazer algo deste género:

```c
void trocaDeValores( int x, int y) {
    int temp;

    temp = x;
    x = y;
    y = temp;
}
```

Sintaticamente, nada está errado, mas o procedimento não vai realmente alterar os valores das variáveis. O que acontece no trecho de código anterior é que o procedimento recebe apenas o conteúdo de duas variáveis e coloca-os numas míseras variáveis locais, ou seja, aquelas que apenas estão disponíveis apenas dentro de uma função/procedimento. O procedimento correto a tomar seria o seguinte:

```c
void trocaDeValores(int* p, int* q) {
    int temp;

    temp = *p;
    *p = *q;
    *q = temp;
}
```

Esta função realmente troca os valores de duas variáveis. Enviam-se dois apontadores, dois endereços, e a variável troca os valores que estão em ambos os endereços da memória RAM, trocando os valores das variáveis.

## Operações com apontadores

Uma das principais vantagens da utilização de apontadores é a fácil modificação de outras variáveis e que algumas linguagens, como a linguagem C, trabalham mais rapidamente com apontadores.

Tal como acontece com as restantes variáveis, podemos incrementar e decrementar apontadores, ou seja, incrementar ou decrementar o endereço que para o qual aponta o apontador.

Imagine que temos um *array* do tipo `double` com dois elementos. Sabemos também que cada variável desse tipo ocupa, geralmente, 8 *bytes* na memória RAM. De seguida, é criado um apontador cujo endereço aponta para esse *array*. O que vai acontecer é que esse endereço apontará para o primeiro *byte* do *array* e não para todos eles.

```c
double numeros[2]; // declaração do array com dois elementos.
double *apontador;

apontador = numeros;
```

Hipoteticamente falando, a variável `apontador` armazena o endereço 4550. Então, sabendo que o *array* ocupa, na totalidade, 16 *bytes* (visto que tem a capacidade para armazenar dois elementos do tipo *double*, que ocupam 8 *bytes* cada), podemos dizer que este *array* ocupa todos os *bytes* entre 4550 e 4565 (inclusive).

Se procedermos a uma incrementação do tipo `apontador++`, a variável `apontador` deixará de apontar para a primeira posição do *array*, passando logo para a segunda. Porquê? Porque quando incrementamos/decrementamos um apontador, não estamos a adicionar/diminuir meramente um *byte*, mas sim a quantidade que ocupa um elemento do tipo de dados que o *array* tem.

Imaginando os endereços de variáveis como números decimais (o que não são, visto serem hexadecimais), as duas linhas seguintes seriam equivalentes:

```c
apontador++;
apontador + sizeof(double);
```

Como exemplo, tem abaixo uma progressão aritmética, que faz uso da incrementação de apontadores. Numa progressão aritmética cada termo é igual ao termo anterior somado com a razão, sendo esta última uma constante.

```
n[y] = n[y-1] + r
```

Poderíamos fazer este pequeno programa da seguinte forma (o código abaixo está explicado):

```c
#include <stdio.h>
#include <stdlib.h>

int main()
{
    int pa[10], razao;
    int *pointer;

    /*
     * Aqui pedímos o termo inicial, ou seja, o primeiro
     * número da PA (Progressão Aritmética).
     *
     * De seguida o apontador é definido para apontar para
     * o array pa.
     */
    printf("Insira o termo inicial: ");
    scanf("%d", &pa[0]);
    pointer = pa;

    printf("Insira razão: ");
    scanf("%d", &razao);

    while(pointer != &pa[9]) {
        /*
         * Cada valor da PA é definido somando o valor corrente do apontador com a razão.
         * De seguida, o apontador é incrementado de forma a apontar para o próximo
         * elemento do array. (Isto acontece enquanto o apontador for diferente do
         * endereço do último elemento da PA.)
         */
        *(pointer + 1) =  *pointer + razao;
        pointer++;
    }

    printf("PA");

    for(pointer = pa ; pointer <= &pa[9] ; pointer++) {
        /*
         * Aqui todos os elementos do array são percoridos
         * e imprime-se assim a Progressão Aritmética criada.
         */
        printf(" -> %d", *pointer);
    }

    return 0;
}
```
