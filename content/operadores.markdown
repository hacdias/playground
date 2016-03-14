---
weight: 4
title: Operadores
type: page
description: "No mundo da programação os dados devem ser modelados, moldados, alterados. É com os operadores abordados neste capítulo que tudo isso pode ser feito. Os operadores abordados existem na maioria das linguagens de programação."
---

Neste capítulo são abordados os operadores, que são deveras importantes na modificação dos valores de variáveis.

{{% concept %}}
\textbf{Operadores} são símbolos para efetuar determinadas ações sobre variáveis. Na programação existem diversos tipos de operadores como, por exemplo, para efetuar operações aritméticas.
{{% /concept %}}

Alguns dos operadores também existem em outras áreas do conhecimento como matemática, por exemplo.

\section{Operadores aritméticos}

Os operadores aritméticos são, tal como o próprio nome indica, utilizados para efetuar operações aritméticas, ou seja, operações matemáticas como somas, subtrações, multiplicações, entre outras.

\begin{table}[h]
\center\begin{tabular}{|l|l|l|}
\hline
\textbf{Nome}        & \textbf{Símbolo} & \textbf{Exemplo}                                         \\ \hline
Soma                 & \texttt{+}                & 5 + 4 = 9                                                \\ \hline
Subtração            & \texttt{-}                & 154 - 10 = 144                                           \\ \hline
Multiplicação        & \texttt{*}                & 5,55 * 10 = 55,5                                         \\ \hline
Divisão              & \texttt{/}                & 40 / 2 = 20                                              \\ \hline
Resto inteiro de uma divisão & \texttt{\%}               & \begin{tabular}[c]{@{}l@{}}1500 \%\\ 11 = 4\end{tabular} \\ \hline
\end{tabular}
\caption{Operadores aritméticos}
\end{table}

\section{Operadores de atribuição}

