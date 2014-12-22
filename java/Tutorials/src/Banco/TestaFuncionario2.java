public class TestaFuncionario2 {
	public static void main(String[] args) {
		Funcionario f = new Funcionario();
		
		f.setNome("Henrique Dias");
		f.setSalario(2000);
		
		System.out.println(f.getNome());
		System.out.println(f.getSalario());
	}

}
