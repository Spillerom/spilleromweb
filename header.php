<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="css/header.css" type="text/css" />
		
		<meta charset="UTF-8">
		<title>Spillerom AS</title>

        <script type="text/javascript" src="js/jquery-1.5.2.js"></script>
        <script type="text/javascript" src="js/spillerom.js"></script>
	</head>

	<body>
		<div id="game-screen">
			<div class="layer">
				<div>
				</div>
			<div>
		
			<div class="layer">
				<?php for( $i=0; $i<5; $i++ ) { ?>
				<div class="nebou-blue" style="margin-left:<?php echo $i*400; ?>px">
					<div class="eyes"></div>
				</div>
				<?php } ?>
			</div>
			
			<div class="layer">
				<div class="nebou-blue">
					<div class="eyes"></div>
				</div>
			</div>
        </div>
	</body>
</html>
