class Escola {
	public static void main(String[] args) {
		Turma nonob = new Turma();
		nonob.ano = 9;
		nonob.letra = "B";

		Aluno henrique = new Aluno();
		henrique.nome = "Henrique Dias";
		henrique.idade = 14;
		henrique.dataDeNascimento = "22/10/1999";
		henrique.turma = nonob;

		System.out.println("O aluno " + henrique.nome + "está nasceu a " + henrique.dataDeNascimento + " por isso, tem " + henrique.idade + " anos e frequenta a turma " + henrique.turma.ano + henrique.turma.letra);

	}
}