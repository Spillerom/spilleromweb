<?php require_once 'set_env.php'; ?><!DOCTYPE HTML>
<html>
<head>
<style>
	html, body, #canvas {
		width: 100%;
		height: 100%;
		margin: 0;
		padding: 0;
		overflow: hidden;
	}
</style>
</head>
<body>
<canvas id="myCanvas" width="100%" height="100%"></canvas>
<script src="js/editor.js" type="text/javascript"></script>
<div id="debug-mode" class="button"><?php LocalizedString('DEBUG_MODE'); ?></div>
</body>
</html>