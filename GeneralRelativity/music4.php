<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
	<canvas id="fft" width="1024" height="768"></canvas>
	<script src="js/mootools-core-1.3.js"></script>	
	<script src="js/sdp.js"></script>	
	<script type="text/javascript">
		// 
		var audioContext;
		var source = 0;
		var jsProcessor = 0;
		
		currentvalue = new Array();
		
		var frameBufferSize = 4096;
		var bufferSize = frameBufferSize/4;
		
		var signal = new Float32Array(bufferSize);
		var peak = new Float32Array(bufferSize);
		
		var fft = new FFT(bufferSize, 44100);
		
		
		var canvas = document.getElementById('fft');
		var gfxContext = canvas.getContext('2d');


		// 
		function loadSample(url) {
			// 
		    var request = new XMLHttpRequest();
		    request.open("GET", url, true);
		    request.responseType = "arraybuffer";

		    // 
		    request.onload = function() { 
		        source.buffer = audioContext.createBuffer(request.response, false);
		        source.loop = true;
		        source.noteOn(0);
				visualizer();				// run jsfft visualizer
		    }

		    request.send();
		}

		// 
		function initAudio() {
		    audioContext = new webkitAudioContext();
		    //audioContext = new window.AudioaudioContext();

		    source = audioContext.createBufferSource();

		    // This AudioNode will do the amplitude modulation effect directly in JavaScript
		    jsProcessor = audioContext.createJavaScriptNode(2048);
		    jsProcessor.onaudioprocess = audioHandler;			// run jsfft audio frame event
		    
		    // Connect the processing graph: source -> jsProcessor -> analyser -> destination
		    source.connect(jsProcessor);
		    jsProcessor.connect(audioContext.destination);

		    // Load the sample buffer for the audio source
		    //loadSample("data/music/oceanloader_5_by_J_dunn.mp3");
		    //loadSample("data/music/compicbakery_load.mp3");
		    loadSample("data/music/Cypernoid_2_by_Joren_tel.mp3");
		}

		// 
		function audioHandler(event) {
			// Copy input arrays to output arrays to play sound
			var inputArrayL = event.inputBuffer.getChannelData(0);
			var inputArrayR = event.inputBuffer.getChannelData(1);
			var outputArrayL = event.outputBuffer.getChannelData(0);
			var outputArrayR = event.outputBuffer.getChannelData(1);

			// 			
			var n = inputArrayL.length;
			for (var i = 0; i < n; ++i) {
				outputArrayL[i] = inputArrayL[i];
				outputArrayR[i] = inputArrayR[i];
				signal[i] = (inputArrayL[i] + inputArrayR[i]) / 2;		// create data frame for fft - deinterleave and mix down to mono
			}
			
			// perform forward transform
			fft.forward(signal);

			// 			
			for ( var i = 0; i < bufferSize/8; i++ ) {
				magnitude = fft.spectrum[i] * 8000; 					// multiply spectrum by a zoom value
				currentvalue[i] = magnitude;
			}
		}

		//
		// SPECTRUM:
		//		
		function visualizer() {
			// 
			gfxContext.clearRect(0,0, canvas.width, canvas.height);
	
			// 
			gfxContext.fillStyle = '#000044';
			for (var i=0; i<currentvalue.length; i++) {
				// Draw rectangle bars for each frequency bin
				gfxContext.fillRect(i * 8, canvas.height, 7, -currentvalue[i]*3);
			}
			
			t = setTimeout('visualizer()', 50);
		}
	</script>
	<script language="JavaScript">
		// 
		function initDemo() {
			initAudio();
		}

		window.onload = initDemo;

	</script>
</body>
</html>