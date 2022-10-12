
function onPageLoadQuickPick() {
	$('body').on('change', '#CaCallGroupRefusedNameQuickPick', function(){
		onChangeRefusedNameQuickPick();
	});
	$('body').on('change', '#CaCallGroupRefusedNameAgainQuickPick', function(){
		onChangeRefusedNameAgainQuickPick();
	});

	// Find closest clinics button
	$('body').on('click', '#findClosestLocations', function() {
		findClosestLocations($('#CaCallGroupPatientFullAddress').val());
	});

	// Load more clinics button
	$('body').on('click', '#loadMoreClinics', function() {
		loadMoreClinics();
	});

	$('body').on('change', '#CaCallGroupIsDirectBookWorking', function() {
		onChangeIsDirectBookWorking(this.value);
	});

	$('#CaCallGroupPatientAddress, #CaCallGroupPatientCity, #CaCallGroupPatientState, #CaCallGroupPatientZip').bind('keyup blur', function() {
		$('#CaCallGroupPatientFullAddress').val(
			$('#CaCallGroupPatientAddress').val() + ',' +
			$('#CaCallGroupPatientCity').val() + ',' +
			$('#CaCallGroupPatientState').val() + ',' +
			$('#CaCallGroupPatientZip').val());
	});
}

$(document).ready(function() {
	onPageLoadQuickPick();
});

/****
 * Start of Functions
 ****/

function onChangeRefusedNameQuickPick() {
	$('.refusedNameYesQuickPick').toggle();
}

function onChangeRefusedNameAgainQuickPick() {
	$('.refusedNameNoQuickPick, .refusedNameYesAgainQuickPick').toggle();
	updateVisibility();
}

var closestClinics;
var chosenClinic;
var clinicCounter = 0;
var searchInfo;

function findClosestLocations(originAddress) {
	$("#closestClinics").empty();

	closestClinics = [];
	clinicCounter = 0;

	var patientCityInput = $("#CaCallGroupPatientCity");
	var patientCity = $.trim(patientCityInput.val());
	var patientStateInput = $("#CaCallGroupPatientState");
	var patientState = $.trim($("#CaCallGroupPatientState").val());

	if ((patientCity.length > 0) && (patientState.length > 0)) {
		$.ajax({
			url:"/ca_calls/get_closest_clinics/"+originAddress,
			dataType: 'json',
			success: function(data) {
				searchInfo = data.pop();
				closestClinics = data;
				fixNoDirectionResults();
				displayClinicTemplates(closestClinics);
			}
		});
		$(".afterClinicFind").show();
		$(patientStateInput).add(patientCityInput).removeAttr('style');
	} else {
		$(patientStateInput).add(patientCityInput).css('border', '2px solid red');
		alert("Please enter a city and select a state before searching.");
	}
}

