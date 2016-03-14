---
weight: 6
title: Funções e Procedimentos
type: page
description: "No quinto capítulo serão abordadas duas coisas importantíssimas na programação: as funções e procedimentos. Com elas irá poupar espaço e ainda reutilizar código."
---

Neste capítulo é abordada uma parte fundamental da programação funcional, ou seja, as funções e procedimentos.

{{% concept %}}
Uma **função** é um bloco de código, que tal como o próprio nome indica, tem uma função própria, ou seja, que serve para um finalidade específica.

**Procedimentos** são blocos de código que contêm uma função específica. A diferença entre funções e procedimentos é que os procedimentos não retornam qualquer valor.
{{% /concept %}}

Ao invés de colocarmos um determinado trecho de código diversas vezes, basta criarmos uma função com esse código e de cada vez que for necessário, precisamos apenas de invocar a função. As funções permitem-nos, por exemplo, reutilizar código.

{{% concept %}}
**Invocar** uma função é o nome que se dá quando o nome de uma função é mencionado no código e esta é "chamada".
{{% /concept %}}

Durante os seus anos de programador irá criar milhares de funções para os mais diversos propósitos. Então é recomendável que vá guardando as funções que utiliza porque futuramente poderá vir a precisar delas.

Existe uma função que tem vindo a ser sempre utilizada: o `main`. É a função principal do programa; aquela que é executada automaticamente quando um programa é iniciado.

## Criação de funções

Então, o primeiro passo a dar é saber como se criam funções.

**Sintaxe**

```c
tipo_dado_retorno nome_da_funcao(parametros) {
    // conteúdo da função
}
```

**Onde:**

-   **tipo_dado_retorno** corresponde ao tipo de dados que a função vai devolver (retornar);
-   **nome_da_funcao** corresponde ao nome da função em questão;
-   **parametros** corresponde aos parâmetros da função, algo que será abordado mais à frente.

Imagine que precisa de um procedimento que imprime a mensagem "Hello World!" no ecrã. Poderia fazer isso da seguinte forma:

```c
#include <stdio.h>

int main() {
    dizHello();
    return 0;
}

void dizHello() {
    printf("Olá Mundo!\n");
}
```

A função chama-se `dizHello` e não retorna nenhuns dados (`void`). O que está contido entre chavetas é o código que é executado quando o procedimento é chamado.

### Argumentos e parâmetros

No exemplo acima é possível visualizar que tanto na invocação da função, como na sua definição foi colocado um par de parênteses sem nada. Isto acontece porque não existem parâmetros.

{{% concept %}}
**Parâmetros** é o conjunto de elementos que uma função pode receber (*input*).
{{% /concept %}}

Imagine agora que necessita de uma função que efetua uma soma: como enviamos os valores para uma função? Definindo o nome e o tipo de parâmetros. Ora veja:

```c
void soma(int n1, int n2) {
    int soma = n1 + n2;
}
```

A função representada no trecho acima, denominada `soma`, tem dois parâmetros, o `n1` e o `n2`, ambos do tipo `int`. Para utilizar a função, basta então proceder do seguinte modo:

```c
soma(4, 6);
```

Os números 4 e 6 (que podiam ser quaisquer outros) são denominados argumentos. A função armazena os dois argumentos na variável `soma` que apenas está disponível dentro da função, o valor da soma entre os dois números.

{{% concept %}}
**Argumento** é o nome dado a um valor que é enviado para a função.
{{% /concept %}}

### Retorno de uma função

Geralmente uma função retorna um valor de forma a poder ser utilizado para outro fim. Para isso, ao invés de colocarmos `void` na declaração da função, devemos colocar qualquer outro tipo de dados.

Imagine que quer que uma função retorne o valor de uma soma entre dois números. Poderia proceder da seguinte forma:

```c
int soma(int n1, int n2) {
    return n1 + n2;
}
```

A função acima retorna dados do tipo `int` e tem dois parâmetros: o `n1` e`n2`. Podemos aplicar esta função, por exemplo, no seguinte contexto, onde o programa efetua a soma de dois números dados pelo o utilizador.

