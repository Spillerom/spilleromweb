<div id="game-screen">
	<!--  -->
	<div id="layer-1" class="layer">
		<!-- RENDER SKY -->
		<div class="background-sky">
			<div class="day"></div>
			<div class="night"></div>
		</div>
	</div>
	
	<!--  -->
	<div id="layer-2" class="layer">
		
		<!-- RENDER CLOUDS -->
		<?php
		// Use an array for positions because we want to place them randomly
		$positions = array(500, 2500);
		foreach( $positions as &$position ) { 
		?>
		<div class="background-cloud" style="margin-left:<?php echo $position; ?>px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		<?php } ?>
		
		<!-- RENDER FAR AWAY OBJECTS -->
		<?php
		// Use an array for positions because we want to place them randomly
		$positions = array(1500);
		foreach( $positions as &$position ) { 
		?>
		<div class="far-away-object" style="margin-left:<?php echo $position; ?>px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		<?php } ?>
		
		<!-- RENDER MOUNTAINS -->
		<?php
		// Use an array for positions because we want to place them randomly
		$positions = array(1000);
		foreach( $positions as &$position ) { 
		?>
		<div class="background-mountain" style="margin-left:<?php echo $position; ?>px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		<?php } ?>
		
		<!-- RENDER MOUNTAINS DOWN -->
		<?php
		// Use an array for positions because we want to place them randomly
		$positions = array(-300);
		foreach( $positions as &$position ) { 
		?>
		<div class="background-mountain-down" style="margin-left:<?php echo $position; ?>px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		<?php } ?>
		
	</div>
	
	<div id="layer-3" class="layer">
	
		<!-- RENDER BACKGROUND BUSHES -->
		<div class="background-bush">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		
		<!-- RENDER FOREGROUND BUSHES -->
		<?php
		// Use an array for positions because we want to place them randomly
		$positions = array(200, 800, 1300, 1700, 2400);
		foreach( $positions as &$position ) { 
		?>
		<div class="foreground-bush" style="margin-left:<?php echo $position; ?>px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		<?php } ?>
		
		<!-- RENDER GROUND -->
		<div class="ground">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		
		<!-- NEBOU BLUE -->
		<div id="nebou-blue" class="nebou" style="margin-left:50px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		
		<!-- NEBOU NINJA -->
		<div id="nebou-ninja" class="nebou" style="margin-left:700px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		
		<!-- NEBOU PURPLE -->
		<div id="nebou-purple" class="nebou" style="margin-left:1200px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		
		<!-- NEBOU PINK -->
		<div id="nebou-pink" class="nebou" style="margin-left:1600px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		
		<!-- NEBOU USAGI -->
		<div id="nebou-usagi" class="nebou" style="margin-left:2000px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
		
	</div>

	<!-- -->
	<div id="layer-4" class="layer">
		<!-- FOREGROUND -->
		<div class="foreground" style="margin-left:0px">
			<div class="day"></div>
			<div class="night"></div>
		</div>
	</div>
	
</div>