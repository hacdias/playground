// [ONI'2015] Qualificacao: Problema D - Teste de Forca
// Ficheiro de implementacao: deve colocar codigo na funcao "resolver"

#include "martelada.h"

int resolver(int N, int K) {
  int part = N/K;

  if (K == 1) {
    for (int i = 1; i < N; i++) {
      if (martelada(i)) return i;
    }
  }

  if (K == 2) {
    if (martelada(part)) {
      for (int i = 1; i <= part; i++) {
        if (martelada(i)) return i;
      }
    } else {
      for (int i = part; i <= N; i++) {
        if (martelada(i)) return i;
      }
    }
  }

  if (K == 3) {
    int first, second, limi, limf;
    first = martelada(part);
    second = martelada(part * 2);

    if (second) {
      limi = part;
      limf = part * 2;
    }

    if (first) {
      limi = 1;
      limf = part;
    }

    if (!first && !second) {
      limi = part * 2;
      limf = N;
    }

    for (limi; limi <= limf; limi++) {
      if (martelada(limi)) return limi;
    }
  }

  return 0;
}