```c
#include <stdio.h>

int main() {
    int a, b;

    printf("Insira o primeiro número: ");
    scanf("%d", &a);

    printf("Insira o segundo número: ");
    scanf("%d", &b);

    printf("A soma é %d", soma(a,b));
    return 0;
}

int soma(int n1, int n2) {
    return n1 + n2;
}
```

## Algumas funções úteis

Aqui encontram-se algumas funções que são úteis no seguimento deste livro. Algumas são relativas à entrada e saída de dados, ou seja, funções que podem receber dados inseridos pelo utilizador e funções que permitem mostrar dados no ecrã. Outras relativas à matemática. Ao longo do livro, outras funções serão abordadas.

### Função `puts`

A função `puts` serve simplesmente para imprimir texto no ecrã. Ao contrário da função `printf` não nos permite imprimir texto formatado.

**Sintaxe**

```c
puts("frase");
```

Ao imprimir uma frase com esta função, o carácter correspondente a uma nova linha é sempre adicionado ao final da mesma.

Imagine agora que precisa de imprimir uma mensagem que não contem nenhum valor variável e a mensagem era "Bem-vindo ao programa XYZ!". Poderia fazê-lo da seguinte forma:

```c
puts("Bem-vindo ao programa XYZ!");
```

### Função `scanf`

A função `scanf` permite-nos obter diversos tipos de dados do utilizador. A utilização desta função é semelhante à da já conhecida função `printf`; são como um "espelho" uma da outra. A `scanf` reconhece o *input* e a `printf` formata o *output*.

**Sintaxe**

```c
scanf(fraseFormatada, &variaveis...);
```

Onde:

-   `fraseFormatada` corresponde à formatação do que irá ser imprimido com os espaços para as variáveis;
-   `variaveis` corresponde às variáveis onde vão ser armazenados os valores obtidos por ordem de ocorrência. O nome da variável deve ser sempre precedido por um `&`;

Imagine agora que vai criar um algoritmo que peça a idade ao utilizador e a imprima logo de seguida. Poderia fazer isto da seguinte forma:

```c
#include <stdio.h>

int main() {   
    int idade;

    printf("Digite a sua idade: ");
    scanf("%d", &idade);

    printf("A sua idade é %d", idade);
    return 0;
}
```

Como pode verificar através da sétima linha do trecho de código anterior, o primeiro parâmetro da função `scanf` deve ser uma *string* com o tipo de caracteres a ser inserido. Todos os parâmetros seguintes deverão ser o nome das variáveis às quais se quer atribuir um valor, precedidos por `&`.

Ao se executar o trecho de código anterior, a mensagem "Digite a sua idade:" irá aparecer o ecrã e o cursor irá posicionar-se logo após essa frase aguardando que um valor seja inserido. Deve-se inserir o valor e premir a tecla *enter*. Depois será imprimida uma mensagem com a idade inserida.

Relembro que pode utilizar as seguintes expressões para definir o tipo de dados a ser introduzido:

-   `%d` → Números inteiros (`int`);
-   `%f` → Números decimais (`float` e `double`);
-   `%c` → Caracteres (`char`).

Podem-se pedir mais do que um valor com a função `scanf`. Ora veja o seguinte exemplo:

```c
#include <stdio.h>

int main()
{   
    int num1, num2;

    printf("Digite dois números: ");
    scanf("%d %d", &num1, &num2);

    printf("Os números que digitou são %d e %d.", num1, num2);

    return 0;
}
```

Assim, quando executar o código acima, terá que escrever dois números, separados por um espaço, *tab* ou *enter*.

### Função `getchar`

Existe uma forma simplicíssima de pedir caracteres ao utilizador: utilizando a função `getchar`. Basta igualar uma variável à função. Esta função é recomendável quando se quer receber um único carácter numa linha.

**Sintaxe**

```c
variavel = getchar();
```

No seguinte exemplo é pedido para inserir a primeira letra do seu nome.

```c
#include <stdio.h>

int main() {   
    printf("Insira a primeira letra do seu nome: ");
    char letra = getchar();

    printf("A primeira letra do seu nome é %c.", letra);
    return 0;
}
```

