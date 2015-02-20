#include "batalhaNaval.h"

/**
 * @file    Batalha Naval
 * @author  Henrique Dias (henriquedias.com)
 * @version 1.0
 *
 * O presente código não segue totalmente as regras de ANSI C (nem c89,
 * nem c90), mas sim a estrutura do c99, pois atualmente a maioria dos
 * compiladores utilizados já suportam c99. Ao ser utilizado c99, o có-
 * digo fica mais "elegante", ficando também mais legível.
 *
 * Para compilar utilizando o GCC, utilize o seguinte comando:
 * 	> gcc -std=c11 ficheiro.c -o ficheiroFinal
 * Exemplo:
 *	> gcc -std=c11 batalhaNaval.c -o batalhaNaval
 */

int main() {
	imprimeBoasVindas();

	printf("Deseja jogar contra um amigo ou contra o computador?\n\n");
	printf("\t- \"c\" para jogar contra o computador;\n");
	printf("\t- \"a\" para jogar contra um amigo.\n\n");

	char opcao = comQuemSeVaiJogar();

	if (opcao == AMIGO) {
		printf("\nEscolheu jogar contra um amigo.\n\n");
		imprimeDivisoria();
		jogaContraAmigo();
	} else if (opcao == COMPUTADOR) {
		printf("\nEscolheu jogar contra o computador.\n\n");
		imprimeDivisoria();
		jogaContraComputador();
	}

	return 0;
}

/**
 * Imprimir Boas Vindas
 *
 * Utiliza-se para imprimir a mensagem de boas vindas ao jogo,
 * incluindo o seu logotipo.
 */
void imprimeBoasVindas() {
	printf("         ____        _        _ _             _   _                  _ \n");
	printf("        |  _ \\      | |      | | |           | \\ | |                | |\n");
	printf("        | |_) | __ _| |_ __ _| | |__   __ _  |  \\| | __ ___   ____ _| |\n");
	printf("        |  _ < / _` | __/ _` | | '_ \\ / _` | | . ` |/ _` \\ \\ / / _` | |\n");
	printf("        | |_) | (_| | || (_| | | | | | (_| | | |\\  | (_| |\\ V / (_| | |\n");
	printf("        |____/ \\__,_|\\__\\__,_|_|_| |_|\\__,_| |_| \\_|\\__,_| \\_/ \\__,_|_|\n\n");
}

/**
 * Obtenção do Adversário
 *
 * É utilizado para apurar se o utilizador
 * deseja jogar contra o computador ou contra um ami-
 * go.
 *
 * @return opção inserida pelo utilizador em lowercase
 */
char comQuemSeVaiJogar() {
	printf("Insira a letra: ");
	char opcao = tolower(getc(stdin));

	if (opcao == COMPUTADOR || opcao == AMIGO) {
		return opcao;
	}

	comQuemSeVaiJogar();
}

/**
 * Imprimir Divisória
 *
 * Imprime 80 LINHAS em branco de forma a "limpar" o ecrã.
 */
void imprimeDivisoria() {
	for (int i = 0; i < 80; i++) {
		printf("\n");
	}
}

/**
 * Jogar Contra um Amigo */
void jogaContraAmigo() {
	int** tabuleiroJogador1 = criaNovoTabuleiro();
	int** tabuleiroJogador2 = criaNovoTabuleiro();

	imprimeInformacoesTabuleiros();

	printf("JOGADOR 1");
	colocaNaviosJogador(tabuleiroJogador1);

	imprimeDivisoria();

	printf("JOGADOR 2");
	colocaNaviosJogador(tabuleiroJogador2);

	do {
		processaJogada(1, tabuleiroJogador2);
		processaJogada(2, tabuleiroJogador1);
	} while (true);

}

/**
 * Jogar Contra o Computador */
