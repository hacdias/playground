class Gerente {
	String nome;
	double salario;

	void aumentar() {
		this.aumentar(0.1);
	}

	void aumentar(double taxa) {
		this.salario += this.salario * taxa;
	}
}