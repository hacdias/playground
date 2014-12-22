import java.text.SimpleDateFormat;
import java.util.Date;

public class GeradorDeExtrato {
	public void imprimeExtratoBasico(Conta c) {
		SimpleDateFormat sdf = new SimpleDateFormat("dd/mm/yy hh:mm:ss");
		Date now = new Date();
		
		System.out.println("Data: " + sdf.format(now));
		System.out.println("Conta: " + c.getSaldo());
		
		
	}

}
