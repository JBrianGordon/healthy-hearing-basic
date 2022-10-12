// Online hearing test logic
// Results JSON object includes:
// answers, email, firstName, emailSymptoms,
// firstName, lastName, hearingResult
import './common';
import '../jquery/jquery.class.min';
import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/modal';

var OnlineHearingTest = jQuery.Class.create({
	initialize: function(results, mobile, responsive) {
		results = results || null;
		mobile = mobile || false;
		responsive = responsive || false;
		if (!results) {
			this.reset();
		} else {
			this.results = results;
		}

		this.mobile = mobile;
		this.responsive = responsive;
		this.debug = false;
		this.fastAdvance = true;
		this.lastPage = this.numberOfQuestions = jQuery(".test-page").length - 1;
		this.totalPages = this.lastPage + 1;
		this.resultsDiv = '#Results';
		this.testCounter = '#test-counter';
		this.modal = '#HearingTest';
		this.startTest = '#start-test';
		this.currentPage = 0;

		if (this.mobile) { //turn off fast advance in mobile
			this.fastAdvance = false;
		}

		this.symptoms = [
			'Difficulty hearing on the telephone',
			'Misunderstanding, disagreements or being encouraged to have hearing checked by loved ones',
			'Difficulty hearing the television without increasing the volume',
			'Difficulty understanding women\'s and children\'s voices',
			'A history of excessive noise exposure',
			'Perception of people mumbling or not speaking clearly',
			'Difficulty hearing in noisy places',
			'Missing what was said but pretending to hear',
			'Tinnitus (ringing, buzzing or other noises in the ears)',
			'Avoidance of social situations, conversations and hobbies you once enjoyed'
		];

		this.resultKey = {
			"normal" : {
				"div": "#test-result-normal"
			},
			"possible" : {
				"div": "#test-result-possible"
			},
			"significant" : {
				"div": "#test-result-significant"
			}
		};

		jQuery(".test-yes-no-radio").on("click",jQuery.proxy(this.radioClick, this));
		jQuery(".answer-detail").on("click",jQuery.proxy(this.detailClick, this));
		jQuery(this.modal).on('hide.bs.modal', jQuery.proxy(this.modalHide, this));
		this.start();
	},

	/**
	* Confirm you want to hide the modal, if we haven't finished the test.
	*/
	modalHide: function() {
		if (!this.completed()){
			var result = confirm('You have not completed the online hearing test, are you sure?');
			if (!result) {
				return false;
			}
		}
		return true;
	},

	/**
	* Click on the radio will go to next page.
	*/
	radioClick: function(event) {
		this.log('radioClick');
		if (this.fastAdvance) {
			if (jQuery(event.target).is(':checked')) {
				var page = jQuery(event.target).attr('page');
				this.nextButton(page);
			}
		} else {
			this.log('fastAdvance disabled.');
		}
	},

	/**
	* Look through the answers
	* and decide what page to show.
	*/
	start: function() {
		this.log('start');
		if (this.completed()) {
			this.showResult(); // show results page
		} else {
			this.showPage(0, true); //start page no transition
		}
	},

	/**
	* Show the actual page passed in, 0 index based.
	*/
	showPage: function(page, instant) {
		instant = instant || false;
		if (this.mobile) {
			instant = true;
		}
		this.log('showPage: ' + page + ' instant: ' + instant);
		var fade_duration = 400;
		var number = parseInt(page);

		if (number < 0) {
			return false; //do nothing;
		}

		if (number >= 0 && number < this.lastPage) {
			var questionNumber = number + 1;
			jQuery(this.testCounter).html("Question " + questionNumber + " of " + this.numberOfQuestions);
		} else {
			jQuery(this.testCounter).html('Almost done!');
		}
		var testpage = "#test-page-" + page;
		if (!instant) {
			jQuery(".test-page").fadeOut(fade_duration);
			jQuery(testpage).delay(fade_duration + 50).fadeIn(fade_duration);
		} else {
			jQuery(".test-page").hide();
			jQuery(testpage).show();
		}
		if (this.mobile) {
			this.scrollTo(testpage);
		}
		this.currentPage = page;
	},

	/**
	* Reset the test
	*/
	reset: function() {
		this.log('reset');
		this.results = {
			answers: [],
			firstName: '',
			lastName: '',
			email: '',
			hearingResult: '',
			emailSymptoms: []
		};
		this.start(); //start from beginning
	},

	/**
	* Save the answers and decide what to do.
	*/
	nextButton: function(page) {
		this.log('nextButton: ' + page);
		page = parseInt(page);
		if (this.processAnswer(page)) {
			if (page == this.lastPage){
				let finalResults = this.getResults();
				//Save the test in database
				this.saveTest(finalResults);
				this.showResult();
			} else {
				this.showPage(page + 1);
			}
		} else {
			this.showPage(page, true); //no transition
		}
	},

	/**
	* Save the answers and decide what to do.
	*/
	prevButton: function(page) {
		this.log('prevButton: ' + page);
		page = parseInt(page);
		if (page != 0) {
			this.showPage(page - 1);
		}
	},

	/**
	* Calculate test result (normal hearing, 
	* possible hearing loss, or significant hearing loss)
	* based upon question responses
	*/
	getTestResult: function() {
		var totalScore = this.results.answers.reduce(function (a, b) {
			return a + b;
		});
		this.log('Total Score: ' + totalScore);

		switch (totalScore) {
			case 0:
			case 1: 
			case 2: this.results.hearingResult = 'normal'; break;
			case 3: 
			case 4:
			case 5: 
			case 6:
			case 7:
			case 8:
			case 9: this.results.hearingResult = 'possible'; break;
			default: this.results.hearingResult = 'significant'; break;
		}
	},

	/**
	* Return the hearing result if we have one.
	*/
	getResult: function() {
		return this.results.hearingResult;
	},

	/**
	* Process and save the answer, return false if we don't have an answer.
	*/
	processAnswer: function(page){
		this.log('ProcessAnswer: ' + page);
		var retval = false;
		var answerIndex = page;

		if (page == 10) { // Contact: First name, last name, email
			this.results.firstName = jQuery('#inputFirstName').val();
			this.results.lastName = jQuery('#inputLastName').val();
			this.results.email = jQuery('#testerEmail').val();
			if (this.contactInfoFilled()) {
				retval = true;
			}

		} else { // Quiz questions
			retval = true;
			switch (jQuery('input[name=quizAnswers' + page + ']:checked').val()) {
				case 'sometimes' : this.results.answers[answerIndex] = 1; break;
				case 'yes' : this.results.answers[answerIndex] = 2; break;
				case 'no'  : this.results.answers[answerIndex] = 0; break;
				default : retval = false;
			}

			if (page == 9) { // Last quiz question
				this.getTestResult();

				// Get selected symptoms for email
				this.results.emailSymptoms = this.symptoms.filter(function (symptom, index) {
					return this[index] > 0;
				}, this.results.answers);

				// Populate hidden results field for form submit POST
				jQuery('#url-result').val(this.getResults());
			}
		}
		this.log('processAnswer outcome: ' + retval);
		if (!retval) {
			jQuery("#error-" + page).show();
		} else {
			jQuery("#error-" + page).hide();
		}
		return retval;
	},

	/**
	* boolean if we're completed.
	*/
	completed: function() {
		return ( (this.results.answers.length == this.numberOfQuestions) && (this.contactInfoFilled()) );
	},

	contactInfoFilled: function() {
		return (this.results.firstName.length > 0 && this.results.lastName.length > 0 && this.results.email.length > 0);
	},

	/**
	* Actually calculate and show the results based on the answer keys
	*/
	showResult: function() {
		this.log('showResult');
		if (this.mobile) {
			jQuery('#HearingTest').hide();
		} else {
			jQuery("#HearingTest").modal('hide');
		}
		if (!this.completed()) {
			this.reset();
			if (this.mobile) {
				jQuery('#HearingTest').show();
			} else {
				jQuery("#HearingTest").modal('show');
			}
			return;
		}

		// Hide the start div
		jQuery(this.startTest).hide();
		// Show the actual results
		this.resultSelect();
		// Update the h1 line.
		this.updateHeader();
		// Auto-fill newsletter sign-up form
		this.autoFillNewsletterForm();
		// Add reCaptcha script to page
		this.addRecaptcha();
		// Show the results
		jQuery(this.resultsDiv).slideDown();
		this.scrollTo(this.resultsDiv);
	},

	/**
	* Update the H1 tag of results
	*/
	updateHeader: function() {
		jQuery('#start-h1').hide();
		jQuery('#result-h2').show();
	},

	/**
	* Show the appropriate result div
	*/
	resultSelect: function(result) {
		result = this.getResult();
		//Hide all the results
		jQuery.each(this.resultKey, function(key, value) {
			jQuery(value.div).hide();
		});
		//Show the result
		jQuery(this.resultKey[result].div).show();
		jQuery('#test-result').show();
		return true;
	},

	/**
	* Get the results as a string so we can save and pass into urls.
	*/
	getResults: function() {
		return JSON.stringify(this.results);
	},

	/**
	* Save the test results in ajax.
	*/
	saveTest: function(results) {
		this.log('Saving Test');
		jQuery.ajax({
				type: "POST",
				data: {"results" : results},
				url: "/quiz_results/email_results"
		});
	},

	/**
	* Scroll to a position.
	*/
	scrollTo: function(selector, offset) {
		offset = offset || 50;
		this.log('scrollTo: ' + selector + ' offset: ' + offset);
		if (jQuery(selector)) {
			jQuery('html,body').animate({scrollTop: jQuery(selector).offset().top - offset},'slow');
			return true;
		}
		return false;
	},

	/**
	* Auto-fill newsletter subscribe form
	*/
	autoFillNewsletterForm: function() {
		if ($("#HearingTestNewsletterForm").length > 0) {
			$('#newsletterFirstName').val(this.results.firstName);
			$('#newsletterLastName').val(this.results.lastName);
			$('#newsletterEmail').val(this.results.email);
		}
	},

	/**
	* Add reCAPTCHA to newsletter sign-up form
	*/
	addRecaptcha: function() {
		var recaptchaScript = document.createElement('script');
		recaptchaScript.setAttribute('src','https://www.google.com/recaptcha/api.js');
		document.head.appendChild(recaptchaScript);
	},

	/**
	* log if we have debugging on.
	*/
	log: function(message) {
		if (this.debug) {
			try {
				console.log(message);
			} catch(e){}
		}
	}
});

var answers;
// 'online_answers' defined in online_hearing_test.ctp
if(typeof online_answers !== 'undefined'){
	answers = online_answers // previous test results
} else{
	answers = null;
}
window.HT = new OnlineHearingTest(answers, false, true);

addSubmitListener();

function onSubmit(e) {
	e.preventDefault();
	if (!grecaptcha.getResponse()) {
		grecaptcha.execute();
	}
}

function addSubmitListener() {
	var form = document.getElementById('HearingTestNewsletterForm');
	if (form !== null) {
		form.addEventListener('submit', onSubmit);
	}
}

function submitNewsletterSignup() {
	if ($("#HearingTestNewsletterForm").get(0).reportValidity()) {
		var formData = $("#HearingTestNewsletterForm").serialize();
		$.ajax({
			type: "POST",
			url: "/quiz_results/newsletter_subscribe",
			data: formData,
			dataType: "json",
			success: function(response) {
				if (response.success === true) {
					$("#HearingTestNewsletterForm").hide();
					$("#subscribe_success").show();
				} else {
					$("#subscribe_error").html(response.errorMessage).show();
				}
				grecaptcha.reset();
			}
		});
	}
}