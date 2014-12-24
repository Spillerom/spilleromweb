
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
		left: 50%;
		top: 50%;
		margin-left: -512px;
		margin-top: -512px;
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


	// Game states
	var GameState = function() {
		return {
			'MOVE_MOUSE': 0,
			'CALCULATE_PATH': 1,
			'RENDER_PATH': 2,
			'LAUNCH': 3
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


	var Planet = function(x, y, radius, mass, color, borderColor) {
		this.x = x;
		this.y = y;
		this.radius = radius;
		this.mass = mass;
		this.color = color;
		this.borderColor = borderColor;
	}

	var startPos = new Vector(0, 0);
    var player = new Planet(startPos.x, startPos.y, 3, 0.005, 'gray', 'gray');

    var planets = [
    			player, 
    			new Planet(412, 212, 50, 0.001, 'green', 'green'),
    			new Planet(812, 112, 50, 0.0002, 'plue', 'blue'),
    			new Planet(812, 512, 50, 0.0001, 'red', 'red')
    			];

    // 
    var F = new Vector(0, 0);
	var startForce = function() {
		F.x = (mousePos.x - startPos.x) * 10.0;
		F.y = (mousePos.y - startPos.y) * 10.0;
	}

	// 
    var calculatePath = function() {
		steps.length = 0;
		isRunning = true;

		player.x = startPos.x;
		player.y = startPos.y;

    	while( isRunning ) {
			for( i=1; i<planets.length; i++ ) {
				var planet = planets[i];

				var r = new Vector(planet.x - player.x, planet.y - player.y)
				if( r.length() < planet.radius ) {
					isRunning = false;
					break;
				}

				var drag = ((planet.mass)*(r.length()^2));

				F.x += (r.x * drag);
				F.y += (r.y * drag);

				player.x += F.x * 0.01;
				player.y += F.y * 0.01;

				steps.push(new Vector(player.x, player.y));
			}
    	}
    }

    var renderPlanets = function() {
		// Render planets
		for( i=0; i<planets.length; i++ ) {
			var planet = planets[i];
			x = planet.x;
			y = planet.y;
			radius = planet.radius;
			color = planet.color;
			borderColor = planet.borderColor;

			context.beginPath();
			context.arc(x, y, radius, 0, 2 * Math.PI, false);
			context.fillStyle = borderColor;
			context.fill();
			context.lineWidth = 5;
			context.strokeStyle = color;
			context.stroke();
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

			//console.log(gameState);

			// 
			switch( gameState ) {
				case GameState.MOVE_MOUSE:
					startForce();

				break;

				case GameState.CALCULATE_PATH:
					calculatePath();
					gameState = GameState.RENDER_PATH;
				break;

				case GameState.RENDER_PATH:
					// Render travel path
					if( steps.length > 2) {
						for( i=1; i<steps.length; i++ ) {
							context.beginPath();
							context.moveTo(steps[i-1].x, steps[i-1].y);
							context.lineTo(steps[i].x, steps[i].y);
							context.lineWidth = 1;
							context.color = 'red';
							context.stroke();

							context.beginPath();
							context.arc(steps[i].x, steps[i].y, 3, 0, 2 * Math.PI, false);
							context.fillStyle = 'green';
							context.fill();
						}
					}
				break;

				case GameState.LAUNCH:
				break;
			}

			// 
			context.beginPath();
			context.moveTo(startPos.x, startPos.y);
			context.lineTo(mousePos.x, mousePos.y);
			context.lineWidth = 1;
			context.color = 'red';
			context.stroke();
		}


		// 
		frame = frame + 1;
	};
	setInterval( mainloop, ONE_FRAME_TIME );

</script>
</body>
</html>