import '../common/common';
import '../jquery/jplayer/jquery.jplayer.min';
import '../common/play_media';
import {questionsOnLoad} from './ca_call_questions';

var locationTitle = '';
var pageLoadComplete = false;
var DIRECT_BOOK_NONE = DIRECT_BOOK_NONE ? DIRECT_BOOK_NONE : '';

function onPageLoad() {
	$('body').on('change', '#CaCallGroupTopicWarranty, #CaCallGroupTopicAidLost', function() {
		// Check the statuses of both of the related checkboxes.
		var warrantyChecked = $('#CaCallGroupTopicWarranty').is(':checked');
		var aidLostChecked	= $('#CaCallGroupTopicAidLost').is(':checked');

		// If either of these are checked, show the 'How Old is your Hearing Aid' dialog.
		if (warrantyChecked || aidLostChecked) {
			$('.aid_age_topic').removeClass('hidden');
		} else {
			$('.aid_age_topic').addClass('hidden');
		}

		// Trigger the change event for the age dialog, to make sure the correct (hidden) checkboxes are checked.
		$('#CaCallGroupHearingAidAge').trigger("change");
	});

	$('body').on('change', '#CaCallGroupHearingAidAge', function() {
		var aidAge			= $(this).val();
		var warrantyChecked	= $('#CaCallGroupTopicWarranty').is(':checked');
		var aidLostChecked	= $('#CaCallGroupTopicAidLost').is(':checked');

		// Set the hidden checkboxes based on what topics are checked, and the age of the hearing aid.
		$('#CaCallGroupTopicAidLostOld').prop('checked', (aidLostChecked && aidAge == 'old'));
		$('#CaCallGroupTopicAidLostNew').prop('checked', (aidLostChecked && aidAge == 'new'));
		$('#CaCallGroupTopicWarrantyOld').prop('checked', (warrantyChecked && aidAge == 'old'));
		$('#CaCallGroupTopicWarrantyNew').prop('checked', (warrantyChecked && aidAge == 'new')).trigger("change");
	});

	$('body').on('change', '#CaCallGroupTopicWantsAppt', function() {
		onChangeTopicWantsAppt(this.checked);
	});

	$('body').on('change', '#CaCallGroupWantsHearingTest', function() {
		onChangeProspect(null);
	});

	$('body').on('change', '[id^=CaCallGroupTopic]', function() {
		onChangeTopic();
	});

	$('body').on('change', '#CaCallGroupLocationId', function(){
		onChangeLocationId(this.value);
	});
	$('body').on('change', '#CaCallCallType', function(){
		onChangeCallType(this.value);
	});
	$('body').on('change', '#CaCallGroupIsPatient', function(){
		onChangeIsPatient(this.checked);
	});
	$('body').on('change', '#CaCallGroupProspect', function(){
		onChangeProspect(this.value);
	});
	$('body').on('change', '#CaCallGroupScore', function(){
		onChangeScore(this.value);
	});
	$('body').on('change', '#CaCallGroupSearch', function(){
		onChangeGroupSearch(this.value);
	});
	$('body').on('change', '#CaCallGroupCallerFirstName', function(){
		onChangeCallerFirstName(this.value);
	});
	$('body').on('change', '#CaCallGroupCallerLastName', function(){
		onChangeCallerLastName(this.value);
	});
	$('body').on('change', '#CaCallGroupCallerPhone', function(){
		onChangeCallerPhone(this.value);
	});
	$('body').on('change', '#CaCallGroupPatientFirstName', function(){
		onChangePatientInfo();
	});
	$('body').on('change', '#CaCallGroupPatientLastName', function(){
		onChangePatientInfo();
	});
	$('body').on('keyup change', '#CaCallGroupFrontDeskName', function(){
		onChangeFrontDeskName(this.value);
	});
	$('body').on('change', '[id^=CaCallGroupApptDate]', function(){
		onChangeApptDate();
	});
	$('body').on('change', '#CaCallGroupConsumerConsent', function(){
		onChangeConsumerConsent(this.value);
	});
	$('body').on('change', '#CaCallGroupDidClinicAnswer, #CaCallGroupDidClinicAnswerUnknown', function(){
		onChangeDidClinicAnswer(this.value);
	});
	$('body').on('change', '#CaCallGroupDidTheyAnswerVm', function(){
		onChangeDidTheyAnswerVm(this.value);
	});
	$('body').on('change', '#CaCallGroupDidTheyAnswerFollowup, #CaCallGroupDidTheyAnswerFollowup2', function(){
		onChangeDidTheyAnswerFollowup(this.value);
	});
	$('body').on('change', '#CaCallGroupDidConsumerAnswer', function(){
		onChangeDidConsumerAnswer(this.value);
	});
	$('body').on('change', '#CaCallGroupDidConsumerAnswer2', function(){
		onChangeDidConsumerAnswer2(this.value);
	});
	$('body').on('change', '#CaCallGroupDidTheyWantHelp', function(){
		onChangeDidTheyWantHelp(this.value);
	});
	$('body').on('change', '#CaCallGroupDidClinicContactConsumer', function(){
		onChangeDidClinicContactConsumer(this.value);
	});
	$('body').on('change', '#CaCallIsWrongNumber', function(){
		if ($('#CaCallIsWrongNumber').prop('checked')) {
			$('.valid_number').hide();
		} else {
			$('.valid_number').show();
		}
		updateVisibility();
	});
	$('body').on('change', '#CaCallGroupRefusedName', function(){
		onChangeRefusedName();
	});
	$('body').on('change', '#CaCallGroupDidClinicRefuse', function(){
		onChangeDidClinicRefuse();
	});

	// Cancel Button
	$('body').on('click', '#cancelBtn', function() {
		var caCallGroupId = $("#CaCallGroupId").val();
		$.ajax({
			url:"/ca_calls/unlock_call_group/"+caCallGroupId,
			dataType: 'json',
			success: function(data, textStatus) {
				if (data['unlock_status'] === true) {
					window.location = '/admin/ca_call_groups/outbound';
				}
			}
		});
	});

	// Disconnect & Unlock Button
	$('body').on('click', '#disconnectedBtn', function() {
		// The "disconnected" button was clicked
		// Make sure the Notes field is filled in
		if ($.trim($('[id^=CaCallGroupCaCallGroupNote]').val())) {
			var callType = $("#CaCallCallType").val();
			if ($.inArray(callType, [CALL_TYPE_OUTBOUND_CLINIC, CALL_TYPE_OUTBOUND_CALLER]) != -1) {
				// If an outbound call was disconnected, set the next call date 24 hours in the future.
				callDate = new Date();
				callDate.setDate(callDate.getDate() + 1);
				// Dis-disable the scheduled call date fields
				$('[id^=CaCallGroupScheduledCallDate]').attr('disabled', false);
				// Set the fields using our handy function
				setDateField('CaCallGroupScheduledCallDate', callDate);
			}
			if ($.inArray(callType, [CALL_TYPE_INBOUND, CALL_TYPE_VM_CALLBACK_CLINIC, CALL_TYPE_VM_CALLBACK_CONSUMER, CALL_TYPE_INBOUND_QUICK_PICK]) != -1) {
				// If an new incoming call or VM followup call was disconnected, submit the form without validation.
				// This will just save the call in our database in case they call back.
				$("#CaCallGroupStatus").val(STATUS_INCOMPLETE);
				$("#CaCallGroupScore").val(SCORE_DISCONNECTED);
			}
			$("#CaCallForm").submit();
		} else {
			$("#note-required").modal("show");
		}
	});

	// Mark as Spam button
	$('body').on('click', '#spamBtn', function() {
		$("#CaCallGroupIsSpam").val(true);
		$("#CaCallForm").submit();
	});

	//Delete Button
	$('body').on('click', '#deleteBtn', function() {
		// The "delete" button was clicked. Display the confirmation modal.
		$("#delete-modal").modal("show");
	});

	//Submit Button
	$('body').on('click', '#submitBtn', function() {
		// The "save" button was clicked
		// Verify that we have a valid clinic value
		validateLocationId();
		// Verify we have a valid prospect value
		validateProspect();
		// Calculate status
		calculateStatus();
		// If topics are hidden, remove the custom validation
		if ($('#CaCallGroupTopicParts').is(":hidden")) {
			$('#CaCallGroupTopicParts').get(0).setCustomValidity('');
		}
	});

	// Unlock Button
	$('body').on('click', '#unlockBtn', function() {
		var caCallGroupId = $("#CaCallGroupId").val();
		$.ajax({
			url:"/ca_calls/unlock_call_group/"+caCallGroupId,
			type:"post",
			dataType: 'json',
			success: function(data, textStatus) {
				if (data['unlock_status'] === true) {
					onChangeGroupSearch(caCallGroupId);
				}
			},
		});
	});

	$('body').on('change', '#CaCallVoicemailFrom', function(){
		$('#CaCallCallType').val(this.value).trigger("change");
	});
}

