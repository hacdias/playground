#include <iostream>
#include <map>
#include <vector>
#include <utility>

using namespace std;

int main()
{
    int N, K, P, i, a, b, c, d;
    cin >> N >> K >> P;

    // intervalos[hora1][hora2]
    map<int, map<int, vector<int> > > intervalos;
    int demonstracoes[P][2];

    vector<int> obras;
    int linha[N];

    for (i = 0; i < K; i++)
    {
        cin >> a >> b >> c >> d;
        intervalos[a][b].push_back(c);
        intervalos[a][b].push_back(d);
    }

    for (i = 0; i < P; i++)
    {
        cin >> demonstracoes[i][0] >> demonstracoes[i][1];
    }

    for (i = 0; i < P; i++)
    {
        for (d = 0; d < N; d++) linha[d] = 0;

        for (a = demonstracoes[i][0]; a <= demonstracoes[i][1]; a++)
        {
            for (b = demonstracoes[i][0]; b <= demonstracoes[i][1]; b++)
            {

                obras = intervalos[a][b];

                for (vector<int>::size_type k = 0; k != obras.size(); k += 2)
                {
                    c = obras[k];
                    d = obras[k+1];

                    for (; c <= d; c++) linha[c] = 1;
                }
            }
        }


        for (c = 0; c < N; c++) cout << linha[c];
        cout << endl;
    }

    return 0;
}
