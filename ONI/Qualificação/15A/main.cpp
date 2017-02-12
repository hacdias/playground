using namespace std;
#include <iostream>
#include <algorithm>

struct Aluno {
  std::string nome;
  int nota;
};

bool aluno_sorter(Aluno const& lhs, Aluno const& rhs) {
  if (lhs.nota == rhs.nota)
    return lhs.nome < rhs.nome;
  return lhs.nota > rhs.nota;
}

int main() {
  int n, p, i, j;

  cin >> n;
  cin >> p;

  struct Aluno aluno;
  struct Aluno *alunos = new struct Aluno[sizeof(struct Aluno) * n];

  for (i = 0; i < n; i++) {
    cin >> alunos[i].nome;
    alunos[i].nota = 0;

    for (j = 0; j < p; j++) {
      int nota;
      cin >> nota;
      alunos[i].nota += nota;
    }
  }

  std::sort(alunos, alunos+n, &aluno_sorter);

  for (i = 0; i < n; i++) {
    cout << alunos[i].nome << " " << alunos[i].nota << endl;
  }

  return 0;
}