$(document).ready(function() {
	onPageLoad();

	IS_CLINIC_LOOKUP_PAGE = typeof IS_CLINIC_LOOKUP_PAGE !== 'undefined' ? IS_CLINIC_LOOKUP_PAGE : false;
	IS_CALL_GROUP_EDIT_PAGE = typeof IS_CALL_GROUP_EDIT_PAGE !== 'undefined' ? IS_CALL_GROUP_EDIT_PAGE : false;

	doWeHaveLocationInitially();
	showOutcome();
	triggerChangeEvents();
	locationAutocomplete();
	pageLoadComplete = true;
});

/****
 * End of Events
 ****/


/****
 * Start of Functions
 ****/

function triggerChangeEvents(skipElements) {
	if (skipElements === undefined) {
		skipElements = [];
	}
	var elements = ['#CaCallGroupLocationId','#CaCallCallType','#CaCallGroupCallerFirstName','#CaCallGroupCallerLastName','#CaCallGroupCallerPhone','#CaCallGroupIsPatient',,'#CaCallGroupPatientFirstName','#CaCallGroupPatientLastName','#CaCallGroupProspect','#CaCallGroupFrontDeskName','#CaCallGroupScore','#CaCallGroupTopicWarranty','#CaCallIsWrongNumber','#CaCallGroupRefusedName'];
	for (var key in elements) {
		let element = elements[key];
		if (skipElements.indexOf(element) == -1) {
			$(element).trigger("change");
		}
	}
}

function locationAutocomplete() {
	$("#CaCallLocationSearch, #location_search").autocomplete({
		source: "/caautocomplete",
		minLength: "2",
		select: function(event, ui){
			if (ui.item.id) {
				$("#CaCallGroupLocationId").val(ui.item.id).trigger("change");
			}
		}
	});

}

function validateLocationId() {
	var locationSearchInput = "input[name*='location_search']";
	if ($(locationSearchInput).length == 0){
		return true;
	}
	var locationId = $.trim($("#CaCallGroupLocationId").val());
	if (locationId && (locationId > 0)) {
		$(locationSearchInput).get(0).setCustomValidity('');
	} else {
		$(locationSearchInput).get(0).setCustomValidity('Please select a valid clinic before saving.');
	}
}

function validateProspect() {
	if ($("#CaCallGroupProspect").length) {
		var isProspectInvalid = false;
		if ($("#CaCallGroupProspect").val() == PROSPECT_UNKNOWN) {
			if ($("#CaCallGroupDidClinicAnswerUnknown").val() == 'no') {
				// For unknown prospect, if clinic did not answer, save as non-prospect
				$("#CaCallGroupProspect").val(PROSPECT_NO);
			} else {
				// If clinic answered, agent should fill in correct prospect. Mark as invalid.
				isProspectInvalid = true;
			}
		}
		if (isProspectInvalid) {
			$('#CaCallGroupProspect').get(0).setCustomValidity('Must select a valid prospect before saving.');
		} else {
			$('#CaCallGroupProspect').get(0).setCustomValidity('');
		}
	}
}

