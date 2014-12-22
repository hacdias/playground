import java.util.Random;

public class BySimpleIMeanSimple {
	static int dieValue;

	public static void main(String[] args) {
		rollDie();
	} // Ends main

	static void rollDie() {
		Random rand = new Random();

		// Atribui um valor aleatório entre 1 e 6 a dieValue
		// O +1 serve para adicionar +1 ao número pois se fosse apenas
		// .nextInt(6) os valores seriam 0,1,2,3,4,5
		dieValue = rand.nextInt(6) + 1;

		System.out.println("You rolled a " + dieValue);

		testDieValue(dieValue);

	}

	static void testDieValue(int dieValue) {
		if (dieValue <= 2) {
			System.out.println("You Lose.");
		} else if (dieValue >= 3 && dieValue <= 5) { // É igual a else if
														// (dieValue == 3 ||
														// dieValue == 4 ||
														// dieValue == 5)
			System.out.println();
			System.out.println("Rerolling.");
			System.out.println();
			rollDie();
		} else if (dieValue == 6) {
			System.out.println("You win! Congratulations!");
		}
	}

}
