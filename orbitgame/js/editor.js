
// 
$.post( "ajax/get_language_file.php", function( data ) {
	// 
	settings = data.SETTINGS;
	localizedStrings = data.LOCALIZED_STRINGS;

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
			var r = new Vector();
			r.x = this.x + b.x;
			r.y = this.y + b.y;
			return r;
		};

		this.sub = function(b) {
			var r = new Vector();
			r.x = this.x - b.x;
			r.y = this.y - b.y;
			return r;
		};
	};

	// 
	var PathStep = function(position, radius, color) {
		this.position = position;
		this.radius = radius;
		this.color = color;
	};

	// 
	var Path = function() {
		this.steps = [];
		this.steps.length = settings.PATH_MAX_NUM_POINTS;
		this.startPos = new Vector(window.innerWidth/2, window.innerHeight/2);
		this.numSteps = 0;
	};
	var path = new Path();

	// 
	var EditorState = function() {
		return {
			'OPEN_LEVEL': 0,
			'SAVE_LEVEL': 1,
			'VIEW_MODE': 2,
			'SCALE_MODE': 3,
			'MOVE_MODE': 4
		}
	}();
	var editorState = EditorState.VIEW_MODE;


	// Game states
	var GameState = function() {
		return {
			'MOVE_MOUSE': 0,
			'CALCULATE_PATH': 1,
			'RENDER_PATH': 2,
			'LAUNCH': 7
		}
	}();
	var gameState = GameState.MOVE_MOUSE;
	var prevGameState = GameState.MOVE_MOUSE;


	// 
	var canvas = document.getElementById('myCanvas');
	var context = canvas.getContext('2d');

	var frame=0;
	var ONE_FRAME_TIME = 1000 / 30;

	var editablePlanet = -1;
	var selectedPlanet = -1;

	// 
	$('#mass-slider-container').slider({
		formater: function(value) {
			if( selectedPlanet != -1 ) {
				planets[selectedPlanet].mass = value + 1;
			}
			return 'Current value: ' + value;
		}
	});

	// 
	$('#bounce-slider-container').slider({
		formater: function(value) {
			if( selectedPlanet != -1 ) {
				planets[selectedPlanet].bounce = value;
			}

			return 'Current value: ' + value;
		}
	});

	// 
	$('#maxstartforce-slider-container').slider({
		formater: function(value) {
			maxStartForce = value;
			return 'Current value: ' + value;
		}
	});

	//
	// MOUSE ROUTINES:
	//

	var Mouse = function() {
		this.isVisible = true;
		this.pos = new Vector(0, 0);
		this.prevPos = new Vector(0, 0);
		this.deltaPos = new Vector(0, 0);
		this.clickPos = new Vector(0, 0);

		this.clickPosDistance = 0;
		this.prevClickPosDistance = 0;

		// 
		this.update = function() {
			this.deltaPos.x = (this.prevPos.x - this.pos.x);
			this.deltaPos.y = (this.prevPos.y - this.pos.y);

			this.prevPos.x = this.pos.x;
			this.prevPos.y = this.pos.y;
		};
	}
	var mouse = new Mouse();

	canvas.addEventListener("mousemove", function(event) {
		var rect = canvas.getBoundingClientRect();

		mouse.pos.x = event.clientX - rect.left;
		mouse.pos.y = event.clientY - rect.top;

		// 
		switch( editorState ) {
			case EditorState.MOVE_MODE:
				if ( editablePlanet != -1 ) {
					planets[editablePlanet].position.x = mouse.pos.x;
					planets[editablePlanet].position.y = mouse.pos.y;
				};
			break;

			case EditorState.SCALE_MODE:
				if ( editablePlanet != -1 ) {
					mouse.prevClickPosDistance = mouse.clickPosDistance;
					mouse.clickPosDistance = planets[editablePlanet].position.sub(mouse.pos).length();

					if( mouse.clickPosDistance > mouse.prevClickPosDistance ) {
						planets[editablePlanet].radius += mouse.deltaPos.length();
					} else {
						planets[editablePlanet].radius -= mouse.deltaPos.length();
						planets[editablePlanet].radius = Math.max(planets[editablePlanet].radius, 5);
					}
				};
			break;
		}
	});

	canvas.addEventListener("mousedown", function(event) {
		// 
		mouse.clickPos.x = mouse.pos.x;
		mouse.clickPos.y = mouse.pos.y;

		// 
		editablePlanet = mouseOverPlanet();

		if( editablePlanet != -1 ) {
			setSelectedPlanet(editablePlanet);
		} else {
			if( editorState == EditorState.ADD_MODE ) {
				addNewObject();
			}
		}
	});

	canvas.addEventListener("mouseup", function(event) {
		editablePlanet = -1;
	});

	// 
	var mouseOverPlanet = function() {
		var r = new Vector(0, 0);

		var length = Number.MAX_VALUE;
		var prevLength = Number.MAX_VALUE;

		var mouseOverPlanet = -1;

		for( i=0; i<planets.length; i++ ) {
			var planet = planets[i];
			length = planet.position.sub(mouse.pos).length();

			if( length <= planet.radius ) {
				if( length < prevLength ) {
					mouseOverPlanet = i;
				}
			}
		}

		return mouseOverPlanet;
	}

	// 
	var setSelectedPlanet = function(index) {
		for( var i=0; i<planets.length; i++ ) {
			planets[i].border = 0;
		}

		if( index > -1 ) {
			selectedPlanet = index;
			planets[selectedPlanet].border = 5;

			//
			var massControl = $("#mass-slider-container").slider();
			massControl.slider('setValue', planets[selectedPlanet].mass);

			//
			var bounceControl = $("#bounce-slider-container").slider();
			bounceControl.slider('setValue', planets[selectedPlanet].bounce);
		}
	};

	//
	// KEYBOARD ROUTINES:
	//

	// 
	var KeyboardKeys = function() {
		return {
			'ESCAPE': 27,
			// ...
			'LEFT': 37,
			'UP': 38,
			'RIGHT': 39,
			'DOWN': 40,
			// ...
			'A': 65,
			'D': 68,
			'E': 69,
			'H': 72,
			'M': 77,
			'O': 79,
			'S': 83,
			'V': 86,
			// ...
			'a': 97,
			'd': 100,
			'e': 101,
			'h': 104,
			'm': 109,
			'o': 111,
			's': 115,
			'v': 118
		}
	}();

	// 
	var showMenu = function() {
		$('#menu-panel').removeClass('menu-hide');
		$('#menu-panel').addClass('menu-show');
	};

	// 
	var hideMenu = function() {
		$('#menu-panel').removeClass('menu-show');
		$('#menu-panel').addClass('menu-hide');
	};

	// 
	var addNewObject = function() {
		planets.push(new Planet(mouse.pos.x, mouse.pos.y, settings.DEFAULT_PLANET_RADIUS, settings.DEFAULT_PLANET_MASS));

		editablePlanet = mouseOverPlanet();

		if( editablePlanet != -1 ) {
			setSelectedPlanet(editablePlanet);
		}
	};

	// 
	var deleteSelectedObject = function() {
		if( selectedPlanet > 0 ) {
			planets.splice(selectedPlanet, 1);
		}
	};

	// 
	var setAddMode = function() {
		$('#editor-mode').text(localizedStrings.ADD_MODE);
		showMenu();
		editorState = EditorState.ADD_MODE;
	};

	// 
	var setScaleMode = function() {
		$('#editor-mode').text(localizedStrings.SCALE_MODE);
		editorState = EditorState.SCALE_MODE;
		showMenu();
	};

	// 
	var showHelpPanel = function() {
	};

	// 
	var setMoveMode = function() {
		$('#editor-mode').text(localizedStrings.MOVE_MODE);
		editorState = EditorState.MOVE_MODE;
		showMenu();
	};

	// 
	var showOpenPanel = function() {
	};
	// 
	var setViewMode = function() {
		$('#editor-mode').text(localizedStrings.VIEW_MODE);

		// 
		setSelectedPlanet(-1);

		// 
		startForce();
		calculatePath();
		gameState = GameState.RENDER_PATH;

		// 
		hideMenu();	
		editorState = EditorState.VIEW_MODE;
	};

	// 
	window.addEventListener("keypress", function(event) {
		var code = event.keyCode;
		console.log(code);
		switch (code) {
			// ADD KEY ('a/A')
			case KeyboardKeys.a:
			case KeyboardKeys.A:
				setAddMode();
			break;

			// DELETE KEY ('d/D')
			case KeyboardKeys.d:
			case KeyboardKeys.D:
				deleteSelectedObject();
			break;

			// EDIT KEY ('e/E')
			case KeyboardKeys.e:
			case KeyboardKeys.E:
			break;

			// HELP KEY ('h/H')
			case KeyboardKeys.h:
			case KeyboardKeys.H:
				showHelpPanel();
			break;

			// MOVE KEY ('m/M')
			case KeyboardKeys.m:
			case KeyboardKeys.M:
				setMoveMode();
			break;

			// OPEN KEY ('o/O')
			case KeyboardKeys.o:
			case KeyboardKeys.O:
				showOpenPanel();
			break;

			// SCALE KEY ('s/S')
			case KeyboardKeys.s:
			case KeyboardKeys.S:
				setScaleMode();
			break;

			// VIEW KEY ('v/V')
			case KeyboardKeys.v:
			case KeyboardKeys.V:
				setViewMode();
			break;
		}
	});

	// 
	var isKeyDown = false;
	window.addEventListener("keydown", function(event) {
		if( !isKeyDown ) {
			isKeyDown = true;
			var code = event.keyCode;
			switch (code) {
				case KeyboardKeys.ESCAPE:
					$('#menu-panel').removeClass('menu-align-left');
					$('#menu-panel').addClass('menu-hide');
				break;

				case KeyboardKeys.LEFT:
				break;

				case KeyboardKeys.UP:
				break;

				case KeyboardKeys.RIGHT:
				break;

				case KeyboardKeys.DOWN:
				break;
			}
		}
	});

	// 
	window.addEventListener("keyup", function(event) {
		isKeyDown = false;
	});

	// 
	var Planet = function(x, y, radius, mass) {
		this.position = new Vector(x, y);
		this.radius = radius;
		this.mass = mass;
		this.bounce = 0
		this.border = 0;
		this.borderColor = '#000000';

		this.getColor = function() {
			var dm = 1-(((this.mass-1)) / settings.MAX_MASS).toFixed(1);
			var hex = dec2hex(dm * 255);
			return '#' + hex + hex + hex;
		};
	};

	// 
	var planets = [
				// FIRST ELEMENT = START POS:
				new Planet(path.startPos.x, path.startPos.y, 100, 1),
				// ...
				];


	//
	// CALCULATION ROUTINES:
	//


	// GRID ROUTINES:

	// 
	var array = [];

	// 
	var buildGrid = function() {
		array = [];
		array.length = 0;
		var gridSize = settings.GRID_SIZE;
		for( var y=0; y<gridSize; y++ ) {
			for( var x=0; x<gridSize; x++ ) {
				//array.push( new Vector( (x * ((canvas.width*2) / gridSize)) - canvas.width / 2 , (y * ((canvas.height*2) / gridSize)) - canvas.width / 2) );
				array.push( new Vector( (x * ((2048*2) / gridSize)) - canvas.width / 2 , (y * ((2048*2) / gridSize)) - canvas.width / 2) );
			}
		}
	};

	// 
	var COG = function(planets) {
		var gridSize = settings.GRID_SIZE;
		var drag = 0;
		var a = 0;
		var dv = new Vector(0, 0);
		var tmp = new Vector(0, 0);
		for( var i=0; i<(gridSize*gridSize); i++ ) {
			tmp.x = array[i].x;
			tmp.y = array[i].y;
			for( j=1; j<planets.length; j++ ) {
				var planet = planets[j];

				// 
				//dv.x = planet.position.x - array[i].x;
				//dv.y = planet.position.y - array[i].y;
				dv.x = planet.position.x - tmp.x;
				dv.y = planet.position.y - tmp.y;

				// 
				a = dv.length();


				// 
				drag = (1 / ((a*a*a) / planet.mass)) * planet.radius;

				//drag = Math.sqrt(planet.mass / (a*a*a));

				drag = Math.max(0, drag);
				drag = Math.min(1, drag);

				// 	
				tmp.x += (dv.x * drag);
				tmp.y += (dv.y * drag);

			}

			array[i].x = tmp.x;
			array[i].y = tmp.y;
		}
	};


	// START FORCE: 
	var F = new Vector(170, 0);
	var F_2 = new Vector(0, 0);
	var startForce = function() {
		F_2 = mouse.pos.sub(path.startPos);
		if( F_2.length() > planets[0].radius ) {
			var df = planets[0].radius / F_2.length();
			F_2.x *= df;
			F_2.y *= df;
		}

		F.x = F_2.x * settings.PEPES_COSMOLOGICAL_CONSTANT;
		F.y = F_2.y * settings.PEPES_COSMOLOGICAL_CONSTANT;
	}

	// 
	var dec2hex = function(value) {
	    return Number(parseInt(value , 10)).toString(16);
	};

	// 
	var intersectionLineCircle = function(p1, p2, planet) {
		// 
		var sgn = function(x) {
			return x<0 ? -1 : 1;
		}

		// 
		var r = planet.radius;

		var x1 = p1.x-planet.position.x, y1 = p1.y-planet.position.y;
		var x2 = p2.x-planet.position.x, y2 = p2.y-planet.position.y;

		var dx = x2 - x1;
		var dy = y2 - y1;

		insideDr = Math.pow(dx,2) + Math.pow(dy,2);
		var dr = Math.sqrt(insideDr);

		var D = x1*y2 - x2*y1;

		var incidence = Math.pow(r,2)*Math.pow(dr,2)-Math.pow(D,2);

		if( incidence >= 0 ) {
			var q1 = new Vector(0, 0);
			var q2 = new Vector(0, 0);

			// 
			q1.x = ((D*dy + sgn(dy)*dx*Math.sqrt(incidence)) / insideDr) + planet.position.x;
			q2.x = ((D*dy - sgn(dy)*dx*Math.sqrt(incidence)) / insideDr) + planet.position.x;

			q1.y = (((-D)*dx + Math.abs(dy)*Math.sqrt(incidence)) / insideDr) + planet.position.y;
			q2.y = (((-D)*dx - Math.abs(dy)*Math.sqrt(incidence)) / insideDr) + planet.position.y;

			var tmp1 = new Vector(q1.x - p1.x, q1.y - p1.y);
			var tmp2 = new Vector(q2.x - p1.x, q2.y - p1.y);

			if( tmp1.length() < tmp2.length() ) {
				return q1;
			} else {
				return q2;
			}
		} else {
			return 0;
		}
	}

	// 
	var calculatePath = function() {
		var isRunning = true;
		var r = new Vector(0, 0);
		var drag = 0;

		path.numSteps = 0;

		path.startPos = planets[0].position;
		var currPos = new Vector(path.startPos.x, path.startPos.y);
		var prevPos = new Vector(path.startPos.x, path.startPos.y);

		while( isRunning ) {
			var step = new PathStep(new Vector(currPos.x, currPos.y), 3, settings.PATH_DOT_COLOR);

			for( i=1; i<planets.length; i++ ) {
				var planet = planets[i];

				r.x = planet.position.x - currPos.x;
				r.y = planet.position.y - currPos.y;

				if( r.length() <= planet.radius*1.5 ) {
					if( path.steps.length > 1) {
						var q = intersectionLineCircle(prevPos, currPos, planet);

						if( q!= 0 ) {
							step.position.x = q.x;
							step.position.y = q.y;
							step.color = settings.PATH_INTERSECT_DOT_COLOR;
							step.radius = 9;

							isRunning = false;
							break;
						}
					}

				}

				drag = 1/((r.length()*r.length()) / planet.mass);

				F.x += r.x * drag;
				F.y += r.y * drag;
			}

			path.steps[path.numSteps] = step;

			prevPos.x = currPos.x;
			prevPos.y = currPos.y;

			currPos.x += F.x * 0.01;
			currPos.y += F.y * 0.01;

			// 
			path.numSteps++;
			if( path.numSteps >= path.steps.length-1 ) {
				isRunning = false;
				break;
			}
		}
	}


	//
	// RENDERING ROUTINES:
	//

	// 
	var clearScreen = function() {
		context.rect(0, 0, canvas.width, canvas.height);
		context.fillStyle = settings.BACKGROUND_COLOR;
		context.fill();
	};

	// 
	var renderGrid = function() {
		var gridSize = settings.GRID_SIZE;
		for( var i=0; i<((gridSize-1)*(gridSize-1)); i++ ) {

			var render = true;
			for( c=0; c<(gridSize-1); c++ ) {
				if( i == ((gridSize*c)-1) ) {
					render = false;
				}
			}

			if( render ) {
				context.beginPath();

				// 
				var x = array[i].x;
				var y = array[i].y;
				context.moveTo(x, y);

				// 
				x = array[i + 1].x;
				y = array[i + 1].y;
				context.lineTo(x, y);

				// 
				x = array[i + (gridSize+1)].x;
				y = array[i + (gridSize+1)].y;
				context.lineTo(x, y);

				// 
				context.strokeStyle = settings.GRID_COLOR;
				context.stroke();
			}
		}
	};

	// 
	var renderDot = function(x, y, radius, color, border, borderColor) {
		context.beginPath();
		context.arc(x, y, radius, 0, 2 * Math.PI, false);
		context.closePath();

		context.fillStyle = color;
		context.fill();

		if( border > 0 ) {
			context.setLineDash([0]);

			//context.setLineDash([10]); // well, that became ugly.. 
			context.lineWidth = border;
			if( borderColor == undefined ) borderColor = settings.INTERSECT_DOT_COLOR;

			context.strokeStyle = borderColor;
			context.stroke();
		}
	}

	// 
	var renderCircle = function(x, y, radius, border, color, dashed) {
		if( dashed == undefined ) dashed = false;

		context.beginPath();
		context.arc(x, y, radius, 0, 2 * Math.PI, false);
		context.closePath();

		if( dashed )
			context.setLineDash([10]);

		context.lineWidth = border;
		context.strokeStyle = color;
		context.stroke();
	}

	// 
	var renderLine = function(p1, p2, color, lineWidth) {
		context.beginPath();
		if( lineWidth == undefined ) lineWidth = 1;
		context.lineWidth = lineWidth;
		context.strokeStyle = color;
		context.moveTo(p1.x, p1.y);
		context.lineTo(p2.x, p2.y);
		context.closePath();
		context.stroke();
	}

	// 
	var renderVector = function(p1, p2, color, lineWidth) {
		context.beginPath();
		if( lineWidth == undefined ) lineWidth = 1;
		context.lineWidth = lineWidth;
		context.strokeStyle = color;
		context.moveTo(p1.x, p1.y);
		context.lineTo(p2.x, p2.y);
		context.closePath();
		context.stroke();

		var tmp = new Vector(p2.x, p2.y);
		tmp.normalize();

		context.save();
		context.translate(p2.x, p2.y);
		context.rotate(-Math.cos(tmp.x));
		context.beginPath();
		context.fillRect(0, 0, 100, 50);
		context.closePath();
		context.restore();
	};

	// 
	var renderPlanets = function() {
		context.globalAlpha = 0.5;

		// FIRST OBJECT IS STARTING POS
		var planet = planets[0];
		renderCircle(planet.position.x, planet.position.y, planet.radius, 1, settings.MAX_START_FORCE_COLOR, true);

		// RENDER PLANETS:
		for( i=1; i<planets.length; i++ ) {
			planet = planets[i];
			renderDot(planet.position.x, planet.position.y, planet.radius, planet.getColor(), planet.border, planet.borderColor);
		}

		context.globalAlpha = 1;
	}

	// 
	var renderPath = function() {
		if( (path.numSteps > 1) && (planets.length > 1) ) {
			for( i=0; i<path.numSteps-1; i++ ) {
				step = path.steps[i];
				nextStep = path.steps[i+1];

				renderLine(step.position, nextStep.position, '#909090');
				renderDot(step.position.x, step.position.y, step.radius, step.color);
			}
			context.globalAlpha = 0.3;
			renderDot(nextStep.position.x, nextStep.position.y, nextStep.radius, nextStep.color);
			context.globalAlpha = 1;
		}
	}

	// 
	var renderStartForce = function() {
		if( mouse.isVisible ) {
			renderLine(path.startPos, path.startPos.add(F_2), '#808080');
		}
	};


	//
	// main():
	//

	// 
	var eventloop = function() {
		// 
		mouse.update();

		// 
		canvas.width  = window.innerWidth;
		canvas.height = window.innerHeight;

		// 
		clearScreen();

		// RENDER GRID:
		buildGrid();
		// for( i=1; i<planets.length; i++ ) {
		// 	var planet = planets[i];
		// 	COG(planet);
		// }
		COG(planets);

		renderGrid();		


		// 
		if( editorState == EditorState.VIEW_MODE ) {
			// 
			if( mouse.deltaPos.length() > 0 ) {
				gameState = GameState.MOVE_MOUSE;
			} else {
				if( prevGameState == GameState.MOVE_MOUSE ) {
					gameState = GameState.CALCULATE_PATH;
				}
			}
			prevGameState = gameState;

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
					renderPath();
				break;

				case GameState.LAUNCH:
				break;
			}

			// 
			renderStartForce();
		}

		// 
		renderPlanets();

		// 
		frame = frame + 1;
	};



	// 
	setInterval( eventloop, ONE_FRAME_TIME );
}, "json");

