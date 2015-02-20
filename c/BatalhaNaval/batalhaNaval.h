/**
 * @file    Batalha Naval Cabeçalho
 * @author  Henrique Dias (henriquedias.com)
 * @version 1.0
 */

#include <stdio.h>
#include <stdlib.h>

/* biblioteca que inclui diversas funções relacionadas com o tipo char */
#include <ctype.h>
/* adiciona o suporte para tipos bool, ou seja, verdadeiro e falso */
#include <stdbool.h>

#define LINHAS      5
#define COLUNAS     9
#define MAX_NAVIOS  3
#define COMPUTADOR  'c'
#define AMIGO       'a'
#define MAR         -1
#define MAR_TIRO    0
#define NAVIO_OK    1
#define NAVIO_TIRO  2

void imprimeBoasVindas();
char comQuemSeVaiJogar();
void imprimeDivisoria();
void jogaContraAmigo();
void jogaContraComputador();
int** criaNovoTabuleiro();
void imprimeInformacoesTabuleiros();
void imprimeTabuleiro(int** tabuleiro);
bool jogoAcabou(int** tabuleiro);
bool posicaoLivre(int** tabuleiro, int linha, int coluna);
void colocaNaviosComputador(int** tabuleiro);
bool jogadaComputador(int** tabuleiro);
void colocaNaviosJogador(int** tabuleiro);
void processaJogada(int jogador, int** tabuleiro);
bool jogadaJogador(int** tabuleiro);
