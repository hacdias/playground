#include "avaliador.h"
#include "stdio.h"
#include "vector"

void luis(int N) {
  string tentativa(N, '0');
  
  int i = 0, wrong = adivinhar(tentativa);
  
  for (i = 0; i < N; i++) {
    if (wrong == 0) break;
    tentativa[i] = '1';
    
    if (adivinhar(tentativa) > wrong) {
      tentativa[i] = '0';
    } else {
      wrong--;
    }
  }
}

vector<string> halfs;

void makeHalfs(string prefix, int n) {
  if (n == 0) {
    halfs.push_back(prefix);
    return;
  }
  
  makeHalfs(prefix+'0', n-1);
  makeHalfs(prefix+'1', n-1);  
}

void vitor(int N) {      
  makeHalfs("", N);

  int wrong = N;
  unsigned int i = 0;
  
  for(i=0; i < halfs.size() && wrong != 0; i++){
    wrong = adivinhar(halfs[i]);
  }
}

void resolver(int N, char C) {
  if (C == 'L') {
    return luis(N);
  }
  
  vitor(N);
}