void jogaContraComputador() {
	int** tabuleiroJogador = criaNovoTabuleiro();
	int** tabuleiroComputador = criaNovoTabuleiro();

	imprimeInformacoesTabuleiros();

	printf("O computador está a colocar os seus navios...\n\n");
	colocaNaviosComputador(tabuleiroComputador);

	printf("Estrutura do tabuleiro:\n\n");
	imprimeTabuleiro(tabuleiroJogador);

	printf("\nComputador preparado. Coloca os teus navios.\n");
	colocaNaviosJogador(tabuleiroJogador);

	bool jogoDecorrer = true;

	do {
		imprimeDivisoria();
		printf("\nÉ a vez do computador.\n");

		if (jogadaComputador(tabuleiroJogador)) {
			printf("O computador acertou num dos seus navios.\n");
		}

		if (jogoAcabou(tabuleiroJogador)) {
			printf("O computador venceu-te!\n");
			break;
		}

		printf("\nÉ a sua vez.\n");

		imprimeTabuleiro(tabuleiroComputador);
		jogadaJogador(tabuleiroComputador);

		if (jogoAcabou(tabuleiroComputador)) {
			imprimeTabuleiro(tabuleiroComputador);
			printf("Ganhaste!\n");
			jogoDecorrer = false;
		}
	} while (jogoDecorrer);

}

/**
 * Criar Novo Tabuleiro
 *
 * Aqui criam-se os tabuleiros e todas as suas posições são
 * ocupadas com o valor -1.
 *
 * @return um array de apontadores que apontam para apontadores
 */
int **criaNovoTabuleiro() {
	/* criação de uma array bidimensional de ponteiros (**) atra-
	vés da função malloc */
	int **novoTabuleiro = malloc(LINHAS * sizeof(int*));

	/* dentro de cada posição do novoTabuleiro, colocar uma outra
	array. Aqui criam-e as COLUNAS */
	for (int i = 0; i < LINHAS; i++) {
		novoTabuleiro[i] = malloc(COLUNAS * sizeof(int));
	}

	//limpeza de todas as posições do tabuleiro criado
	for (int linha = 0; linha < LINHAS; linha++) {
		for (int coluna = 0; coluna < COLUNAS; coluna++) {
			novoTabuleiro[linha][coluna] = MAR;
		}
	}

	return novoTabuleiro;
}

/**
 * Imprimir Informações de Tabuleiros
 *
 * Imprime informações acerca dos tabuleiros que são utilizados
 * no jogo, bem como os seus símbolos.
 */
void imprimeInformacoesTabuleiros() {
	printf("Cada tabuleiro tem %d LINHAS e %d COLUNAS.\n", LINHAS, COLUNAS);
	printf("Cada jogador tem %d navios.\n\n", MAX_NAVIOS);

	printf("Legenda dos tabuleiros:\n");
	printf("\t ~ - Locais sem tiros;\n");
	printf("\t * - Locais com tiros, mas sem navios;\n");
	printf("\t X - Locais com tiros e um navio derrubado.\n");
	printf("\n");
}

/**
 * Imprimir Tabuleiro
 *
 * @param **tabuleiro O tabuleiro a ser imprimido.
 */
void imprimeTabuleiro(int** tabuleiro) {
	for (int i = 0; i < COLUNAS; i++) {
		printf("\t%d", i + 1);
	}

	printf("\n");

	for (int linha = 0; linha < LINHAS; linha++) {
		printf("%d", linha + 1);

		for (int coluna = 0; coluna < COLUNAS; coluna++) {
			switch(tabuleiro[linha][coluna]) {
				case MAR:
				case NAVIO_OK:
					printf("\t~");
					break;
				case MAR_TIRO:
					printf("\t*");
					break;
				case NAVIO_TIRO:
					printf("\tX");
					break;
			}
		}

		printf("\n");
	}
}

/**
 * Jogo Acabou
 *
 * Confirma se um jogo acabou, visualizando se algum
 * tabuleiro já tem todos os navios destruídos.
 *
 * @param **tabuleiro O tabuleiro a verificar
 * @return true caso o tabuleiro não tenha navios sobreviventes ou false caso contrário
 */
bool jogoAcabou(int** tabuleiro) {
	int naviosDerrotados = 0;

	for (int linha = 0; linha < LINHAS; linha++) {
		for (int coluna = 0; coluna < COLUNAS; coluna++) {
			if (tabuleiro[linha][coluna] == NAVIO_TIRO) {
				naviosDerrotados++;

				if (naviosDerrotados == MAX_NAVIOS) {
					return true;
				}
			}
		}
	}

	return false;
}

/**
 * Posição Livre
 *
 * Confirma se uma determinada posição num tabuleiro está livre.
 *
 * @param int** tabuleiro O tabuleiro em questão
 * @param int linha A linha a verificar
 * @param int coluna A coluna a verificar
 * @return true se a posição estiver livre ou false caso não esteja
 */
