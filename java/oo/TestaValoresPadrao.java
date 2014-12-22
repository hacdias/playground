class TestaValoresPadrao {
	public static void main(String[] args) {
		Agencia a1 = new Agencia(1234);
		Conta c = new Conta(a1);

		System.out.println(c.numero);
		System.out.println(c.saldo);
		System.out.println(c.limite);
	}
}