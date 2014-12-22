class TestaFuncionarios {
	public static void main(String[] args) {
		Gerente g = new Gerente();
		g.setNome("Henrique Dias");
		g.setSalario(2000);
		g.setUsuario("hacdias");
		g.setSenha("12345");
		
		Telefonista t = new Telefonista();
		t.setNome("Jesuina Maria");
		t.setSalario(1100);
		t.setEstacaoDeTrabalho(1);
		
		Secretaria s = new Secretaria();
		s.setNome("Teresa Borgáio");
		s.setSalario(1000);
		s.setRamal(1);
		
		System.out.println("GERENTE");
		g.mostraDados();
		
		System.out.println("\nTELEFONISTA");
		t.mostraDados();
		
		System.out.println("\nSECRETÁRIA");
		s.mostraDados();
	}
}
