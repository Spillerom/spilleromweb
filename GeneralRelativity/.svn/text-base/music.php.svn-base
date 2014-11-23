
<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
	<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.jplayer.min.js"></script>

	<script type="text/javascript">
		var soundBuffer = null;
		// Fix up prefixing
		window.AudioContext = window.AudioContext || window.webkitAudioContext;
		var context = new AudioContext();

		// 
		function playSound(buffer) {
			// var source = context.createBufferSource(); // creates a sound source
			// source.buffer = buffer;                    // tell the source which sound to play
			// source.connect(context.destination);       // connect the source to the context's destination (the speakers)
			// source.start(0); 	                         // play the source now

			// 
			var src = context.createBufferSource();
			src.buffer = buffer;
			//src.loop = true;

			// 
			var gain = context.createGain();
			gain.gain.value = 10;
			gain.gain.setValueAtTime(0, 0);
			gain.gain.linearRampToValueAtTime(1, 1);

			// 
			var sp = context.createScriptProcessor(1024);
			src.connect(gain);
			gain.connect(sp);
			sp.connect(context.destination);
			src.start(0);

			// 
			sp.onaudioprocess = function(e) {
				sp.onaudioprocess = null;
				console.log("context.currentTime = " + context.currentTime);
				console.log("computedGain = " + e.inputBuffer.getChannelData(0)[0]);
			};

		}

		// 
		function loadSound(url) {
			var request = new XMLHttpRequest();
			request.open('GET', url, true);
			request.responseType = 'arraybuffer';

			// Decode asynchronously
			request.onload = function() {
				context.decodeAudioData(request.response, function(buffer) {
					soundBuffer = buffer;
					playSound(soundBuffer);
				}, function(error) {
					console.log(error);
				});
			}
			request.send();
		}

		// 
		loadSound('http://dev.spillerom.no:8888/GeneralRelativity/data/music/compicbakery_load.mp3');
	</script>
</body>
</html>