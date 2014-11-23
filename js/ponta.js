

//
var SPLATT_EFFECT = 1;

//
var nightLevel = 0;
var scrollDirection = 0;
var isEffectActive = false;

// 
leftScroll = function(speed) {
	// 
	$("div#game-screen div#layer-2").animate({
		marginLeft: '+=50px'
	}, speed, function() {
	});
	
	// 
	$("div#game-screen div#layer-3").animate({
		marginLeft: '+=350px'
	}, speed, function() {
	});
	
	// 
	if( !$.browser.webkit ) {
		$("div#game-screen div#layer-4").animate({
			marginLeft: '+=800px'
		}, speed, function() {
		});
	}
}

// 
rightScroll = function(speed) {
	// 
	$("div#game-screen div#layer-2").animate({
		marginLeft: '-=50px'
	}, speed, function() {
	});
	
	// 
	$("div#game-screen div#layer-3").animate({
		marginLeft: '-=350px'
	}, speed, function() {
	});
	
	// 
	if( !$.browser.webkit ) {
		$("div#game-screen div#layer-4").animate({
			marginLeft: '-=800px'
		}, speed, function() {
		});
	}
}

// 
handleScroll = function(speed) {
	if( scrollDirection == 0 ) {
		rightScroll(speed);
	} else {
		leftScroll(speed);
	}
	
	scrollDirection ^= 1;
}

// 
resetScroll = function(speed) {
	// 
	$("div#game-screen div#layer-2").animate({
		marginLeft: '0px'
	}, speed, function() {
	});
	
	// 
	$("div#game-screen div#layer-3").animate({
		marginLeft: '0px'
	}, speed, function() {
	});
	
	// 
	$("div#game-screen div#layer-4").animate({
		marginLeft: '0px'
	}, speed, function() {
	});
}

//
setNightLevel = function(step, speed) {
	
	// 
	$(".night").animate({
		opacity: (step)
	}, speed, function() {
	});
}

//
handleNight = function(speed) {
	nightLevel ^= 1;
	setNightLevel(nightLevel, speed);
}

// 
showScreenEffect = function(type) {
	if( !isEffectActive) {
		isEffectActive = true;
		
		switch(type) {
	
			// 
			case SPLATT_EFFECT:
				$("#effects").css("opacity", 100).show().animate({"opacity": 100}, 3000,function() {
					
				}).animate({
					"opacity": 0
				}, 1000, function() {
					$("#effects").hide();
					isEffectActive = false;
				});
			
			break;
		}
	}
}

// 
$(document).ready(function() {
	// 
	setNightLevel(nightLevel, 1000);
	
	$("#effects").hide();
	
	// 
	if( $.browser.webkit ) {
		$("#layer-4").hide();
	}
	
	// 
	$("div#nebou-pink").click(function() {
		showScreenEffect(SPLATT_EFFECT);
	});
	
	// 
	$("div#nebou-blue").click(function() {
		handleScroll(1000);
	});
	
	// 
	$("div#nebou-purple").click(function() {
		handleScroll(1000);
	});
	
	// 
	$("div#nebou-ninja").click(function() {
		handleNight(1000);
	});
	
	// 
	$("div#nebou-usagi").click(function() {
		handleScroll(1000);
	});
});