// Online hearing test logic
// Results JSON object includes:
// answers, email, firstName, emailSymptoms,
// firstName, lastName, hearingResult
/*** TODO: check this when online hearing test view built out ***/
import './common';

class OnlineHearingTest {
	constructor(results = null, mobile = false, responsive = false) {
		this.results = results || null;
		this.mobile = mobile;
		this.responsive = responsive;
		this.debug = false;
		this.fastAdvance = true;
		this.lastPage = this.numberOfQuestions = document.querySelectorAll('.test-page').length - 1;
		this.totalPages = this.lastPage + 1;
		this.resultsDiv = '#Results';
		this.testCounter = '#test-counter';
		this.modal = '#HearingTest';
		this.startTest = '#start-test';
		this.currentPage = 0;

		if (this.mobile) { // turn off fast advance in mobile
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
			"normal": {
				"div": "#test-result-normal"
			},
			"possible": {
				"div": "#test-result-possible"
			},
			"significant": {
				"div": "#test-result-significant"
			}
		};

		document.querySelectorAll('.test-yes-no-radio').forEach((element) => {
			element.addEventListener('click', this.radioClick.bind(this));
		});

		document.querySelectorAll('.answer-detail').forEach((element) => {
			element.addEventListener('click', this.detailClick.bind(this));
		});

		document.querySelector(this.modal).addEventListener('hide.bs.modal', this.modalHide.bind(this));

		this.start();
	}

	modalHide(e) {
		if (!this.completed()) {
			const result = confirm('You have not completed the online hearing test, are you sure?');
			if (!result) {
				e.preventDefault();
			}
		}
		return true;
	}

	radioClick(event) {
		this.log('radioClick');
		if (this.fastAdvance) {
			const target = event.target;
			if (target.checked) {
				const page = target.getAttribute('page');
				this.nextButton(page);
			}
		} else {
			this.log('fastAdvance disabled.');
		}
	}

	start() {
		this.log('start');
		if (this.completed()) {
			this.showResult(); // show results page
		} else {
			this.showPage(0, true); // start page with no transition
		}
	}

	showPage(page, instant) {
		instant = instant || false;
		if (this.mobile) {
			instant = true;
		}
		this.log(`showPage: ${page} instant: ${instant}`);
		const fade_duration = 400;
		const number = parseInt(page);

		if (number < 0) {
			return false; // do nothing
		}

		if (number >= 0 && number < this.lastPage) {
			const questionNumber = number + 1;
			document.querySelector(this.testCounter).textContent = `Question ${questionNumber} of ${this.numberOfQuestions}`;
		} else {
			document.querySelector(this.testCounter).textContent = 'Almost done!';
		}
		const testpage = `#test-page-${page}`;
		if (!instant) {
			document.querySelectorAll(".test-page").forEach(element => {
				element.style.transitionDuration = `${fade_duration}ms`;
				element.style.opacity = 0;
			});
			setTimeout(() => {
				document.querySelectorAll(".test-page").forEach(element => {
					element.style.transitionDuration = "0ms";
					element.style.display = "none";
				});
				document.querySelector(testpage).style.display = "block";
				document.querySelector(testpage).style.transitionDuration = `${fade_duration}ms`;
				document.querySelector(testpage).style.opacity = 1;
			}, fade_duration + 50);
		} else {
			document.querySelectorAll(".test-page").forEach(element => {
				element.style.display = "none";
			});
			document.querySelector(testpage).style.display = "block";
		}
		if (this.mobile) {
			this.scrollTo(testpage);
		}
		this.currentPage = page;
	}

	reset() {
		const firstPage = document.querySelector('#test-page-0');
		firstPage.style.opacity = 1;
		this.log('reset');
		this.results = {
			answers: [],
			firstName: '',
			lastName: '',
			email: '',
			hearingResult: '',
			emailSymptoms: []
		};
		this.start(); // start from the beginning
	}

	nextButton(page) {
		this.log('nextButton: ' + page);
		page = parseInt(page);
		if (this.processAnswer(page)) {
			if (page === this.lastPage) {
				const finalResults = this.getResults();
				// Save the test in the database
				this.saveTest(finalResults);
				this.showResult();
			} else {
				this.showPage(page + 1);
			}
		} else {
			this.showPage(page, true); // no transition
		}
	}

	prevButton(page) {
		this.log('prevButton: ' + page);
		page = parseInt(page);
		if (page !== 0) {
			this.showPage(page - 1);
		}
	}

	getTestResult() {
		const totalScore = this.results.answers.reduce((a, b) => a + b, 0);
		this.log('Total Score: ' + totalScore);

		switch (totalScore) {
			case 0:
			case 1:
			case 2:
				this.results.hearingResult = 'normal';
				break;
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
				this.results.hearingResult = 'possible';
				break;
			default:
				this.results.hearingResult = 'significant';
				break;
		}
	}

	getResult() {
		return this.results.hearingResult;
	}

