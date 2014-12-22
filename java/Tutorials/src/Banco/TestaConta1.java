public class TestaConta1 {
	public static void main(String[] args){
		System.out.println("Contador: " + Conta.contador);
		
		Conta c1 = new Conta();
		System.out.println("Número da conta: " + c1.numero);
		
		System.out.println("Contador: " + Conta.contador);
		
		Conta c2 = new Conta();
		System.out.println("Número da conta: " + c2.numero);
		
		System.out.println("Contador: " + Conta.contador);
		
		Conta.zeraContador();
	}
}
