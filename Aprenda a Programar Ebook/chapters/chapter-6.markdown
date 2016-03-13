Até este ponto do livro, apenas têm sido abordadas variáveis que contêm um e apenas um valor. Chegou a altura de falar de uma estrutura de dados muito importante no mundo da programação, os *arrays*.

{{% concept %}}
*Arrays* (também conhecidos por "tabelas" ou "vetores") são estruturas de dados que permitem armazenar múltiplos valores em posições bem definidas.
\end{defi}

Os *arrays* são como matrizes/tabelas de dados onde cada dado se encontra localizado numa determinada posição que pode ser acedida através de "coordenadas", através de um índice (por exemplo, índice 4 para a quarta posição). Existem os *arrays* unidimensionais e multidimensionais.

## Arrays unidimensionais

Os *arrays* unidimensionais podem ser comparados a tabelas com uma única coluna, mas com diversas linhas. São o tipo mais simples de *array*. Eis a declaração geral de um *array*:

```c
tipo nomeVariavel[numeroDeElementos];
```

Onde:

+ `tipo` corresponde ao tipo de dados que o *array* vai armazenar;
+ `nomeVariavel` corresponde ao nome do *array*;
+ `numeroDeElementos` corresponde ao número máximo de elementos que o *array* irá conter.

Os *arrays* são *zero-index*, ou seja, a primeira posição é 0 e não 1. Para aceder à última posição de um *array* com 6 linhas, deve-se pedir o que está contido na posição 5. Ora veja um exemplo:

```c
int idades[10]; // array de 10 elementos
 
idades[0] = 14; // atribuição correta
idades[4] = 12; // atribuição correta
idades[7] = 15; // atribuição correta
idades[10] = 20; // atribuição incorreta (tamanho máximo do array ultrapassado)
```

No exemplo anterior, a última declaração está errada porque o índice máximo do \textit{array} foi ultrapassado, ou seja, tentou-se aceder a uma posição inexistente. O \textit{array} tem 10 elementos, 10 posições. O primeiro é no índice 0 e o último no índice 9.

À semelhança do que acontece com as variáveis, pode-se atribuir o valor dos \textit{arrays} no momento da declaração. Por exemplo:

\begin{lstlisting}
int idades[10] = {0, 1, 2, 3, 4, 5, 6, 7, 8, 9}
\end{lstlisting}

\section{Arrays multidimensionais}

Um \textit{array} multidimensional é um \textit{array} que tem mais do que uma dimensão, ou seja, se comparamos a uma tabela tem mais do que uma coluna. 

\begin{lstlisting}
tipo nome[linhas][colunas];
\end{lstlisting}

Relativamente à contagem das posições, começa-se sempre no 0, tal como acontece com os \textit{arrays} unidimensionais. Analise então o seguinte código:

\begin{lstlisting}
float notas[6][5]; // declaração de um array com 6 linhas e 5 colunas

notas[0][0] = 18.7; // linha 1, coluna 1
notas[0][1] = 15.4; // linha 1, coluna 2
notas[3][2] = 19.6; // linha 4, coluna 3
notas[5][4] = 17.5; // linha 6, coluna 5
notas[4][3] = 57.5; // linha 5, coluna 4
notas[6][0] = 20.0; // excedeu o máximo de linhas (6)
notas[5][5] = 17.4; // excedeu o máximo de colunas (5)
\end{lstlisting}

No exemplo anterior é possível visualizar a criação de um \textit{array} com 6 linhas e 5 colunas. Este \textit{array}, com os dados inseridos, poderia ser traduzido na seguinte tabela:

\begin{table}[h]
\begin{center}
\begin{tabular}{|l|l|l|l|l|}
\hline
18.7 & 15.4 &      &      &      \\ \hline
     &      &      &      &      \\ \hline
     &      &      &      &      \\ \hline
     &      & 19.6 &      &      \\ \hline
     &      &      & 57.5 &      \\ \hline
     &      &      &      & 17.5 \\ \hline
\end{tabular}
\end{center}
\caption{Representação de um \textit{array} 6 por 5}
\end{table}

Tal como nos \textit{arrays} unidimensionais, podemos adicionar os valores ao \textit{array} multidimensional no momento da sua declaração. Veja então o seguinte exemplo:

\begin{lstlisting}
int idades[2][4] = {
    {1, 2, 3, 4},
    {0, 1, 2, 3}};
\end{lstlisting}
