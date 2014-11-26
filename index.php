<!doctype html>
<html>
	<head>
		<?php require_once 'set_env.php'; ?>
		<link rel="stylesheet" href="css/default.css" type="text/css" />
		<?php if( strcmp($language, 'jp') == 0 ) { ?>
		<style type="text/css">
			#manaka #portfolio-button, #menu #contact-button {
				font-size: 22px;
			}
			#manaka #contact-button {
				margin-left: 650px;
			}
		</style>
		<?php } ?>
		<link rel="stylesheet" href="css/ponta.css" type="text/css" />
		
		<meta charset="UTF-8">
		<title><?php LocalizedString('PAGE_TITLE'); ?></title>

        <script type="text/javascript" src="js/jquery-1.6.1.js"></script>
        
        <!-- GENERAL INCLUDES -->
        <script type="text/javascript" src="js/spillerom.js"></script>
        
        <!-- PONTA SPESIFIC INCLUDES -->
        <script type="text/javascript" src="js/ponta.js"></script>
	</head>

	<body>
		<!-- CURRENT BACKGROUND DESIGN -->
		<?php require_once("ponta.php"); ?>
		
		<!-- CONTENT CONTAINERS -->
		<?php
		require_once("about.php");
		require_once("portfolio.php");
		require_once("mail-form.php");
		?>
		
		<!-- FLAGS
		<div id="flags-bar">
			<a href="http://localhost:8888/spilleromweb/?language=no">
				<img alt="Norsk" src="data/flag_no<?php GetFlagStatus($language=='no'); ?>.png">
			</a>
			<a href="http://localhost:8888/spilleromweb/?language=en">
				<img alt="English" src="data/flag_en<?php GetFlagStatus($language=='en'); ?>.png">
			</a>
			<a href="http://localhost:8888/spilleromweb/?language=jp">
				<img alt="日本語" src="data/flag_jp<?php GetFlagStatus($language=='jp'); ?>.png">
			</a>
		</div>
		-->
		<!-- MENU BAR -->
		<div id="manaka">
			<div id="background"></div>
			<div id="line"></div>
			<div id="menu">
				<div id="elements">
					<div id="portfolio-button">
						<?php LocalizedString('PORTFOLIO'); ?>
					</div>
				
					<!-- SOSIAL MEDIA LINKS -->
		        	<div id="company-logo-container">
		        		<div></div>
		        	</div>
		        	
					<div id="contact-button">
						<?php LocalizedString('CONTACT'); ?>
					</div>
				</div>
	        	
				<!-- SOSIAL MEDIA LINKS -->
				<ul id="social-media-links">
					<li id="twitter"></li>
					<li id="facebook"></li>
				</ul>
			</div>
		</div>
		
		<!-- SCREEN EFFECTS -->
		<div id="effects">
			<div id="splatt">
				<div id="sprite-1" class="sprite"></div>
				<div id="sprite-2" class="sprite"></div>
				<div id="sprite-3" class="sprite"></div>
				<div id="sprite-4" class="sprite"></div>
				<div id="sprite-5" class="sprite"></div>
			</div>
		</div>
	</body>
</html>