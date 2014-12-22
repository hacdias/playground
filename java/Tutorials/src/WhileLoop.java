public class WhileLoop {
	public static void main(String[] args) {
		//Syntax:
		//for (Ação Inicial; Condição; Ação Final)
		for (int count = 0; count < count+1; count++) {
			System.out.println(count);
			
			if (count >= 10000) {
				break; //Para o loop quando count chega a 10000
			}
		}
	}
}