function calculateStatus() {
	var callType = $("#CaCallCallType").val();
	var isVoicemailType = (callType == CALL_TYPE_VM_CALLBACK_CLINIC) || (callType == CALL_TYPE_VM_CALLBACK_CONSUMER);
	var calculateByScore = false;
	if (IS_CALL_GROUP_EDIT_PAGE) {
		// Do not automatically calculate a new status on the Edit Call Group page
	} else if ((callType == CALL_TYPE_FOLLOWUP_APPT) && !IS_CLINIC_LOOKUP_PAGE && ($("#CaCallGroupDidTheyAnswerFollowup").val() == 'no')) {
		// Clinic did not answer followup call
		if ($("#CaCallGroupClinicFollowupCount").val() < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_SET_APPT);
		} else {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_NO_ANSWER);
			$("#CaCallGroupPatientFollowupCount").val(0);
		}
	} else if ((callType == CALL_TYPE_FOLLOWUP_TENTATIVE_APPT) && !IS_CLINIC_LOOKUP_PAGE && ($("#CaCallGroupDidTheyAnswerFollowup").val() == 'no')) {
		// Clinic did not answer followup call
		if ($("#CaCallGroupClinicFollowupCount").val() < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
			$("#CaCallGroupStatus").val(STATUS_TENTATIVE_APPT);
		} else {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_NO_ANSWER);
			$("#CaCallGroupPatientFollowupCount").val(0);
		}
	} else if ((callType == CALL_TYPE_FOLLOWUP_APPT_REQUEST) && !IS_CLINIC_LOOKUP_PAGE && ($("#CaCallGroupDidTheyAnswerFollowup").val() == 'no')) {
		// Clinic did not answer followup call
		if ($("#CaCallGroupClinicFollowupCount").val() < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_APPT_REQUEST_FORM);
		} else {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_NO_ANSWER);
			$("#CaCallGroupPatientFollowupCount").val(0);
		}
	} else if ((callType == CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT) && !IS_CLINIC_LOOKUP_PAGE) {
		if ($("#CaCallGroupDidConsumerAnswer").val() == 'yes' && ($("#CaCallGroupDidTheyAnswerFollowup").val() == 'no')) {
			// Consumer answered but clinic did not. Next attempt will not be direct book.
			if ($("#CaCallGroupClinicFollowupCount").val() < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
				$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_APPT_REQUEST_FORM);
			} else {
				$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_NO_ANSWER);
				$("#CaCallGroupPatientFollowupCount").val(0);
			}
		} else if ($("#CaCallGroupDidConsumerAnswer").val() == 'no' && ($("#CaCallGroupDidTheyAnswerFollowup2").val() == 'no')) {
			// Neither consumer or clinic answered
			if ($("#CaCallGroupClinicFollowupCount").val() < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
				$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_APPT_REQUEST_FORM);
			} else {
				$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_NO_ANSWER);
				$("#CaCallGroupPatientFollowupCount").val(0);
			}
		} else {
			calculateByScore = true;
		}
	} else if (callType == CALL_TYPE_FOLLOWUP_NO_ANSWER) {
		if ($("#CaCallGroupDidTheyAnswerFollowup").val() == 'yes') {
			// Patient answered
			if ($("#CaCallGroupScore").val() == SCORE_APPT_SET) {
				$("#CaCallGroupStatus").val(STATUS_APPT_SET);
			} else {
				$("#CaCallGroupStatus").val(STATUS_MO_NO_ANSWER);
				$("#CaCallGroupScore").attr('disabled', false).val(SCORE_MISSED_OPPORTUNITY);

			}
		} else if ($("#CaCallGroupDidTheyAnswerFollowup").val() == 'vm') {
			// Left a voicemail
			$("#CaCallGroupStatus").val(STATUS_MO_NO_ANSWER);
			$("#CaCallGroupScore").attr('disabled', false).val(SCORE_MISSED_OPPORTUNITY);
		} else {
			// Patient did not answer
			if ($("#CaCallGroupPatientFollowupCount").val() < MAX_PATIENT_FOLLOWUP_ATTEMPTS) {
				$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_NO_ANSWER);
			} else {
				$("#CaCallGroupStatus").val(STATUS_MO_NO_ANSWER);
				$("#CaCallGroupScore").attr('disabled', false).val(SCORE_MISSED_OPPORTUNITY);
			}
		}
	} else if (callType == CALL_TYPE_OUTBOUND_CLINIC) {
		if (($("#CaCallGroupDidTheyAnswerOutbound").val() == 1) || IS_CLINIC_LOOKUP_PAGE) {
			if (($("#CaCallGroupQuestionVisitClinic").val() == Q_VISIT_CLINIC_DECLINED) ||
				($("#CaCallGroupQuestionWhatFor").val() == Q_WHAT_FOR_DECLINED) ||
				($("#CaCallGroupQuestionPurchase").val() == Q_PURCHASE_DECLINED) ||
				($("#CaCallGroupQuestionBrand").val() == Q_BRAND_DECLINED)) {
				// Clinic refused to answer our questions
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_DECLINED);
			} else if ($('#CaCallGroupQuestionVisitClinic').val() == Q_VISIT_CLINIC_NO_RESCHEDULED) {
				// Appointment is coming up ..
				$("#CaCallGroupStatus").val(STATUS_APPT_SET);
				$('[id^=CaCallGroupScheduledCallDate]').attr('disabled', false);
				onChangeApptDate();
			} else {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_COMPLETE);
			}
		} else {
			if ($("#CaCallGroupClinicOutboundCount").val() < MAX_CLINIC_OUTBOUND_ATTEMPTS) {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_ATTEMPTED);
			} else {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_TOO_MANY_ATTEMPTS);
			}
		}
	} else if (callType == CALL_TYPE_OUTBOUND_CALLER) {
		if ($("#CaCallGroupDidTheyAnswerOutbound").val() == 1) {
			if ($('#CaCallGroupQuestionVisitClinic').val() == Q_VISIT_CLINIC_NO_RESCHEDULED) {
				// Appointment is coming up ..
				$("#CaCallGroupStatus").val(STATUS_APPT_SET);
				$('[id^=CaCallGroupScheduledCallDate]').attr('disabled', false);
				onChangeApptDate();
			} else if (($("#CaCallGroupQuestionVisitClinic").val() == Q_VISIT_CLINIC_DECLINED) ||
				($("#CaCallGroupQuestionWhatFor").val() == Q_WHAT_FOR_DECLINED) ||
				($("#CaCallGroupQuestionPurchase").val() == Q_PURCHASE_DECLINED) ||
				($("#CaCallGroupQuestionBrand").val() == Q_BRAND_DECLINED)) {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CUST_DECLINED);
			} else {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CUST_SURVEY_COMPLETE);
			}
		} else {
			if ($("#CaCallGroupPatientOutboundCount").val() < MAX_PATIENT_OUTBOUND_ATTEMPTS) {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CUST_ATTEMPTED);
			} else {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CUST_TOO_MANY_ATTEMPTS);
			}
		}
	} else if (callType == CALL_TYPE_SURVEY_DIRECT) {
		if ($("#CaCallGroupDmHasApptInfo").val() == 1) {
			// DM had appt info
			if (($("#CaCallGroupQuestionVisitClinic").val() == Q_VISIT_CLINIC_DECLINED) ||
				($("#CaCallGroupQuestionWhatFor").val() == Q_WHAT_FOR_DECLINED) ||
				($("#CaCallGroupQuestionPurchase").val() == Q_PURCHASE_DECLINED) ||
				($("#CaCallGroupQuestionBrand").val() == Q_BRAND_DECLINED)) {
				// DM was missing some important info. Try calling clinic.
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_ATTEMPTED);
			} else if ($('#CaCallGroupQuestionVisitClinic').val() == Q_VISIT_CLINIC_NO_RESCHEDULED) {
				// Appointment is coming up ..
				$("#CaCallGroupStatus").val(STATUS_APPT_SET);
				$('[id^=CaCallGroupScheduledCallDate]').attr('disabled', false);
				onChangeApptDate();
			} else {
				$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_COMPLETE);
			}
		} else {
			// DM did not have appt info. Try calling clinic.
			$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_ATTEMPTED);
		}
	} else if (isVoicemailType && ($("#CaCallGroupDidTheyAnswerVm").val() == 'vm')) {
		$("#CaCallGroupStatus").val(STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS);
	} else if (isVoicemailType && (($("#CaCallGroupDidTheyAnswerVm").val() == 'no') || ($("#CaCallGroupDidTheyAnswerVm").val() == ''))) {
		if ($("#CaCallGroupVmOutboundCount").val() < MAX_VM_OUTBOUND_ATTEMPTS) {
			$("#CaCallGroupStatus").val(STATUS_VM_CALLBACK_ATTEMPTED);
		} else {
			$("#CaCallGroupStatus").val(STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS);
		}
	} else if (isVoicemailType && ($("#CaCallGroupDidTheyAnswerVm").val() == 'noAttempt')) {
		var vmCount = $("#CaCallGroupVmOutboundCount").val();
		$("#CaCallGroupVmOutboundCount").val(vmCount-1);
		$("#CaCallGroupStatus").val(STATUS_VM_CALLBACK_ATTEMPTED);
	} else if (callType == CALL_TYPE_VM_CALLBACK_INVALID) {
		$("#CaCallGroupStatus").val(STATUS_WRONG_NUMBER);
	} else if ($('#CaCallIsWrongNumber').prop('checked')) {
		$("#CaCallGroupStatus").val(STATUS_WRONG_NUMBER);
	} else if ($('#CaCallGroupRefusedNameAgainQuickPick').prop('checked')) {
		$("#CaCallGroupStatus").val(STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS);
	} else if ($("#CaCallGroupDidClinicAnswer").val() == 'cr') {
		$("#CaCallGroupStatus").val(STATUS_QUICK_PICK_CALLER_REFUSED_HELP);
	} else { // Inbound or Followup call
		calculateByScore = true;
	}

	if (calculateByScore) {
		var score = $("#CaCallGroupScore").val();
		var prospect = $("#CaCallGroupProspect").val();
		if (prospect == PROSPECT_NO) {
			$("#CaCallGroupStatus").val(STATUS_NON_PROSPECT);
		} else if ((score == SCORE_DISCONNECTED) || (prospect == PROSPECT_DISCONNECTED)) {
			$("#CaCallGroupStatus").val(STATUS_INCOMPLETE);
			$("#CaCallGroupScore").val(SCORE_DISCONNECTED);
		} else if (score == SCORE_NOT_REACHED) {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_SET_APPT);
		} else if ((score == SCORE_APPT_SET) || (score == SCORE_APPT_SET_DIRECT)) {
			$("#CaCallGroupStatus").val(STATUS_APPT_SET);
		} else if (score == SCORE_TENTATIVE_APPT) {
			$("#CaCallGroupStatus").val(STATUS_TENTATIVE_APPT);
		} else if (score == SCORE_MISSED_OPPORTUNITY) {
			$("#CaCallGroupStatus").val(STATUS_MISSED_OPPORTUNITY);
		} else {
			$("#CaCallGroupStatus").val(STATUS_NEW);
		}
	}
}
function onChangeLocationId(locationId) {
	doWeHaveLocationAndFrontDesk();
	if (locationId && (locationId > 0)) {
		$.ajax({
			url:"/ca_calls/get_location_data/"+locationId,
			dataType: 'json',
			success: function(data, textStatus) {
				handleLocationChange(data);
			},
		});
	} else {
		handleLocationChange(null);
	}
}
function handleLocationChange(data) {
	$(".locationLink").html(data ? data['link'] : '');
	$(".locationTitle").html(data ? data['title'] : '');
	locationTitle = data ? data['title'] : '';
	$(".locationAddress").html(data ? data['address'] : '');
	$(".locationPhone").html(data ? data['phone'] : '');
	$(".locationCovid").html(data && data['covid'] ? 'COVID-19 statement: '+data['covid'] : '');
	$(".locationLandmarks").html(data && data['landmarks'] ? 'Landmarks: '+data['landmarks'] : '');
	$(".andYhn").html(data && (data['isYhn'] == 1) ? 'and Your Hearing Network' : '');
	if (!$("#CaCallLocationSearch").val()) {
		if (data) {
			$("#CaCallLocationSearch").val(data['searchTitle']);
		}
	}
	if (data) {
		$("#CaCallGroupDirectBookType").val(data['directBookType']);
		$("#directBookUrl").text(data['directBookUrl']);
		$("#directBookUrl").attr('href', data['directBookUrl']);
	} else {
		$("#CaCallGroupDirectBookType").val(DIRECT_BOOK_NONE);
	}
	$(".locationCityStateStreet").html(data ? data['cityStateStreet'] : '');
	var hours = data ? data['hours'] : '';
	if (hours != '') {
		hours = '<u>Clinic hours</u><br>'+hours;
	}
	$(".locationHours").html(hours);
	var hoursToday = data ? data['hoursToday'] : '';
	if (hoursToday != '') {
		if (hoursToday == 'closed') {
			hoursToday = 'They are closed today.';
		} else {
			hoursToday = 'Their hours today are <strong>'+hoursToday+'</strong>.';
		}
	}
	$(".locationHoursToday").html(hoursToday);
	$('.locationCurrentTime').html(data ? data['currentTime'] : '');
	var locationTimezone = data ? data['timezone']: '';
	$("label[for='CaCallGroupApptDateMonth']").html("Appointment date/time ("+locationTimezone+")<br><small class='text-muted'>This is the clinic's timezone</small>");

	var locationId = data ? data['id'] : '';
	if (IS_CLINIC_LOOKUP_PAGE) {
		if (locationId) {
			$.ajax({
				url:"/ca_calls/get_previous_calls/"+locationId+"/"+1,
				type:"post",
				dataType: 'json',
				success: function(data, textStatus) {
					var count = Object.keys(data).length;
					if (count === 0) {
						// No followup calls found
						$("#CaCallGroupId").val('');
						$(".found-no-calls").show();
						$(".found-multiple-calls").hide();
						$(".group-found").hide();
						updateVisibility();
					} else if (count == 1) {
						// One previous call found. Automatically select it.
						$(".found-no-calls").hide();
						$(".found-multiple-calls").hide();
						updateVisibility();
						var dataKeys = Object.keys(data);
						var groupId = dataKeys[0];
						onChangeGroupSearch(groupId);
					} else {
						// Found multiple followup calls. User must select one.
						$(".found-no-calls").hide();
						$(".found-multiple-calls").show();
						$(".group-found").hide();
						updateVisibility();
						$("#CaCallGroupId").val('');
						$("span.callCount").html(count);
						$(".group_search").find("option").remove();
						$('.group_search').append($('<option>', {
							value: '',
							text: ''
						}));
						for(var key in data) {
							$('.group_search').append($('<option>', {
								value: key,
								text: data[key]
							}));
						}
					}
				},
			});
		} else {
			// No location selected
			$(".found-no-calls").hide();
			$(".found-multiple-calls").hide();
			updateVisibility();
		}
	} else {
		$.ajax({
			url:"/ca_calls/get_previous_calls/"+locationId,
			type:"post",
			dataType: 'json',
			success: function(data, textStatus) {
				// Found multiple pending calls
				$(".group_search").find("option").remove();
				$('.group_search').append($('<option>', {
					value: '',
					text: ''
				}));
				for(var key in data) {
					$('.group_search').append($('<option>', {
						value: key,
						text: data[key]
					}));
				}
			},
		});
	}
}

