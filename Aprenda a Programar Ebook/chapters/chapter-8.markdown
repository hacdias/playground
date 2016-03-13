Na programação, os tipos de dados não se limitam aos já abordados no capítulo 2: `char`, `int`, `float`, `double`, etc. O tipo `char` permite armazenar um carácter. Mas, não é um carácter muito pouco? E se for necessário armazenar uma frase? Aí entram as *strings*.

{{% concept %}}
**Strings** são sequências de caracteres. Qualquer frase é considerada uma *string*, pois é uma sequência de caracteres.
{{% /concept %}}

Em C, todas as *strings* terminam com o carácter `\0`, um delimitador ASCII para indicar o final da *string*.

## Declaração e inicialização de *strings*

As *strings* podem conter, tal como as variáveis do tipo `char`, apenas um carácter. A diferença entre ambas prende-se com a utilização de aspas ou plicas. As aspas são utilizadas para delimitar *strings* e as plicas para delimitar caracteres. Visualize o seguinte exemplo:

```
"Programar" -> String
"P" -> String
'P' -> Caracter
```

Em C, as *strings* são *arrays* de caracteres, ou seja, *arrays* do tipo `char`. Podem ser declaradas de diversas formas.

Uma forma de declarar *strings* em C, é criar um *array* do tipo `char` com um número de caracteres pré-definidos. Por exemplo:

```c
// o mesmo que: char nome[8] = {'P', 'p', 'l', 'w', 'a', 'r', 'e', '\0'};
char nome[8] = "Pplware";
```

No exemplo anterior, é declarada a *string* `nome` que pode armazenar uma frase com 7 caracteres. Porquê 7 se foram declaradas 8 posições no *array*? Isto acontece porque o último carácter, o oitavo carácter, é o delimitador do final da frase `\0`.

Existem, no total, três formas de declarar *strings* em C: 

+ A primeira consiste na criação de um *array* com o tamanho pré-determinado;
+ A segunda consiste na criação de um *array* sem especificar o seu comprimento, tendo que ser inicializada no momento da declaração de forma a que o espaço na memória seja alocado dependendo do tamanho da *string* colocada;
+ Ou através de um apontador.

```c
char nome[8] = "Pplware";
char nome[] = "Pplware"; // recomenda-se devido à legibilidade
char* nome = "Pplware"; 
```

Se reparar, este "tipo" de dados sempre foi utilizado. Na função *printf*, por exemplo, o primeiro argumento foi sempre uma *string*, pois é uma sequência de caracteres delimitada por aspas.

## Como imprimir *strings*

As *strings* podem ser imprimidas recorrendo a diversas funções. Aqui são abordadas duas formas: recorrendo à função `printf` e recorrendo à função `puts`.

### Com a função `printf`

Para imprimir uma *string* utilizando a função `printf`, basta utilizar o especificador `\%s`. Por exemplo:

```c
printf("Esta é uma string: %s", nomeDaString);
```

A função `printf` é útil quando é necessário imprimir uma *string* que pode variar.

### Com a função `puts`

Temos também a função `puts`, já abordada no capítulo 5, cujo nome quer dizer *put string*, ou seja, colocar *string*. Esta função é excelente para imprimir uma *string* que não esteja intercalada noutra *string*. Ora veja o seguinte exemplo:

```c
char* nome = "José";
puts(nome);
```

## Como ler *strings*

Quando é necessário um dado do utilizador como o nome, por exemplo, saber como se leem *strings* é importante. A leitura de *strings* pode ser feita de diversas formas.

### Com a função `scanf`

A função `scanf` já foi falada diversas vezes ao longo deste livro. Tal como o que acontece com a função `printf`, deve-se utilizar o especificador `%s` para ler *strings*. Ora veja como se lê uma *string*:

```c
scanf("%s", variavelParaArmazenarAString);
```

Analisando o excerto anterior é possível verificar que, ao contrário do que acontece com os restantes tipos de dados, neste não colocamos o "e" comercial no início do nome da variável que é utilizada para armazenar a *string*. Isto acontece porque as variáveis que contêm *strings* são, ou *arrays*, ou apontadores, logo o seu nome já aponta para o endereço da memória.

Imagine agora que precisa do nome, apelido, morada e código postal de um utilizador para criar o seu cartão de identificação. Poderia proceder da seguinte forma:

```c
#include <stdio.h>
#include <stdlib.h>
 
int main() {
    char nome[21],
        apelido[21],
        morada[51],
        codigoPostal[11];
 
    printf("Por favor insira os seus dados conforme pedido:\n\n");
    printf("Primeiro nome: ");
    scanf("%s", nome);
 
    printf("Último nome: ");
    scanf("%s", apelido);
 
    printf("Morada: ");
    scanf("%s", morada);
 
    // limpeza do buffer no Windows; usar "_fpurge(stdin)" em sistemas Unix
    fflush(stdin);
 
    printf("Código Postal: ");
    scanf("%s", codigoPostal);
 
    printf("\nO seu Cartão de Identificação:\n");
    printf("Nome: %s, %s\n", apelido, nome);
    printf("Morada: %s\n", morada);
    printf("Código Postal: %s\n", codigoPostal);
    return 0;
}
```

