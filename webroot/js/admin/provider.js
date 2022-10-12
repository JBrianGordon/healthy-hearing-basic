/***
 * Provider Tab Code -- used on admin/location/edit && clinic/locations/edit
 ***/

var provider = {
	errorStyle: {
		'background': 'rgba(200,100,100,.5)'
	},
	init: function() {
		var providerObj = this;

		// Add triggers for each of the methods.
		$('body').on('click', '.js-provider-license-add', function() { providerObj.addLicenseRow(this); return false; });
		$('body').on('click', '.js-provider-license-delete', function() { providerObj.removeLicenseRow(this); return false; });
		$('body').on('click', '.credLink', function() { providerObj.addCredential(this); return false; });
		$('body').on('click', '.js-provider-up', function() { providerObj.moveProviderUp(this); return false; });
		$('body').on('click', '.js-provider-down', function() { providerObj.moveProviderDown(this); return false; });
	},
	checkEmpty: function(obj) {
		var providerObj = this;
		// Check if the value of the input is greater than 0 (not empty)
		if ($(obj).val().length == 0) {
			// Apply all of the error styles to the input
			for (key in providerObj.errorStyle) {
				var style = providerObj.errorStyle[key];
				$(obj).css(key, style);
			} 
			return false;
		} else {
			// Remove all of the error styles from the input.
			for (key in providerObj.errorStyle) {
				$(obj).css(key, '');
			}
			return true;
		}

	},
	moveProviderUp: function(obj) {
		var providerDiv = $(obj).parents('.provider');
		var providerKey = providerDiv.attr('provider');
		var swapKey = parseInt(providerKey) - 1; 

		this.swapProviders(providerDiv, providerKey, swapKey);
	},
	moveProviderDown: function(obj) {
		var providerDiv = $(obj).parents('.provider');
		var providerKey = providerDiv.attr('provider');
		var swapKey = parseInt(providerKey) + 1; 

		this.swapProviders(providerDiv, providerKey, swapKey);
	},
	swapProviders: function(providerDiv, providerKey, swapKey) {
		// Check if there's a Provider with specified swap Key
		var swapProvider = $('.provider[provider=' + swapKey + ']');

		// Provider doesn't exist, let's get out.
		if (swapProvider.length == 0) {
			return false;
		} 

		// Change provider attr in div, and the order input.
		var swapDiv = swapProvider.first();
		swapDiv.attr('provider', providerKey);
		swapDiv.find('.provider-order').first().val(parseInt(providerKey) + 1);
		providerDiv.attr('provider', swapKey);
		providerDiv.find('.provider-order').first().val(parseInt(swapKey) + 1);

	},
	addCredential: function(obj) {
		var fieldName = $(obj).attr('field');
		var field = $('#' + fieldName);
		var credential = $(obj).html();

		// Make sure we don't add a credential that's already in the list.
		var credentialList = field.val().split(', ');
		if ($.inArray(credential, credentialList) > -1) {
			return false;
		}

		// If the field already has a credential, add it to the end.
		if (field.val().length > 0) {
			credential = ', ' + credential;
		}
		field.val(field.val() + credential);
		return false;
	},
	addLicenseRow: function(obj) {
		var providerObj = this;
		var row = $(obj).parents('tr');
		var newRow = $('<tr>');

		var newLicense = $(row).find('[name=provider-license]').first();
		var newIssueState = $(row).find('[name=provider-issue-state]').first();
		var newLicenseNumber = $(row).find('[name=provider-license-number]').first();
		var newExpDate = $(row).find('[name=provider-exp-date]').first();

		errorCheck = [];
		errorCheck.push(providerObj.checkEmpty(newLicense));
		errorCheck.push(providerObj.checkEmpty(newIssueState));
		errorCheck.push(providerObj.checkEmpty(newLicenseNumber));
		errorCheck.push(providerObj.checkEmpty(newExpDate));

		for (key in errorCheck) {
			if (errorCheck[key] === false) {
				return false;
			}
		}

		newRow.append('<td>' + newLicense.val() + '</td>');
		newRow.append('<td>' + newIssueState.val() + '</td>');
		newRow.append('<td>' + newLicenseNumber.val() + '</td>');
		newRow.append('<td>' + newExpDate.val() + '</td>');
		newRow.append('<td><button class="btn btn-md btn-danger js-provider-license-delete">delete</button></td>');
		row.before(newRow);

		// Clear out old values 
		newLicense.val('');
		newIssueState.val('');
		newLicenseNumber.val('');
		newExpDate.val('');

		this.parseLicenses(row.parent());
	},
	removeLicenseRow: function(obj) {
		var row = $(obj).parents('tr');
		var table = row.parent();
		row.remove();
		this.parseLicenses(table);
	},
	parseLicenses: function(table) {
		var providerId = $(table).find('.providerKey').first().val();
		var licenses = [];
		$(table).children('tr').each(function() {
			if (!$(this).is('.header') && !$(this).is('.footer')) {
				licenseTypeCol 			= $(this).children('td').first();
				licenseIssueStateCol 	= licenseTypeCol.next();
				licenseNumberCol 		= licenseIssueStateCol.next();
				licenseExpDateCol 		= licenseNumberCol.next();

				var isYhn = $(this).attr('yhn') == 1 ? true : false;
				var license = {
					'LicenseType': licenseTypeCol.html(),
					'IssueState': licenseIssueStateCol.html(),
					'LicenseNumber': licenseNumberCol.html(),
					'ExpDate': 	licenseExpDateCol.html(),					
					'yhn': isYhn
				};

				licenses.push(license);
			}
		});
		var jsonLicenses = JSON.stringify(licenses);
		$('#Provider' + providerId + 'Licenses').val(jsonLicenses);
	},
};

provider.init();

//Replace AUD with Audiologist
for(var i = 0; i < $(".provider").length; i++){
	if($("#Provider" + i + "AudOrHis").val() == "AUD"){
		$("#Provider" + i + "AudOrHis").val("Audiologist");
	}
}
