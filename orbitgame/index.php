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
			position: relative;
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
			overflow: hidden;
		}

		#myCanvas {
			float: left;
			width: 100%;
		}

		#menu-panel {
			position: fixed;
			bottom: 0;
			width: 100%;
			height: 25%;
			-webkit-transition:width 1s;
			transition:width 1s;
		}

		.menu-show {
			bottom: 0;
		}

		.menu-hide {
			bottom: -25%;
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
 	<canvas id="myCanvas"></canvas>

	<div id="menu-panel" class="menu-show container theme-showcase">
		<div id="editor-mode" class="label label-danger"></div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Properties</h3>
 			</div>
			<div class="panel-body">
				<form role="form">
					<div class="form-group">
						<label for="mass">Mass:</label>
						<input id="mass-slider-container" data-slider-id='mass-slider' type="text" data-slider-min="0" data-slider-max="10000" data-slider-step="500" data-slider-value="0"/>
					</div>

					<div class="form-group">
						<label for="mass">Bounce:</label>
						<input id="bounce-slider-container" data-slider-id='bounce-slider' type="text" data-slider-min="0" data-slider-max="1" data-slider-step="0.1" data-slider-value="0"/>
					</div>

					<div id="save-button" class="btn btn-primary"><?php LocalizedString('SAVE'); ?></div>
				</form>				
			</div>
		</div>



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