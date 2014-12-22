import java.awt.Color;
import java.awt.Graphics;

import javax.swing.JFrame;

@SuppressWarnings("serial")
public class GraphicsDemo extends JFrame {

	// The constructor follows:
	public GraphicsDemo() {
		setTitle("Graphics Demo Test");
		setSize(800, 480);
		setVisible(true);
		setDefaultCloseOperation(EXIT_ON_CLOSE);
	}

	public void paint(Graphics g) {
		g.setColor(Color.WHITE);
		g.fillRect(0, 0, 800, 480);
		g.setColor(Color.BLUE);
		g.drawRect(60, 200, 100, 250);
		g.setColor(Color.BLACK);
		g.drawString("My name is Henrique", 200, 400);
	}

	// All classes need a main method, so we create that here too!
	public static void main(String args[]) {
		// We will create a GraphicsDemo object in the main method like so:
		// This should be familar, as we used this to create Random objects and
		// Thread objects:
		GraphicsDemo demo = new GraphicsDemo();

	}

}