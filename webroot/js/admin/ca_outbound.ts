import './admin_common';

declare global {
	interface Window {
		STATUS_VM_NEEDS_CALLBACK: string;
		STATUS_VM_CALLBACK_ATTEMPTED: string;
		STATUS_FOLLOWUP_NO_ANSWER: string;
		STATUS_FOLLOWUP_SET_APPT: string;
		STATUS_TENTATIVE_APPT: string;
	}
}

document.addEventListener("DOMContentLoaded", function () {
	const body = document.querySelector("body");

	if (!body) {
		return;
	}

	// Get form elements
	const callGroupStatus = document.getElementById("CaCallGroupStatus") as HTMLInputElement;
	const callGroupScore = document.getElementById("CaCallGroupScore") as HTMLInputElement;
	const callGroupIsApptRequestForm = document.getElementById("CaCallGroupIsApptRequestForm") as HTMLInputElement;
	const outboundCallsForm = document.getElementById("OutboundCallsForm") as HTMLFormElement;

	//window variables
	const STATUS_VM_NEEDS_CALLBACK = window.STATUS_VM_NEEDS_CALLBACK;
	const STATUS_VM_CALLBACK_ATTEMPTED = window.STATUS_VM_CALLBACK_ATTEMPTED;
	const STATUS_FOLLOWUP_NO_ANSWER = window.STATUS_FOLLOWUP_NO_ANSWER;
	const STATUS_FOLLOWUP_SET_APPT = window.STATUS_FOLLOWUP_SET_APPT;
	const STATUS_TENTATIVE_APPT = window.STATUS_TENTATIVE_APPT;

	// Call Type filter buttons
	body.addEventListener("click", function (e: MouseEvent) {
		const target = e.target as HTMLElement;

		if (!callGroupStatus || !callGroupScore || !callGroupIsApptRequestForm) {
			return;
		}

		if (target.id === "vmCallbackBtn") {
			callGroupStatus.value = STATUS_VM_NEEDS_CALLBACK + "[or]" + STATUS_VM_CALLBACK_ATTEMPTED;
			callGroupScore.value = "";
			callGroupIsApptRequestForm.value = "";
		} else if (target.id === "followupNoAnswerBtn") {
			callGroupStatus.value = STATUS_FOLLOWUP_NO_ANSWER;
			callGroupScore.value = "";
			callGroupIsApptRequestForm.value = "";
		} else if (target.id === "clinicFollowupBtn") {
			callGroupStatus.value = STATUS_FOLLOWUP_SET_APPT;
			callGroupScore.value = "";
			callGroupIsApptRequestForm.value = "";
		} else if (target.id === "followupApptRequestBtn") {
			callGroupStatus.value = "!" + STATUS_FOLLOWUP_NO_ANSWER;
			callGroupScore.value = "";
			callGroupIsApptRequestForm.value = "true";
		} else if (target.id === "followupTentativeBtn") {
			callGroupStatus.value = STATUS_TENTATIVE_APPT;
			callGroupScore.value = "";
			callGroupIsApptRequestForm.value = "";
		}
	});

	body.addEventListener("change", function (e: Event) {
		const target = e.target as HTMLElement;

		if (target.classList.contains("timezoneFilter") && outboundCallsForm) {
			outboundCallsForm.submit();
		}
	});
});