bool posicaoLivre(int** tabuleiro, int linha, int coluna) {
	return (tabuleiro[linha][coluna] == MAR) ? true : false;
}

/* FUNÇÕES RELACIONADAS COM AÇÕES DO JOGADOR COMPUTADOR */

/**
 * Colocar Navios do Computador
 *
 * Coloca navios em posições aleatórias num tabuleiro
 *
 * @param int** tabuleiro O tabuleiro para colocar os navios.
 */
void colocaNaviosComputador(int** tabuleiro) {
	int i = 0, linha, coluna;

	while (i < MAX_NAVIOS) {
		linha = rand() % LINHAS;
		coluna = rand() % COLUNAS;

		if (posicaoLivre(tabuleiro, linha, coluna)) {
			tabuleiro[linha][coluna] = NAVIO_OK;
			i++;
		}
	}
}

/**
 * Jogada do Computador
 *
 * Utiliza-se para efetuar uma jogada aleatória (quando o com-
 * putador joga).
 *
 * @param int** tabuleiro O tabuleiro do adversário.
 * @return false caso não acerte num navio ou true caso acerte.
 */
bool jogadaComputador(int** tabuleiro) {
	int linha, coluna;

	linha = rand() % LINHAS;
	coluna = rand() % COLUNAS;

	switch (tabuleiro[linha][coluna]) {
		case MAR:
		case MAR_TIRO:
			tabuleiro[linha][coluna] = MAR_TIRO;
			return false;
		case NAVIO_TIRO:
			tabuleiro[linha][coluna] = NAVIO_TIRO;
			return false;
		case NAVIO_OK:
			tabuleiro[linha][coluna] = NAVIO_TIRO;
			return true;
	}
}

/* FUNÇÕES RELACIONADAS COM AÇÕES DO JOGADOR HUMANO */

/**
 * Colocar Navios do Jogador
 *
 * Utiliza-se para colocar navios em posições aleatórias
 * dadas pelo jogador.
 *
 * @param int** tabuleiro O tabuleiro para colocar os navios.
 */
void colocaNaviosJogador(int** tabuleiro) {
	int i = 0, linha, coluna;

	while (i < MAX_NAVIOS) {
		printf("\nColoca as coordenadas do navio %d:\n", i + 1);
		printf("Linha: ");
		scanf("%d", &linha);

		printf("Coluna: ");
		scanf("%d", &coluna);

		if (posicaoLivre(tabuleiro, linha - 1, coluna - 1)) {
			tabuleiro[linha - 1][coluna - 1] = NAVIO_OK;
			i++;
		} else {
			printf("\nPosição ocupada ou inexistente. Tenta novamente.\n");
		}
	}
}

/**
 * Processar Jogada
 *
 * Utiliza-se para automatizar o processo de efetuar uma jogada,
 * chamando todas as funções necessárias para o processo.
 */
void processaJogada(int jogador, int** tabuleiro) {
	imprimeDivisoria();

	printf("JOGADOR %d\n", jogador);

	imprimeTabuleiro(tabuleiro);
	jogadaJogador(tabuleiro);

	if (jogoAcabou(tabuleiro)) {
		imprimeTabuleiro(tabuleiro);
		printf("Ganhou o JOGADOR %d!\n", jogador);
		exit(0);
	}
}

/**
 * Jogada Jogador
 *
 * Efetua a jogada para coordenadas definidas pelo utilizador.
 *
 * @param int** tabuleiro O tabuleiro do adversário.
 * @return true caso tenha acertado num navio ou false caso não acerte.
 */
bool jogadaJogador(int** tabuleiro) {
	int linha, coluna;

	do {
		printf("\nQuer disparar para que local?\n");
		printf("Linha: ");
		scanf("%d", &linha);

		printf("Coluna: ");
		scanf("%d", &coluna);

		linha--;
		coluna--;
	} while (linha >= LINHAS || coluna >= COLUNAS);

	switch (tabuleiro[linha][coluna]) {
		case MAR:
			tabuleiro[linha][coluna] = MAR_TIRO;
			return false;
		case NAVIO_TIRO:
		case MAR_TIRO:
			return false;
		case NAVIO_OK:
			tabuleiro[linha][coluna] = NAVIO_TIRO;
			return true;
	}
}
