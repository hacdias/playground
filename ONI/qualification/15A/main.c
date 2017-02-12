#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main() {
  struct Aluno {
    char nome[20];
    int nota;
  };

  int n, p, i, j;

  scanf("%d %d", &n, &p);

  struct Aluno aluno;
  struct Aluno *alunos = malloc(sizeof(struct Aluno) * n);

  for (i = 0; i < n; i++) {
    scanf("%s", alunos[i].nome);
    alunos[i].nota = 0;

    for (j = 0; j < p; j++) {
      int nota;
      scanf("%d", &nota);
      alunos[i].nota += nota;
    }
  }

  for (i = 0; i < n; i++) {
    for (j = i + 1; j < n; j++) {
        if (alunos[i].nota < alunos[j].nota) {
            aluno = alunos[i];
            alunos[i] = alunos[j];
            alunos[j] = aluno;
        } else if (alunos[i].nota == alunos[j].nota && strcmp(alunos[i].nome, alunos[j].nome) > 0) {
            aluno = alunos[i];
            alunos[i] = alunos[j];
            alunos[j] = aluno;
        }
    }
  }

  for (i = 0; i < n; i++) {
    printf("%s %d\n", alunos[i].nome, alunos[i].nota);
  }

  return 0;
}
