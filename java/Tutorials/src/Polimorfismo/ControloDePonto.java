import java.text.SimpleDateFormat;
import java.util.Date;
	
public class ControloDePonto {
	public void registaEntrada(Funcionario f) {
		SimpleDateFormat date = new SimpleDateFormat("dd/mm/yy hh:mm:ss");
		Date agora = new Date();
		
		System.out.println("ENTRADA\nData: " + date.format(agora));
		
		
	}
	
	public void registaSaida(Funcionario f) {
		SimpleDateFormat date = new SimpleDateFormat("dd/mm/yy hh:mm:ss");
		Date agora = new Date();
		
		System.out.println("SAÍDA\nData: " + date.format(agora));
		
		
	}
}
