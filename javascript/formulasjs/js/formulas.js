function result(value) {
	confirm("The result is " + value);
}

function nan(value) {
	alert(value + " is not a number!");
}

//Creating the "namespace"
var formulas = {};

formulas.perimeterSquare = function () {
	var side = prompt("Insert the side length:");
	if (side && !isNaN(side)) {
		var perimeter = 4 * side;
		result(perimeter);
	} else if (isNaN(side)) {
		nan(side);
	};
}

formulas.perimeterRectangle = function () {
	var length = prompt("Insert the length:");
	if (length && !isNaN(length)) {
		var width = prompt("Insert the width:");

		if (width && !isNaN(width)) {
			var perimeter = (2 * length) + (2 * width);
			result(perimeter);
		} else if (isNaN(width)) {
			nan(width);
		}
	} else if (isNaN(length)) {
		nan(length);
	};
}

formulas.perimeterTriangle = function () {
	var a = prompt("Insert the length of first side:");

	if (a && !isNaN(a)) {
		var b = prompt("Insert the length of second side:");
		if (b && !isNaN(b)) {
			var c = prompt("Insert the length of third side:");
			if (c && !isNaN(c)) {
				var perimeter = 1*a + 1*b + 1*c;
				result(perimeter);
			} else if (isNaN(c)) {
				nan(c);
			}
		} else if (isNaN(b)) {
			nan(b);
		}
	} else if (isNaN(a)) {
		nan(a);
	};
}

formulas.perimeterCircle = function () {
	var r = prompt("Insert radius:");
	if (r && !isNaN(r)) {
		var perimeter = 2 * Math.PI * r;
		result(perimeter);
	} else if (isNaN(r)) {
		nan(r);
	};
}

//Areas
formulas.areaSquare = function () {
	var side = prompt("Insert the side measure:");
	if (side && !isNaN(side)) {
		var area = Math.pow(side, 2);
		result(area);
	} else if (isNaN(side)) {
		nan(side);
	};
}

formulas.areaRectangle = function () {
	var length = prompt("Insert the length:");
	if (length && !isNaN(length)) {
		var width = prompt("Insert the width:");
		if (width && !isNaN(width)) {
			var area = width * length;
			result(area);
		} else if (isNaN(width)) {
			nan(width);
		}
	} else if (isNaN(length)) {
		nan(length);
	};
}

formulas.areaTriangle = function () {
	var height = prompt("Insert the height/length:");
	if (height && !isNaN(height)) {
		var width = prompt("Insert the width:");
		if (width && !isNaN(width)) {
			var area = (width * height) / 2;
			result(area);
		} else if (isNaN(width)) {
			nan(width);
		}
	} else if (isNaN(height)) {
		nan(height);
	};
}

formulas.areaRhombus = function () {
	var d1 = prompt("Insert the length of diagonal 1:");
	if (d1 && !isNaN(d1)) {
		var d2 = prompt("Insert the length of diagonal 2:");
		if (d2 && !isNaN(d2)) {
			var area = (d1 * d2) / 2;
			result(area);
		} else if (isNaN(d2)) {
			nan(d2);
		}
	} else if (isNaN(d1)) {
		nan(d1);
	};
}

formulas.areaCircle = function () {
	var r = prompt("Insert the radius of the circle:");
	if (r && !isNaN(r)) {
		var area = Math.PI * Math.pow(r, 2);
		result(area);
	} else if (isNaN(r)) {
		nan(r);
	};
}

formulas.areaTrapezoid = function () {
	var b1 = prompt("Insert the value of base 1:");
	if (b1 && !isNaN(b1)) {
		var b2 = prompt("Insert the value of base 2:");
		if (b2 && !isNaN(b2)) {
			var height = prompt("Insert the height:");
			if (height && !isNaN(height)) {
				var area = height/2*(b1+b2);
				result(area);
			} else if (isNaN(height)) {
				nan(height);
			}
		} else if (isNaN(b2)) {
			nan(b2);
		}
	} else if (isNaN(b1)) {
		nan(b1);
	};
}

