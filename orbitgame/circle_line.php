
<!DOCTYPE HTML>
<html>
<head>
<style>
	body {
		margin: 0px;
		padding: 0px;
	}
	#myCanvas {
		position: absolute;
		left: 0%;
		top: 0%;
		margin-left: 0px;
		margin-top: 0px;
	}
</style>
</head>
<body>
<canvas id="myCanvas" width="100%" height="100%"></canvas>
<script>
	// 
	var Vector = function(x, y) {
		// 
		this.x = x;
		this.y = y;

		this.length = function() {
			return Math.sqrt(this.x*this.x + this.y*this.y);
		};

		this.normalize = function() {
			this.x = this.x / this.length();
			this.y = this.y / this.length();
			return this;
		};

		this.add = function(b) {
			var r = new Point();
			r.x = b.x + r.x;
			r.y = b.y + r.y;
			return r;
		};

		this.sub = function(b) {
			var r = new Point();
			r.x = b.x - r.x;
			r.y = b.y - r.y;
			return r;
		};
	};

	// 
	var Planet = function(x, y, radius, mass, color, borderColor) {
		this.x = x;
		this.y = y;
		this.radius = radius;
		this.mass = mass;
		this.color = color;
		this.borderColor = borderColor;
	}

	// 
	var canvas = document.getElementById('myCanvas');
	canvas.width = 1024;
	canvas.height = 1024;

	var context = canvas.getContext('2d');


	var mousePos = new Vector(0, 0);
	canvas.addEventListener("mousemove", function(event) {
		var rect = canvas.getBoundingClientRect();
		mousePos.x = event.clientX - rect.left;
		mousePos.y = event.clientY - rect.top;


		mainloop();
	});
	



	// 
	var intersectionLineCircle = function(p1, p2, planet) {
		// 
		var sgn = function(x) {
			return x<0 ? -1 : 1;
		}

		// 
		var r = planet.radius;

		var solutions = [];

		var x1 = p1.x-planet.x, y1 = p1.y-planet.y;
		var x2 = p2.x-planet.x, y2 = p2.y-planet.y;

		var dx = x2 - x1;
		var dy = y2 - y1;

		insideDr = Math.pow(dx,2) + Math.pow(dy,2);
		var dr = Math.sqrt(insideDr);

		var D = x1*y2 - x2*y1;

		var incidence = Math.pow(r,2)*Math.pow(dr,2)-Math.pow(D,2);

		var q1 = new Vector(0, 0);
		var q2 = new Vector(0, 0);


		// 
		q1.x = ((D*dy + sgn(dy)*dx*Math.sqrt(incidence)) / insideDr) + planet.x;
		q2.x = ((D*dy - sgn(dy)*dx*Math.sqrt(incidence)) / insideDr) + planet.x;

		q1.y = (((-D)*dx + Math.abs(dy)*Math.sqrt(incidence)) / insideDr) + planet.y;
		q2.y = (((-D)*dx - Math.abs(dy)*Math.sqrt(incidence)) / insideDr) + planet.y;

		solutions.push(q1);
		solutions.push(q2);

		return solutions;
	}

	// 
	var clearScreen = function() {
		context.rect(0, 0, canvas.width, canvas.height);
		context.fillStyle="white";
		context.fill();
	};

	planet = new Planet(512, 512, 100, 1, 'gray', 'gray');

	// 
	var renderDot = function(x, y, radius) {
		context.beginPath();
		context.arc(x, y, radius, 0, 2 * Math.PI, false);
		context.fillStyle = 'blue';
		context.fill();
	}

	// 
	var startPos = new Vector(0, 0);

	var ONE_FRAME_TIME = 1000 / 30;
	var mainloop = function() {
		clearScreen();

		context.beginPath();
		context.arc(planet.x, planet.y, planet.radius, 0, 2 * Math.PI, false);
		context.fillStyle = 'red';
		context.fill();

		context.beginPath();
		context.moveTo(startPos.x, startPos.y);
		context.lineTo(mousePos.x, mousePos.y);
		context.lineWidth = 1;
		context.color = 'red';
		context.stroke();


		var solutions = intersectionLineCircle(startPos, mousePos, planet);

		renderDot(solutions[0].x, solutions[0].y, 6);
		renderDot(solutions[1].x, solutions[1].y, 6);

		console.log(Math.pow(5,2));

	};
	//setInterval( mainloop, ONE_FRAME_TIME );

</script>
</body>
</html>