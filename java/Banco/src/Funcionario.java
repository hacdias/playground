public class Funcionario {
	private String nome;
	private double salario;
	static double valeRefeicaoDiario;
	
	void aumentaSalario(double aumento) {
		this.setSalario(this.getSalario() + aumento);
	}
	
	static void reajustaValeRefeicaoDiario(double taxa) {
		Funcionario.valeRefeicaoDiario += valeRefeicaoDiario * taxa;
	}
	
	//Getters e Setters
	public String getNome() {
		return nome;
	}

	public void setNome(String nome) {
		this.nome = nome;
	}

	public double getSalario() {
		return salario;
	}

	public void setSalario(double salario) {
		this.salario = salario;
	}
}
