import '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap/tab';

$(document).ready(function() {
	// Display the selected tab
	var hash = window.location.hash;
	if (hash.length > 0) {
		var parentTabId = $('a[href="' + hash + '"]').closest('.tab-pane').attr('id');
		if (typeof parentTabId != 'undefined') {
			// If tab is nested with a parent tab, click both
			$('a[href="#' + parentTabId + '"]').trigger('click');
		}
		$('a[href="' + hash + '"]').trigger('click');
	}

	// When a tab is clicked, change the URL to our new hash
	$('.nav-tabs a').on('click', function() {
		var scrollmem = $('body').scrollTop() || $('html').scrollTop();
		window.location.hash = this.hash;
		$('html,body').scrollTop(scrollmem);
	});

	// On submit, make any validation errors on tabs visible
	$('input[type=submit]').on('click', function() {
		if ($(this).closest('form').get(0).checkValidity() == false) {
			displayErrorsOnTabs();
		}
	});
});

// Make validation errors on tabs more visible
function displayErrorsOnTabs() {
	$('input:invalid').each(function() {
		$(this).parent('div').addClass('has-error');
	});
	$('input.form-error').each(function() {
		$(this).parent('div').addClass('has-error');
	});
	$('.nav-tabs li a').each(function() {
		var tab = $(this).attr('href');
		if ($(tab+' div.has-error').length || $(tab+' span.has-error').length || $(tab+' input.form-error').length) {
			$('a[href="' + tab + '"]').addClass('tab-has-error').click();
		}
	});
}
