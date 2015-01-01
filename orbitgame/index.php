<?php require_once 'set_env.php'; ?><!DOCTYPE HTML>
<html>
<head>
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap theme -->
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">

	<!-- Bootstrap slider -->
	<link href="css/slider.css" rel="stylesheet">

    <!-- Custom styles -->	
	<style>
		html, body {
			position: absolute;
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
			overflow: hidden;
		}

		#myCanvas {
			position: absolute;
			z-index: 0;
		}

		.background {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: #000;
			opacity: 0.5;
		}

		.button {
			float: left;
			color: #fff;
			background-color: #808080;
			text-align: center;
		}

		#menu-panel {
			position: absolute;
			z-index: 1;
		}
			.menu-section {
				position: relative;
				float: left;
				width: 100%;
				padding: 1em 0;
				color: #fff;
				background-color: #808080;
				text-align: center;
			}

		.menu-align-left {
			left: 0;
			width: 300px;
			height: 100%;
		}
		.menu-align-right {
			right: 0;
			width: 300px;
			height: 100%;
		}
		.menu-align-top {
			left: 0;
			width: 100%;
			height: 300px;
		}
		.menu-align-bottom {
			left: 0;
			width: 100%;
			height: 300px;
		}

		#border-slider .slider-selection {
			background: #BABABA;
		}
	</style>
</head>
 <body role="document">
 	<canvas id="myCanvas" width="100%" height="100%"></canvas>

	<div id="menu-panel" class="menu-align-right container theme-showcase">
		<div class="background"></div>
		<div id="debug-mode" class="menu-section"><?php LocalizedString('EDIT_MODE'); ?></div>

		<form role="form">
			<div class="form-group">
				<label for="mass">Mass:</label>
				<input type="mass" class="form-control" id="mass" placeholder="Input mass">
			</div>

			<div class="form-group">
				<label for="mass">Border:</label>
				<input id="border-slider-container" data-slider-id='border-slider' type="text" data-slider-min="0" data-slider-max="5" data-slider-step="1" data-slider-value="0">
			</div>
			<button type="submit" class="btn btn-default"><?php LocalizedString('SAVE'); ?></button>
		</form>
	</div>

	<!-- JQUERY INCLUDES -->
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

	<!-- BOOTSTRAP INCLUDES -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-slider.js"></script>

	<!-- EDITOR INCLUDES -->
	<script type="text/javascript" src="js/editor.js"></script>
</body>
</html>