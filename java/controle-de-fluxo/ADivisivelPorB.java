class ADividePorB {
	public static void main(String[] args) {
		java.util.Random nA = new java.util.Random();
		java.util.Random nB = new java.util.Random();
		int a = nA.nextInt(1000);
		int b = nB.nextInt(1000);

		if (a % b == 0) {
			System.out.println("A divisão dá resto 0, por isso é divisível.");
		} else if (a % b != 0) {
			System.out.println("A divisão não dá resto 0, por isso não é divisível.");
		}
	}
}