function onChangeCallType(callType) {
	$("span.callType").html(callTypes[callType]);
	if (callType == CALL_TYPE_VM_CALLBACK_CONSUMER) {
		loadReturnVoicemailForm('consumer');
		updateVisibility();
		IS_CLINIC_LOOKUP_PAGE = false;
	} else if (callType == CALL_TYPE_VM_CALLBACK_CLINIC) {
		loadReturnVoicemailForm('clinic');
		updateVisibility();
		IS_CLINIC_LOOKUP_PAGE = true;
	} else if (callType == CALL_TYPE_VM_CALLBACK_INVALID) {
		loadReturnVoicemailForm('invalid');
		updateVisibility();
		IS_CLINIC_LOOKUP_PAGE = false;
	}
}

function loadReturnVoicemailForm(type) {
	$('#return_vm_from_invalid').hide();
	var caCallGroupId = $('#CaCallGroupId').val();
	var ajaxUrl = null;
	if (type == 'clinic') {
		ajaxUrl = '/admin/ca_calls/ajax_clinic_form/' + caCallGroupId;
	} else if (type == 'consumer') {
		ajaxUrl = '/admin/ca_calls/ajax_consumer_form/' + caCallGroupId;
	}

	if (ajaxUrl) {
		$.ajax({
			url: ajaxUrl,
			success: function(data) {
				console.log('AJAX form loaded successfully: ' + type);
				$('#return_vm_ajax_form').html(data).show();
				$('#return_vm_from_invalid').hide();
				locationAutocomplete();
				triggerChangeEvents(['#CaCallCallType']);
				$('#CaCallGroupDidTheyAnswerVm').trigger("change");
			},
			error: function(data) {
				console.log(data);
			}
		});
	} else {
		$('#return_vm_ajax_form').html('').hide();
		$('#return_vm_from_invalid').show();
	}
}

function onChangeIsPatient(isPatient) {
	if (isPatient) {
		$('.patient-data').hide();
	} else {
		$('.patient-data').show();
	}
	updateVisibility();
	onChangePatientInfo();
}

function onChangeProspect(selectedProspect) {
	var isOverride = 0;
	var calculatedProspect = PROSPECT_NO;
	if ($('#CaCallGroupTopicDeclined').prop('checked')) {
		// Caller refused to give name
		calculatedProspect = PROSPECT_UNKNOWN;
	}
	Object.keys(prospectTopics).forEach(function (key) {
		if ($('#'+prospectTopics[key]).prop('checked')) {
			// One of the prospect topics is checked
			calculatedProspect = PROSPECT_YES;
		}
	});

	if ($("#CaCallCallType").val() == CALL_TYPE_INBOUND_QUICK_PICK) {
		calculatedProspect = selectedProspect;
		if ((calculatedProspect !== PROSPECT_YES) && ($("#CaCallGroupStatus").val() !== STATUS_INCOMPLETE)) {
			isOverride = 1;
		}
	} else if (selectedProspect !== null) {
		if (selectedProspect != calculatedProspect) {
			// User is selecting a prospect different than
			// the calculated prospect based on topic.
			calculatedProspect = selectedProspect;
			isOverride = 1;
		}
	}

	// Do not overwrite prospect and override flag if we are still loading the page
	if (pageLoadComplete == false) {
		calculatedProspect = $('#CaCallGroupProspect').val();
		isOverride = $('#CaCallGroupIsProspectOverride').val();
	}
	$('#CaCallGroupProspect').val(calculatedProspect);
	$('#CaCallGroupIsProspectOverride').val(isOverride);

	if (calculatedProspect == PROSPECT_YES) {
		$('.nonProspectTopic').hide();
		$('.prospectUnknownTopic').hide();
		$('.prospectTopic').show();
		// Do we call the clinic or direct book?
		var wantsAppt = $('#CaCallGroupTopicWantsAppt').is(':checked');
		var directBookType = $("#CaCallGroupDirectBookType").val();
		var isDirectBookEarqOrBp = (directBookType == DIRECT_BOOK_BLUEPRINT) || (directBookType == DIRECT_BOOK_EARQ);
		var wantsHearingTest = $('#CaCallGroupWantsHearingTest').val() == 1;
		if (wantsAppt && (directBookType == DIRECT_BOOK_DM) && wantsHearingTest) {
			$('.directBookDm').show();
			$('.directBookBlueprintEarQ').hide();
			$('.nonDirectBook').hide();
		} else if (wantsAppt && isDirectBookEarqOrBp) {
			$('.directBookDm').hide();
			$('.directBookBlueprintEarQ').show();
			$('.nonDirectBook').hide();
		} else {
			$('.nonDirectBook').show();
			$('.directBookDm').hide();
			$('.directBookBlueprintEarQ').hide();
		}
		updateVisibility();
	} else if (calculatedProspect == PROSPECT_NO) {
		$('.prospectTopic').hide();
		$('.prospectUnknownTopic').hide();
		$('.nonProspectTopic').show();
		updateVisibility();
		$('#CaCallGroupScore').val('').trigger('change');
	} else if (calculatedProspect == PROSPECT_UNKNOWN) {
		$('.prospectTopic').hide();
		$('.nonProspectTopic').hide();
		$('.prospectUnknownTopic').show();
		updateVisibility();
	} else {
		// disconnected - no need to show any further script
		$('.prospectTopic').hide();
		$('.nonProspectTopic').hide();
		$('.prospectUnknownTopic').hide();
		updateVisibility();
	}
}

