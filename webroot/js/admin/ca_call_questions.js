import {updateVisibility} from './ca_call_edit';

export const questionsOnLoad = () => {
  const clinicAnswerSelect = document.getElementById("CaCallGroupDidClinicAnswer");
  const theyAnswerOutboundSelect = document.getElementById("CaCallGroupDidTheyAnswerOutbound");
  const dmHasApptInfoSelect = document.getElementById("CaCallGroupDmHasApptInfo");
  clinicAnswerSelect.addEventListener("change", function() {
    onChangeDidClinicAnswerSurvey(this.value);
  });
  theyAnswerOutboundSelect.addEventListener("change", function() {
    onChangeDidClinicAnswerSurvey(this.value);
  });
  dmHasApptInfoSelect.addEventListener("change", function() {
    onChangeDidClinicAnswerSurvey(this.value);
  });
  clinicAnswerSelect.dispatchEvent(new Event("change"));
  
  const visitClinicSelect = document.getElementById("CaCallGroupQuestionVisitClinic");
  visitClinicSelect.addEventListener("change", function() {
    onChangeQuestionVisitClinic(this.value);
  });
  
  const whatForSelect = document.getElementById("CaCallGroupQuestionWhatFor");
  whatForSelect.addEventListener("change", function() {
    onChangeQuestionWhatFor(this.value);
  });
  
  const purchaseSelect = document.getElementById("CaCallGroupQuestionPurchase");
  purchaseSelect.addEventListener("change", function() {
    onChangeQuestionPurchase(this.value);
  });
  
  const brandSelect = document.getElementById("CaCallGroupQuestionBrand");
  brandSelect.addEventListener("change", function() {
    onChangeQuestionBrand(this.value);
  });
  
  setDefaultQuestionValues();
};

function setDefaultQuestionValues() {
  const callType = document.getElementById("CaCallCallType").value;
  const visitClinicSelect = document.getElementById("CaCallGroupQuestionVisitClinic");
  const whatForSelect = document.getElementById("CaCallGroupQuestionWhatFor");
  const purchaseSelect = document.getElementById("CaCallGroupQuestionPurchase");
  const brandSelect = document.getElementById("CaCallGroupQuestionBrand");
  
  if (callType === CALL_TYPE_OUTBOUND_CALLER) {
    if (visitClinicSelect.value === Q_VISIT_CLINIC_DECLINED) {
      visitClinicSelect.value = "";
    }
    if (whatForSelect.value === Q_WHAT_FOR_DECLINED) {
      whatForSelect.value = "";
    }
    if (purchaseSelect.value === Q_PURCHASE_DECLINED) {
      purchaseSelect.value = "";
    }
    if (brandSelect.value === Q_BRAND_DECLINED) {
      brandSelect.value = "";
    }
  }
}

function onChangeDidClinicAnswerSurvey(answer) {
  const questionVisitClinic = document.getElementById("questionVisitClinic");
  const questionVisitClinicSelect = document.getElementById("CaCallGroupQuestionVisitClinic");
  const scheduledCallDate = document.querySelector(".scheduled_call_date");

  switch (answer) {
    case "1": // YES
      questionVisitClinic.style.display = "block";
      questionVisitClinicSelect.dispatchEvent(new Event("change"));
      scheduledCallDate.style.display = "none";
      break;
    case "0": // NO
      questionVisitClinic.style.display = "none";
      scheduledCallDate.style.display = "block";
      // Default next call time to 2 hours from now
      const callDate = new Date();
      callDate.setHours(callDate.getHours() + 2);
      setDateField("CaCallGroupScheduledCallDate", callDate);
      break;
    default:
      questionVisitClinic.style.display = "none";
      questionVisitClinicSelect.style.display = "none";
      scheduledCallDate.style.display = "none";
      break;
  }
  updateVisibility();
}

