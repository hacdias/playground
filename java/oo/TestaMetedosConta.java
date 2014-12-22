class TestaMetedosConta {
	public static void main(String[] args) {
		Agencia a1 = new Agencia(1234);
		Conta c = new Conta(a1);

		c.deposita(1000);
		c.imprimeExtrato();

		c.saca(500);
		c.imprimeExtrato();

		double saldoDisponivel = c.consultaSaldoDisponivel();
		System.out.println("Saldo Disponível: " + saldoDisponivel);
	}
}