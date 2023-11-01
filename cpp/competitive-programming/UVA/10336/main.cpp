#include <bits/stdc++.h>
using namespace std;

map<char, int> nations;
vector<vector<char> > world;
vector<vector<bool> > pool;

int n, h, w, c;
const int BLOCK = 10000;

void visit(int x, int y) {
    pool[x][y] = true;
    if (x > 0 && world[x-1][y] == world[x][y] && !pool[x-1][y]) visit(x-1, y);
    if (y > 0 && world[x][y-1] == world[x][y] && !pool[x][y-1]) visit(x, y-1);
    if (x < h - 1 && world[x+1][y] == world[x][y] && !pool[x+1][y]) visit(x+1, y);
    if (y < w - 1 && world[x][y+1] == world[x][y] && !pool[x][y+1]) visit(x, y+1);
}

bool sortNations(pair<char, int> first, pair<char, int> second) {
    if (second.second > first.second) return false;
    if (first.second == second.second) return false;
    return true;
}

int main() {
    scanf("%d", &n);
    while (n--) {
        nations.clear();
        world.clear();
        pool.clear();

        scanf("%d %d\n", &h, &w);

        pool.resize(h);
        fill(pool.begin(), pool.end(), vector<bool>(w));

        world.resize(h);
        fill(world.begin(), world.end(), vector<char>(w));

        for (int i = 0; i < h; i++) {
            for (int j = 0; j < w; j++) {
                scanf("%c", &world[i][j]);
            }
            scanf("\n");
        }

        for (int i = 0; i < h; i++) {
            for (int j = 0; j < w; j++) {
                if (!pool[i][j]) {
                    if (nations.find(world[i][j]) != nations.end()) {
                        nations[world[i][j]]++;
                    } else {
                        nations[world[i][j]] = 1;
                    }

                    visit(i, j);
                }
            }
            scanf("\n");
        }

        printf("World #%d\n", ++c);

        vector<pair<char, int> > nat(nations.begin(), nations.end());
        sort(nat.begin(), nat.end(), &sortNations);

        for (vector<pair<char, int> >::iterator it = nat.begin(); it != nat.end(); ++it) {
            printf("%c: %d\n", it->first, it->second);
        }
    }

    return 0;
}
