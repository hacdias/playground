class Conta {
	int numero;
	int saldo;
	int limite = 100;
	Agencia agencia;


	Conta(Agencia agencia) {
 		this.agencia = agencia; 
 	}

	void deposita(double valor) {
		this.saldo += valor;
	}

	void saca(double valor) {
		this.saldo -= valor;
	}

	void imprimeExtrato() {
		System.out.println("Saldo: " + this.saldo);
	}

	double consultaSaldoDisponivel() {
		return this.saldo + this.limite;
	}

	void transfere(Conta destino, double valor) {
		this.saldo -= valor;
		destino.saldo += valor;
	}
}