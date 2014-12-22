class Numeros1a100 {
	public static void main(String[] args) {
		for (int i = 0; i <= 100; i++) {
			int resto = i % 2;

			if (resto==0) {
				System.out.println("*");
			} else if (resto != 0) {
				System.out.println("**");
			}
		}
	}
}