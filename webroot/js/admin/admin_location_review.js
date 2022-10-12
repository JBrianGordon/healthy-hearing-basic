import '../common/common';

var review = {
	init: function() {
		var reviewObj = this;
		$('.js-copy-left').on("click", function() { reviewObj.copyLeft(this); return false; });
		$('.js-link').on("click", function() { reviewObj.link(this); return false; });
		$('.js-add-all').on("click", function() { reviewObj.addAll(); return false; });
		$('.js-add-provider').on("click", function() { reviewObj.addProvider(this); return false; });
		$('.js-link-delete').on("click", function() { reviewObj.deleteProvider(this); return false; });
		$('.js-link-cancel').on("click", function() { reviewObj.linkCancel(this); return false; });
		reviewObj.highlightDifferences();
	},
	copyLeft: function(obj) {
		var hhInput = $(obj).parent().prev().children('input,textarea').first();
		var yhnInput = $(obj).parent().next().children('input,textarea').first();

		// Copy the data from the YHN side
		hhInput.val(yhnInput.val());

		this.highlightDifferences();
		return false;
	},
	link: function(obj) {
		$('.hh-link, .yhn-link').toggleClass('hidden');
		$('.js-link-delete').toggleClass('hidden');
		$('.js-add-provider').toggleClass('hidden');
		if ($(obj).is('.yhn-link')) {
			$(obj).parents('tr').addClass('js-linking');
			$(obj).siblings('.js-link-cancel').toggleClass('hidden');
		} else {
			$('.js-linking').find('input.import-data').each(function(i) {
				var field = $(this).attr('field');
				var fieldVal = $(this).val();
				// Copy the value over
				var toInput = $(obj).parents('tr').find('input.import-data[field='+field+']');
				toInput.val(fieldVal);
			});

			// Remove the "linked" row
			$('tr.js-linking').remove();

			this.highlightDifferences();
		}
	},
	linkCancel: function(obj) {
		$('.hh-link, .yhn-link').toggleClass('hidden');
		$('.js-link-delete').toggleClass('hidden');
		$('.js-add-provider').toggleClass('hidden');
		$(obj).toggleClass('hidden');
		$('.js-linking').removeClass('.js-linking');
	},
	addAll: function() {
		$('.provider-table .js-copy-left').click();
	},
	highlightDifferences: function() {
		$('tr').each(function() {
			var input1 = $(this).find('input,textarea').first();
			var input2 = $(this).find('input,textarea').last();
			if (input1.length) {
				if (input1.val() == input2.val()) {
					input2.removeClass('different').addClass('match');
				} else {
					input2.removeClass('match').addClass('different');
				}
			}
		});
	},
	deleteProvider: function(obj) {
		var row = $(obj).parents('tr');
		var providerId = row.attr('provider');
		if (confirm('Are you sure you want to delete this provider?')) {
			$.ajax({
				url: '/admin/imports/delete_provider/' + providerId,
				success: function(data) {
					row.remove();
				}

			});
		}
	},
	addProvider: function(obj) {
		var row = $(obj).parents('tr');
		var providerCount = row.attr('providercount');
		$('[providercount='+providerCount+'] .js-copy-left').click();
	}
};

review.init();
