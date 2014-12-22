class Funcionario {
	String nome;
	double salario = 1000;

	void aumentar(double valor) {
		this.salario += valor;
	} 

	void diminuir(double valor) {
		this.salario -= valor;
	}

	String informacao() {
		return "Nome: " + this.nome + "\nSalário: " + this.salario;
	}
}