formulas.areaEllipse = function () {
	var r1 = prompt("Insert radius 1:");
	if (r1 && !isNaN(r1)) {
		var r2 = prompt("Insert tadius 2:");
		if (r2 && !isNaN(r2)) {
			var area = Math.PI * r1 * r2;
			result(area);
		} else if (isNaN(r2)) {
			nan(r2);
		}
	} else if (isNaN(r1)) {
		nan(r1);
	};
}

//volume

formulas.volumeCube = function() {
	var side = prompt("Insert the length of the cube edge:");
	if (side && !isNaN(side)) {
		var volume = Math.pow(side,3);
		result(volume);
	} else if (isNaN(side)) {
		nan(side);
	}
}

formulas.volumeParallelepiped = function () {
	var width = prompt("Insert the base width:");
	if (width && !isNaN(width)) {
		var length = prompt("Insert the base length:");
		if (length && !isNaN(length)) {
			var height = prompt("Insert the height:");
			if (height  && !isNaN(height)) {
				var volume = width * length * height;
				result(volume);
			} else if (isNaN(height)) {
				nan(height);
			}
		} else if (isNaN(length)) {
			nan(length);
		}
	} else if (isNaN(width)) {
		nan(width);
	};
}

formulas.volumeCylinder = function () {
	var r = prompt("Insert the radius of the base:");
	if (r && !isNaN(r)) {
		var height = prompt("Insert the height:");
		if (height && !isNaN(height)) {
			var volume = Math.PI * Math.pow(r,2) * height;
			result(volume);
		} else if (isNaN(height)) {
			nan(height);
		}
	} else if (isNaN(r)) {
		nan(r);
	};
}

formulas.volumeQuadPrism = function () {
	var baseSide = prompt("Insert the base side length:");
	if (baseSide && !isNaN(baseSide)) {
		var height = prompt("Insert the height of the Prism:");
		if (height && !isNaN(height)) {
			var volume = Math.pow(baseSide, 2) * height;
			result(volume);
		} else if (isNaN(height)) {
			nan(height);
		}
	} else if (isNaN(baseSide)) {
		nan(baseSide);
	};
}

formulas.volumeSphere = function () {
	var r = prompt("Insert the sphere radius:");
	if (r && !isNaN(r)) {
		var volume = Math.pow(r,3) * Math.PI * 4/3;
		result(volume);
	} else if (isNaN(r)) {
		nan(r);
	};
}

formulas.volumePyramid = function () {
	var l1 = prompt("Insert base side 1:");
	if (l1 && !isNaN(l1)) {
		var l2 = prompt("Insert base side 2:");
		if (l2 && !isNaN(l2)) {
			var height = prompt("Insert the height:");
			if (height && !isNaN(height)) {
				var volume = 1 / 3 * l1 * l2 * height;
				result(volume);
			} else if (isNaN(height)) {
				nan(height);
			}
		} else if (isNaN(l2)) {
			nan(l2);
		}
	} else if (isNaN(l1)) {
		nan(l1);
	};
}

formulas.volumeCone = function () {
	var r = prompt("Insert base radius:");
	if (r && !isNaN(r)) {
		var h = prompt("Insert the height:");
		if (h && !isNaN(h)) {
			var volume = 1 / 3 * Math.PI * Math.pow(r,2) * h;
			result(volume);
		} else if (isNaN(h)) {
			nan(h);
		}
	} else if (isNaN(r)) {
		nan(r);
	};
}

//Other Formulas

formulas.quadraticEquation = function () {
	var a = prompt("Insert 'a' value:");
	if (a && !isNaN(a)) {
		var b = prompt("Insert 'b' value:");
		if (b && !isNaN(b)) {
			var c = prompt("Insert 'c' value:");
			if (c && !isNaN(c)) {
				var delta = Math.pow(b,2) - (4 * a * c);

				if (delta < 0) {
					confirm("The equation is impossible.");
				} else {
					var x1 = (-b + Math.sqrt(delta)) /(2*a);
					var x2 = (-b - Math.sqrt(delta)) /(2*a);
					confirm("The solutions of the equation are: " + x1 + " and " + x2);
				}
			} else if (isNaN(c)) {
				nan(c);
			}
		} else if (isNaN(b)) {
			nan(b);
		}
	} else if (isNaN(a)) {
		nan(a);
	};
}