function onChangeScore(score) {
	if ((score == SCORE_APPT_SET) || (score == SCORE_APPT_SET_DIRECT)) {
		// Appointment set
		$('.appt_date').show();
		$('.scheduled_call_date').show();
		updateVisibility();
		$("label[for='CaCallGroupScheduledCallDateMonth']").html("Survey call date/time ("+easternTimezone+")");
		// Do not modify the call date if we are loading the page and call date is already set
		if (pageLoadComplete || !isCallDateSet) {
			onChangeApptDate();
		}
	} else if (score == SCORE_TENTATIVE_APPT) {
		// Left a voicemail with clinic - followup in 48 hours to verify if appointment has been set
		$('.appt_date').hide();
		$("label[for='CaCallGroupScheduledCallDateMonth']").html("Next attempt to reach clinic ("+easternTimezone+")");
		// Do not modify the call date if we are loading the page and call date is already set
		if (pageLoadComplete || !isCallDateSet) {
			// Next call time should be 48 hours from now
			var nextCallDate = new Date();
			nextCallDate.setDate(nextCallDate.getDate()+2);
			setDateField('CaCallGroupScheduledCallDate', nextCallDate);
			$('.scheduled_call_date').show();
		}
		if (IS_CALL_GROUP_EDIT_PAGE) {
			$('.scheduled_call_date').show();
		}
		updateVisibility();
	} else if (score == SCORE_NOT_REACHED) {
		// Clinic not reached - needs followup to set appt
		$('.appt_date').hide();
		$("label[for='CaCallGroupScheduledCallDateMonth']").html("Next attempt to reach clinic ("+easternTimezone+")");
		// Do not modify the call date if we are loading the page and call date is already set
		if (pageLoadComplete || !isCallDateSet) {
			// Next call time should be 15 minutes from now
			var callDate = new Date();
			callDate.setMinutes(callDate.getMinutes()+15);
			setDateField('CaCallGroupScheduledCallDate', callDate);
			$('.scheduled_call_date').show();
		}
		if (IS_CALL_GROUP_EDIT_PAGE) {
			$('.scheduled_call_date').show();
		}
		updateVisibility();
	} else {
		// Non-prospect/missed opportunity
		$('.appt_date').hide();
		$('.scheduled_call_date').hide();
		// Disable any fields that are required and hidden, or the form will fail to validate.
		updateVisibility();
	}
}

function onChangeGroupSearch(group_id) {
	$(".lock-error").hide();
	if (group_id) {
		$.ajax({
			url:"/ca_calls/get_call_group_data/"+group_id,
			type:"post",
			dataType: 'json',
			success: function(data, textStatus) {
				if (data['lock_error'] === true) {
					$(".lock-error").show();
					$(".group-found").hide();
					updateVisibility();
					$("span.lockTime").html(data['lock_time']);
					$("span.lockedBy").html(data['locked_by']);
					$("#CaCallGroupId").val(group_id);
				} else {
					handleCallGroupChange(data);
				}
			},
		});
	} else {
		handleCallGroupChange(null);
	}
}

function handleCallGroupChange(data) {
	if (data && data['CaCallGroup']) {
		$("span.callGroupId").html(data['CaCallGroup']['id']);
		$('#CaCallCaCallGroupId').val(data['CaCallGroup']['id']);
		$('#CaCallGroupId').val(data['CaCallGroup']['id']);
		$('#CaCallGroupStatus').val(data['CaCallGroup']['status']);
		$("span.status").html(statuses[data['CaCallGroup']['status']]);
		showGroupFound();
		$('#CaCallGroupCallerFirstName').val(data['CaCallGroup']['caller_first_name']).trigger('change');
		$('#CaCallGroupCallerLastName').val(data['CaCallGroup']['caller_last_name']).trigger('change');
		$('#CaCallGroupCallerPhone').val(data['CaCallGroup']['caller_phone']).trigger('change');
		$('#CaCallGroupIsPatient').prop('checked', data['CaCallGroup']['is_patient']).trigger('change');
		$('#CaCallGroupPatientFirstName').val(data['CaCallGroup']['patient_first_name']).trigger('change');
		$('#CaCallGroupPatientLastName').val(data['CaCallGroup']['patient_last_name']).trigger('change');
		$('#CaCallGroupTopicWantsAppt').prop('checked', data['CaCallGroup']['topic_wants_appt']);
		$('#CaCallGroupTopicClinicHours').prop('checked', data['CaCallGroup']['topic_clinic_hours']);
		$('#CaCallGroupTopicInsurance').prop('checked', data['CaCallGroup']['topic_insurance']);
		$('#CaCallGroupTopicClinicInquiry').prop('checked', data['CaCallGroup']['topic_clinic_inquiry']);
		$('#CaCallGroupTopicAidLostOld').prop('checked', data['CaCallGroup']['topic_aid_lost_old']);
		$('#CaCallGroupTopicAidLostNew').prop('checked', data['CaCallGroup']['topic_aid_lost_new']);
		$('#CaCallGroupTopicWarrantyOld').prop('checked', data['CaCallGroup']['topic_warranty_old']);
		$('#CaCallGroupTopicWarrantyNew').prop('checked', data['CaCallGroup']['topic_warranty_new']);
		$('#CaCallGroupTopicBatteries').prop('checked', data['CaCallGroup']['topic_batteries']);
		$('#CaCallGroupTopicParts').prop('checked', data['CaCallGroup']['topic_parts']);
		$('#CaCallGroupTopicCancelAppt').prop('checked', data['CaCallGroup']['topic_cancel_appt']);
		$('#CaCallGroupTopicRescheduleAppt').prop('checked', data['CaCallGroup']['topic_reschedule_appt']);
		$('#CaCallGroupTopicApptFollowup').prop('checked', data['CaCallGroup']['topic_appt_followup']);
		$('#CaCallGroupTopicMedicalRecords').prop('checked', data['CaCallGroup']['topic_medical_records']);
		$('#CaCallGroupTopicTinnitus').prop('checked', data['CaCallGroup']['topic_tinnitus']);
		$('#CaCallGroupTopicMedicalInquiry').prop('checked', data['CaCallGroup']['topic_medical_inquiry']);
		$('#CaCallGroupTopicSolicitor').prop('checked', data['CaCallGroup']['topic_solicitor']);
		$('#CaCallGroupTopicPersonalCall').prop('checked', data['CaCallGroup']['topic_personal_call']);
		$('#CaCallGroupTopicRequestFax').prop('checked', data['CaCallGroup']['topic_request_fax']);
		$('#CaCallGroupTopicRequestName').prop('checked', data['CaCallGroup']['topic_request_name']);
		$('#CaCallGroupTopicRemoveFromList').prop('checked', data['CaCallGroup']['topic_remove_from_list']);
		$('#CaCallGroupTopicForeignLanguage').prop('checked', data['CaCallGroup']['topic_foreign_language']);
		$('#CaCallGroupTopicOther').prop('checked', data['CaCallGroup']['topic_other']);
		$('#CaCallGroupTopicDeclined').prop('checked', data['CaCallGroup']['topic_declined']).trigger('change');
		$('#CaCallGroupProspect').val(data['CaCallGroup']['prospect']).trigger('change');
		if (!IS_CLINIC_LOOKUP_PAGE) {
			// Don't overwrite the front desk name on the clinic lookup page
			$('#CaCallGroupFrontDeskName').val(data['CaCallGroup']['front_desk_name']).trigger('change');
		}
		$('#CaCallGroupScore').val(data['CaCallGroup']['score']).trigger('change');
		$('#CaCallGroupIsReviewNeeded').prop('checked', data['CaCallGroup']['is_review_needed']);
		if ($("#CaCallGroupLocationId").val() != data['CaCallGroup']['location_id']) {
			// Only trigger a location change if different
			$("#CaCallGroupLocationId").val(data['CaCallGroup']['location_id']).trigger('change');
		}
		setDateField('CaCallGroupApptDate', data['CaCallGroup']['appt_date']);
		setDateField('CaCallGroupScheduledCallDate', data['CaCallGroup']['scheduled_call_date']);
		showOutcome(data['CaCallGroup']['status']);
	} else {
		clearAllFields();
	}
}
function clearAllFields() {
	$("span.callGroupId").html('');
	$('#CaCallCaCallGroupId').val('');
	$('#CaCallGroupId').val('');
	$('#CaCallGroupStatus').val(statuses[STATUS_NEW]);
	$("span.status").html(statuses[STATUS_NEW]);
	showGroupFound();
	$('#CaCallGroupCallerFirstName').val('').trigger('change');
	$('#CaCallGroupCallerLastName').val('');
	$('#CaCallGroupCallerPhone').val('');
	$('#CaCallGroupPatientFirstName').val('');
	$('#CaCallGroupPatientLastName').val('');
	$('#CaCallGroupIsPatient').prop('checked', true).trigger('change');
	$('#CaCallGroupTopicWantsAppt').prop('checked', false);
	$('#CaCallGroupTopicClinicHours').prop('checked', false);
	$('#CaCallGroupTopicInsurance').prop('checked', false);
	$('#CaCallGroupTopicClinicInquiry').prop('checked', false);
	$('#CaCallGroupTopicAidLostOld').prop('checked', false);
	$('#CaCallGroupTopicAidLostNew').prop('checked', false);
	$('#CaCallGroupTopicWarrantyOld').prop('checked', false);
	$('#CaCallGroupTopicWarrantyNew').prop('checked', false);
	$('#CaCallGroupTopicBatteries').prop('checked', false);
	$('#CaCallGroupTopicParts').prop('checked', false);
	$('#CaCallGroupTopicCancelAppt').prop('checked', false);
	$('#CaCallGroupTopicRescheduleAppt').prop('checked', false);
	$('#CaCallGroupTopicApptFollowup').prop('checked', false);
	$('#CaCallGroupTopicMedicalRecords').prop('checked', false);
	$('#CaCallGroupTopicTinnitus').prop('checked', false);
	$('#CaCallGroupTopicMedicalInquiry').prop('checked', false);
	$('#CaCallGroupTopicSolicitor').prop('checked', false);
	$('#CaCallGroupTopicPersonalCall').prop('checked', false);
	$('#CaCallGroupTopicRequestFax').prop('checked', false);
	$('#CaCallGroupTopicRequestName').prop('checked', false);
	$('#CaCallGroupTopicRemoveFromList').prop('checked', false);
	$('#CaCallGroupTopicForeignLanguage').prop('checked', false);
	$('#CaCallGroupTopicOther').prop('checked', false);
	$('#CaCallGroupTopicDeclined').prop('checked', false).trigger('change');
	$('#CaCallGroupProspect').val(PROSPECT_NO).trigger('change');
	$('#CaCallGroupFrontDeskName').val('').trigger('change');
	$('#CaCallGroupScore').val('').trigger('change');
	$('#CaCallGroupIsReviewNeeded').prop('checked', false);
	if (($("#CaCallGroupLocationSearch") !== undefined) &&
		($("#CaCallGroupLocationSearch").val() !== '')) {
		// Changing the group id should not clear the location search
	} else if ($("#CaCallGroupLocationId").val() !== '') {
		// Only trigger a location change if different
		$("#CaCallGroupLocationId").val('').trigger('change');
	}
	setDateField('CaCallGroupApptDate', null);
	setDateField('CaCallGroupScheduledCallDate', null);
	showOutcome();
}

