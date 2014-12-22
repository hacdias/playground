
class Gerente extends Funcionario {
	private String usuario;
	private String senha;
	
	//GETTERS and SETTERS
	public void setUsuario(String usuario) {
		this.usuario = usuario;
	}
	
	public String getUsuario() {
		return usuario;
	}
	
	public void setSenha(String senha) {
		this.senha = senha;
	}
	
	public String getSenha() {
		return senha;
	}
	
	public double calculaBonificacao() {
		return this.getSalario() * 0.2 + 200;
	}
	
	public void mostraDados() {
		super.mostraDados();
		System.out.println("Usuário: " + this.usuario);
		System.out.println("Senha: " + this.senha);
	}
}
