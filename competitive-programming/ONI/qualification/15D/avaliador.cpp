// [ONI'2015] Qualificacao: Problema D - Teste de Forca
// Ficheiro com um avaliador exemplo para poder testar na sua maquina
// (note que o avaliador oficial sera diferente!)

#include <cstdio>

#include "martelada.h"

int N;
int K;
int forcaNecessaria;

int sinosPartidos = 0;
int tentativas = 0;

int martelada(int f) {
  if (sinosPartidos >= K) {
    puts("ERRO: todos os sinos foram partidos.");
    exit(-1);
  }
  tentativas++;
  if (f < forcaNecessaria)
    return 0;
  else {
    if (f > N) {
      puts("ERRO: Forca excessiva.");
      exit(-1);
    }
    else {
      sinosPartidos++;
      return 1;
    }
  }
}

int main() {
  int t, casos, resposta;
  scanf("%d %d %d", &N, &K, &casos);
  for (t = 0; t < casos; t++) {
    tentativas = 0; sinosPartidos = 0;
    scanf("%d", &forcaNecessaria);
    resposta = resolver(N, K);
    if (resposta == forcaNecessaria)
      printf("Resposta correcta (%d apos %d tentativas).\n", resposta, tentativas);
    else
      printf("Resposta errada (respondido=%d, resposta=%d).\n", resposta, forcaNecessaria);
  }
  return 0;
}
