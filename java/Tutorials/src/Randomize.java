import java.util.Random;

public class Randomize {
	public static void main(String[] args) {
		Random rand = new Random();
		
		int result = rand.nextInt(4);
		
		if (result == 0) {
			System.out.println("0... The number of piece.");
		} else if (result == 1 ) {
			System.out.println("We will be so... ahah");
		} else if (result == 2) {
			System.out.println("Las cum carajas"); 
		} else {
			System.out.println("We are not on the list");
		}
	}

}
