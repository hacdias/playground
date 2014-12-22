import java.util.Random;

class CoinTossSwitch {

	public static void main(String[] args) {

		Random rand = new Random();
		int randomInt = rand.nextInt(2);

		System.out.println(randomInt);

		switch (randomInt) {

		case 0:
			System.out.println("Tails!");
			break;
		case 1:
			System.out.println("Heads!");
			break;

		} // Ends switch

	} // Ends main

} // Ends Class 