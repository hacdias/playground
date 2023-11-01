#include <bits/stdc++.h>
using namespace std;

int N, M, K;

int main() {
    scanf("%d %d", &N, &M);

    int periods[M][2];
    for (int i = 0; i < M; i++) scanf("%d %d", &periods[i][0], &periods[i][1]);

    // BRUTE FORCE!!!!! Let's go.

    // 0  - compatible
    // 1  - inco
    // -1 - Unvisited // DOESNT MATTER
    /*int compatible[M][M];
    memset(compatible, -1, sizeof(int) * M * M);

    for (int i = 0; i < M; i++) {
        for (int j = 0; j < M; j++) {
            if (i == j) continue;
            if (compatible[i][j] > 0) continue;
            compatible[i][j] = 0;


            if (periods[i][0] >= periods[j][0] && periods[i][0] <= periods[j][1]) compatible[i][j] = 1;
            if (periods[i][1] <= periods[j][1] && periods[i][1] >= periods[j][0]) compatible[i][j] = 1;

            compatible[j][i] = compatible[i][j];
        }
    } */

    vector<vector<int> > cycles;
    cycles.push_back(vector<int>());
    cycles[0].push_back(0);

    for (int i = 1; i < M; i++) {
        bool inserted = false;

        for (int j = 0; j < (int)cycles.size(); j++) {
            bool works = true;

            for (int k = 0; k < (int)cycles[j].size(); k++) {
                if (periods[i][0] >= periods[j][0] && periods[i][0] <= periods[j][1]) works = false;
                if (periods[i][1] <= periods[j][1] && periods[i][1] >= periods[j][0]) works = false;

            //    if (compatible[i][cycles[j][k]] == 1)  works = false;
            }

            if (works) {
                cycles[j].push_back(i);
                inserted = true;
            }
        }

        if (!inserted) {
            cycles.push_back(vector<int>());
            cycles[(int)cycles.size() - 1].push_back(i);
        }
    }

/*   for (int j = 0; j < (int)cycles.size(); j++) {
        printf("CYCLE %d: ", j);
        for (int i = 0; i < (int)cycles[j].size(); i++) {
            printf("%d ", cycles[j][i]);
        }

        printf("\n");
    } */

    /*for (int i = 0; i < M; i++) {
       for (int j = 0; j < M; j++) {
           printf("%d ", compatible[i][j]);
         //  if (compatible[i][j] != 1 && compatible[i][j] != -1) c++;
       }
       printf("\n");
   } */



    printf("%d\n", (int)cycles.size());
    return 0;
}
