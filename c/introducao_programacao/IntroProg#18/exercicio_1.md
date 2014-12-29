```c
int trocaDeValores( int *i, int *j) {
    int *temp;

    *temp = *i;
    *i = *j;
    *j = *temp;

    return 0;
}
```
O trecho de código acima está errado pois a variável temporária ```temp``` não pode ser um ponteiro. Se utilizarmos a função anterior, iremos atribuir ao ponteiro ```temp``` o conteúdo que está localizado no endereço que para o qual a variável ```i``` está a apontar.