	processAnswer(page) {
		this.log('ProcessAnswer: ' + page);
		let retval = false;
		const answerIndex = page;

		if (page === 10) { // Contact: First name, last name, email
			this.results.firstName = document.querySelector('#inputFirstName').value;
			this.results.lastName = document.querySelector('#inputLastName').value;
			this.results.email = document.querySelector('#testerEmail').value;
			if (this.contactInfoFilled()) {
				retval = true;
			}

		} else { // Quiz questions
			retval = true;
			if(document.querySelector(`input[name=quizAnswers${page}]:checked`) !== null){
				switch (document.querySelector(`input[name=quizAnswers${page}]:checked`).value) {
					case 'sometimes': this.results.answers[answerIndex] = 1; break;
					case 'yes': this.results.answers[answerIndex] = 2; break;
					case 'no': this.results.answers[answerIndex] = 0; break;
				}
			} else {
				retval = false;
			}

			if (page === 9) { // Last quiz question
				this.getTestResult();

				// Get selected symptoms for email
				this.results.emailSymptoms = this.symptoms.filter((symptom, index) => {
					return this.results.answers[index] > 0;
				});

				// Populate hidden results field for form submit POST
				document.querySelector('#url-result').value = this.getResults();
			}
		}
		this.log('processAnswer outcome: ' + retval);
		if (!retval) {
			document.querySelector("#error-" + page).style.display = 'block';
		} else {
			document.querySelector("#error-" + page).style.display = 'none';
		}
		return retval;
	}

	completed() {
		if(this.results !== null){
			return this.results.answers.length === this.numberOfQuestions && this.contactInfoFilled();
		} else {
			return false;
		}
	}

	contactInfoFilled() {
		return this.results.firstName.length > 0 && this.results.lastName.length > 0 && this.results.email.length > 0;
	}

	showResult() {
		this.log('showResult');
		if (this.mobile) {
			document.querySelector('#HearingTest').style.display = 'none';
		} else {
			$("#HearingTest").modal('hide');
		}
		if (!this.completed()) {
			this.reset();
			if (this.mobile) {
				document.querySelector('#HearingTest').style.display = 'block';
			} else {
				$("#HearingTest").modal('show');
			}
			return;
		}

		// Hide the start div
		document.querySelector(this.startTest).style.display = 'none';
		// Show the actual results
		this.resultSelect();
		// Update the h1 line.
		this.updateHeader();
		// Auto-fill newsletter sign-up form
		this.autoFillNewsletterForm();
		// Add reCaptcha script to page
		this.addRecaptcha();
		// Show the results
		$(this.resultsDiv).slideDown();
		window.scrollTo(0,0);
	}

	updateHeader() {
		document.querySelector('#start-h1').style.display = 'none';
		document.querySelector('#result-h2').style.display = 'block';
	}

	resultSelect(result) {
		result = this.getResult();
		// Hide all the results
		Object.entries(this.resultKey).forEach(([key, value]) => {
			document.querySelector(value.div).style.display = 'none';
		});
		// Show the result
		document.querySelector(this.resultKey[result].div).style.display = 'block';
		document.querySelector('#test-result').style.display = 'block';
		return true;
	}

	getResults() {
		return JSON.stringify(this.results);
	}

	async saveTest(results) {
		this.log('Saving Test');
		try {
			const csrfToken = document.getElementsByName("_csrfToken")[0].value;
			await fetch("/QuizResults/emailResults", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-CSRF-Token": csrfToken
				},
				body: JSON.stringify({ results, _csrfToken: csrfToken })
			});
		} catch (error) {
			console.error("Error saving test:", error);
		}
	}

	scrollTo(selector, offset = 50) {
		this.log(`scrollTo: ${selector} offset: ${offset}`);
		const element = document.querySelector(selector);
		if (element) {
			window.scrollTo({
				top: element.offsetTop - offset,
				behavior: 'smooth'
			});
			return true;
		}
		return false;
	}

	autoFillNewsletterForm() {
		const newsletterForm = document.querySelector("#HearingTestNewsletterForm");
		if (newsletterForm) {
			document.querySelector('#newsletterFirstName').value = this.results.firstName;
			document.querySelector('#newsletterLastName').value = this.results.lastName;
			document.querySelector('#newsletterEmail').value = this.results.email;
		}
	}

	addRecaptcha() {
		const recaptchaScript = document.createElement('script');
		recaptchaScript.src = 'https://www.google.com/recaptcha/api.js';
		document.head.appendChild(recaptchaScript);
	}

	log(message) {
		if (this.debug) {
			try {
				console.log(message);
			} catch (e) {}
		}
	}
}

// 'online_answers' defined in online_hearing_test.ctp, true indicates previous test results
let answers = online_answers ?? null;

window.HT = new OnlineHearingTest(answers, false, true);

function onSubmit(e) {
  e.preventDefault();
  if (!grecaptcha.getResponse()) {
    grecaptcha.execute();
  }
}

function addSubmitListener() {
  const form = document.getElementById('HearingTestNewsletterForm');
  if (form !== null) {
    form.addEventListener('submit', onSubmit);
  }
}

function submitNewsletterSignup() {
  const form = document.querySelector("#HearingTestNewsletterForm");
  if (form.reportValidity()) {
    const formData = new FormData(form);
    fetch("/quiz_results/newsletter_subscribe", {
      method: "POST",
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success === true) {
          form.style.display = "none";
          document.querySelector("#subscribe_success").style.display = "block";
        } else {
          document.querySelector("#subscribe_error").innerHTML = data.errorMessage;
          document.querySelector("#subscribe_error").style.display = "block";
        }
        grecaptcha.reset();
      })
      .catch(error => {
        console.error("Error:", error);
      });
  }
}

addSubmitListener();