function doWeHaveLocationAndFrontDesk() {
	// If we have a location id and front desk name, then show the appropriate text.
	var locationId = $("#CaCallGroupLocationId").val();
	var frontDeskName = $("#CaCallGroupFrontDeskName").val();
	if (locationId && frontDeskName) {
		$(".have-location-and-front-desk").show();
	} else {
		$(".have-location-and-front-desk").hide();
	}
	updateVisibility();
}

function doWeHaveLocationInitially() {
	// If we have a location id on page load, then show the appropriate text.
	var locationId = $("#CaCallGroupLocationId").val();
	if (locationId) {
		$(".init_have_location").show();
		$(".init_no_location").hide();
		updateVisibility();
	} else {
		$(".init_have_location").hide();
		$(".init_no_location").show();
		updateVisibility();
	}
}

function showGroupFound() {
	// If we have a group id and front desk name, then show the group-found text.
	var groupId = $("#CaCallGroupId").val();
	var frontDeskName = $("#CaCallGroupFrontDeskName").val();
	if (groupId && frontDeskName) {
		// Load group found form if it's not currently loaded and not locked
		var groupNotLoaded = $('.group-found').length && ($('.group-found').data('groupId') != groupId);
		var isGroupLocked = $('.lock-error').length && $('.lock-error').is(':visible');
		if (groupNotLoaded && !isGroupLocked) {
			$('.group-found').data('groupId', groupId);
			$.ajax({
				url: '/admin/ca_calls/ajax_outbound_followup_form/' + groupId,
				success: function(data) {
					var status = $("#CaCallGroupStatus").val();
					if ((status == STATUS_OUTBOUND_CLINIC_ATTEMPTED) ||
						(status == STATUS_APPT_SET)) {
						$("#CaCallCallType").val(CALL_TYPE_OUTBOUND_CLINIC);
					} else if (status == STATUS_TENTATIVE_APPT) {
						$("#CaCallCallType").val(CALL_TYPE_FOLLOWUP_TENTATIVE_APPT);
					} else { // STATUS_FOLLOWUP_SET_APPT
						$("#CaCallCallType").val(CALL_TYPE_FOLLOWUP_APPT);
					}
					$('.group-found').html(data).show();
					onPageLoad();
					questionsOnLoad();
					triggerChangeEvents(['#CaCallGroupLocationId', '#CaCallCallType']);
					$("span.locationTitle").html(locationTitle);
				}
			});
		}
		$('.group-found-buttons').show();
		updateVisibility();
	} else {
		$(".group-found").html('').hide();
		$('.group-found-buttons').hide();
		updateVisibility();
	}
}

function showOutcome() {
	var status = $('#CaCallGroupStatus').val();
	if (status) {
		if ((status == STATUS_OUTBOUND_CLINIC_COMPLETE) ||
			(status == STATUS_OUTBOUND_CUST_SURVEY_COMPLETE)) {
			$('#outcome').show();
		} else {
			$('#outcome').hide();
		}
	} else {
		$('#outcome').hide();
	}
	updateVisibility();
}

function onChangeApptDate() {
	// Call date should be one day after appt date
	var callDate = getDateField('CaCallGroupApptDate');
	callDate.setDate(callDate.getDate()+1);
	setDateField('CaCallGroupScheduledCallDate', callDate);
}

function onChangeCallerFirstName(callerFirstName) {
	$("span.callerFirstName").html(callerFirstName);
	onChangePatientInfo();
}
function onChangeCallerLastName(callerLastName) {
	$("span.callerLastName").html(callerLastName);
	onChangePatientInfo();
}
function onChangeCallerPhone(callerPhone) {
	if (callerPhone.length == 10) {
		callerPhone = callerPhone.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
	} else if (callerPhone.length == 11) {
		callerPhone = callerPhone.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1-$2-$3-$4');
	}
	$("span.callerPhone").html(callerPhone);
}
function onChangePatientInfo() {
	var isPatient = $('#CaCallGroupIsPatient').prop('checked');
	if (isPatient) {
		$('span.not-self').hide();
		$('span.self').show();
		$("span.isNotPatient").hide();
		var callerFirstName = $("#CaCallGroupCallerFirstName").val();
		var callerLastName = $("#CaCallGroupCallerLastName").val();
		$("span.patientName").html(callerFirstName+' '+callerLastName);
	} else {
		var patientFirstName = $("#CaCallGroupPatientFirstName").val();
		var patientLastName = $("#CaCallGroupPatientLastName").val();
		$("span.isNotPatient").show();
		$("span.patientName").html(patientFirstName+' '+patientLastName);
		$('span.self').hide();
		$('span.not-self').show();
	}
}
function onChangeFrontDeskName(frontDeskName) {
	$("span.frontDeskName").html(frontDeskName);
	doWeHaveLocationAndFrontDesk();
	showGroupFound();
}

