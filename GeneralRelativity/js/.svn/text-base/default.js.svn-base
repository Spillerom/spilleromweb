
// 
var Settings = {
	CAROUSEL_LOOP_SPEED: 5000,
	TRANSITION_SPEED: 300,
	NUM_QUESTIONS: 3
};

var currentView = 0;

var answeredQuestions = [];
var numQuizMistakes = 0;
var currentScore = 0;


// 
var Player = function() {
	// 
	this.facebook = false;
	this.facebookId = '';
	this.facebookProfileImage = '';
	this.score = '';
	this.email = '';
	this.phone = '';
	this.firstName = '';
	this.lastName = '';
	this.address = '';
	this.postCode = '';
	this.city = '';
	this.lastDateAttended = getMySqlDate();

	// 
	this.getJSON = function() {
		var jsonString = JSON.stringify(this);
		return jsonString;
	};
};

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// HELPER FUNCTIONS:
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 
var startVideo = function(youTubeId) {
	var html = '<iframe width="100%" height="100%" src="' + youTubeId + '?autoplay=1" frameborder="0" allowfullscreen></iframe><div class="heightfix-16_9"></div>';
	$('#video-container').html(html);
	$('#lightboxvideo-view').show();
};

// 
var isMouseOverCarousel = false;

// 
var currentCarouselBanner = 0;
var handleCarouselBannerTransition = function(speed) {
	var numCarouselElements = $('.carousel-element').length;

	if( !isMouseOverCarousel ) {
		currentCarouselBanner = (currentCarouselBanner + 1) % numCarouselElements;
		$('.carousel-element').fadeOut(speed);
		$('.carousel-element').eq(currentCarouselBanner).fadeIn(speed);

		$('#page-indicator li').css('background-color', '#ffffff');
		$('#page-indicator li').eq(currentCarouselBanner).css('background-color', '#cfcfcf');
	}
};

var initCarousel = function() {
	handleCarouselBannerTransition(0);
	setInterval(changeCarouselBanner, Settings.CAROUSEL_LOOP_SPEED);
};
var changeCarouselBanner = function() {
	handleCarouselBannerTransition(Settings.TRANSITION_SPEED);
};

// 
var getMySqlDate = function() {
	var dd = new Date();
	var yy = dd.getYear();
	var mm = dd.getMonth() + 1;
	var dd = dd.getDate();
	if (yy < 2000) { yy += 1900; }
	if (mm < 10) { mm = "0" + mm; }
	if (dd < 10) { dd = "0" + dd; }
	var retval = yy + "-" + mm + "-" + dd;
	return retval;
};

//
var fetchFacebookUserCredetials = function(response, doneCallback) {
	// 
	FB.api('/me', function(response) {
		// 
		var player = new Player();

		player.facebook = true;
		player.facebookId = response.id;
		player.firstName = response.first_name;
		player.lastName = response.last_name;
		player.facebookPicture = response.picture;
		player.email = response.email;
		player.score = Math.max(0, currentScore - numQuizMistakes);

		// 
		doneCallback(player);
	});
};

// 
var collectUserDateFromFormFields = function(doneCallback) {
		// 
		var player = new Player();

		player.facebook = false;
		player.firstName = $('#first-name').val();
		player.lastName = $('#last-name').val();
		player.email = $('#email').val();
		player.phone = $('#email').val();
		player.address = $('#address').val();
		player.postCode = $('#post-code').val();
		player.city = $('#city').val();
		player.score = currentScore;

		// 
		doneCallback(player);
};

// 
var registerPlayer = function(player, doneCallback) {
	// 
	var handleRegistration = function(player) {
		$.post("ajax/registerPlayer.php", { _player:escape(player.getJSON()) }, function(dataResult) {
			var returnCode = JSON.parse(dataResult);
			if( !returnCode.status ) {
				console.log(returnCode.message);
			}
			doneCallback();
		});		
	};

	//
	if( (!player.facebook)  ) {
		if( (player!=undefined) && (player.firstName!='') && (player.lastName!='') && (player.email!='') && (player.phone!='') ) {
			handleRegistration(player);
		} else {
			alert('Alle felter må fylles ut.');
		}
	} else {
		handleRegistration(player);
	}
};

