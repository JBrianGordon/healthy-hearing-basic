import {updateVisibility} from './ca_call_edit';

let questionsOnLoad = () => {
	$("#CaCallGroupDidClinicAnswer, #CaCallGroupDidTheyAnswerOutbound, #CaCallGroupDmHasApptInfo").on("change", function(){
		onChangeDidClinicAnswerSurvey(this.value);
	}).trigger("change");
	$("#CaCallGroupQuestionVisitClinic").on("change", function(){
		onChangeQuestionVisitClinic(this.value);
	});
	$("#CaCallGroupQuestionWhatFor").on("change", function(){
		onChangeQuestionWhatFor(this.value);
	});
	$("#CaCallGroupQuestionPurchase").on("change", function(){
		onChangeQuestionPurchase(this.value);
	});
	$("#CaCallGroupQuestionBrand").on("change", function(){
		onChangeQuestionBrand(this.value);
	});
	setDefaultQuestionValues();
}

function setDefaultQuestionValues() {
	// For outbound calls to consumer post appointment, we want to show if clinic answered any questions,
	// but leave blank if clinic refused to answer a question.
	var callType = $("#CaCallCallType").val();
	if (callType == CALL_TYPE_OUTBOUND_CALLER) {
		if ($("#CaCallGroupQuestionVisitClinic").val() == Q_VISIT_CLINIC_DECLINED) {
			$("#CaCallGroupQuestionVisitClinic").val("");
		}
		if ($("#CaCallGroupQuestionWhatFor").val() == Q_WHAT_FOR_DECLINED) {
			$("#CaCallGroupQuestionWhatFor").val("");
		}
		if ($("#CaCallGroupQuestionPurchase").val() == Q_PURCHASE_DECLINED) {
			$("#CaCallGroupQuestionPurchase").val("");
		}
		if ($("#CaCallGroupQuestionBrand").val() == Q_BRAND_DECLINED) {
			$("#CaCallGroupQuestionBrand").val("");
		}
	}
}

// Did clinic or consumer answer survey call? Or does DM have appt info?
function onChangeDidClinicAnswerSurvey(answer) {
	switch (answer) {
		case '1': // YES
			$("#questionVisitClinic").show();
			$("#CaCallGroupQuestionVisitClinic").trigger("change");
			$('.scheduled_call_date').hide();
			break;
		case '0': // NO
			$("#questionVisitClinic").hide();
			$('.scheduled_call_date').show();
			// Default next call time to 2 hours from now
			var callDate = new Date();
			callDate.setHours(callDate.getHours()+2);
			setDateField('CaCallGroupScheduledCallDate', callDate);
			break;
		default:
			$("#questionVisitClinic").hide();
			$("#questionWhatFor").hide();
			$("#questionPurchase").hide();
			$('.scheduled_call_date').hide();
			break;
	}
	updateVisibility();
}

function onChangeQuestionVisitClinic(answer) {
	switch (answer) {
		case Q_VISIT_CLINIC_YES:
			$("#questionWhatFor").show();
			$("#CaCallGroupQuestionWhatFor").trigger("change");
			$(".appt_date").hide();
			$(".scheduled_call_date").hide();
			$("#surveyComplete").hide();
			break;
		case Q_VISIT_CLINIC_NO_RESCHEDULED:
			$("#questionWhatFor").hide();
			$("#CaCallGroupQuestionWhatFor").val("");
			$("#questionPurchase").hide();
			$("#questionBrand").hide();
			$(".appt_date").show();
			$(".scheduled_call_date").show();
			$("#surveyComplete").show();
			break;
		case Q_VISIT_CLINIC_NO_CANCELLED:
		case Q_VISIT_CLINIC_DECLINED:
			$("#questionWhatFor").hide();
			$("#CaCallGroupQuestionWhatFor").val("");
			$(".appt_date").hide();
			$(".scheduled_call_date").hide();
			$("#surveyComplete").show();
			break;
		case "":
			$("#questionWhatFor").hide();
			$("#CaCallGroupQuestionWhatFor").val("");
			$(".appt_date").hide();
			$(".scheduled_call_date").hide();
			$("#surveyComplete").hide();
			break;
	}
	updateVisibility();
}

function onChangeQuestionWhatFor(answer) {
	switch (answer) {
		case "":
			$("#questionPurchase").hide();
			$("#surveyComplete").hide();
			break;
		case Q_WHAT_FOR_OTHER_DR:
		case Q_WHAT_FOR_DECLINED:
			$("#CaCallGroupQuestionPurchase").val("");
			$("#CaCallGroupQuestionBrand").val("");
			$("#questionPurchase").hide();
			$("#questionBrand").hide();
			$("#surveyComplete").show();
			break;
		default:
			$("#questionPurchase").show();
			$("#CaCallGroupQuestionPurchase").trigger("change");
			$("#surveyComplete").hide();
			break;
	}
	updateVisibility();
}

function onChangeQuestionPurchase(answer) {
	switch (answer) {
		case "":
			$("#questionBrand").hide();
			$("#surveyComplete").hide();
			break;
		case Q_PURCHASE_NO:
		case Q_PURCHASE_DECLINED:
			$("#questionBrand").hide();
			$("#CaCallGroupQuestionBrand").val("");
			$("#surveyComplete").show();
			break;
		case Q_PURCHASE_YES:
			$("#questionBrand").show();
			$("#surveyComplete").hide();
			break;
	}
	updateVisibility();
}

function onChangeQuestionBrand(brand) {
	switch (brand) {
		case Q_BRAND_OTHER:
			$("#questionBrandOther").show();
			$("#surveyComplete").show();
			break;
		case "":
			$("#questionBrandOther").hide();
			$("#CaCallGroupQuestionOtherBrand").val("");
			$("#surveyComplete").hide();
			break;
		default:
			$("#questionBrandOther").hide();
			$("#CaCallGroupQuestionOtherBrand").val("");
			$("#surveyComplete").show();
			break;
	}
	updateVisibility();
}

$(document).ready(function() {
	questionsOnLoad();
});

export {questionsOnLoad};
