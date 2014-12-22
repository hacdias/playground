class TestaAgencia {
	public static void main(String[] args) {
		Agencia a1 = new Agencia(1234);
		a1.numero = 1234;

		Agencia a2 = new Agencia(4321);
		a2.numero = 56478;

		System.out.println(a1.numero);
		System.out.println(a2.numero);
	}
}