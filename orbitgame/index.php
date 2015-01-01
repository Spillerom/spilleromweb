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

		#menu-panel {
			position: absolute;
			z-index: 1;
			width: 300px;
			height: 100%;
			-webkit-transition:width 1s;
			transition:width 1s;
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
			#planet-settings {
				position: relative;
			}

		.menu-hide {
			left: 300px;
		}
		.menu-show {
			left: 0px;
		}

		.slider-selection {
			background: #BABABA;
		}

		label {
			width: 100%;
		}
	</style>
</head>
 <body role="document">
 	<canvas id="myCanvas" width="100%" height="100%"></canvas>
	<!--
	this.mass = mass;
	this.color = color;

	this.border = border;
	this.borderColor = borderColor;
	-->
	<div id="menu-panel" class="menu-show container theme-showcase">
		<div class="background"></div>
		<div id="editor-mode" class="menu-section"><?php LocalizedString('EDIT_MODE'); ?></div>

		<form id="planet-settings" role="form">
			<div class="form-group">
				<label for="mass">Mass:</label>
				<input id="mass-slider-container" data-slider-id='mass-slider' type="text" data-slider-min="0" data-slider-max="10000" data-slider-step="500" data-slider-value="0">
			</div>

			<div class="form-group">
				<label for="mass">Bounce:</label>
				<input id="bounce-slider-container" data-slider-id='bounce-slider' type="text" data-slider-min="0" data-slider-max="5" data-slider-step="1" data-slider-value="0">
			</div>

			<div id="save-button" class="btn btn-default"><?php LocalizedString('SAVE'); ?></div>
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