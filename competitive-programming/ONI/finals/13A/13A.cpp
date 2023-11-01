#include <iostream>
#include <vector>
#include <map>
#include <cmath>
#include <sstream>
#include <algorithm>
#include <string>
using namespace std;

#define N 100000

typedef unsigned int uint;

map<int, int> numDigitosBank;

int numDigitos(int num)
{
    if (numDigitosBank.count(num) > 0) return numDigitosBank[num];
    int i = 0;

    while(num)
    {
        num /= 10;
        i++;
    }

    numDigitosBank[num] = i;
    return i;
}

map<int, vector<int> > digitosBank;

vector<int> digitos(int num)
{
    if (digitosBank.count(num) > 0) return digitosBank[num];
    vector<int> d;
    while(num)
    {
        d.push_back(num%10);
        num /= 10;
    }

    reverse(d.begin(), d.end());
    digitosBank[num] = d;
    return d;
}

bool primo(uint num)
{
    uint root = floor(sqrt(num)), i;
    for (i = 2; i <= root; i++)
    {
        if (num%i == 0) return false;
    }

    return true;
}



int main()
{
    int P, C, i, j, maiorPos = 0;
    cin >> P >> C;

    int posicoes[C];

    for (i = 0; i < C; i++)
    {
        cin >> posicoes[i];
        if (posicoes[i] > maiorPos) maiorPos = posicoes[i];
    }

    int numPrimos = ceil(sqrt(maiorPos*2) / numDigitos(P));

    // CRIVO

    /* vector<int> primos;

    int crivo[N];
    for (i = 0; i < N; i++) crivo[i] = true;
    crivo[0] = false, crivo[1] = false;

    for (i = 2; i < N; i++) {
        if (crivo[i]) {
            if (i >= P) primos.push_back(i);
            for (j = i*2; j < N; j += i) crivo[j] = false;
        }
    } */

    // ANOTHER WAY

    int primos[numPrimos];
    for (i = 0; i < numPrimos; i++) primos[i] = 0;
    primos[0] = P, j = 0;

    for (i = P+1; primos[numPrimos-1] == 0; i++)
    {
        if (primo(i)) primos[++j] = i;
    }

    vector<int> lis;
    vector<int> seq;
    lis.push_back(0);
    seq.push_back(0);

    for (i = 1; i <= numPrimos; i++)
    {
        lis.push_back(lis[i-1] + numDigitos(primos[i-1]));
    }

    for (vector<int>::size_type k = 1; k != lis.size(); k++)
    {
        seq.push_back(seq[k-1] + lis[k]);
    }

    for (i = 0; i < C; i++)
    {
        int Qi = posicoes[i];
        cout << "POS " << Qi << endl;
        int a = 0;
        int b = 0;

        for (vector<int>::size_type k = 0; k != seq.size()-1; k++)
        {
            if (Qi <= seq[k])
            {
                a = k;
                break;
            }
        }

        for (vector<int>::size_type k = 0; k != lis.size()-1; k++)
        {
            if (Qi < lis[k])
            {
                b = k-1;
                break;
            }
        }

        cout << a << endl;
        cout << b << endl;
    }

    //seq[j] = seq[j - 1] + list[j]


    /*

    for (i = 1; i > 0; i++)
    {
       lis.push_back(lis[i-1]);
       for (j = 0; j < i; j++)
       {
           lis[i] += numDigitos(primos[j]);
           if (lis[i] >= maiorPos) i = -1;

           // seq[j] = seq[j - 1] + list[j]





           k += numDigitos(primos[j]);
           vector<int> dds = digitos(primos[j]);
           for (vector<int>::size_type m = 0; m < dds.size(); m++)
           {
               sequencia[n] = dds[m];
               n++;
           }
       }
    } */



    /*
        int sequencia[maiorPos];
        int k = 0, n = 0;

        for (i = 0; k < maiorPos; i++)
        {
            for (j = 0; j < i; j++)
            {
                k += numDigitos(primos[j]);
                vector<int> dds = digitos(primos[j]);
                for (vector<int>::size_type m = 0; m < dds.size(); m++)
                {
                    sequencia[n] = dds[m];
                    n++;
                }
            }
        }

        for (i = 0; i < C; i++) cout << sequencia[posicoes[i]-1] << endl; */
    return 0;
}
