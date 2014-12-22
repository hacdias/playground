
public class TestaFuncionario1 {
	public static void main(String[] args) {
		Funcionario.valeRefeicaoDiario = 15;
		System.out.println(Funcionario.valeRefeicaoDiario);
		
		Funcionario.reajustaValeRefeicaoDiario(0.5);
		System.out.println(Funcionario.valeRefeicaoDiario);
	}
}
