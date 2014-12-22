public class ForLooping {
	public static void main(String[] args) {
		int initialValue = 0;
		int finalValue = 10;
		
		int counter = 0;

		if (initialValue < finalValue) {
			System.out.println("Input Accepted!");
			System.out.println("Initial Value: " + initialValue);
			System.out.println("Final Value: " + finalValue);
			System.out.println();
			System.out.println("Initiating count.");
			System.out.println();

			System.out.println(initialValue);
			counter++;

			for (initialValue = 1; initialValue < finalValue + 1; initialValue++) {
				System.out.println(initialValue);
				counter++;

				if (initialValue == finalValue) {
					System.out.println();
					System.out.println("Counting complete.");
					System.out.println("There are " + counter
							+ " numbers (inclusive) between "
							+ (initialValue - counter + 1) + " and "
							+ finalValue + ".");
				}
			}

		} else {
			System.out.println("Final value is less than initial value!");
			System.out.println("Please choose new values.");
		}

	}
}