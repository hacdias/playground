---
weight: 2
title: Dados
description: "Tal como o nome sugere, o tema a abordar são os dados e várias coisas relacionadas com eles. São abordados os vários tipos de dados existentes, tal como a utilização de variáveis e constantes em C."
type: page
---

No [capítulo 1](/aprenda-a-programar/fundamentos/) foi referida a existência de diversos tipos de dados, que podem variar de linguagem para linguagem e também a existência de variáveis e constantes.

{{% concept %}}
Os **tipos de dados** constituem uma variedade de valores e de operações que uma variável pode suportar. São necessários para indicar ao compilador (ou interpretador) as conversões necessárias para obter os dados da memória.
{{% /concept %}}

Os tipos de dados subdividem-se ainda em dois grupos: os tipos primitivos e os tipos compostos.

{{% concept %}}
**Tipos primitivos**, nativos ou básicos são aqueles que são fornecidos por uma linguagem de programação como um bloco de construção básico.

**Tipos compostos** são aqueles que podem ser construídos numa linguagem de programação através de tipos de dados primitivos e compostos. A este processo denomina-se **composição**.
{{% /concept %}}

## Variáveis

No [capítulo 1](/aprenda-a-programar/fundamentos/) foi abordada a existência de variáveis e constantes que permitem armazenar dados. Nesta secção é explicado como se devem declarar as variáveis na linguagem de programação que será utilizada ao longo do resto do livro, a linguagem C.

Relembro que variáveis permitem o armazenamento de valores que podem ser alterados durante a execução de um programa. A declaração de variáveis em C é bastante simples:

```c
tipo_de_dados nome_da_variavel;
```

Onde:

-   `tipo_de_dados` corresponde ao tipo de dados que a variável vai armazenar;
-   `nome_da_variavel` corresponde ao nome que a variável vai tomar, à sua identificação.

Imagine que quer criar uma variável chamada `idade` do tipo inteiro. Bastaria proceder da seguinte forma:


```c
int idade;
```

## Constantes

Em C, tal como noutras linguagens de programação, existem as constantes. Relembro que constantes permitem armazenar valores imutáveis durante a execução de um programa.

Existem diversas formas de declarar constantes em C. Iremos abordar as duas mais utilizadas: as constantes declaradas e as constantes definidas.

### Constantes Definidas com `#define`

Chamam-se Constantes Definidas àquelas que são declaradas no cabeçalho de um ficheiro. Estas são interpretadas pelo pré-processador que procederá à substituição da constante em todo o código pelo respetivo valor. A principal vantagem deste tipo de constantes é que são sempre globais. Ora veja como se define:

```c
#define identificador valor
```

Onde:

-   `identificador` corresponde ao nome da constante que, convencionalmente, é escrito em maiúsculas e com *underscore* (\_) a separar palavras;
-   `valor` corresponde ao valor que a constante armazena.

Imagine que, por exemplo, precisa de uma constante que armazene o valor do Pi e que depois se calcule o perímetro de um círculo. Poderia proceder da seguinte forma:

```c
#include <stdio.h>
#define PI 3.14159

int main (){

  double r = 5.0;              
  double circle;

  circle = 2 * PI * r;      
  printf("%f\n", circle);
  return 0;
}
```

O que acontece quando é definida uma constante através da diretiva `#define` é que quando o pré-compilador lê a definição da constante, substitui todas as ocorrências no código daquela constante pelo seu valor, literalmente.

{{% moreabout %}}
Pode utilizar a biblioteca `math.h` que tem a constante `M_PI` com o valor do pi.
{{% /moreabout %}}

### Constantes Declaradas com `const`

As Constantes Declaradas, ao contrário das Constantes Definidas são, tal como o próprio nome indica, declaradas no código, em linguagem C. A declaração destas constantes é extremamente semelhante à declaração das variáveis. Apenas temos que escrever `const` antes do tipo de dados. Ora veja como se declara uma constante:

```c
const tipo nome = valor;
```

Onde:

-   `tipo` corresponde o tipo de dados que a constante vai conter;
-   `nome` corresponde ao nome da constante;
-   `valor` corresponde ao conteúdo da constante.

Se tentar alterar o valor de uma constante durante a execução de um programa irá obter um erro. Analise então o seguinte excerto de código:

```c
#include <stdio.h>
#include <math.h>

int main() {
    const double goldenRatio = (1 + sqrt(5)) / 2;

    goldenRatio = 9; // erro. A constante não pode ser alterada.

    double zero = (goldenRatio * goldenRatio) - goldenRatio - 1;
    printf("%f", zero);
    return 0;
}    
```

Existem vantagens ao utilizar cada uma destas formas de declarar constantes. As constantes declaradas podem ser locais ou globais porém as definidas são sempre globais.

{{% concept %}}
Uma constante/variável **local** é uma constante/variável que está restrita a uma determinada função e só pode ser utilizada na função em que é declarada.
{{% /concept %}}

## Números inteiros - `int`

Comecemos por abordar o tipo `int`. Esta abreviatura quer dizer *integer number*, ou seja, número inteiro (exemplos: 4500, 5, -250). Em C, pode-se definir o intervalo em que se situam os números de cada variável do tipo `int`.

{{% concept %}}
**Inicialização de variáveis** consiste em dar o primeiro valor a uma variável no código. Uma variável não tem que ser obrigatoriamente inicializada no código. Pode-se, por exemplo, declarar uma variável e dar-lhe o valor de uma leitura em que o utilizador introduz os dados, sendo a variável inicializada com os dados inseridos pelo utilizador.
{{% /concept %}}

No seguinte exemplo pode visualizar como se declara uma variável, ou seja, como se reserva um endereço da memória RAM, do tipo `int` com o nome `a`. Seguidamente é inicializada com o valor 20 e imprimida recorrendo à função `printf`.

```c
#include <stdio.h>      

int main() {      

    int a;
    a = 20;      

    printf("Guardei o número %d.", a);  
    return 0;      
}      
```

Antes de continuar, deve ter reparado que foi utilizado um `%d` dentro do primeiro parâmetro. Este é substituído pelo valor da variável `a` quando é impresso no ecrã.

### Função `printf` e números inteiros

Utiliza-se `%d` quando se quer imprimir o valor de uma variável dentro de uma frase. A variável deve ser colocada nos parâmetros seguintes, por ordem de ocorrência. Por exemplo:


```c
#include <stdio.h>

int main() {
    int a, b;
    a = 20;
    b = 100;

    /* imprime: O primeiro número é: 20 */
    printf("O primeiro número é: %d.\n", a);
    /* imprime: O segundo número é: 100 */
    printf("O segundo número é: %d.\n", b);
    /* imprime: O primeiro e segundo números são 20 e 100 */
    printf("O primeiro e segundo números são %d e %d.\n", a, b);

    return 0;
}
```

### Modificadores `short` e `long`

Este tipo de variáveis ocupa, normalmente, entre 2 a 4 *bytes* na memória de um computador. E se quiser utilizar uma variável para um número pequeno? Não poderei gastar menos recursos? E se acontecer o contrário e precisar de um número maior?

{{% moreabout title="" %}}
*Bit (Binary Digit)* é a menor unidade de informação que pode ser armazenada ou transmitida. Um *bit* só pode assumir dois valores: 0 e 1, ou seja, o código binário. Os *bits* são representados por "B" minúsculo.

*Byte (Binary Term)* é um tipo de dados de computação. Normalmente é utilizado para especificar a quantidade de memória ou capacidade de armazenamento de algo. É representado por um "B" maiúsculo. Geralmente:

-   **1 Byte** = 8 bits (Octeto)
-   **1/2 Byte** = 4 bits (Semiocteto)