function getDateField(prefix) {
	var month = $('#'+prefix+'Month').val();
	var day = $('#'+prefix+'Day').val();
	var year = $('#'+prefix+'Year').val();
	var hour = $('#'+prefix+'Hour').val();
	var min = $('#'+prefix+'Min').val();
	var meridian = $('#'+prefix+'Meridian').val();
	var date = new Date(year+'/'+month+'/'+day+' '+hour+':'+min+' '+meridian);
	return date;
}

function setDateField(prefix, date) {
	var newDate;
	if (date) {
		if (typeof date == 'string') {
			// new Date("Y-m-d H:i:s") fails in IE.
			// Convert to "Y-m-d\TH:i:s". This works in all browsers.
			date = date.replace(' ', 'T');
		}
		newDate = new Date(date);
	} else {
		newDate = new Date();
	}
	// Round to nearest 15 minutes
	newDate.setMinutes(Math.round(newDate.getMinutes() / 15) * 15);
	var hour = newDate.getHours();
	let meridian;
	if (hour < 12 || hour == 24) {
		meridian = 'am';
	} else {
		meridian = 'pm';
	}
	if (hour > 12) {
		hour -= 12;
	}
	$('#'+prefix+'Month').val(('0'+(newDate.getMonth()+1)).slice(-2).toString());
	$('#'+prefix+'Day').val(('0'+newDate.getDate()).slice(-2).toString());
	$('#'+prefix+'Year').val(newDate.getFullYear().toString());
	$('#'+prefix+'Hour').val(('0'+String(hour)).slice(-2).toString());
	$('#'+prefix+'Min').val(('0'+newDate.getMinutes()).slice(-2).toString());
	$('#'+prefix+'Meridian').val(meridian);
}

function updateVisibility(className) {
	if (!className) {
		className = 'form_fields';
	}
	// This will disable all hidden fields and enable all visible fields within the specified class
	$('.'+className+' :hidden:input').prop('disabled', true);
	$('.'+className+' :visible:input').prop('disabled', false);
	// We don't want to disable the hidden checkbox fields. These are important.
	$('div.checkbox').find(':input').prop('disabled', false);
}

function onChangeTopic() {
	var topics = [];
	var isTopicAidLost = false;
	var isTopicWarranty = false;
	$('[id^=CaCallGroupTopic]:checked').each(function() {
		let topic = $(this).next('span.topic-label').html(),
		topicId = this.id;
		if (topicId.indexOf("CaCallGroupTopicAidLost") >= 0) {
			isTopicAidLost = true;
		} else if (topicId.indexOf("CaCallGroupTopicWarranty") >= 0) {
			isTopicWarranty = true;
		} else if (topic !== undefined) {
			topics.push(topic);
		}
	});
	if (isTopicAidLost) {
		topics.push("Hearing aid lost/broken");
	}
	if (isTopicWarranty) {
		topics.push("Hearing aid warranty question");
	}
	if (topics.length) {
		$('span.callerTopics').html(topics.join(', '));
		$('#CaCallGroupTopicParts').get(0).setCustomValidity('');
	} else {
		$('span.callerTopics').html('unknown');
		$('#CaCallGroupTopicParts').get(0).setCustomValidity('At least one topic is required');
	}
	// Calculate prospect based on topics selected
	onChangeProspect(null);
}

function onChangeTopicWantsAppt(wantsAppt) {
	var isDirectBookDm = $("#CaCallGroupDirectBookType").val() == DIRECT_BOOK_DM;
	// If wants appt and this is a direct book DM location, show the hearing test question
	if ((wantsAppt==true) && (isDirectBookDm==true)) {
		$('.wantsHearingTest').show();
	} else {
		$('.wantsHearingTest').hide();
	}
	updateVisibility();
}

