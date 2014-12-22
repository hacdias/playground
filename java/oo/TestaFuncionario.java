class TestaFuncionario {
	public static void main(String[] args) {
		Funcionario henrique = new Funcionario();
		henrique.nome = "Henrique Dias";

		henrique.aumentar(100);
		System.out.println(henrique.informacao());
	}
}