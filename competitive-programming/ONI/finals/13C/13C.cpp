#include <iostream>
#include <map>
#include <string>
using namespace std;

typedef unsigned int uint;

char alfabeto[26] = {'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 's', 'r', 't', 'u', 'v', 'w', 'x', 'y', 'z'};

map<pair<char, char>, uint> distancias;
int distancia(char a, char b)
{
    char temp;

    if (a > b)
    {
        temp = b;
        b = a;
        a = temp;
    }

    if (distancias.count(make_pair(a, b)) > 0) return distancias[make_pair(a, b)];

    for (int i = 0; i < 26; i++)
    {
        if (alfabeto[i] == a) for (int j = i; j < 26; j++)
            {
                if (alfabeto[j] == b)
                {
                    distancias[make_pair(a, b)] = j-i;
                    return j-i;
                }
            }
    }


    return 0;
}

int main()
{
    string inicial, final;
    cin >> inicial >> final;


    return 0;
}