function onChangeConsumerConsent(consumerConsent) {
	if (consumerConsent == 'yes') {
		$('.consumerConsentYes').show();
		$('.consumerConsentNo').hide();
		$("span.callTransferInstructions").html("[Mute and listen to appointment info]");
	} else if (consumerConsent == 'no') {
		$('.consumerConsentYes').hide();
		$('.consumerConsentNo').show();
		$("span.callTransferInstructions").html("[Hang up and score as 'Tentative appointment'.]");
		$('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
	}
}

function onChangeDidClinicAnswer(didClinicAnswer) {
	if ($(".prospectOptions").is(':hidden')) {
		$(".prospectOptions").show();
	}
	if (didClinicAnswer == 'yes') {
		$(".didClinicAnswerYes").show();
		$(".didClinicAnswerNo").hide();
		$(".didClinicAnswerVm").hide();
		updateVisibility();
		$('#CaCallGroupScore').val('').trigger('change');
	} else if (didClinicAnswer == 'no') {
		$(".didClinicAnswerYes").hide();
		$(".didClinicAnswerNo").show();
		$(".didClinicAnswerVm").hide();
		updateVisibility();
		if ($('#CaCallGroupProspect').val() == PROSPECT_YES) {
			if ($('#CaCallGroupRefusedName').prop('checked')) {
				$('#CaCallGroupScore').val(SCORE_MISSED_OPPORTUNITY).trigger('change');
			} else {
				$('#CaCallGroupScore').val(SCORE_NOT_REACHED).trigger('change');
			}
		}
	} else if (didClinicAnswer == 'vm') {
		// No, but we can leave a voicemail
		$(".didClinicAnswerYes").hide();
		$(".didClinicAnswerNo").hide();
		$(".didClinicAnswerVm").show();
		updateVisibility();
		if ($('#CaCallGroupProspect').val() == PROSPECT_YES) {
			$('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
		}
	} else if (didClinicAnswer == 'cr') {
		$("#CaCallGroupScore").val(SCORE_DISCONNECTED).trigger('change');
		$(".prospectOptions").hide();
		$(".didClinicAnswerYes").hide();
		$(".didClinicAnswerNo").hide();
		$(".didClinicAnswerVm").hide();
		updateVisibility();
	} else {
		$(".didClinicAnswerYes").hide();
		$(".didClinicAnswerNo").hide();
		$(".didClinicAnswerVm").hide();
		$(".scheduled_call_date").show();
		$("#CaCallGroupScore").val('').trigger('change');
		updateVisibility();
	}
}

function onChangeDidTheyAnswerVm(didTheyAnswer) {
	var callDate = new Date();
	if (didTheyAnswer == 'yes') {
		$("#didTheyAnswerYes").show();
		$("#didTheyAnswerNo").hide();
		$("#didTheyAnswerVm").hide();
		updateVisibility();
	} else if (didTheyAnswer == 'vm') {
		$("#didTheyAnswerYes").hide();
		$("#didTheyAnswerNo").hide();
		$("#didTheyAnswerVm").show();
		updateVisibility();
	} else if (didTheyAnswer == 'noAttempt') {
		$("#didTheyAnswerYes").hide();
		$("#didTheyAnswerNo").show();
		$("#didTheyAnswerNo .scheduled_call_date").show();
		$("#didTheyAnswerVm").hide();
		updateVisibility();
		// Default next call time to 2 hours from now
		callDate.setMinutes(callDate.getMinutes()+120);
		setDateField('NoAnswerScheduledCallDate', callDate);
	} else { //NO
		$("#didTheyAnswerYes").hide();
		$("#didTheyAnswerNo").show();
		$("#didTheyAnswerNo .scheduled_call_date").show();
		$("#didTheyAnswerVm").hide();
		updateVisibility();
		// Default next call time to 30 minutes from now
		callDate.setMinutes(callDate.getMinutes()+30);
		setDateField('NoAnswerScheduledCallDate', callDate);
	}
}

function onChangeDidTheyAnswerFollowup(answer) {
	var callType = $("#CaCallCallType").val();
	if (answer == 'yes') {
		$(".didTheyAnswerFollowupYes").show();
		$(".didTheyAnswerFollowupNo").hide();
		$(".didTheyAnswerFollowupVm").hide();
		$('.scheduled_call_date').hide();
	} else if (answer == 'vm') {
		var prospect = $("#CaCallGroupProspect").val();
		$(".didTheyAnswerFollowupYes").hide();
		$(".didTheyAnswerFollowupNo").hide();
		$(".didTheyAnswerFollowupVm").show();
		if ((callType == CALL_TYPE_FOLLOWUP_NO_ANSWER) || (prospect == PROSPECT_NO)) {
			$(".followupForm").hide();
			$('.scheduled_call_date').hide();
		} else {
			$(".followupForm").show();
			$('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
		}
	} else { //NO
		$(".didTheyAnswerFollowupYes").hide();
		$(".didTheyAnswerFollowupVm").hide();
		$(".didTheyAnswerFollowupNo").show();
		$(".followupForm").hide();
		$('.scheduled_call_date').show();
		var nextCallDate = new Date();
		if (callType == CALL_TYPE_FOLLOWUP_APPT) {
			// Set next call time (depends on call type and how many followup calls we have made)
			var nextCallMinutes = 15;
			switch ($("#CaCallGroupClinicFollowupCount").val()) {
				case 1:
					nextCallMinutes = 15; // 15 minutes
					break;
				case 2:
					nextCallMinutes = 120; // 2 hours
					break;
				default: //3-8
					nextCallMinutes = 240; // 4 hours
					break;
			}
			nextCallDate.setMinutes(nextCallDate.getMinutes()+nextCallMinutes);
			setDateField('CaCallGroupScheduledCallDate', nextCallDate);
		} else if ((callType == CALL_TYPE_FOLLOWUP_TENTATIVE_APPT) ||
			(callType == CALL_TYPE_FOLLOWUP_NO_ANSWER)) {
			// Try again in 4 hours
			nextCallDate.setMinutes(nextCallDate.getMinutes()+240);
			setDateField('CaCallGroupScheduledCallDate', nextCallDate);
		} else if (callType == CALL_TYPE_FOLLOWUP_APPT_REQUEST) {
			// Try again in 15 minutes
			nextCallDate.setMinutes(nextCallDate.getMinutes()+15);
			setDateField('CaCallGroupScheduledCallDate', nextCallDate);
		} else {
			// Try again in 15 minutes
			nextCallDate.setMinutes(nextCallDate.getMinutes()+15);
			setDateField('CaCallGroupScheduledCallDate', nextCallDate);
			$("label[for='CaCallGroupScheduledCallDateMonth']").html("Next attempt to reach consumer ("+easternTimezone+")");
		}
	}
	updateVisibility();
}

function onChangeDidConsumerAnswer(answer) {
	var callType = $("#CaCallCallType").val();
	var nextCallDate = new Date();
	if (answer == 'yes') {
		$(".didConsumerAnswerYes").show();
		$(".didConsumerAnswerNo").hide();
		$(".didConsumerAnswerVm").hide();
		$(".didConsumerAnswerInvalid").hide();
		$(".followupForm").show();
		$('.scheduled_call_date').hide();
	} else if (answer == 'vm') {
		$(".didConsumerAnswerYes").hide();
		$(".didConsumerAnswerNo").hide();
		$(".didConsumerAnswerVm").show();
		$(".didConsumerAnswerInvalid").hide();
		if (callType == CALL_TYPE_FOLLOWUP_APPT_REQUEST) {
			// Try again in 4 hours
			$('.scheduled_call_date').show();
			nextCallDate.setMinutes(nextCallDate.getMinutes()+240);
			setDateField('CaCallGroupScheduledCallDate', nextCallDate);
		} else {
			$(".followupForm").show();
			$('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
		}
	} else if (answer == 'invalid') {
		$(".didConsumerAnswerYes").hide();
		$(".didConsumerAnswerNo").hide();
		$(".didConsumerAnswerVm").hide();
		$(".didConsumerAnswerInvalid").show();
		$(".followupForm").show();
		$('#CaCallGroupScore').val(SCORE_DISCONNECTED).trigger('change');
	} else { //NO
		var prospect = $("#CaCallGroupProspect").val();
		$(".didConsumerAnswerYes").hide();
		$(".didConsumerAnswerNo").show();
		$(".didConsumerAnswerVm").hide();
		$(".didConsumerAnswerInvalid").hide();
		if ((callType == CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT) || (prospect == PROSPECT_NO)) {
			$(".followupForm").hide();
		} else {
			$(".followupForm").show();
			$('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
		}
	}
	updateVisibility();
}

function onChangeDidConsumerAnswer2(answer) {
	// 2nd attempt to reach consumer.
	// For call type CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT.
	var nextCallDate = new Date();
	if (answer == 'yes') {
		$(".didConsumerAnswer2Yes").show();
		$(".didConsumerAnswer2No").hide();
		$(".followupForm").show();
		$('.scheduled_call_date').hide();
	} else { //NO
		$(".didConsumerAnswer2Yes").hide();
		$(".didConsumerAnswer2No").show();
		$(".followupForm").show();
		$('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
	}
	updateVisibility();
}

function onChangeDidTheyWantHelp(answer) {
	if (answer == 1) { //YES
		$(".wantHelpYes").show();
		$(".wantHelpNo").hide();
	} else { //NO
		$(".wantHelpYes").hide();
		$(".wantHelpNo").show();
	}
	updateVisibility();
}

function onChangeDidClinicContactConsumer(answer) {
	if (answer == 1) { //YES
		$(".didClinicContactConsumerYes").show();
		$(".didClinicContactConsumerNo").hide();
		$(".followupForm").show();
	} else { //NO
		$(".didClinicContactConsumerYes").hide();
		$(".didClinicContactConsumerNo").show();
		$('#CaCallGroupDidTheyWantHelp').val('');
		$('#CaCallGroupScore').val(SCORE_MISSED_OPPORTUNITY).trigger('change');
		if ($("#CaCallCallType").val() == CALL_TYPE_FOLLOWUP_TENTATIVE_APPT) {
			$(".followupForm").show();
		} else { // CALL_TYPE_FOLLOWUP_NO_ANSWER
			$(".followupForm").hide();
		}
	}
	updateVisibility();
}

function onChangeRefusedName() {
	if ($('#CaCallGroupRefusedName').prop('checked')) {
		$('.refusedNameNo').hide();
		$('.refusedNameYes').show();
		if (pageLoadComplete) {
			$('#CaCallGroupTopicDeclined').prop('checked', true).trigger('change');
		}
		// Don't leave vm at clinic if we don't know caller name
		$("#CaCallGroupDidClinicAnswer option[value='vm']").remove();
	} else {
		$('.refusedNameNo').show();
		$('.refusedNameYes').hide();
		if (pageLoadComplete) {
			$('#CaCallGroupTopicDeclined').prop('checked', false).trigger('change');
		}
		if ($("#CaCallGroupDidClinicAnswer option[value='vm']").length == 0) {
			$("#CaCallGroupDidClinicAnswer").append('<option value="vm">No, but leave voicemail</option>');
		}
	}
	updateVisibility();
}

function onChangeDidClinicRefuse() {
	// Clinic refused to take prospective patient data
	if ($('#CaCallGroupDidClinicRefuse').prop('checked')) {
		$(".didClinicRefuseYes").show();
		if (pageLoadComplete) {
			$('#CaCallGroupIsReviewNeeded').prop('checked', true);
			$('#CaCallGroupScore').val(SCORE_MISSED_OPPORTUNITY).trigger('change');
		}
	} else {
		$(".didClinicRefuseYes").hide();
		if (pageLoadComplete) {
			$('#CaCallGroupIsReviewNeeded').prop('checked', false);
			$('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
		}
	}
	updateVisibility();
}

export {updateVisibility};