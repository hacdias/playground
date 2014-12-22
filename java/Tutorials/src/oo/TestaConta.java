class TestaConta {
	public static void main(String[] args) {
		Agencia a1 = new Agencia(1234);
		Conta c1 = new Conta(a1);
		c1.numero = 1234;
		c1.saldo = 1000;
		c1.limite = 500;

		Agencia a2 = new Agencia(4321);
		Conta c2 = new Conta(a2);
		c2.numero = 5678;
		c2.saldo = 2000;
		c2.limite = 250;

		System.out.println(c1.numero);
		System.out.println(c1.saldo);
		System.out.println(c1.limite); 

		System.out.println(c2.numero);
		System.out.println(c2.saldo);
		System.out.println(c2.limite); 
	}
}