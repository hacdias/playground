class Saudacao {
	public static void main(String[] args) {
		java.util.Random gerador = new java.util.Random();
		int hora = gerador.nextInt(24);

		if (hora >= 0 && hora < 12) {
			System.out.println("Bom Dia!");
		} else if (hora >= 12 && hora < 18) {
			System.out.println("Boa tarde!");
		} else if (hora >= 18 && hora < 24) {
			System.out.println("Boa Noite!");
		} else {
			System.out.println("Estás na Terra?");
		}
	}
}