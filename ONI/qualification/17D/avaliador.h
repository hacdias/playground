#ifndef __AVALIADOR_H__
#define __AVALIADOR_H__

#define MAXN 1005

#ifdef __cplusplus
#include <string>

using namespace std;

int adivinhar(string g);

#else

int adivinhar(char g[MAXN]);

#endif

void resolver(int N, char C);

#endif