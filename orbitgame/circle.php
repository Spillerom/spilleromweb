
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
	var PathStep = function(position, radius, color) {
		this.position = position;
		this.radius = radius;
		this.color = color;
	};

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

	var isMouseVisible = true;

	// Game states
	var GameState = function() {
		return {
			'MOVE_MOUSE': 0,
			'CALCULATE_PATH': 1,
			'RENDER_PATH': 2,
			'DEBUG_MODE': 3,
			'LAUNCH': 4
		}
	}();
	var gameState = GameState.MOVE_MOUSE;
	var prevGameState = GameState.MOVE_MOUSE;

	var steps = [];

	// 
	var canvas = document.getElementById('myCanvas');

	canvas.width = 1024;
	canvas.height = 1024;

	var frame=0;
	var ONE_FRAME_TIME = 1000 / 30;

	var mousePos = new Vector(0, 0);

	var context = canvas.getContext('2d');

	canvas.addEventListener("mousemove", function(event) {
		var rect = canvas.getBoundingClientRect();
		mousePos.x = event.clientX - rect.left;
		mousePos.y = event.clientY - rect.top;
	});

	// 
	var clearScreen = function() {
		context.rect(0, 0, canvas.width, canvas.height);
		context.fillStyle="white";
		context.fill();
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

	var startPos = new Vector(0, 0);
    var player = new Planet(startPos.x, startPos.y, 3, 0.005, '#0000ff', '#0000ff');

    var planets = [
    			new Planet(412, 212, 60, 0.001, 'gray', 'gray'),
    			new Planet(812, 112, 50, 0.0002, 'gray', 'gray'),
    			new Planet(812, 512, 30, 0.0001, 'gray', 'gray'),
    			player
    			];

    // 
    var F = new Vector(1700, 0);
	var startForce = function() {
		F.x = (mousePos.x - startPos.x) * 10.0;
		F.y = (mousePos.y - startPos.y) * 10.0;

		//F.x = 1700;
		//F.y = 0;
	}

	// 
	var intersectionLineCircle = function(p1, p2, planet) {


		var sgn = function(x) {
			if( x<0 )
				return -1;
			else
				return 1;
		}

		var r = planet.radius;

		var solutions = [];

		var x1 = p1.x-planet.x;
		var y1 = p1.y-planet.y;

		//console.log(x1 + ' ' + y1);

		var x2 = p2.x-planet.x;
		var y2 = p2.y-planet.y;

		//console.log(x2 + ' ' + y2);

		var dx = x2 - x1;
		var dy = y2 - y1;

		var dr = Math.sqrt(dx^2 + dy^2);

		var D = x1*y2 - x2*y1;

		var incidence = (r^2)*(dr^2)-(D^2);

		var q1 = new Vector(0, 0);
		var q2 = new Vector(0, 0);

		// 
		q1.x = ((D*dy + sgn(dy)*dx*Math.sqrt(incidence)) / (dr^2)) + planet.x;
		q1.y = ((-D*dy + Math.abs(dy)*Math.sqrt(incidence)) / (dr^2)) + planet.y;

		// 
		q2.x = ((D*dy - sgn(dy)*dx*Math.sqrt(incidence)) / (dr^2)) + planet.x;
		q2.y = ((-D*dy - Math.abs(dy)*Math.sqrt(incidence)) / (dr^2)) + planet.y;

		solutions.push(q1);
		solutions.push(q2);

		return solutions;
	}

	// 
    var calculatePath = function() {
		var isRunning = true;
		var r = new Vector(0, 0);
		var drag = 0;

		steps.length = 0;

		var currPos = new Vector(startPos.x, startPos.y);
		var prevPos = new Vector(startPos.x, startPos.y);

    	while( isRunning ) {
    		var step = new PathStep(new Vector(currPos.x, currPos.y), 3, '#00ff00');

			for( i=0; i<planets.length-1; i++ ) {
				var planet = planets[i];

				r.x = planet.x - currPos.x;
				r.y = planet.y - currPos.y;

				if( r.length() <= planet.radius ) {
					step.color = '#ff0000';
					step.radius = 6;

					if( steps.length > 1) {
						var solutions = intersectionLineCircle(prevPos, currPos, planet);

						//console.log(solutions);

						step.x = solutions[0].x;
						step.y = solutions[0].y;
						step.color = '#000000';
						step.radius = 9;

						isRunning = false;
						break;
					}

				}

				drag = ((planet.mass)*(r.length()^2));
				F.x += (r.x * drag);
				F.y += (r.y * drag);
			}

			steps.push(step);

			prevPos.x = currPos.x;
			prevPos.y = currPos.y;

			currPos.x += F.x * 0.01;
			currPos.y += F.y * 0.01;

    	}
    }

    // 
    var renderPlanets = function() {
		for( i=0; i<planets.length-1; i++ ) {
			var planet = planets[i];
			x = planet.x;
			y = planet.y;
			radius = planet.radius;
			color = planet.color;
			borderColor = planet.borderColor;

			context.beginPath();
			context.arc(x, y, radius, 0, 2 * Math.PI, false);
			context.fillStyle = borderColor;
			context.globalAlpha = 0.3;
			context.fill();
			context.lineWidth = 5;
			context.strokeStyle = color;
			context.stroke();
		}
    }

    var renderPath = function() {
    	// 
    	var renderDot = function(step) {
			context.beginPath();
			context.arc(step.position.x, step.position.y, step.radius, 0, 2 * Math.PI, false);
			context.fillStyle = step.color;
			context.fill();
    	}

		// Render travel path
		if( steps.length > 1 ) {
			for( i=0; i<steps.length-1; i++ ) {
				step = steps[i];
				nextStep = steps[i+1];

				context.beginPath();
				context.moveTo(step.position.x, step.position.y);
				context.lineTo(nextStep.position.x, nextStep.position.y);

				context.lineWidth = 1;
				context.color = step.color;
				context.stroke();

				renderDot(step);
			}

			renderDot(nextStep);
		}
    }

	var deltaMousePos = new Vector(0, 0);
	var prevMousePos = new Vector(0, 0);

    isGame = true;
	var mainloop = function() {
		if( isGame ) {
			clearScreen();

			renderPlanets();

			// 
			deltaMousePos.x = Math.abs(prevMousePos.x - mousePos.x);
			deltaMousePos.y = Math.abs(prevMousePos.y - mousePos.y);
			if( deltaMousePos.length() > 0 ) {
				gameState = GameState.MOVE_MOUSE;
			} else {
				if( prevGameState == GameState.MOVE_MOUSE ) {
					gameState = GameState.CALCULATE_PATH;
				}
			}
			prevGameState = gameState;
			prevMousePos.x = mousePos.x;
			prevMousePos.y = mousePos.y;

			// 
			switch( gameState ) {
				case GameState.MOVE_MOUSE:
					startForce();
				break;

				case GameState.CALCULATE_PATH:
					calculatePath();
					gameState = GameState.RENDER_PATH;
					//gameState = GameState.DEBUG_MODE;
				break;

				case GameState.RENDER_PATH:
					renderPath();
				break;

				case GameState.DEBUG_MODE:
					renderPath();
				break;

				case GameState.LAUNCH:
				break;
			}

			// 
			if( isMouseVisible ) {
				context.beginPath();
				context.moveTo(startPos.x, startPos.y);
				context.lineTo(mousePos.x, mousePos.y);
				context.lineWidth = 1;
				context.color = 'red';
				context.stroke();
			}
		}


		// 
		frame = frame + 1;
	};
	setInterval( mainloop, ONE_FRAME_TIME );


</script>
</body>
</html>