#include <iostream>
#include <stdlib.h>
#include "avaliador.h"

bool correct = false;
int n, guesses = 0;
char c;
string p;

void end()
{
  if (correct)
    cout << "Correto! Foram usadas " << guesses << " adivinhas" << endl;
  else
    cout << "Incorreto..." << endl;
  exit(0);
}

int adivinhar(string g)
{
  correct = false;
  guesses++;

  if (int(g.length()) != n)
    end();

  if (guesses > 2050)
    end();

  int nm = 0;
  for (int i = 0; i < n; i++)
    if (g[i] != '0' && g[i] != '1')
      end();
    else if (g[i] != p[i])
      nm++;

  if (nm == 0)
    correct = true;

  if (c == 'V')
  {
    if (nm == 0)
      nm = 0;
    else if (nm == n / 2)
      nm = n / 2;
    else
      nm = n;
  }

  return nm;
} 

int main()
{
  cin >> n >> c;
  cin >> p;

  resolver(n, c);
  end();

  return 0;
}