import java.util.Random;

public class Tilemap {

	public static void main(String args[]) {
		Tilemap tp = new Tilemap();

	}

	public Tilemap() {
		int[][] tilemap = new int[30][50];

		System.out.println("New Tilemap created.");
		Random r = new Random();

		int rows = tilemap.length;
		int columns = tilemap[1].length;

		printTiles(rows, columns, tilemap, r);

	}

	private void printTiles(int rows, int columns, int[][] tilemap, Random r) {

		for (int i = 0; i < rows; i++) {
			for (int j = 0; j < columns; j++) {
				tilemap[i][j] = r.nextInt(5);
				System.out.print(" " + tilemap[i][j]);
			}

			System.out.println("");

		}
	}

}