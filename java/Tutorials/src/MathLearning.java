public class MathLearning {
	// Criação de variáveis estáticas
	static double a = 14;
	static double b = 17;
	static int c = 20;
	static int counter = 0;

	public static void main(String[] args) {
		// Criação de 5 variáveis do tipo "double"
		double result;
		double resultTwo;
		double resultThree;
		double resultFour;
		double resultFive;

		// Atribuição de valores às 5 variáveis acima criadas
		result = a + b;
		resultTwo = a - b;
		resultThree = a * b;
		resultFour = a / c;
		resultFive = b % c;

		// Invocamos o métedo "out" com um parâmetro ''double'' obrigatório
		out(result);
		out(resultTwo);
		out(resultThree);
		out(resultFour);
		out(resultFive);

	}

	public static void out(double output) {
		counter++;
		System.out.println("Resultado " + counter + " é " + output);
	}

}