### Limpeza do `buffer`

Quando se fala em entrada e saída de dados, deve-se ter em conta o *buffer* e a sua limpeza, pois é algo extremamente importante que pode fazer a diferença entre um programa que funciona e um que não funciona.

{{% concept %}}
*Buffer* é o nome dado à região da memória de armazenamento física que é utilizada para armazenar temporariamente dados.
{{% /concept %}}

Ora analise o seguinte código:

```c
#include <stdio.h>

int main()
{   
    char letra1, letra2;

    printf("Insira a primeira letra do seu nome: ");
    scanf("%c", &letra1);

    printf("E agora a última: ");
    scanf("%c", &letra2);

    printf("O seu nome começa com \"%c\" e termina com \"%c\".", letra1, letra2);

    return 0;
}
```

Ao olhar para o código acima, provavelmente pensará que tudo irá correr como previsto: executa-se o programa, digitam-se duas letras ("X" e "Y", por exemplo) e depois é imprimida a mensagem "O seu nome começa com X e termina com Y.". Infelizmente, não é isso que acontece.

Se executar o algoritmo acima, irá inserir a primeira letra, clicar na tecla *enter*, mas depois o programa irá chegar ao fim dizendo que o seu nome termina com a letra ` ` (em branco). Por que é que isto acontece? Quando a tecla *enter* é premida, o programa submete a letra inserida, mas o carácter correspondente à tecla *enter*, `\n`, também fica na memória. Assim, quando é pedido um novo carácter, o que estava na memória é automaticamente submetido.

Para que isso não aconteça, basta limpar o *buffer* antes de pedir dados novamente ao utilizador. No Windows pode ser utilizada a função `fflush` e em sistemas operativos Linux a função `__fpurge`. Então, ficaria assim:

```c
#include <stdio.h>

int main()
{   
    char letra1, letra2;

    printf("Insira a primeira letra do seu nome: ");
    scanf("%c",&letra1);

 	// stdin corresponde à entrada teclado
    fflush(stdin);
    __fpurge(stdin);

    printf("E agora a última: ");
    scanf("%c",&letra2);

    printf("O seu nome começa com \"%c\" e termina com \"%c\".", letra1, letra2);

    return 0;
}
```

A utilização deste tipo de funções não é recomendável, pois não é uma convenção da linguagem C. Então pode tomar ações diferentes dependendo do compilador. O recomendável é utilizar funções que não incluam "lixo" quando é necessário ler algo do utilizador.

### Função `rand`

Durante a sua jornada no mundo da programação irá precisar de gerar números aleatórios para os mais diversos fins. Em C podemos gerar números aleatórios recorrendo à função `rand`. Para poder utilizar esta função deve-se incluir a biblioteca `stdlib.h`.

**Sintaxe**

```c
int numero = rand();
```

Imagine que precisa gerar um número aleatório entre 1 e 10. Em primeiro lugar teria que obter o resto da divisão de `rand` por 10 e somar 1. Ora veja:

```c
int numero = (rand() % 10) + 1;
```

Se experimentar executar um algoritmo que contenha a linha de código acima, irá verificar que o número gerado é sempre o mesmo, mas ninguém quer que o número gerado seja sempre o mesmo. Então, temos que "semear" a "semente" que vai dar origem ao número. Para o fazer deve-se recorrer à função `srand`.

A função `srand` permite adicionar um número como ponto de partida de forma a gerar um número aleatório. Podemos, por exemplo, gerar um número baseado na hora e tempo atuais. Ora veja um exemplo:

```c
#include <stdio.h>
#include <stdlib.h>
#include <time.h>

int main() {
	/* "semeia-se" utilizando o tempo atual num
	tipo unsigned, ou seja, só com valores positivos */
	srand((unsigned)time(NULL));
	int numero = (rand() % 10) + 1;

	printf("O número gerado é %d.", numero);
	return 0;
}
```

Agora, mesmo que execute o mesmo código várias vezes, irá verificar que o número gerado é diferente na maioria das vezes. Não se esqueça de incluir a biblioteca `time.h` para poder utilizar a função `time()`.