Relembro que a utilização de comandos para limpar o *buffer* não é recomendável e que devem ser utilizadas outras funções que não a `scanf` de forma a obter dados do utilizador sem "lixo".

\subsection{Com a função \texttt{gets}}

Podem-se imprimir \textit{strings} com a função \texttt{gets}, cujo nome quer dizer \textit{get string}, ou seja, obter \textit{string}. A utilização desta função é simples. Ora veja como se utiliza esta função:

\begin{lstlisting}
gets(nomeDaVariavel);
\end{lstlisting}

Onde \texttt{nomeDaVariavel} corresponde ao apontador que aponta para o local onde a \textit{string} vai ser armazenada. Recordo que, no caso se ser utilizado um apontador ou um \textit{array}, não é necessário utilizar um \quotes{e} comercial no início.

Imaginando agora que precisa criar um boletim de informação com diversos dados sobre o utilizador. Poderia fazer da seguinte forma:

```c
#include <stdio.h>
#include <stdlib.h>
 
int main() {
    char nome[21],
        apelido[21],
        morada[51],
        codigoPostal[11];
 
    printf("Por favor insira os seus dados conforme pedido:\n\n");
    printf("Primeiro nome: ");
    gets(nome);
 
    printf("Último nome: ");
    gets(apelido);
 
    printf("Morada: ");
    gets(morada);
 
    printf("Código Postal: ");
    gets(codigoPostal);
 
    printf("\nO seu Cartão de Identificação:\n");
    printf("Nome: %s, %s\n", apelido, nome);
    printf("Morada: %s\n", morada);
    printf("Código Postal: %s\n", codigoPostal);
    return 0;
}
```

Analisando o código é possível verificar que com esta função não é preciso limpar o *buffer* de forma a não obter caracteres indevidos. Isto acontece porque a função `gets` os ignora.

### Com a função `fgets`

Tanto a função `gets` como a função `scanf` têm alguns contratempos; a primeira tem alguns problemas quando as *strings* incluem caracteres como espaços e a segunda obtém caracteres desnecessários. Devido à falta de uma solução efetiva a estes problemas, a função `fgets` poderá ser a melhor opção.

A função `fgets` permite obter dados, não só do teclado, como de outros locais. Ora veja a sua sintaxe:

```c
fgets(char *str, int n, FILE *stream);
```

Onde:

+ `str` corresponde ao apontador para um \textit{array} de caracteres onde os dados obtidos serão armazenados;
+ `n` é o número máximo de caracteres a serem lidos (incluindo o delimitador final). Geralmente é igual ao tamanho do \textit{arrar};
+ `stream` corresponde ao apontador para o ficheiro ou objeto donde serão lidos os dados.

Imaginando agora que é necessário converter o programa da criação do boletim de informação do utilizador para utilizar a função \texttt{fgets}. Ficaria da seguinte forma:

\begin{lstlisting}
#include <stdio.h>
#include <stdlib.h>
 
int main() {
    char nome[21],
        apelido[21],
        morada[51],
        codigoPostal[11];
 
    printf("Por favor insira os seus dados conforme pedido:\n\n");
    printf("Primeiro nome: ");
    fgets(nome, 21, stdin);
 
    printf("Último nome: ");
    fgets(apelido, 21, stdin);
 
    printf("Morada: ");
    fgets(morada, 51, stdin);
 
    printf("Código Postal: ");
    fgets(codigoPostal, 11, stdin);
 
    printf("\nO seu Cartão de Identificação:\n");
    printf("Nome: %s, %s\n", apelido, nome);
    printf("Morada: %s\n", morada);
    printf("Código Postal: %s\n", codigoPostal);
    return 0;
}
\end{lstlisting}

Se compilar e correr o código acima, irá receber algo semelhante ao seguinte:

\begin{lstlisting}[language=bash,numbers=none]
O seu Cartão de Identificação:
Nome: Apelido
, Nome
 
Morada: Morada

Código Postal: CP
\end{lstlisting}

Estas mudanças de linha acontecem porque as \textit{strings} obtidas através da função \texttt{fgets} ficaram com o carácter \texttt{\textbackslash n} no final. Para remover este carácter pode-se recorrer à função \texttt{strtok}. Esta função utiliza-se da seguinte forma:

\begin{lstlisting}
strtok(char *str, const char *delim);
\end{lstlisting}

Onde:

\begin{itemize}
\item \texttt{str} é o apontador para um \textit{array} de caracteres onde a \textit{string} está armazenada;
\item \texttt{delim} corresponde ao delimitador a remover.
\end{itemize}

Assim, para que o carácter \texttt{\textbackslash n} seja removido de todas as \textit{strings} utilizadas no programa anterior, bastaria adicionar as seguintes linhas:

\begin{lstlisting}
strtok(nome, "\n");
strtok(apelido, "\n");
strtok(morada, "\n");
strtok(codigoPostal, "\n");
\end{lstlisting}
