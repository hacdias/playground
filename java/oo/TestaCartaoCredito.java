class TestaCartaoCredito {
	public static void main(String[] args) {
		CartaoCredito cdc1 = new CartaoCredito(111);
		cdc1.dataDeValidade = "01/01/2015";

		CartaoCredito cdc2 = new CartaoCredito(222);
		cdc2.dataDeValidade = "01/01/2016";

		System.out.println(cdc1.numero);
		System.out.println(cdc1.dataDeValidade);

		System.out.println(cdc2.numero);
		System.out.println(cdc2.dataDeValidade);
	}
}