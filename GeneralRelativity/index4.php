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

    var gridSize = 128;

    // 
	var array = [];

	// 
	var dragForce = .00100;
	dragForce = 1;
	var frame=0;
	var ONE_FRAME_TIME = 1000 / 30;


	var context = canvas.getContext('2d');

    // 
    var point = function(x, y, mass, radius) {
    	// 
    	this.x = x;
    	this.y = y;
    	this.mass = mass;
    	this.radius = radius;

    	// 
    	this.length = function() {
    		return Math.sqrt(this.x*this.x + this.y*this.y);
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
				array.push(new point((x * ((canvas.width*2) / gridSize)) - canvas.width / 2, (y * ((canvas.height*2) / gridSize) ) - canvas.width / 2 ));
			}
		}
    };

	// 
    var COG = function(cog) {
		for( var i=0; i<(gridSize)*(gridSize); i++ ) {
			var dv = new point(array[i].x - cog.x, array[i].y - cog.y, 1);

			var a = dv.length();

			var drag = (Math.max(Math.min((a)/812, 1), 0));
			array[i].x = cog.x + (dv.x * drag);
			array[i].y = cog.y + (dv.y * drag);
		}
    };

	// 
    var COGs = function(cogArray) {
		for( var i=0; i<(gridSize*gridSize); i++ ) {

			var cogSum = new point(0,0,1,1);
			for( var j=0; j<cogArray.length; j++ ) {
				var dv = new point(array[i].x - cogArray[j].x, array[i].y - cogArray[j].y, 1, 1);

				var a = (dv.length());

				var drag = -(1-(Math.max(Math.min((a*cogArray[j].mass)/cogArray[j].radius, 1), 0)));

				cogSum.x += cogArray[j].x - (cogArray[j].x + (dv.x * drag));
				cogSum.y += cogArray[j].y - (cogArray[j].y + (dv.y * drag));
			}
			
			array[i].x += (cogSum.x);
			array[i].y += (cogSum.y);

			// array[i].x += (cogSum.x) / cogArray.length;
			// array[i].y += (cogSum.y) / cogArray.length;
		}
    };

    // 
    var renderGrid = function() {
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
				// context.fillStyle = '#8ED6FF';
				// context.fill();

				// 
				context.stroke();
			}
		}
	};

	// 
	var mainloop = function() {
		// 
		clearScreen();

		// 
		buildGrid();


		// 
		//COG(new point((canvas.width * 0.1), (canvas.height * 0.1)));


		//var cogArray = [new point(0, 0), new point(512, 512), new point(512, 0), new point(0, 512)];
		//var cogArray = [new point(0, 0, 1, 512), new point(256, 256, 1, 512), new point(0, 256, 1, 256), new point(256, 50, 1, 256)];
		var cogArray = [new point(256 - (Math.cos(frame * 0.05) * 255), 256 + (Math.sin(frame * 0.05) * 20), 1, 64),
						new point(256 + (Math.cos(frame * 0.05) * 255), 256 - (Math.sin(frame * 0.05) * 20), 1, 64)];
		// var cogArray = [new point(256, 256, 1, 64),
		// 				new point(256 + (Math.cos(frame * 0.05) * 64), 256 - (Math.sin(frame * 0.05) * 64), 1, 164)];
		COGs(cogArray);


		// 
		renderGrid();

		// 
        frame = frame + 1;
    };
    setInterval( mainloop, ONE_FRAME_TIME );

</script>
</body>
</html>