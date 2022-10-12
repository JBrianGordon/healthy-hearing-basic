import '../jquery/jquery.class.min';
//import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/modal';

var LocationReview = jQuery.Class.create({
		initialize: function(){
			//globals
			this.addReviewButton = '.show_clinic';
			this.updateDiv = '#review_error';
			this.submitButton = '#submit_review';
			this.modal = '#review_form';
			this.infoDiv = '#review_thank';
			this.modalThank = '#review_form_thankyou';
			this.subscribeButton = '#subscribe_button';
			this.newsletterForm = '#newsletter_form';
			this.subscribeError = '.subscribe_error';
			this.submittedReview = false;
			this.noThanksButton = '#renew-dismiss';
		},

		/**
		* Depending on if we've submitted a review open the thank you modal or the normal modal
		*/
		reviewButtonClick: function() {
			if (this.submittedReview) {
				jQuery(this.modalThank).modal('show');
			} else {
				jQuery(this.modal).modal('show');
			}
			return false;
		},
		/**
		* Confirm you want to hide the modal, if we haven't submitted the review.
		*/
		modalHide: function() {
			if (!this.submittedReview){
				var result = confirm('This review has not been saved. Are you sure you want to exit?');
				if (!result) {
					return false;
				}
				//Dismissed without submitting.
				dataLayer.hhTrackEvent('ReviewForm','review_dismissed_no_submit', document.location.pathname, 0, true);
			}
			return true;
		},

		/**
		* Submit the subscribe feature
		*/
		submitSubscribe: function() {
			jQuery.ajax({
					data: jQuery(this.subscribeButton).closest("form").serialize(),
					dataType:"text",
					success: jQuery.proxy(this.handleSubscribeRequest, this),
					type:"post",
					beforeSend: function() { jQuery('.newsletter_loading').show(); },
					complete: function() { jQuery('.newsletter_loading').hide(); },
					url:"/reviews/subscribe"
			});
			return false;
		},

		/**
		* Handle the request of the subscribe ajax.
		* @param mixed data returned by ajax call
		* @param textStatus the success/failure of request
		* @return void
		*/
		handleSubscribeRequest: function(data, textStatus) {
			if (data === '1') {
				dataLayer.hhTrackEvent('ReviewForm','newsletter_submit', document.location.pathname, 0, true);
				jQuery(this.subscribeError).html('');
				jQuery(this.newsletterForm).slideUp('400', jQuery.proxy(this.newsletterFinish, this));
				jQuery(this.noThanksButton).html('Dismiss');
				jQuery(this.subscribeButton).hide();
			} else {
				var text = "<div class='alert alert-danger' role='alert'>";
				text += data;
				text += "</div>";
				jQuery(this.subscribeError).html(text);
			}
		},

		/**
		* Update the text after the animation, pass in function through proxy
		*/
		newsletterFinish: function() {
			var text = "<p class='lead'>You've successfully subscribed! Thank you for taking the time to subscribe to our newsletter. Look for a confirmation email from us in your inbox.</p>";
			jQuery(this.newsletterForm).html(text);
			jQuery(this.newsletterForm).slideDown();
		},

		/**
		* Submit the like via Ajax
		*/
		submitReview: function(){
			jQuery.ajax({
					data:jQuery(this.submitButton).closest("form").serialize(),
					dataType:"text",
					success: jQuery.proxy(this.handleRequest, this),
					type:"post",
					beforeSend: function() { jQuery('.loading').show(); },
					complete: function() { jQuery('.loading').hide(); },
					url:"/reviews/edit"
			});
			return false;
		},

		/**
		* Handle the form submit return
		*
		* @param mixed data returned by ajax call
		* @param textStatus the success/failure of request
		* @return void
		*/
		handleRequest: function(data, textStatus){
			if (data === '1') {
				dataLayer.hhTrackEvent('ReviewForm','review_submitted', document.location.pathname, 0, true);
				this.submittedReview = true;
				jQuery(this.modal).modal('hide');
				jQuery(this.modalThank).modal('show');
			} else {
				var text = "<div class='alert alert-danger' role='alert'>";
				//var text = "<div class='label label-danger'>";
				text += data;
				text += "</div>";
				jQuery(this.updateDiv).html(text);
			}
		},

		/**
		* Start the listeners
		*/
		startListeners: function() {
			jQuery(this.submitButton).on('click',jQuery.proxy(this.submitReview, this));
			jQuery(this.subscribeButton).on('click',jQuery.proxy(this.submitSubscribe, this));
			jQuery(this.modal).on('hide.bs.modal', jQuery.proxy(this.modalHide, this));
			jQuery(this.addReviewButton).on('click',jQuery.proxy(this.reviewButtonClick, this));
		}
});

window.LR = new LocationReview();
LR.startListeners();