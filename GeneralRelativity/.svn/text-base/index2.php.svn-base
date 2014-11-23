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
		margin-left: -256px;
		margin-top: -256px;
	}
</style>
</head>
<body>
<canvas id="myCanvas" width="100%" height="100%"></canvas>
<script>
	// 
	var canvas = document.getElementById('myCanvas');

	// canvas.width = window.innerWidth;
	// canvas.height = window.innerHeight;

	canvas.width = 512;
	canvas.height = 512;

    var gridSize = 32;

    // 
	var array = [];

	// 
	var dragForce = .00100;
	dragForce = 1;
	var frame=0;
	var ONE_FRAME_TIME = 1000 / 30;


	var context = canvas.getContext('2d');

    // 
    var point = function(x, y) {
    	// 
    	this.x = x;
    	this.y = y;

    	// this.x = 256-x;
    	// this.y = 256-y;
    	// 
    	this.length = function() {
    		return Math.sqrt(this.x*this.x + this.y*this.y);
    	};

    	// 
    	this.normalize = function() {
    		this.x = this.x / this.length();
    		this.y = this.y / this.length();
    		return this;
    	};
    };

    // 
    var clearScreen = function() {
		context.rect(0, 0, canvas.width, canvas.height);
		context.fillStyle="white";
		context.fill();
    };

    // 
    var buildGrid = function() {
		array = [];
		for( var y=0; y<gridSize; y++ ) {
			for( var x=0; x<gridSize; x++ ) {
				array.push(new point(x * (canvas.width / gridSize), y * (canvas.height / gridSize)));
			}
		}
    };

	// 
    var COG = function(cog) {
		// var logestLine = 0;
		for( var i=0; i<(gridSize-1)*gridSize; i++ ) {
			var dv = new point(array[i].x - cog.x, array[i].y - cog.y);

			var a = dv.length();

			//var inverseSqr = (a * a);
			//var drag = inverseSqr * .0001;

			// var drag = -(Math.max(Math.min((a)/512, 1), 0));
			// array[i].x = (array[i].x + ((cog.x * drag) ));
			// array[i].y = (array[i].y + ((cog.y * drag) ));

			var drag = (Math.max(Math.min((a)/512, 1), 0));
			array[i].x = cog.x + (dv.x * drag);
			array[i].y = cog.y + (dv.y * drag);
		}
		// console.log("longest line : " + logestLine);
    };

    // 
    var renderGrid = function() {
		for( var i=0; i<((gridSize-1)*(gridSize-1))-1; i++ ) {
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

		     	x = (x*2)-128;
		     	y = (y*2)-128;

				context.moveTo(x, y);

				// 
		    	x = array[i + 1].x;
				y = array[i + 1].y;

		     	x = (x*2)-128;
		     	y = (y*2)-128;

				context.lineTo(x, y);

				// 
		    	x = array[i + (gridSize+1)].x;
				y = array[i + (gridSize+1)].y;

		     	x = (x*2)-128;
		     	y = (y*2)-128;

				context.lineTo(x, y);

				context.stroke();
			}
		}
	};

	var mainloop = function() {
		// 
		clearScreen();

		// 
		buildGrid();

		// 
		COG(new point(
			(canvas.width * 0.5) + (-Math.cos(frame * 0.02) * 80), 
			(canvas.height * 0.5) + (Math.sin(frame * 0.02) * 80) ));

		// 
		COG(new point((canvas.width * 0.2), (canvas.height * 0.2)));

		// 
		renderGrid();

		// 
        frame = frame + 1;
    };
    setInterval( mainloop, ONE_FRAME_TIME );

</script>
</body>
</html>