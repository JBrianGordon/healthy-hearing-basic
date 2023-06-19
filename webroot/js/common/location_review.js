class LocationReview {
	constructor() {
		//globals
		this.addReviewButton = '.show_clinic';
		this.updateDiv = '#review_error';
		this.submitButton = '#submitReview';
		this.modal = '#reviewSubmitModal';
		/*** TODO: uncomment when thank you modal functionality built: ***
		this.infoDiv = '#review_thank';
		this.modalThank = '#review_form_thankyou';
		this.subscribeButton = '#subscribe_button';
		*/
		this.newsletterForm = '#newsletter_form';
		this.subscribeError = '.subscribe_error';
		this.submittedReview = false;
		this.noThanksButton = '#renew-dismiss';
	}

	reviewButtonClick() {
	  if (this.submittedReview) {
	    document.querySelector(this.modalThank).classList.add('show');
	  } else {
	    document.querySelector(this.modal).classList.add('show');
	  }
	  return false;
	}

	modalHide() {
	  if (!this.submittedReview) {
	    var result = confirm('This review has not been saved. Are you sure you want to exit?');
	    if (!result) {
	      return false;
	    }
	    // Dismissed without submitting.
	    dataLayer.hhTrackEvent('ReviewForm', 'review_dismissed_no_submit', document.location.pathname, 0, true);
	  }
	  return true;
	}

	submitSubscribe() {
	  const formData = new FormData(document.querySelector(this.subscribeButton).closest('form'));

	  fetch('/reviews/subscribe', {
	    method: 'POST',
	    body: formData
	  })
	    .then(response => response.text())
	    .then(data => this.handleSubscribeRequest(data))
	    .catch(error => console.log(error));

	  document.querySelector('.newsletter_loading').style.display = 'block';

	  return false;
	}

	handleSubscribeRequest(data, textStatus) {
	  if (data === '1') {
	    dataLayer.hhTrackEvent('ReviewForm', 'newsletter_submit', document.location.pathname, 0, true);
	    document.querySelector(this.subscribeError).innerHTML = '';
	    document.querySelector(this.newsletterForm).slideUp(400, () => this.newsletterFinish());
	    document.querySelector(this.noThanksButton).textContent = 'Dismiss';
	    document.querySelector(this.subscribeButton).style.display = 'none';
	  } else {
	    const errorText = `<div class='alert alert-danger' role='alert'>${data}</div>`;
	    document.querySelector(this.subscribeError).innerHTML = errorText;
	  }
	}

	newsletterFinish() {
	  const text = "<p class='lead'>You've successfully subscribed! Thank you for taking the time to subscribe to our newsletter. Look for a confirmation email from us in your inbox.</p>";
	  document.querySelector(this.newsletterForm).innerHTML = text;
	  document.querySelector(this.newsletterForm).slideDown();
	}

	submitReview() {
	  const form = document.querySelector(this.submitButton).closest("form");
	  const formData = new FormData(form);

	  fetch("/reviews/edit", {
	    method: "POST",
	    body: formData
	  })
	    .then(response => response.text())
	    .then(data => this.handleRequest(data))
	    .catch(error => console.error(error));

	  return false;
	}

	handleRequest(data, textStatus) {
	  if (data === '1') {
	    dataLayer.hhTrackEvent('ReviewForm', 'review_submitted', document.location.pathname, 0, true);
	    this.submittedReview = true;
	    this.modal.hide();
	    this.modalThank.show();
	  } else {
	    const text = `<div class="alert alert-danger" role="alert">${data}</div>`;
	    this.updateDiv.innerHTML = text;
	  }
	}

	startListeners() {
	  document.querySelector(this.submitButton).addEventListener('click', this.submitReview.bind(this));
	  /*** TODO: uncomment when thank you modal functionality built: ***
	  document.querySelector(this.subscribeButton).addEventListener('click', this.submitSubscribe.bind(this));
	  document.querySelector(this.modal).addEventListener('hide.bs.modal', this.modalHide.bind(this));*/
	  document.querySelector(this.addReviewButton).addEventListener('click', this.reviewButtonClick.bind(this));
	}
}

window.LR = new LocationReview();
LR.startListeners();