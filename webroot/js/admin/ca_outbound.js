import './admin_common';

document.addEventListener("DOMContentLoaded", function() {
	// Call Type filter buttons
	document.querySelector("body").addEventListener("click", function(e) {
		const target = e.target;
		if (target.id === "vmCallbackBtn") {
			$("#CaCallGroupStatus").val(STATUS_VM_NEEDS_CALLBACK + "[or]" + STATUS_VM_CALLBACK_ATTEMPTED);
			$("#CaCallGroupScore").val("");
			$("#CaCallGroupIsApptRequestForm").val("");
		} else if (target.id === "followupNoAnswerBtn") {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_NO_ANSWER);
			$("#CaCallGroupScore").val("");
			$("#CaCallGroupIsApptRequestForm").val("");
		} else if (target.id === "clinicFollowupBtn") {
			$("#CaCallGroupStatus").val(STATUS_FOLLOWUP_SET_APPT);
			$("#CaCallGroupScore").val("");
			$("#CaCallGroupIsApptRequestForm").val("");
		} else if (target.id === "followupApptRequestBtn") {
			$("#CaCallGroupStatus").val("!" + STATUS_FOLLOWUP_NO_ANSWER);
			$("#CaCallGroupScore").val("");
			$("#CaCallGroupIsApptRequestForm").val(true);
		} else if (target.id === "followupTentativeBtn") {
			$("#CaCallGroupStatus").val(STATUS_TENTATIVE_APPT);
			$("#CaCallGroupScore").val("");
			$("#CaCallGroupIsApptRequestForm").val("");
		} else if (target.id === "surveyDirectBtn") {
			$("#CaCallGroupStatus").val(STATUS_APPT_SET);
				$("#CaCallGroupScore").val(SCORE_APPT_SET_DIRECT);
		} else if (target.id === "surveyClinicBtn") {
			$("#CaCallGroupStatus").val(STATUS_APPT_SET + "[or]" + STATUS_OUTBOUND_CLINIC_ATTEMPTED);
			$("#CaCallGroupScore").val("!" + SCORE_APPT_SET_DIRECT);
		} else if (target.id === "surveyCallerBtn") {
			$("#CaCallGroupStatus").val(STATUS_OUTBOUND_CLINIC_DECLINED + "[or]" + STATUS_OUTBOUND_CLINIC_TOO_MANY_ATTEMPTS + "[or]" + STATUS_OUTBOUND_CUST_ATTEMPTED);
			$("#CaCallGroupScore").val("");
		}
	});

	document.querySelector("body").addEventListener("change", function(e) {
		const target = e.target;
		if (target.classList.contains("timezoneFilter")) {
			$("#OutboundCallsForm").submit();
		}
	});
});