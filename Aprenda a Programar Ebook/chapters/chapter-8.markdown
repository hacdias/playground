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

Uma forma de declarar \textit{strings} em C, é criar um \textit{array} do tipo \texttt{char} com um número de caracteres pré-definidos. Por exemplo:

\begin{lstlisting}
// o mesmo que: char nome[8] = {'P', 'p', 'l', 'w', 'a', 'r', 'e', '\0'};
char nome[8] = "Pplware";
\end{lstlisting}

No exemplo anterior, é declarada a \textit{string} \texttt{nome} que pode armazenar uma frase com 7 caracteres. Porquê 7 se foram declaradas 8 posições no \textit{array}? Isto acontece porque o último carácter, o oitavo carácter, é o delimitador do final da frase \texttt{\textbackslash 0}.

Existem, no total, três formas de declarar \textit{strings} em C: 

\begin{itemize}
\item A primeira consiste na criação de um \textit{array} com o tamanho pré-determinado;
\item A segunda consiste na criação de um \textit{array} sem especificar o seu comprimento, tendo que ser inicializada no momento da declaração de forma a que o espaço na memória seja alocado dependendo do tamanho da \textit{string} colocada;
\item Ou através de um apontador.
\end{itemize}

\begin{lstlisting}
char nome[8] = "Pplware";
char nome[] = "Pplware"; // recomenda-se devido à legibilidade
char* nome = "Pplware"; 
\end{lstlisting}

Se reparar, este \quotes{tipo} de dados sempre foi utilizado. Na função \textit{printf}, por exemplo, o primeiro argumento foi sempre uma \textit{string}, pois é uma sequência de caracteres delimitada por aspas.

\section{Como imprimir \textit{strings}}

As \textit{strings} podem ser imprimidas recorrendo a diversas funções. Aqui são abordadas duas formas: recorrendo à função \texttt{printf} e recorrendo à função \texttt{puts}.

\subsection{Com a função \texttt{printf}}

Para imprimir uma \textit{string} utilizando a função \texttt{printf}, basta utilizar o especificador \texttt{\%s}. Por exemplo:

\begin{lstlisting}
printf("Esta é uma string: \%s", nomeDaString);
\end{lstlisting}

A função \texttt{printf} é útil quando é necessário imprimir uma \textit{string} que pode variar.

\subsection{Com a função \texttt{puts}}

Temos também a função \texttt{puts}, já abordada no capítulo 5, cujo nome quer dizer \textit{put string}, ou seja, colocar \textit{string}. Esta função é excelente para imprimir uma \textit{string} que não esteja intercalada noutra \textit{string}. Ora veja o seguinte exemplo:

\begin{lstlisting}
char* nome = "José";
puts(nome);
\end{lstlisting}

\section{Como ler \textit{strings}}

Quando é necessário um dado do utilizador como o nome, por exemplo, saber como se leem \textit{strings} é importante. A leitura de \textit{strings} pode ser feita de diversas formas.

\subsection{Com a função \texttt{scanf}}

A função \texttt{scanf} já foi falada diversas vezes ao longo deste livro. Tal como o que acontece com a função \texttt{printf}, deve-se utilizar o especificador \texttt{\%s} para ler \textit{strings}. Ora veja como se lê uma \textit{string}:

\begin{lstlisting}
scanf("%s", variavelParaArmazenarAString);
\end{lstlisting}

Analisando o excerto anterior é possível verificar que, ao contrário do que acontece com os restantes tipos de dados, neste não colocamos o \quotes{e} comercial no início do nome da variável que é utilizada para armazenar a \textit{string}. Isto acontece porque as variáveis que contêm \textit{strings} são, ou \textit{arrays} ou apontadores, logo o seu nome já aponta para o endereço da memória.

Imagine agora que precisa do nome, apelido, morada e código postal de um utilizador para criar o seu cartão de identificação. Poderia proceder da seguinte forma:

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
\end{lstlisting}

Relembro que a utilização de comandos para limpar o \textit{buffer} não é recomendável e que devem ser utilizadas outras funções que não a \texttt{scanf} de forma a obter dados do utilizador sem \quotes{lixo}.

\subsection{Com a função \texttt{gets}}

Podem-se imprimir \textit{strings} com a função \texttt{gets}, cujo nome quer dizer \textit{get string}, ou seja, obter \textit{string}. A utilização desta função é simples. Ora veja como se utiliza esta função:

\begin{lstlisting}
gets(nomeDaVariavel);
\end{lstlisting}

Onde \texttt{nomeDaVariavel} corresponde ao apontador que aponta para o local onde a \textit{string} vai ser armazenada. Recordo que, no caso se ser utilizado um apontador ou um \textit{array}, não é necessário utilizar um \quotes{e} comercial no início.

Imaginando agora que precisa criar um boletim de informação com diversos dados sobre o utilizador. Poderia fazer da seguinte forma:

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
\end{lstlisting}

Analisando o código é possível verificar que com esta função não é preciso limpar o \textit{buffer} de forma a não obter caracteres indevidos. Isto acontece porque a função \texttt{gets} os ignora.

\subsection{Com a função \texttt{fgets}}

Tanto a função \texttt{gets} como a função \texttt{scanf} têm alguns contratempos; a primeira tem alguns problemas quando as \textit{strings} incluem caracteres como espaços e a segunda obtém caracteres desnecessários. Devido à falta de uma solução efetiva a estes problemas, a função \texttt{fgets} poderá ser a melhor opção.

A função \texttt{fgets} permite obter dados, não só do teclado, como de outros locais. Ora veja a sua sintaxe:

\begin{lstlisting}
fgets(char *str, int n, FILE *stream);
\end{lstlisting}

Onde:

\begin{itemize}
\item \texttt{str} corresponde ao apontador para um \textit{array} de caracteres onde os dados obtidos serão armazenados;
\item \texttt{n} é o número máximo de caracteres a serem lidos (incluindo o delimitador final). Geralmente é igual ao tamanho do \textit{arrar};
\item \texttt{stream} corresponde ao apontador para o ficheiro ou objeto donde serão lidos os dados.
\end{itemize}

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
