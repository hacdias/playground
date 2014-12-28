#include <stdio.h>
#include <stdlib.h>
#include <math.h>

/*
* Exercício do artigo "Vamos Programar? - Introdução à programação #13".
* Autor: Henrique Dias
*/

/*
* Função que recebe um número inteiro e o retorna.
*/
int receberInt() {
    int a;
    scanf(" %d", &a);

    return a;
}

/*
* Função que recebe um número do tipo "float" e o
* retorna.
*/
float receberNumero() {
    float a;
    scanf(" %f", &a);

    return a;
}

/*
* Imprimir o separador utilizado nos menus e afins.
*/
int imprimirSeparador() {
    printf("***************************************************************\n");
    return 0;
}

/*
* Mostrar o menu principal que continuará a ser mostrado
* até o utilizador decidir sair com "0".
*/
int mostrarMenu() {
    int opcao;
    float a, b, c;

    do {
        imprimirSeparador();

        printf("Deseja calcular:\n");
        printf("1 - Perímetros\n");
        printf("2 - Áreas\n");
        printf("3 - Volumes\n");
        printf("4 - Fórmula Resolvente\n");
        printf("0 - Sair\n");
        printf("Insira uma opção: ");

        opcao = receberInt();

        switch (opcao) {
            case 1:
            mostrarPerimetros();
            break;

            case 2:
            mostrarAreas();
            break;

            case 3:
            mostrarVolumes();
            break;

            case 4:
            equacaoSegundoGrau();
            break;
        }

    } while (opcao != 0);

    return 0;
}

/*
* Mostra o menu dos perímetros tendo uma opção de retornar
* ao menu anterior.
*/
int mostrarPerimetros() {
    int opcao;

    do {
        imprimirSeparador();

        printf("Deseja calcular o perímetro de:\n");
        printf("1 - Quadrado\n");
        printf("2 - Retângulo\n");
        printf("3 - Triângulo\n");
        printf("4 - Círculo\n");
        printf("0 - Voltar ao menu anterior\n");
        printf("Insira uma opção: ");

        opcao = receberInt();

        switch (opcao) {
            case 1:
            perimetroQuadrado();
            break;

            case 2:
            perimetroRetangulo();
            break;

            case 3:
            perimetroTriangulo();
            break;

            case 4:
            perimetroCirculo();
            break;
        }

    } while (opcao != 0);

    return 0;
}

/*
* Mostra o menu das áreas tendo uma opção de retornar
* ao menu anterior.
*/
int mostrarAreas() {
    int opcao;

    do {
        imprimirSeparador();

        printf("Deseja calcular a área de:\n");
        printf("1 - Quadrado\n");
        printf("2 - Retângulo\n");
        printf("3 - Triângulo\n");
        printf("4 - Losango\n");
        printf("5 - Círculo\n");
        printf("6 - Trapézio\n");
        printf("7 - Elipse\n");
        printf("0 - Voltar ao menu anterior\n");
        printf("Insira uma opção: ");

        opcao = receberInt();

        switch (opcao) {
            case 1:
            areaQuadrado();
            break;

            case 2:
            areaRetangulo();
            break;

            case 3:
            areaTriangulo();
            break;

            case 4:
            areaLosango();
            break;

            case 5:
            areaCirculo();
            break;

            case 6:
            areaTrapezio();
            break;

            case 7:
            areaElipse();
            break;
        }

    } while (opcao != 0);

    return 0;
}

/*
* Mostra o menu dos volumes tendo uma opção de retornar
* ao menu anterior.
*/
int mostrarVolumes() {
    int opcao;

    do {
        imprimirSeparador();

        printf("Deseja calcular o volume de:\n");
        printf("1 - Cubo\n");
        printf("2 - Paralelepípedo\n");
        printf("3 - Cilindro\n");
        printf("4 - Esfera\n");
        printf("5 - Pirâmide Quadrangular/Retângular\n");
        printf("6 - Cone\n");
        printf("0 - Voltar ao menu anterior\n");
        printf("Insira uma opção: ");

        opcao = receberInt();

        switch (opcao) {
            case 1:
            volumeCubo();
            break;

            case 2:
            volumeParalelepipedo();
            break;

            case 3:
            volumeCilindro();
            break;

            case 4:
            volumeEsfera();
            break;

            case 5:
            volumePiramideQuadRet();
            break;

            case 6:
            volumeCone();
            break;
        }

    } while (opcao != 0);

    return 0;
}

/*
* As três funções seguintes têm como função mostrar
* o valor do resultado da respetiva grandeza.
*
* Os resultados apresentados são do tipo float e estão
* arredondados na quarta casa decimal
*/

int dizerPerimetro(float a) {
    imprimirSeparador();
    printf("O PERÍMETRO É %.4f.\n", a);
    return 0;
}

int dizerArea(float a) {
    imprimirSeparador();
    printf("A ÁREA É %.4f.\n", a);
    return 0;
}

int dizerVolume(float a) {
    imprimirSeparador();
    printf("O VOLUME É %.4f.\n", a);
    return 0;
}

/*
* As seguintes funções são dedicadas ao calculo
* do perímetro pedindo, em primeiro lugar, os
* valor necessários e, posteriormente, apresenta-os
* recorrendo às funções anteriores.
*/
int perimetroQuadrado() {
    float l;

    printf("Largura: ");
    l = receberNumero();

    dizerPerimetro(4 * l);
    return 0;
}