Os operadores de atribuição servem para atribuir um determinado valor a uma variável ou constante. Existem vários operadores de atribuição e muitos deles funcionam como abreviatura para operações aritméticas. Estes operadores são \textit{syntactic sugar}\footnote{Consulte \color{links}\href{http://en.wikipedia.org/wiki/Syntactic\_sugar}{en.wikipedia.org/wiki/Syntactic\_sugar}}, ou seja, têm uma sintaxe elegante de forma a serem facilmente entendidos pelos seres humanos.

\begin{table}[h]
\center\begin{tabular}{|l|l|l|l|}
\hline
\textbf{Nome}				&	\textbf{Símbolo}    			& \textbf{Exemplo} 	& \textbf{Valor de \texttt{var}} \\ \hline
Atribuição					&	\texttt{=}                   	& var = 20 			& 20     \\ \hline
Adição e atribuição			&	\texttt{+= (var = var + n)} 	& var += 5 			& 25     \\ \hline
Subtração e atribuição		&	\texttt{-= (var = var - n)}  	& var -= 10			& 15    \\ \hline
Multiplicação e atribuição	&	\texttt{*= (var = var * n)}  	& var *= 4			& 60     \\ \hline
Divisão e atribuição		&	\texttt{/= (var = var / n)}  	& var /= 5 			& 12    \\ \hline
Resto inteiro e atribuição	&	\texttt{\%= (var = var \% n}	& var \%= 5 		& 2     \\ \hline
\end{tabular}
\caption{Operadores de atribuição}
\end{table}

\section{Operadores relacionais}

{{% moreabout title="" %}}
Pode avançar esta e as secções mais à frente por agora. Mais tarde ser-lhe-á indicado para aqui voltar. Consultar capítulo 4.
{{% /moreabout %}}

Estes operadores (relacionais) permitem-nos estabelecer relações de comparação entre diversas variáveis.

\begin{table}[h]
\center\begin{tabular}{|l|l|l|}
\hline
\textbf{Nome}  & \textbf{Símbolo} & \textbf{Exemplo}                                                                                                        \\ \hline
Igualdade      & \texttt{==}               & \begin{tabular}[c]{@{}l@{}}x == y retorna 1 se x for igual a y e \\ 0 se tiverem valores diferentes\end{tabular} \\ \hline
Diferente      & \texttt{!=}              & \begin{tabular}[c]{@{}l@{}}x != y retorna 1 se x for diferente de y \\ ou 0 se x for igual a y\end{tabular}      \\ \hline
Maior          & \texttt{\textgreater}     & x \textgreater 40                                                                                                       \\ \hline
Maior ou Igual & \texttt{\textgreater=}    & y \textgreater= 25                                                                                                      \\ \hline
Menor          & \texttt{\textless}        & y \textless 20                                                                                                          \\ \hline
Menor ou Igual & \texttt{\textless=}       & x \textless= y                                                                                                          \\ \hline
\end{tabular}
\caption{Operadores relacionais}
\end{table}

\section{Operadores lógicos}

Os operadores lógicos são normalmente utilizados em testes lógicos quando é necessário incluir mais do que uma condição para que algo aconteça. Existem três operadores lógicos que aqui são abordados: \texttt{\&\&}, \texttt{\(||\)} e \texttt{!}. Estes operadores também são \textit{syntactic sugar}.

| Nome          | Operador |
|---------------|:--------:|
| Operador "e"  | `&&`     |
| Operador "ou" | `||`     |
| Negação       | `!`      |

\subsection{Operador \texttt{\&\&}}

Na programação, o operador \texttt{\&\&} tem como função a conjugação de condições, ou seja, funciona da mesma forma que um \quotes{e} na Língua Portuguesa. Com este elemento, para que algo seja considerado verdadeiro, todos os elementos têm que o ser. Veja alguns exemplos em que este operador é utilizado para agregar condições:

```
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

A condição acima pode ser transcrita para uma linguagem lógica da seguinte forma: \quotes{\textbf{Se} \texttt{a} for maior que 0 \textbf{e} menor ou igual a 10, então o código é executado}.

Este operador pode ser utilizado mais do que uma vez no interior de um teste condições pois podemos intersetar duas ou mais condições, bastando apenas adicionar \texttt{\&\&} e a outra condição a ser adicionada.

\subsection{Operador \texttt{\(||\)}}

À semelhança do operador anterior, o operador \texttt{\(||\)} também tem uma função que pode ser comparada a uma pequena palavra do Português: à palavra \quotes{ou}. Com este elemento, para que algo seja considerado verdadeiro, basta que um elemento o seja.  

Com este operador, podemos executar um trecho de código que \textbf{satisfaz} uma das \textbf{várias condições} existentes. Por exemplo:

```
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

Numa linguagem puramente lógica, podemos converter a condição anterior para o seguinte: \quotes{Se \texttt{a} for 3 \textbf{ou} 5, então a linha 8 é executada}.

\subsection{Operador \textit{!}}

O operador \texttt{!} é utilizado para indicar a negação, ou numa linguagem corrente, \quotes{o contrário de}. Quando é utilizado juntamente com uma condição, quer dizer que o código que está condicionado depende se a negação da condição é satisfeita, tal como o antónimo de uma palavra. Ora veja o seguinte exemplo:

```
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

Relembrando que o número 0 é considerado o binário para falso e que, qualquer número diferente de 0 é, na linguagem C, considerado como verdadeiro, a condição acima pode ser traduzida para: \quotes{Se \texttt{a} \textbf{não} for diferente de 0, então executa o código}.

\subsection{Operadores de decremento e incremento}

Os operadores de incremento e decremento são dois operadores essenciais na vida de qualquer programador. Imagine que necessita de contar um número cujo qual nem o programador sabe o fim. Vai adicionar/subtrair valor a valor? Não, não é necessário.

```
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

O código acima imprime a frase \quotes{O número é x}, onde \textit{x} corresponde ao valor da variável \texttt{num} nesse momento. Este algoritmo faz com que a variável inicialmente tenha um valor de 1, passando por 2, chegando finalmente a 3. As linhas \texttt{num = num + 1} e \texttt{num += 1} são equivalentes.

Existe outra forma mais simples para adicionar/subtrair um valor a uma variável: através dos operadores \texttt{++} e \texttt{--}. Veja como ficaria o código anterior com estes operadores:

```
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

Para remover uma unidade bastaria colocar \texttt{--} ao invés de \texttt{++}. Então podemos concluir que este operador torna o incremento/decremento mais rápido, mas só funciona quando o assunto é uma unidade. Veja o seguinte exemplo:

```
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

{{% moreabout title="" %}}
\subsubsection{Posição do operador}

Estes operadores podem ocupar duas posições: antes ou depois do nome da variável, ou seja, posso colocar tanto \texttt{num++} como \texttt{++num}. Quando são utilizados isoladamente, não existe nenhuma diferença. Porém, quando estamos a efetuar uma atribuição, existem diferenças. Analise o seguinte exemplo:

```
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

Em primeiro lugar, são declaradas três variáveis: \texttt{a}, \texttt{b} e \texttt{c}. Seguidamente, é atribuído o valor 0 à primeira variável. Quando o valor \texttt{a++} é atribuído à variável \texttt{b}, esta fica com valor 0 ou 1? E o que acontece com a variável \texttt{a}? A variável \texttt{b} irá assumir o valor 0, e um valor é incrementado a \texttt{a} ficando esta com o valor 1, ou seja, \texttt{b = a++} é um atalho para o seguinte:

```
b = a;  
a++;  
```

Depois desta atribuição, é atribuída à variável \texttt{c}, o valor \texttt{++a}, ou seja, primeiro é incrementado o valor da variável \texttt{a} e só depois é que o valor de esta é atribuído à variável \texttt{c}. Então, isto é um atalho para o seguinte:

```
++a;  
c = a;
```
{{% /moreabout %}}