function onChangeQuestionVisitClinic(answer) {
  const questionWhatFor = document.getElementById("questionWhatFor");
  const questionWhatForSelect = document.getElementById("CaCallGroupQuestionWhatFor");
  const apptDate = document.querySelector(".appt_date");
  const scheduledCallDate = document.querySelector(".scheduled_call_date");
  const surveyComplete = document.getElementById("surveyComplete");

  switch (answer) {
    case Q_VISIT_CLINIC_YES:
      questionWhatFor.style.display = "block";
      questionWhatForSelect.dispatchEvent(new Event("change"));
      apptDate.style.display = "none";
      scheduledCallDate.style.display = "none";
      surveyComplete.style.display = "none";
      break;
    case Q_VISIT_CLINIC_NO_RESCHEDULED:
      questionWhatFor.style.display = "none";
      questionWhatForSelect.value = "";
      apptDate.style.display = "block";
      scheduledCallDate.style.display = "block";
      surveyComplete.style.display = "block";
      break;
    case Q_VISIT_CLINIC_NO_CANCELLED:
    case Q_VISIT_CLINIC_DECLINED:
      questionWhatFor.style.display = "none";
      questionWhatForSelect.value = "";
      apptDate.style.display = "none";
      scheduledCallDate.style.display = "none";
      surveyComplete.style.display = "block";
      break;
    case "":
      questionWhatFor.style.display = "none";
      questionWhatForSelect.value = "";
      apptDate.style.display = "none";
      scheduledCallDate.style.display = "none";
      surveyComplete.style.display = "none";
      break;
  }
  updateVisibility();
}

function onChangeQuestionWhatFor(answer) {
  const questionPurchase = document.getElementById("questionPurchase");
  const questionBrand = document.getElementById("questionBrand");
  const surveyComplete = document.getElementById("surveyComplete");
  const questionPurchaseSelect = document.getElementById("CaCallGroupQuestionPurchase");
  const questionBrandSelect = document.getElementById("CaCallGroupQuestionBrand");

  switch (answer) {
    case "":
      questionPurchase.style.display = "none";
      surveyComplete.style.display = "none";
      break;
    case Q_WHAT_FOR_OTHER_DR:
    case Q_WHAT_FOR_DECLINED:
      questionPurchaseSelect.value = "";
      questionBrandSelect.value = "";
      questionPurchase.style.display = "none";
      questionBrand.style.display = "none";
      surveyComplete.style.display = "block";
      break;
    default:
      questionPurchase.style.display = "block";
      questionPurchaseSelect.dispatchEvent(new Event("change"));
      surveyComplete.style.display = "none";
      break;
  }
  updateVisibility();
}

function onChangeQuestionPurchase(answer) {
  const questionBrand = document.getElementById("questionBrand");
  const surveyComplete = document.getElementById("surveyComplete");
  const questionBrandSelect = document.getElementById("CaCallGroupQuestionBrand");

  switch (answer) {
    case "":
      questionBrand.style.display = "none";
      surveyComplete.style.display = "none";
      break;
    case Q_PURCHASE_NO:
    case Q_PURCHASE_DECLINED:
      questionBrand.style.display = "none";
      questionBrandSelect.value = "";
      surveyComplete.style.display = "block";
      break;
    case Q_PURCHASE_YES:
      questionBrand.style.display = "block";
      surveyComplete.style.display = "none";
      break;
  }
  updateVisibility();
}

function onChangeQuestionBrand(brand) {
  const questionBrandOther = document.getElementById("questionBrandOther");
  const questionBrandOtherInput = document.getElementById("CaCallGroupQuestionOtherBrand");
  const surveyComplete = document.getElementById("surveyComplete");

  switch (brand) {
    case Q_BRAND_OTHER:
      questionBrandOther.style.display = "block";
      surveyComplete.style.display = "block";
      break;
    case "":
      questionBrandOther.style.display = "none";
      questionBrandOtherInput.value = "";
      surveyComplete.style.display = "none";
      break;
    default:
      questionBrandOther.style.display = "none";
      questionBrandOtherInput.value = "";
      surveyComplete.style.display = "block";
      break;
  }
  updateVisibility();
}

document.addEventListener("DOMContentLoaded", function() {
  questionsOnLoad();
});
