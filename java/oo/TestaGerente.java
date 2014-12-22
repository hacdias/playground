class TestaGerente {
	public static void main(String[] args) {
		Gerente g = new Gerente();
		g.salario = 1000;

		System.out.println("Salário: " + g.salario);

		System.out.println("Aumentando o salário em 10%...");
		g.aumentar();

		System.out.println("Salário: " + g.salario);

		System.out.println("Aumentando o salário em 30%...");
		g.aumentar(0.3);

		System.out.println("Salário: " + g.salario);
	}
}