Existem os **Prefixos Binários (IEC)** que são nomes/símbolos utilizados para medidas indicando a multiplicação da unidade, neste caso *byte*, por potências de base dois. Como por exemplo os *megabibytes* (MiB) que equivale a dois elevado a vinte *bytes*.

Por outro lado, existem os prefixos do **Sistema Internacional de Unidades (SI)**, que são os mais comuns, que correspondem na unidade multiplicada por potências de base dez. Como por exemplo os *megabytes* (MB) que correspondem a dez elevado a seis.
{{% /moreabout %}}

Nestas situações, podem-se utilizar modificadores.

{{% concept %}}
Um **modificador** consiste numa palavra-chave, numa *keyword*, que se coloca antes de um elemento de forma a modificar uma propriedade do mesmo.
{{% /concept %}}

Para alterar a capacidade de armazenamento, ou seja, o número de *bytes* ocupado por uma variável do tipo `int`, podem-se utilizar os modificadores `short` e `long`. Estes permitem-nos criar variáveis que ocupem um maior ou menor número de bytes, respetivamente.

Uma variável do tipo `int`, ao assumir um número de *bytes* diferentes, também está a alterar a sua capacidade de armazenamento. Assim, temos os seguintes valores:

-   1 *byte* armazena de -128 a +127
-   2 *bytes* armazenam de -32 768 a +32 767
-   4 *bytes* armazenam de -2 147 483 648 a +2 147 483 647
-   8 *bytes* armazenam de -9 223 372 036 854 775 808 a +9 223 372 036 854 775 807

A utilização destes modificadores é feita da seguinte forma:

```c
short int nomeDaVariavel = 20; // ou "long"
```

**Função `sizeof`**

O número de *bytes* atribuído utilizando um destes modificadores pode depender do computador onde o código está a ser executado. Este "problema" depende da linguagem. Existem linguagens de programação cuja capacidade de cada tipo de variável é igual em todas as máquinas.

Para descobrirmos qual o tamanho de bytes que utiliza o seu sistema, basta recorrer à função `sizeof` da seguinte forma:

```c
#include <stdio.h>

int main() {    
    printf("int : %d bytes\n", sizeof(int) );
    printf("short int: %d bytes\n", sizeof(short) );
    printf("long int: %d bytes\n", sizeof(long) );
    return 0;
}
```

No computador que estou a utilizar, por exemplo, `short` refere-se a 2 *bytes*, `long` a 8 *bytes* e o tamanho padrão de `int` é 4 *bytes*.

### Modificadores `signed` e `unsigned`

Como sabe, os números inteiros podem assumir forma positiva e negativa. Por vezes, na programação, os números negativos podem atrapalhar (ou então ajudar), dependendo do caso.

Para termos controlo sobre a "positividade" ou "negatividade" de um número, podemos atribuir os modificadores `signed` e `unsigned`. Para que uma variável possa conter tanto números positivos como negativos, devemos utilizar o modificador `signed`. Caso queira que o número seja apenas positivo, incluindo 0, utilize `unsigned`.

Tendo em conta que variáveis marcadas com o modificador `unsigned` não podem conter números negativos, podem conter um intervalo de números positivos superior ao regular. Imaginando que uma variável `int` suporta números entre -32 768 e 32 767; a mesma variável com o modificador `unsigned` irá suportar números entre 0 e 65 535.

## Números reais - `float` e `double`

Além dos números inteiros, existem outros tipos de dados que nos permitem armazenar números que, ao invés de serem inteiros, são decimais (por exemplo 1,3; 5,540; etc).

Existem dois tipos de dados que nos permitem armazenar valores do tipo decimal/real, ou seja, que têm casas decimais. Estes tipos são `float` e `double`. Devem ser utilizados da seguinte forma:

```c
float pi = 3.14;
double pi = 3.14159265359;
```

Como pode ter reparado, em C (e na maioria das linguagens de programação), não se utiliza a vírgula, mas sim um ponto para separar a parte inteira da decimal.

