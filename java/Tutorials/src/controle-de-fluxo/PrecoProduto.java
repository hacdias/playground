class PrecoProduto {
	public static void main(String[] args) {
		double precoDoProduto1 = 7526.2;
		double precoDoProduto2 = 4057.8;

		if (precoDoProduto1 > precoDoProduto2) {
			System.out.println("O produto 1 é mais caro.");
		} else if (precoDoProduto2 > precoDoProduto1) {
			System.out.println("O produto 2 é mais caro.");
		} else {
			System.out.println("Ambos os produtos têm o mesmo preço.");
		}
	}
}