function clickedClinic(clinicDiv) {
	clinicCounter++;

	clinicIndex = clinicDiv.firstElementChild.getAttribute('value');
	chosenClinic = closestClinics[clinicIndex];

	$(".locationDistance").html(chosenClinic.distance.text);
	$(".locationTime").html(chosenClinic.duration.text);

	if (chosenClinic.distance.value === undefined || chosenClinic.duration.value === undefined) {
		$(".hasDirections").hide();
	} else {
		$(".hasDirections").show();
	}

	var numReviews = parseInt(chosenClinic.Location.reviews_approved, 10);
	switch (numReviews) {
		case 0:
			var ratingsReviewsText = "<strong>0</strong> reviews";
			break;
		case 1:
			var ratingsReviewsText = "an average rating of <strong>" + chosenClinic.Location.average_rating + " out of 5</strong> stars and <strong>1</strong> review";
			break;
		default:
			var ratingsReviewsText = "an average rating of <strong>" + chosenClinic.Location.average_rating + " out of 5</strong> stars and <strong>" + chosenClinic.Location.reviews_approved + "</strong> reviews";
	}

	$(".locationRating").html(ratingsReviewsText);

	$(clinicDiv).css('background-color', '#78afc9');
	$(clinicDiv).siblings().css('background-color', 'transparent');

	if (clinicCounter > 1) {
		$(".firstClinic").hide();
		$(".subsequentClinic").show();
	} else {
		$(".firstClinic").show();
		$(".subsequentClinic").hide();
	}

	var locationId = $(clinicDiv).children("p[id*='locationId']").html();
	$("#CaCallGroupLocationId").val(locationId).trigger("change");

	if (clinicCounter % 3 === 0) {
		$("#purposeReminder").show();
		$("#ifNoCall").hide();
	} else {
		$("#purposeReminder").hide();
		$("#ifNoCall").show();
	}

	$(".scriptLocationAddress").html(
		chosenClinic.Location.address + ', '
		+ chosenClinic.Location.city + ', '
		+ chosenClinic.Location.state
	);

	if (chosenClinic.Location.direct_book_type == DIRECT_BOOK_NONE) {
		$('.nonDirectBookQuickPick').show();
		$('.directBookQuickPick').hide();
		$('.isDirectBookWorking').hide();
	} else {
		$('.directBookQuickPick').show();
		$('.nonDirectBookQuickPick').hide();
		$('.isDirectBookWorking').show();
		if (chosenClinic.Location.direct_book_type == DIRECT_BOOK_DM) {
			$('.directBookDm').show();
			$('.directBookBlueprintEarQ').hide();
		} else { // Blueprint or EarQ
			$('.directBookDm').hide();
			$('.directBookBlueprintEarQ').show();
			$('#directBookUrl').text(chosenClinic.Location.direct_book_url);
			$('#directBookUrl').attr('href', chosenClinic.Location.direct_book_url);
		}
	}
	updateVisibility();
}

function createClinicDiv(clinicData, index) {
	var clinicTemplate = [
		'<div id="clinic-div-',index,'" class="pl20">',
			'<input type="hidden" id="clinic-',index,'-number" value="',index,'">',
			'<p hidden id="clinic-',index,'-locationId">', clinicData.Location.id , '</p>',
			'<p class="mt5 mb5 clinic-',index,'-Title">', clinicData.Location.title,' (',clinicData.distance.text,' / ',clinicData.duration.text,')</p>',
			'<hr style="border-top: 2px solid gray;" class="m0">',
		'</div>'
	];
	if (index > 2) { // Only show first 3 clinics initially
		return $(clinicTemplate.join('')).hide();
	}
	return $(clinicTemplate.join(''));
}

function displayClinicTemplates(data) {
	var clinicDivs = $();

	data.forEach(function(item, i) {
		clinicDivs = clinicDivs.add(createClinicDiv(item, i));
	});

	$('#closestClinics').append(clinicDivs);

	$("[id^=clinic-div-]").click(function() {
		clickedClinic(this);
	});
	$("[id^=clinic-div-]:first").click();
}

function loadMoreClinics() {
	var nextSetOfClinics = $("#closestClinics div:visible:last").nextAll().slice(0,3);

	if (nextSetOfClinics.length < 1) {
		if (searchInfo.numZipSearches > 1) {
			alert("I'm sorry, these are the closest clinics we could find in our directory for the address you provided. Would you like to end the call or check another address?");
		} else {
			alert("I'm sorry, we don't have any other clinics in our directory within "+searchInfo.searchRadius+" miles of the address provided. Would you like to end the call or check another address?");
		}
	} else {
		nextSetOfClinics.show();
	}
}

function fixNoDirectionResults() {
	closestClinics.forEach(function(item, i) {
		if (item.status !== "OK") {
			item.duration = {text: "Google can't provide directions"};
			item.distance = {text: "Google can't provide directions"};
		}
	});
}

function onChangeIsDirectBookWorking(answer) {
	if (answer == 0) { // NO
		$('.directBookQuickPick').hide();
		$('.nonDirectBookQuickPick').show();
	} else { // YES
		$('.directBookQuickPick').show();
		$('.nonDirectBookQuickPick').hide();
	}
	updateVisibility();
}