A diferença entre `float` e `double` é que o segundo ocupa mais memória que o primeiro, logo consegue armazenar números de maior dimensão.

Normalmente, o tipo float ocupa 4 *bytes* de memória RAM enquanto o segundo tipo, `double`, ocupa 8 *bytes* de memória. Mais uma vez, relembro que estes valores podem alterar de máquina para máquina.

Para quem precise de fazer cálculos mais precisos, o tipo de dados `double` é o mais aconselhado pois é o que permite uma maior extensão do valor.

### Função `printf` e números reais

Recorrendo à função `printf` abordada na secção **1.5.7**, utiliza-se `%f` para se imprimir o valor de uma variável dos tipos `float` e `double`. A variável deve ser colocada nos parâmetros seguintes, por ordem de ocorrência. Por exemplo:

```c
#include <stdio.h>

int main() {    
    float piMinor = 3.14;
    double piMajor = 3.14159265359;

	// imprime: Pi pode ser 3.140000 mas, de forma mais exata, é 3.141593
    printf("Pi pode ser %f mas, de forma mais exata, é %f.", piMinor, piMajor);

    return 0;
}
```

Pode visualizar que, quando se utiliza `%f`, é utilizado um número específico de casas decimais. Caso o número de casas decimais seja mais pequeno do que o da variável original, o número é arredondado.

Pode definir o número de casas decimais que quer que sejam apresentadas da seguinte forma: `%.{númeroDeCasasDecimais}f`. Veja o seguinte exemplo, baseado no anterior:

```c
#include <stdio.h>

int main() {    
    float piMinor = 3.14;
    double piMajor = 3.14159265359;

	// imprime: Pi pode ser 3.14 mas, de forma mais exata, é 3.14159265359.
    printf("Pi pode ser \%.2f mas, de forma mais exata, é \%.11f.", piMinor, piMajor);

    return 0;
}
```

### Notação Científica

Relembre o conceito de [notação científica](http://pt.wikipedia.org/wiki/Nota\%C3\%A7\%C3\%A3o_cient\%C3\%ADfica), ou seja, números no formato `n*10^s`, ou seja,`(n` vezes dez elevado a `s`. Podemos utilizar notação científica nas variáveis do tipo *float* e *double*. Veja o seguinte exemplo:

```c
#include <stdio.h>

int main() {    
    float num = 24E-5; // 24 x 10 elevado a -5
    printf("\%f\n", num); // imprime: 0.000240

    num = 2.45E5; //2.45 x 10^5
    printf("\%.0f", num);  // imprime: 245000

    return 0;
}
```

## Caracteres - `char`

O tipo `char` é um género de dados que nos permite armazenar um único carácter. É declarado da seguinte forma:

```c
char letra = 'P';
```

Como pode visualizar, a variável `letra` agora contém o carácter "P". Pode, ao invés de utilizar este tipo de notação, utilizar números hexadecimais, octais e decimais. Em C pode-se utilizar ASCII.

{{% concept %}}
**ASCII** (do inglês *American Standard Code for Information Interchange*; em português "Código Padrão Americano para o Intercâmbio de Informação") é um conjunto de códigos binários que codificam 95 sinais gráficos e 33 sinais de controlo. Dentro desses sinais estão incluídos o nosso alfabeto, sinais de pontuação e sinais matemáticos. No **Anexo I** encontra uma tabela ASCII com caracteres que podem ser utilizados em C.
{{% /concept %}}

### Função `printf` e caracteres

Utiliza-se *%c* quando se quer imprimir o valor de uma variável dos tipo `char` dentro de uma frase. A variável deve ser colocada nos parâmetros seguintes, por ordem de ocorrência. Exemplo:

```c
#include <stdio.h>

int main() {    
    char letra = 'P';

    printf("O nome Pplware começa por %c.", letra);   
    return 0;
}
```
