
// 
var MENU_SPEED = 300;

var isHiding = false;
var isWindowOpen = true;

//
hideLayer = function(speed) {
	isHiding = true;
	
	$("div#game-screen div#layer-4").animate({
		"opacity": 0
	}, speed, function() {
	});
}

//
showLayer = function(speed) {
	isHiding = false;
	
	$("div#game-screen div#layer-4").animate({
		"opacity": 1
	}, speed, function() {
	});
}

// 
handleLayerVisibility = function(speed) {
	// 
	if( ($(window).height() < 800) && (isWindowOpen) ) {
		if( !isHiding) {
			hideLayer(speed);
		}
	} else {
		if( isHiding) {
			showLayer(speed);
		}
	}
}

// 
$(document).ready(function() {
	// RESET 
	$("div#mail-form").hide();
	$("div#portfolio").hide();
	$("div#about").show();
	
	handleLayerVisibility(0);

	// 
	$(window).resize(function() {
		handleLayerVisibility(MENU_SPEED);
	});

	// 
	$("div#game-screen").click(function() {
		$("div#about").hide(MENU_SPEED);
		$("div#mail-form").hide(MENU_SPEED);
		$("div#portfolio").hide(MENU_SPEED);
		
		isWindowOpen = false;		
		
		handleLayerVisibility(MENU_SPEED);
	});
	
	// 
	$("div#portfolio-button").click(function() {
		$("div#about").hide(MENU_SPEED);
		$("div#mail-form").hide(MENU_SPEED);
		$("div#portfolio").show(MENU_SPEED);
		
		isWindowOpen = true;		
		
		handleLayerVisibility(MENU_SPEED);
	});
	
	// 
	$("div#company-logo-container").click(function() {
		$("div#mail-form").hide(MENU_SPEED);
		$("div#portfolio").hide(MENU_SPEED);
		$("div#about").show(MENU_SPEED);
		
		isWindowOpen = true;		
		
		handleLayerVisibility(MENU_SPEED);
	});
	
	// 
	$("div#contact-button").click(function() {
		$("div#about").hide(MENU_SPEED);
		$("div#portfolio").hide(MENU_SPEED);
		$("div#mail-form").show(MENU_SPEED);
		
		isWindowOpen = true;		
		
		handleLayerVisibility(MENU_SPEED);
	});

	//
	$("#mail-form #submit-button").click(function() {
		// 
		$.post("ajax/send_email.php", { name:$('#input-name').val(), email:$('#input-email').val(), message:$('#input-message').val()  }, function(dataResult) {
			//
			if(dataResult=='ok') {
				
				$("#status-message").fadeTo(200, 0.1, function() {
					$(this).html('Thank you!').addClass('status-message').fadeTo(900, 1, function() {
						$("div#mail-form").hide();
					});
				});
				
			} else {
				$("#status-message").fadeTo(200, 0.1, function() {

					if(dataResult='send-error') {
						$(this).html('Sending message failed..').addClass('error-message').fadeTo(500, 1);
					} else if(dataResult='empty-field-error') {
						$(this).html('Please fill out all fields..').addClass('error-message').fadeTo(500, 1);
					}
				});
			}
		});
		
	});
	
	// 
	$('#manaka #social-media-links #twitter').click(function() {
		window.location = "http://twitter.com/#!/spillerom";
	});	
	$('#manaka #social-media-links #facebook').click(function() {
		window.location = "http://www.facebook.com/#!/pages/Spillerom/190823858245";
	});	
});
