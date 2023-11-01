---
weight: 6
title: Arrays
type: page
description: "Neste capítulo é abordada uma estrutura de dados extremamente importante, os arrays, que estão presentes em quase todas as linguagens de programação."
---

Até este ponto do livro, apenas têm sido abordadas variáveis que contêm um e apenas um valor. Chegou a altura de falar de uma estrutura de dados muito importante no mundo da programação, os *arrays*.

{{% concept %}}
*Arrays* (também conhecidos por "tabelas" ou "vetores") são estruturas de dados que permitem armazenar múltiplos valores em posições bem definidas.
{{% /concept %}}

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
idades[4] = 12; // attr. correta
idades[7] = 15; // attr. correta
idades[10] = 20; // attr. incorreta (tamanho máx. excedido)
```

No exemplo anterior, a última declaração está errada porque o índice máximo do *array* foi ultrapassado, ou seja, tentou-se aceder a uma posição inexistente. O *array* tem 10 elementos, 10 posições. O primeiro é no índice 0 e o último no índice 9.

À semelhança do que acontece com as variáveis, pode-se atribuir o valor dos *arrays* no momento da declaração. Por exemplo:

```
int idades[10] = {0, 1, 2, 3, 4, 5, 6, 7, 8, 9}
```

## Arrays multidimensionais

Um *array* multidimensional é um *array* que tem mais do que uma dimensão, ou seja, se comparamos a uma tabela tem mais do que uma coluna.

```c
tipo nome[linhas][colunas];
```

Relativamente à contagem das posições, começa-se sempre no 0, tal como acontece com os *arrays* unidimensionais. Analise então o seguinte código:

```c
float notas[6][5]; // array com 6 linhas e 5 colunas

notas[0][0] = 18.7; // linha 1, coluna 1
notas[0][1] = 15.4; // linha 1, coluna 2
notas[3][2] = 19.6; // linha 4, coluna 3
notas[5][4] = 17.5; // linha 6, coluna 5
notas[4][3] = 57.5; // linha 5, coluna 4
notas[6][0] = 20.0; // excedeu o máximo de linhas (6)
notas[5][5] = 17.4; // excedeu o máximo de colunas (5)
```

No exemplo anterior é possível visualizar a criação de um *array* com 6 linhas e 5 colunas. Este *array*, com os dados inseridos, poderia ser traduzido na seguinte tabela:

| COL 1 | COL 2 | COL 3 | COL 4 | COL 5 |
|------|------|------|------|------|
| 18.7 | 15.4 |      |      |      |
|      |      |      |      |      |
|      |      |      |      |      |
|      |      | 19.6 |      |      |
|      |      |      | 57.5 |      |
|      |      |      |      | 17.5 |

Tal como nos *arrays* unidimensionais, podemos adicionar os valores ao *array* multidimensional no momento da sua declaração. Veja então o seguinte exemplo:

```c
int idades[2][4] = {
    {1, 2, 3, 4},
    {0, 1, 2, 3}};
```