int perimetroRetangulo() {
    float a, b;

    printf("Comprimento: ");
    a = receberNumero();

    printf("Largura: ");
    b = receberNumero();

    dizerPerimetro(2 * a + 2 * b);
    return 0;
}

int perimetroTriangulo() {
    float a, b, c;

    printf("Lado 1: ");
    a = receberNumero();

    printf("Lado 2: ");
    b = receberNumero();

    printf("Lado 3: ");
    c = receberNumero();

    dizerPerimetro(a + b + c);
    return 0;
}

int perimetroCirculo() {
    float r;

    printf("Raio: ");
    r = receberNumero();

    dizerPerimetro(2 * M_PI * r);
    return 0;
}

/*
* As seguintes funções são dedicadas ao calculo
* das áreas.
*/

int areaQuadrado() {
    float l;

    printf("Lado: ");
    l = receberNumero();

    dizerArea(l * l);
    return 0;
}

int areaRetangulo() {
    float l, c;

    printf("Comprimento: ");
    l = receberNumero();

    printf("Largura: ");
    c = receberNumero();

    dizerArea(l * c);
    return 0;
}

/*
* A área do Triângulo e do Losango calcula-se da mesma
* forma então podemos utilizar a mesma função para
* efetuar o cálculo.
*/
float calcularAreaTrianguloLosango(float a, float b) {
    return a * b / 2;
}

int areaTriangulo() {
    float b, h, area;

    printf("Base: ");
    b = receberNumero();

    printf("Altura: ");
    h = receberNumero();

    area = calcularAreaTrianguloLosango(b, h);
    dizerArea(area);

    return 0;
}

int areaLosango() {
    float d, D, area;

    printf("Diagonal menor: ");
    d = receberNumero();

    printf("Diagonal maior: ");
    D = receberNumero();

    area = calcularAreaTrianguloLosango(d, D);
    dizerArea(area);

    return 0;
}

int areaCirculo() {
    float r;

    printf("Raio: ");
    r = receberNumero();

    dizerArea(M_PI * r * r);
    return 0;
}

int areaTrapezio() {
    float h, b1, b2;

    printf("Altura: ");
    h = receberNumero();

    printf("Diagonal menor: ");
    b1 = receberNumero();

    printf("Diagonal menor: ");
    b1 = receberNumero();

    dizerArea(h / 2 * (b1 + b2));
    return 0;
}

int areaElipse() {
    float r1, r2;

    printf("Raio 1: ");
    r1 = receberNumero();

    printf("Raio 2: ");
    r2 = receberNumero();

    dizerArea(M_PI * r1 * r2);
    return 0;
}

/*
* As seguintes funções são dedicadas ao calculo
* dos volumes.
*/

int volumeCubo() {
    float a;

    printf("Aresta: ");
    a = receberNumero();

    dizerVolume(a * a * a);
    return 0;
}

int volumeParalelepipedo() {
    float a, b, c;

    printf("Aresta da Base 1: ");
    a = receberNumero();

    printf("Aresta da Base 2: ");
    b = receberNumero();

    printf("Altura: ");
    c = receberNumero();

    dizerVolume(a * b * c);
    return 0;
}

int volumeCilindro() {
    float r, h;

    printf("Raio da Base: ");
    r = receberNumero();

    printf("Altura: ");
    h = receberNumero();

    dizerVolume(M_PI * r * r * h);
    return 0;
}

int volumeEsfera() {
    float r;

    printf("Raio: ");
    r = receberNumero();

    dizerVolume(r * r * r * M_PI * 4 / 3);
    return 0;
}

int volumePiramideQuadRet() {
    float l1, l2, h;

    printf("Aresta da Base 1: ");
    l1 = receberNumero();

    printf("Aresta da Base 2: ");
    l2 = receberNumero();

    printf("Altura: ");
    h = receberNumero();

    dizerVolume(1 / 3 * l1 * l2 * h);
    return 0;
}

int volumeCone() {
    float r, h;

    printf("Raio da Base: ");
    r = receberNumero();

    printf("Altura: ");
    h = receberNumero();

    dizerVolume(1 / 3 * M_PI * r * r * h);
    return 0;
}

/*
* Função dedicada à Fórmula Resolvente, ou seja, às
* equações de segundo grau completas.
*/
int equacaoSegundoGrau() {
    float a, b, c, ans1, ans2, delta;

    printf("Insira o valor de a: ");
    a = receberNumero();

    printf("Insira o valor de b: ");
    b = receberNumero();

    printf("Insira o valor de c: ");
    c = receberNumero();

    delta = b * b - (4 * a * c);

    if (delta < 0) {
        printf("A equação é impossível!");
    } else {
        ans1 = (-b + sqrt(delta)) / (2 * a);
        ans2 = (-b - sqrt(delta)) / (2 * a);

        imprimirSeparador();
        printf("AS SOLUÇÕES SÃO %.2f E %.2f\n", ans1, ans2);
    }

    return 0;
}

/*
* Função principal do programa que inicia o programa ao mostrar
* o menu principal.
*/
int main() {
    mostrarMenu();
    return 0;
}