// 
var setCorrectAnswer = function(questionNode, alternativeNode) {
	// if( $.inArray(questionNode.index(), answeredQuestions) == -1 ) {
		// 
		currentScore += 5;

		// 
		answeredQuestions.push(questionNode.index());

		//
		var progress = answeredQuestions.length;
		var fullWidth = $('#progress-bar div').eq(1).width();

		//
		$('#progress-bar div').eq(0).width((Math.min(3, Math.max(0, progress)) / Settings.NUM_QUESTIONS) * fullWidth);
		$('#player-num-answered-questions').text(progress)

		// 
		alternativeNode.removeClass('button');
		alternativeNode.addClass('green-button');
	// }
}

// 
var setWrongAnswer = function(node) {
	node.removeClass('button');
	node.addClass('red-button');
	numQuizMistakes++;
}

// 
var displayConfirmationView　= function() {
	$('#quiz-view').hide();
	$('#registrationform-view').hide();

	$('#completeregistration-view').show();
};

// 
$(document).ready(function() {

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// EVENTS:
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//
	// QUIZ EVENTS:
	//
	
	// HANDLE QUESTIONS:
	$('#quiz-view .question .alternatives li').click(function() {
		// 
		var currentQuestionNode = $(this).parent().parent();
		var correctAnswer = parseInt(currentQuestionNode.find('.metadata').text());

		//currentQuestionNode.find('li').removeClass('red-button');
		if( $.inArray(currentQuestionNode.index(), answeredQuestions) == -1 ) {
			currentQuestionNode.find('li').removeClass('red-button');
			currentQuestionNode.find('li').addClass('button');
			// 
			if( $(this).index() == correctAnswer ) {
				setCorrectAnswer(currentQuestionNode, $(this));
			} else {
				setWrongAnswer($(this));
			}
		}

	});

	// 
	$('#submit-manually').click(function() {
		$('#quiz-view').hide();
		$('#registrationform-view').show();
	});

	// 
	$('#registrationform-view #submit').click(function() {
		collectUserDateFromFormFields(function(player) {
			registerPlayer(player, function() {
				displayConfirmationView();
			});
		});
	});
	
	//
	// MAP EVENTS:
	//
	
	// SETUP SOUNDS:
	$('.trashcan').each(function(i) {
		var soundFilePath = $(this).find('.metadata').text();
		$("#jquery-jplayer-" + i).jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					wav: soundFilePath + '.wav',
					mp3: soundFilePath + '.mp3'
				});
			},
			preload: "none", 
			swfPath: "",
			//solution: "flash, html",
			supplied: "mp3, wav",
			cssSelectorAncestor: "",
			cssSelector: {
				play: "#play-" + i,
				pause: "#pause-" + i,
			},
			size: {
				width: "0",
				height: "0"
			}
		});
	});

	// 
	$("#dropdown-button").click(function() {
		$("#nav").toggle(300);
	});

	//
	// CAROUSEL EVENTS:
	//

	// 
	$('.carousel-element, #links-view .viewport').click(function() {
		var youTubeUrl = $(this).find('.metadata').text();
		if( youTubeUrl != '' ) {
			startVideo(youTubeUrl);
		} else {
			window.location = "index.php?view=ambassadeurs";
		}
	});

	// 
	$('.carousel-element').on('mouseenter', function() {
		isMouseOverCarousel = true;
		console.log(isMouseOverCarousel);
	}).on('mouseleave', function() {
		isMouseOverCarousel = false;
		console.log(isMouseOverCarousel);
	});

	//
	$('#carousel-view ul li').click(function() {
		if( currentCarouselBanner != $(this).index() ) {
			currentCarouselBanner = $(this).index();
			$('.carousel-element').fadeOut(Settings.TRANSITION_SPEED);
			$('.carousel-element').eq(currentCarouselBanner).fadeIn(Settings.TRANSITION_SPEED);
		}
	});


	//
	// LIGHTBOX VIEW EVENTS:
	//

	// 
	$('#lightboxvideo-view .transparent-background').click(function() {
		$('#lightboxvideo-view').fadeOut(Settings.TRANSITION_SPEED, function() {
			$('#video-container').empty();
		});
	});


	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// "void main()":
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	initCarousel();
});