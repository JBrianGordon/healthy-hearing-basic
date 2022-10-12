import './common';
import '../jquery/jquery.class.min';
import {directBookBtn} from './direct_book_btn';
import './appt_request';
import './responsive_slider';

directBookBtn();

var LocationResults = jQuery.Class.create({
		initialize: function(){
			//globals
			this.updateDiv = '#clinic-results';
			this.filterResults = '#filter-results';
			this.resultText = '#result-text';
			this.sort = '';
			this.filters = [];
			this.filterString = "";

			if (this.getFilters().length != 0) {
				this.submitFilters();
			}
		},

		/**
		* Submit the filters via ajax
		*/
		submitFilters: function() {
			jQuery.ajax({
				data: {
					"f": this.generateFilterString(),
					"s": this.getSort()
				},
				url: location.pathname,
				success: jQuery.proxy(this.handleRequest, this),
				beforeSend: function() { jQuery(this.filterResults).html(''); jQuery('.loading').show(); },
				complete: function() { jQuery('.loading').hide();},
			});
		},

		/**
		* Handle the form submit return
		*
		* @param mixed data returned by ajax call
		* @param textStatus the success/failure of request
		* @return void
		*/
		handleRequest: function(data, textStatus){
			//update the results
			jQuery(this.updateDiv).html(data);

			var filter_count = this.filters.length;
			var clinics = jQuery('.clinic-info').length;
			var cplural = 's';
			if (clinics == 1) {
				cplural = '';
			}
			var fplural = 's';
			if (filter_count == 1) {
				fplural = '';
			}
			//Update the results text on the top based on clinics found and selections.
			jQuery(this.filterResults).html('<i>We found ' + clinics + ' clinic'+ cplural +' based on your selection'+ fplural +'.</i> <a href="'+ location.pathname +'" class="btn btn-default btn-xs">Reset</a>');

			//Update the error if we have zero clinics bansed on how many filters we have selected.
			if (clinics == 0) {
				if (filter_count == 1) {
					jQuery(this.resultText).html('<i>No clinics found with your selection. Please uncheck the filter above.</i>');
				} else {
					jQuery(this.resultText).html('<i>No clinics found with your selections. Please uncheck some filters above.</i>');
				}
			}
		},

		/**
		* Get the filters from the checkboxes available on the page
		*/
		getFilters: function() {
			var filters = [];
			jQuery('input.filter-box:checkbox:checked').each(function () {
				filters.push($(this).val());
			});
			this.filters = filters;
			return this.filters;
		},

		/**
		* Get the filters from the checkboxes available on the page
		* @return selected sort value
		*/
		getSort: function() {
			this.sort = jQuery('input.sort-box:radio:checked').val();
			return this.sort;
		},

		/**
		* Generate a json string to pass as a variable
		* @return string of filters
		*/
		generateFilterString: function() {
			this.getFilters();
			this.filterString = "[";
			for (var i = 0; i < this.filters.length; i++) {
				if (i != 0) {
					this.filterString += ",";
				}
				this.filterString += '"' + this.filters[i] + '"';
			}
			this.filterString += "]";
			return this.filterString;
		},

		/**
		* Start the listeners
		*/
		startListeners: function() {
			jQuery(".filter-box").on("click", function(){jQuery.proxy(LResults.submitFilters())});
			jQuery(".sort-box").on("click", function(){jQuery.proxy(LResults.submitFilters())});
		}
});

window.LResults = new LocationResults();
LResults.startListeners();

//Add class to review text (and not star spans) to allow CSS underlines
var reviewLinks = document.getElementsByClassName("reviews"),
	linkRegex = /\(\d+( Review[s]?)\)/gm;
for(var i = 0; i < reviewLinks.length; i++){
	if(reviewLinks[i].childElementCount > 0){
		var currentLink = reviewLinks[i].children;
		var linkText = currentLink[0].innerHTML.match(linkRegex);
		if(linkText){
			var updatedLink = currentLink[0].innerHTML.replace(linkRegex, ""),
				newLink = "<p class='link-text'>" + linkText + "</p>",
				updatedLink = updatedLink + newLink;
			currentLink[0].innerHTML = updatedLink;
		}
	}
}

//Add recaptcha script on form click
$(document).on("focus","#apptRequestModal input",function(){
	if(!$("#apptRequestModal").hasClass("focused")) {
		$("#apptRequestModal").addClass("focused");
		var recaptchaScript = document.createElement('script');
		recaptchaScript.setAttribute('src','https://www.google.com/recaptcha/api.js');
		document.head.appendChild(recaptchaScript);
		$("#apptRequestModal input").off("focus");
	}
})

function onMessage(event) {
	// Check sender origin to be trusted
	if (event.origin !== "https://booking.myearq.com") return;
	// Do not save appointment if no clinic id
	if (directBookClinicId == 0) return;
	if (event.data.func == "goThankYouAppointment") {
		$.ajax({
			url:"/ca_calls/ajax_add_earq_appt/"+directBookClinicId,
			type:"post",
			dataType: 'json',
			success: function(data, textStatus) {
				if (data == "error") {
					console.log('Failed to save EarQ appointment for '+directBookClinicId);
				}
				directBookClinicId = 0;
			},
		});
	}
}
