#include <iostream>
#include <vector>
#include <utility>
#include <map>
#include <cmath>
#include <algorithm>
using namespace std;

typedef pair<int, vector<int> > Data;

int K;

map<int, vector<int> > digitosBank;
map<int, int> numDigitosBank;

Data digitos(int num) {
    int i = num;

    if (numDigitosBank.count(num) > 0) {
        return make_pair(numDigitosBank[num], digitosBank[num]);
    }

    vector<int> itens;
    int n = 0;

    while (num > 0) {
        itens.push_back(num%10);
        num /= 10;
        n++;
    }

    reverse(itens.begin(), itens.end());

    numDigitosBank[i] = n;
    digitosBank[i] = itens;

    return make_pair(n, itens);
}

bool kCapicua(int n) {
    Data info = digitos(n);

    if (info.first <= K+1) return true;

    int a = 0, b = 0, dif = 0;

    if (info.first%2 == 0) {
        a = info.first/2-1;
        b = a+1;
    } else {
        a = ceil((float)info.first/2)-1;
        b = a;
        a--;
        b++;
    }

    while (a >= 0) {
        if (info.second[a] != info.second[b]) dif++;
        a--;
        b++;
    }

    if (info.first%2 != 0 && dif == 0 && K != 0) dif++;

    if (dif <= K) {
        return true;
    }

    return false;
}

int main() {
    int P, maximo = 0, maxDigitos = 0, i, n, j, a, b;
    cin >> K >> P;
    int N[P];

    for (i = 0; i < P; i++) {
        cin >> N[i];
        if (N[i] > maximo) maximo = N[i];
    }

    // kpicuas[n] = Número de K-capicuas com n digitos
    vector<int> kpicuas;
    kpicuas.push_back(0);

    for (i = 1; ; i++) {
        // i => número de digitos
        // a => nº de digitos em cada metade
        // b => nº de possibilidades com o numero de digitos i para j-capicua
        a = ceil((float)i/2);
        b = 0;
        //b = pow(10, a)-pow(10, a-1);

        int base = i/a

        for (j = a; j > 0; j--) {
            b += pow(10, j)-pow(10, j-1);
        }

        kpicuas.push_back(b);

        if (kpicuas[i] >= maximo) {
            maxDigitos = i;
            break;
        }
    }

    cout << kpicuas[2] << endl;


    /* for (i = 0; i < P; i++) {
        for (j = 1; j < maxDigitos; j++) {
            if (N[i] < kpicuas[j]) {
                n = kpicuas[j-1];
                j = pow(10, j-1);
                break;
            }
        }

        for (; n != N[i]; j++) {
            if (kCapicua(j)) {
                n++;
            }
            if (n == N[i]) cout << j << endl;
        }
    } */

    return 0;
}
