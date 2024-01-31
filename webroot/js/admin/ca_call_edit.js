//import '../common/common';
//import '../jquery/jplayer/jquery.jplayer.min';
//import '../common/play_media';
//import {questionsOnLoad} from './ca_call_questions';

var locationTitle = '';
var pageLoadComplete = false;
var DIRECT_BOOK_NONE = DIRECT_BOOK_NONE ? DIRECT_BOOK_NONE : '';

const onPageLoad = () => {
  document.querySelector('body').addEventListener('change', e => {
    const targetId = e.target.id;
    const targetClass = e.target.classList;
    const targetValue = e.target.value;
    const targetChecked = e.target.checked;

    if (targetId === 'CaCallGroupTopicWarranty' || targetId === 'CaCallGroupTopicAidLost') {
      // Check the statuses of both of the related checkboxes.
      const warrantyChecked = document.querySelector('#CaCallGroupTopicWarranty').checked;
      const aidLostChecked = document.querySelector('#CaCallGroupTopicAidLost').checked;

      // If either of these are checked, show the 'How Old is your Hearing Aid' dialog.
      if (warrantyChecked || aidLostChecked) {
        document.querySelector('.aid_age_topic').classList.remove('hidden');
      } else {
        document.querySelector('.aid_age_topic').classList.add('hidden');
      }

      // Trigger the change event for the age dialog, to make sure the correct (hidden) checkboxes are checked.
      document.querySelector('#CaCallGroupHearingAidAge').dispatchEvent(new Event('change'));
    }

    if (targetId === 'CaCallGroupHearingAidAge') {
      const warrantyChecked = document.querySelector('#CaCallGroupTopicWarranty').checked;
      const aidLostChecked = document.querySelector('#CaCallGroupTopicAidLost').checked;

      // Set the hidden checkboxes based on what topics are checked and the age of the hearing aid.
      document.querySelector('#CaCallGroupTopicAidLostOld').checked = (aidLostChecked && targetValue === 'old');
      document.querySelector('#CaCallGroupTopicAidLostNew').checked = (aidLostChecked && targetValue === 'new');
      document.querySelector('#CaCallGroupTopicWarrantyOld').checked = (warrantyChecked && targetValue === 'old');
      document.querySelector('#CaCallGroupTopicWarrantyNew').checked = (warrantyChecked && targetValue === 'new');
      document.querySelector('#CaCallGroupTopicWarrantyNew').dispatchEvent(new Event('change'));
    }

    if (targetId === 'is-wrong-number') {
      const isWrongNumberChecked = document.querySelector('#is-wrong-number').checked;
      const validNumberElements = document.querySelectorAll('.valid_number');

      if (isWrongNumberChecked) {
        validNumberElements.forEach(element => {
          element.style.display = 'none';
        });
      } else {
        validNumberElements.forEach(element => {
          element.style.display = 'block';
        });
      }

      updateVisibility();
    }

    if (targetId === 'cancelBtn') {
      const caCallGroupId = document.querySelector('#CaCallGroupId').value;
      const url = `/ca-calls/unlock_call_group/${caCallGroupId}`;

      fetch(url)
        .then(response => response.json())
        .then(data => {
          if (data.unlock_status === true) {
            window.location = '/admin/ca-call-groups/outbound';
          }
        })
        .catch(error => {
          console.error('An error occurred:', error);
        });
    }

    if (targetId === 'disconnectedBtn') {
      // The "disconnected" button was clicked
      // Make sure the Notes field is filled in
      const callGroupNoteValue = document.querySelector('[id^=CaCallGroupCaCallGroupNote]').value.trim();

      if (callGroupNoteValue) {
        const callType = document.querySelector('#CaCallCallType').value;
        const callTypeOutboundOptions = [CALL_TYPE_OUTBOUND_CLINIC, CALL_TYPE_OUTBOUND_CALLER];
        const callTypeInboundOptions = [CALL_TYPE_INBOUND, CALL_TYPE_VM_CALLBACK_CLINIC, CALL_TYPE_VM_CALLBACK_CONSUMER, CALL_TYPE_INBOUND_QUICK_PICK];
        let callDate;

        if (callTypeOutboundOptions.includes(callType)) {
          // If an outbound call was disconnected, set the next call date 24 hours in the future.
          callDate = new Date();
          callDate.setDate(callDate.getDate() + 1);

          // Dis-disable the scheduled call date fields
          const scheduledCallDateFields = document.querySelectorAll('[id^=CaCallGroupScheduledCallDate]');
          scheduledCallDateFields.forEach(field => {
            field.disabled = false;
          });

          // Set the fields using our handy function
          setDateField('CaCallGroupScheduledCallDate', callDate);
        }

        if (callTypeInboundOptions.includes(callType)) {
          // If a new incoming call or VM follow-up call was disconnected, submit the form without validation.
          // This will just save the call in our database in case they call back.
          document.querySelector('#CaCallGroupStatus').value = STATUS_INCOMPLETE;
          document.querySelector('#CaCallGroupScore').value = SCORE_DISCONNECTED;
        }

        document.querySelector('#CaCallForm').submit();
      } else {
        document.querySelector('#note-required').modal('show');
      }
    }

    if (targetId === 'unlockBtn') {
      const caCallGroupId = document.querySelector('#CaCallGroupId').value;
      try {
        const response = fetch(`/ca-calls/unlock_call_group/${caCallGroupId}`, {
          method: 'post',
          headers: {
            'Content-Type': 'application/json'
          },
          dataType: 'json'
        });
        const data = response.json();
        if (data.unlock_status === true) {
          onChangeGroupSearch(caCallGroupId);
        }
      } catch (error) {
        console.error('An error occurred while unlocking the call group:', error);
      }
    }

    //All other form logic using functions
    switch (targetId) {
      case 'CaCallGroupTopicWantsAppt':
        onChangeTopicWantsAppt(targetChecked);
        break;
      case 'CaCallGroupWantsHearingTest':
        onChangeProspect(null);
        break;
      case 'CaCallGroupTopic':
        onChangeTopic();
        break;
      case 'location-id':
      case 'ca-call-group-location-id':
        onChangeLocationId(targetValue);
        break;
      case 'CaCallCallType':
        onChangeCallType(targetValue);
        break;
      case 'ca-call-group-is-patient':
      case 'is-patient':
        onChangeIsPatient(targetChecked);
        break;
      case 'CaCallGroupProspect':
        onChangeProspect(targetValue);
        break;
      case 'CaCallGroupScore':
        onChangeScore(targetValue);
        break;
      case 'CaCallGroupSearch':
        onChangeGroupSearch(targetValue);
        break;
      case 'CaCallGroupCallerFirstName':
        onChangeCallerFirstName(targetValue);
        break;
      case 'CaCallGroupCallerLastName':
        onChangeCallerLastName(targetValue);
        break;
      case 'CaCallGroupCallerPhone':
        onChangeCallerPhone(targetValue);
        break;
      case 'CaCallGroupPatientFirstName':
      case 'CaCallGroupPatientLastName':
        onChangePatientInfo();
        break;
      case 'ca-call-group-front-desk-name':
        onChangeFrontDeskName(targetValue);
        break;
      case 'CaCallGroupApptDate':
      case 'CaCallGroupApptDate2':
      case 'CaCallGroupApptDate3':
        onChangeApptDate();
        break;
      case 'CaCallGroupConsumerConsent':
        onChangeConsumerConsent(targetValue);
        break;
      case 'CaCallGroupDidClinicAnswer':
      case 'CaCallGroupDidClinicAnswerUnknown':
        onChangeDidClinicAnswer(targetValue);
        break;
      case 'CaCallGroupDidTheyAnswerVm':
        onChangeDidTheyAnswerVm(targetValue);
        break;
      case 'CaCallGroupDidTheyAnswerFollowup':
      case 'CaCallGroupDidTheyAnswerFollowup2':
        onChangeDidTheyAnswerFollowup(targetValue);
        break;
      case 'CaCallGroupDidConsumerAnswer':
        onChangeDidConsumerAnswer(targetValue);
        break;
      case 'CaCallGroupDidConsumerAnswer2':
        onChangeDidConsumerAnswer2(targetValue);
        break;
      case 'CaCallGroupDidTheyWantHelp':
        onChangeDidTheyWantHelp(targetValue);
        break;
      case 'CaCallGroupDidClinicContactConsumer':
        onChangeDidClinicContactConsumer(targetValue);
        break;
      case 'ca-call-group-refused-name':
        onChangeRefusedName();
        break;
      case 'CaCallGroupDidClinicRefuse':
        onChangeDidClinicRefuse();
        break;
      case'spamBtn':
        document.querySelector('#CaCallGroupIsSpam').value = true;
        document.querySelector('#CaCallForm').submit();
        break;
      case 'deleteBtn':
        // The "delete" button was clicked. Display the confirmation modal.
        document.querySelector('#delete-modal').modal('show');
    case 'submitBtn':
      // The "save" button was clicked
      // Verify that we have a valid clinic value
      validateLocationId();
      // Verify we have a valid prospect value
      validateProspect();
      // Calculate status
      calculateStatus();
      // If topics are hidden, remove the custom validation
      if (document.querySelector('#CaCallGroupTopicParts').hidden) {
        document.querySelector('#CaCallGroupTopicParts').setCustomValidity('');
      }
      break;
      case 'CaCallVoicemailFrom':
        document.querySelector('#CaCallCallType').value = targetValue;
        const callTypeChangeEvent = new Event('change');
        document.querySelector('#CaCallCallType').dispatchEvent(callTypeChangeEvent);
        break;
      default:
        break;
    }

  });

  document.getElementById('submitBtn').addEventListener('click', function() {
    // Disable hidden fields before submitting
    disableHiddenFields();
  });

  document.querySelector('body').addEventListener('keyup', e => {
    const targetId = e.target.id;
    const targetValue = e.target.value;

    if (targetId === 'ca-call-group-front-desk-name') {
      onChangeFrontDeskName(targetValue);
    }

    if (targetId === 'ca-call-group-front-desk-name') {
      onChangeFrontDeskName(targetValue);
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  onPageLoad();

  const IS_CLINIC_LOOKUP_PAGE = typeof IS_CLINIC_LOOKUP_PAGE !== 'undefined' ? IS_CLINIC_LOOKUP_PAGE : false;
  const IS_CALL_GROUP_EDIT_PAGE = typeof IS_CALL_GROUP_EDIT_PAGE !== 'undefined' ? IS_CALL_GROUP_EDIT_PAGE : false;

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

function triggerChangeEvents(skipElements = []) {
  const elements = ['#ca-call-group-location-id','#call-type','#ca-call-group-caller-first-name','#ca-call-group-caller-last-name','#ca-call-group-caller-phone','#ca-call-group-is-patient','#is-patient','#ca-call-group-patient-first-name','#ca-call-group-patient-last-name','#ca-call-group-prospect','#ca-call-group-front-desk-name','#ca-call-group-score','#ca-call-group-topic-warranty','#is-wrong-number','#ca-call-group-refused-name'];
  elements.forEach(element => {
    if (skipElements.indexOf(element) === -1) {
      var selector = document.querySelector(element);
      if (selector !== null) {
        selector.dispatchEvent(new Event('change', {bubbles: true}));
      }
    }
  });
}

//Leaving this alone, since autocomplete is dependent on jQuery
function locationAutocomplete() {
  const locationSearch = document.querySelector("#location-search, #location_search");
  if (locationSearch) {
    //TODO: Autocomplete (ticket #17080)
    /*
    locationSearch.autocomplete({
      source: "/caautocomplete",
      minLength: "2",
      select: function(event, ui){
        if (ui.item.id) {
          $("#ca-call-group-location-id").val(ui.item.id).trigger("change");
        }
      }
    });
    */
  }
}

function validateLocationId() {
  const locationSearchInput = "input[name*='location_search']";
  if (document.querySelectorAll(locationSearchInput).length === 0) {
    return true;
  }
  const locationId = document.querySelector("#ca-call-group-location-id").value.trim();
  if (locationId && (parseInt(locationId) > 0)) {
    document.querySelector(locationSearchInput).setCustomValidity('');
  } else {
    document.querySelector(locationSearchInput).setCustomValidity('Please select a valid clinic before saving.');
  }
}

const validateProspect = () => {
  const prospectInput = document.querySelector("#CaCallGroupProspect");
  if (prospectInput) {
    let isProspectInvalid = false;
    if (prospectInput.value === PROSPECT_UNKNOWN) {
      const clinicAnswerUnknownInput = document.querySelector("#CaCallGroupDidClinicAnswerUnknown");
      if (clinicAnswerUnknownInput.value === 'no') {
        // For unknown prospect, if clinic did not answer, save as non-prospect
        prospectInput.value = PROSPECT_NO;
      } else {
        // If clinic answered, agent should fill in correct prospect. Mark as invalid.
        isProspectInvalid = true;
      }
    }
    prospectInput.setCustomValidity(isProspectInvalid ? 'Must select a valid prospect before saving.' : '');
  }
};

const calculateStatus = () => {
  const callType = document.querySelector("#CaCallCallType").value;
  const isVoicemailType =
    callType === CALL_TYPE_VM_CALLBACK_CLINIC ||
    callType === CALL_TYPE_VM_CALLBACK_CONSUMER;
  let calculateByScore = false;

  if (IS_CALL_GROUP_EDIT_PAGE) {
    // Do not automatically calculate a new status on the Edit Call Group page
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#CaCallGroupDidTheyAnswerFollowup").value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#CaCallGroupClinicFollowupCount").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_SET_APPT;
    } else {
      document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_NO_ANSWER;
      document.querySelector("#CaCallGroupPatientFollowupCount").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#CaCallGroupDidTheyAnswerFollowup").value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#CaCallGroupClinicFollowupCount").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      document.querySelector("#CaCallGroupStatus").value = STATUS_TENTATIVE_APPT;
    } else {
      document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_NO_ANSWER;
      document.querySelector("#CaCallGroupPatientFollowupCount").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#CaCallGroupDidTheyAnswerFollowup").value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#CaCallGroupClinicFollowupCount").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_APPT_REQUEST_FORM;
    } else {
      document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_NO_ANSWER;
      document.querySelector("#CaCallGroupPatientFollowupCount").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT && !IS_CLINIC_LOOKUP_PAGE) {
    if (document.querySelector("#CaCallGroupDidConsumerAnswer").value === "yes" && document.querySelector("#CaCallGroupDidTheyAnswerFollowup").value === "no") {
      // Consumer answered but clinic did not. Next attempt will not be direct book.
      if (Number(document.querySelector("#CaCallGroupClinicFollowupCount").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_APPT_REQUEST_FORM;
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_NO_ANSWER;
        document.querySelector("#CaCallGroupPatientFollowupCount").value = 0;
      }
    } else if (document.querySelector("#CaCallGroupDidConsumerAnswer").value === "no" && document.querySelector("#CaCallGroupDidTheyAnswerFollowup2").value === "no") {
      // Neither consumer nor clinic answered
      if (
        Number(document.querySelector("#CaCallGroupClinicFollowupCount").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_APPT_REQUEST_FORM;
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_NO_ANSWER;
        document.querySelector("#CaCallGroupPatientFollowupCount").value = 0;
      }
    } else {
      calculateByScore = true;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_NO_ANSWER) {
    if (document.querySelector("#CaCallGroupDidTheyAnswerFollowup").value === "yes") {
      // Patient answered
      if (document.querySelector("#CaCallGroupScore").value === SCORE_APPT_SET) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_APPT_SET;
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_MO_NO_ANSWER;
        document.querySelector("#CaCallGroupScore").disabled = false;
        document.querySelector("#CaCallGroupScore").value = SCORE_MISSED_OPPORTUNITY;
      }
    } else if (document.querySelector("#CaCallGroupDidTheyAnswerFollowup").value === "vm") {
      // Left a voicemail
      document.querySelector("#CaCallGroupStatus").value = STATUS_MO_NO_ANSWER;
      document.querySelector("#CaCallGroupScore").disabled = false;
      document.querySelector("#CaCallGroupScore").value = SCORE_MISSED_OPPORTUNITY;
    } else {
      // Patient did not answer
      if (Number(document.querySelector("#CaCallGroupPatientFollowupCount").value) < MAX_PATIENT_FOLLOWUP_ATTEMPTS) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_NO_ANSWER;
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_MO_NO_ANSWER;
        document.querySelector("#CaCallGroupScore").disabled = false;
        document.querySelector("#CaCallGroupScore").value = SCORE_MISSED_OPPORTUNITY;
      }
    }
  } else if (callType === CALL_TYPE_OUTBOUND_CLINIC) {
    if (document.querySelector("#CaCallGroupDidTheyAnswerOutbound").value === "1" || IS_CLINIC_LOOKUP_PAGE) {
      if (document.querySelector("#CaCallGroupQuestionVisitClinic").value === Q_VISIT_CLINIC_DECLINED || document.querySelector("#CaCallGroupQuestionWhatFor").value === Q_WHAT_FOR_DECLINED || document.querySelector("#CaCallGroupQuestionPurchase").value === Q_PURCHASE_DECLINED || document.querySelector("#CaCallGroupQuestionBrand").value === Q_BRAND_DECLINED) {
        // Clinic refused to answer our questions
        document.querySelector("#CaCallGroupStatus").value = STATUS_OUTBOUND_CLINIC_DECLINED;
      } else if (document.querySelector("#CaCallGroupQuestionVisitClinic").value === Q_VISIT_CLINIC_NO_RESCHEDULED) {
        // Appointment is coming up ..
        document.querySelector("#CaCallGroupStatus").value = STATUS_APPT_SET;
        document.querySelector("[id^=CaCallGroupScheduledCallDate]").disabled = false;
        onChangeApptDate();
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_OUTBOUND_CLINIC_COMPLETE;
      }
    } else {
      if (Number(document.querySelector("#CaCallGroupClinicOutboundCount").value) < MAX_CLINIC_OUTBOUND_ATTEMPTS) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_OUTBOUND_CLINIC_ATTEMPTED;
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_OUTBOUND_CLINIC_TOO_MANY_ATTEMPTS;
      }
    }
  } else if (callType === CALL_TYPE_SURVEY_DIRECT) {
      if (document.querySelector("#CaCallGroupDmHasApptInfo").value === "1") {
        // DM had appt info
        if (document.querySelector("#CaCallGroupQuestionVisitClinic").value === Q_VISIT_CLINIC_DECLINED || document.querySelector("#CaCallGroupQuestionWhatFor").value === Q_WHAT_FOR_DECLINED || document.querySelector("#CaCallGroupQuestionPurchase").value === Q_PURCHASE_DECLINED || document.querySelector("#CaCallGroupQuestionBrand").value === Q_BRAND_DECLINED) {
          // DM was missing some important info. Try calling clinic.
          document.querySelector("#CaCallGroupStatus").value = STATUS_OUTBOUND_CLINIC_ATTEMPTED;
        } else if (document.querySelector("#CaCallGroupQuestionVisitClinic").value === Q_VISIT_CLINIC_NO_RESCHEDULED) {
          // Appointment is coming up ..
          document.querySelector("#CaCallGroupStatus").value = STATUS_APPT_SET;
          document.querySelector("[id^=CaCallGroupScheduledCallDate]").disabled = false;
          onChangeApptDate();
        } else {
          document.querySelector("#CaCallGroupStatus").value = STATUS_OUTBOUND_CLINIC_COMPLETE;
        }
      } else {
        // DM did not have appt info. Try calling clinic.
        document.querySelector("#CaCallGroupStatus").value = STATUS_OUTBOUND_CLINIC_ATTEMPTED;
      }
    } else if (isVoicemailType && document.querySelector("#CaCallGroupDidTheyAnswerVm").value === "vm") {
      document.querySelector("#CaCallGroupStatus").value = STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS;
    } else if (isVoicemailType && (document.querySelector("#CaCallGroupDidTheyAnswerVm").value === "no" || document.querySelector("#CaCallGroupDidTheyAnswerVm").value === "")) {
      if (Number(document.querySelector("#CaCallGroupVmOutboundCount").value) < MAX_VM_OUTBOUND_ATTEMPTS) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_VM_CALLBACK_ATTEMPTED;
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS;
      }
    } else if (isVoicemailType && document.querySelector("#CaCallGroupDidTheyAnswerVm").value === "noAttempt") {
      const vmCount = Number(document.querySelector("#CaCallGroupVmOutboundCount").value);
      document.querySelector("#CaCallGroupVmOutboundCount").value = vmCount - 1;
      document.querySelector("#CaCallGroupStatus").value = STATUS_VM_CALLBACK_ATTEMPTED;
    } else if (callType === CALL_TYPE_VM_CALLBACK_INVALID) {
      document.querySelector("#CaCallGroupStatus").value = STATUS_WRONG_NUMBER;
    } else if (document.querySelector("#is-wrong-number").checked) {
      document.querySelector("#CaCallGroupStatus").value = STATUS_WRONG_NUMBER;
    } else if (document.querySelector("#CaCallGroupRefusedNameAgainQuickPick").checked) {
      document.querySelector("#CaCallGroupStatus").value = STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS;
    } else if (document.querySelector("#CaCallGroupDidClinicAnswer").value === "cr") {
      document.querySelector("#CaCallGroupStatus").value = STATUS_QUICK_PICK_CALLER_REFUSED_HELP;
    } else {
      // Inbound or Followup call
      calculateByScore = true;
    }

    if (calculateByScore) {
      const score = document.querySelector("#CaCallGroupScore").value;
      const prospect = document.querySelector("#CaCallGroupProspect").value;
      if (prospect === PROSPECT_NO) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_NON_PROSPECT;
      } else if (score === SCORE_DISCONNECTED || prospect === PROSPECT_DISCONNECTED) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_INCOMPLETE;
        document.querySelector("#CaCallGroupScore").value = SCORE_DISCONNECTED;
      } else if (score === SCORE_NOT_REACHED) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_FOLLOWUP_SET_APPT;
      } else if (score === SCORE_APPT_SET || score === SCORE_APPT_SET_DIRECT) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_APPT_SET;
      } else if (score === SCORE_TENTATIVE_APPT) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_TENTATIVE_APPT;
      } else if (score === SCORE_MISSED_OPPORTUNITY) {
        document.querySelector("#CaCallGroupStatus").value = STATUS_MISSED_OPPORTUNITY;
      } else {
        document.querySelector("#CaCallGroupStatus").value = STATUS_NEW;
      }
    }
}


function onChangeLocationId(locationId) {
  doWeHaveLocationAndFrontDesk();
  if (locationId && locationId > 0) {
    const url = `/admin/ca-calls/get-location-data/${locationId}`;
    try {
      fetch(url, {
        method: "GET",
        headers: {
          'Accept': 'application/json',
        },
      })
      .then(response => response.json())
      .then(data => {
        if (data.title !== undefined) {
          handleLocationChange(data);
        } else {
          console.log('getLocationData failed');
          console.debug(data);
        }
      });
    } catch (error) {
      console.error(error);
    }
  } else {
    handleLocationChange(null);
  }
}

function handleLocationChange(data) {
  const updateElementHTML = (selector, content) => {
    const element = document.querySelector(selector);
    if (element) {
      element.innerHTML = content || '';
    }
  };

  updateElementHTML(".locationLink", data ? data['link'] : '');
  updateElementHTML(".locationTitle", data ? data['title'] : '');
  locationTitle = data ? data['title'] : '';
  updateElementHTML(".locationAddress", data ? data['address'] : '');
  updateElementHTML(".locationPhone", data ? data['phone'] : '');
  updateElementHTML(".locationCovid", data && data['covid'] ? `COVID-19 statement: ${data['covid']}` : '');
  updateElementHTML(".locationLandmarks", data && data['landmarks'] ? `Landmarks: ${data['landmarks']}` : '');
  updateElementHTML(".andYhn", data && data['isYhn'] === 1 ? 'and Your Hearing Network' : '');
  
  //todo: search
  //const locationSearchInput = document.querySelector("#CaCallLocationSearch");
  //if (!locationSearchInput.value && data) {
  //  locationSearchInput.value = data['searchTitle'];
  //}

  if (data) {
    const directBookTypeInput = document.querySelector("#ca-call-group-direct-book-type");
    const directBookUrlLink = document.querySelector("#directBookUrl");
    directBookTypeInput.value = data['directBookType'];
    directBookUrlLink.textContent = data['directBookUrl'];
    directBookUrlLink.href = data['directBookUrl'];
  } else {
    const directBookTypeInput = document.querySelector("#ca-call-group-direct-book-type");
    directBookTypeInput.value = DIRECT_BOOK_NONE;
  }
  const locationCityStateStreetElement = document.querySelector(".locationCityStateStreet");
  locationCityStateStreetElement.innerHTML = data ? data['cityStateStreet'] : '';

  let hours = data ? data['hours'] : '';
  if (hours !== '') {
    hours = '<u>Clinic hours</u><br>' + hours;
  }
  const locationHoursElement = document.querySelector(".locationHours");
  locationHoursElement.innerHTML = hours;

  let hoursToday = data ? data['hoursToday'] : '';
  if (hoursToday !== '') {
    if (hoursToday === 'closed') {
      hoursToday = 'They are closed today.';
    } else {
      hoursToday = 'Their hours today are <strong>' + hoursToday + '</strong>.';
    }
  }
  const locationHoursTodayElement = document.querySelector(".locationHoursToday");
  locationHoursTodayElement.innerHTML = hoursToday;

  const locationCurrentTimeElement = document.querySelector('.locationCurrentTime');
  locationCurrentTimeElement.innerHTML = data ? data['currentTime'] : '';

  const locationTimezone = data ? data['timezone'] : '';
  const labelElement = document.querySelector("label[for='CaCallGroupApptDateMonth']");
  //todo:
  //labelElement.innerHTML = `Appointment date/time (${locationTimezone})<br><small class='text-muted'>This is the clinic's timezone</small>`;

  const locationId = data ? data['id'] : '';

  if (IS_CLINIC_LOOKUP_PAGE) {
    if (locationId) {
      fetch(`/ca-calls/get_previous_calls/${locationId}/1`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        }
      })
      .then(response => response.json())
      .then(data => {
        const count = Object.keys(data).length;
        if (count === 0) {
          // No followup calls found
          document.querySelector("#CaCallGroupId").value = '';
          document.querySelector(".found-no-calls").style.display = 'block';
          document.querySelector(".found-multiple-calls").style.display = 'none';
          document.querySelector(".group-found").style.display = 'none';
          //updateVisibility();
        } else if (count == 1) {
          // One previous call found. Automatically select it.
          document.querySelector(".found-no-calls").style.display = 'none';
          document.querySelector(".found-multiple-calls").style.display = 'none';
          //updateVisibility();
          const dataKeys = Object.keys(data);
          const groupId = dataKeys[0];
          onChangeGroupSearch(groupId);
        } else {
          // Found multiple followup calls. User must select one.
          document.querySelector(".found-no-calls").style.display = 'none';
          document.querySelector(".found-multiple-calls").style.display = 'block';
          document.querySelector(".group-found").style.display = 'none';
          //updateVisibility();
          document.querySelector("#CaCallGroupId").value = '';
          const callCountElement = document.querySelector("span.callCount");
          callCountElement.textContent = count;
          const groupSearchElement = document.querySelector('.group_search');
          groupSearchElement.innerHTML = '';
          groupSearchElement.appendChild(new Option('', ''));
          for (const key in data) {
            groupSearchElement.appendChild(new Option(data[key], key));
          }
        }
      })
      .catch(error => {
        // Handle the error
      });
    } else {
      // No location selected
      document.querySelector(".found-no-calls").style.display = 'none';
      document.querySelector(".found-multiple-calls").style.display = 'none';
      //updateVisibility();
    }
  } else {
    const url = `/admin/ca-calls/get-previous-calls/${locationId}`;
    try {
      fetch(url, {
        method: "GET",
        headers: {
          'Accept': 'application/json',
        },
      })
      .then(response => response.json())
      .then(data => {
        var size = Object.keys(data).length;
        if (size > 0) {
          // Found multiple pending calls
          const groupSearchElement = document.querySelector('.group_search');
          groupSearchElement.innerHTML = '';
          groupSearchElement.appendChild(new Option('', ''));
          for (const key in data) {
            groupSearchElement.appendChild(new Option(data[key], key));
          }
        } else {
          console.log('getPreviousCalls failed');
          console.debug(data);
        }
      });
    } catch (error) {
      console.error(error);
    }
  }
}

function onChangeCallType(callType) {
  const callTypeElement = document.querySelector("span.callType");
  callTypeElement.innerHTML = callTypes[callType];

  if (callType === CALL_TYPE_VM_CALLBACK_CONSUMER) {
    loadReturnVoicemailForm('consumer');
    //updateVisibility();
    IS_CLINIC_LOOKUP_PAGE = false;
  } else if (callType === CALL_TYPE_VM_CALLBACK_CLINIC) {
    loadReturnVoicemailForm('clinic');
    //updateVisibility();
    IS_CLINIC_LOOKUP_PAGE = true;
  } else if (callType === CALL_TYPE_VM_CALLBACK_INVALID) {
    loadReturnVoicemailForm('invalid');
    //updateVisibility();
    IS_CLINIC_LOOKUP_PAGE = false;
  }
}

function loadReturnVoicemailForm(type) {
  const returnVmFromInvalid = document.querySelector('#return_vm_from_invalid');
  const caCallGroupId = document.querySelector('#CaCallGroupId').value;
  let ajaxUrl = null;
  if (type === 'clinic') {
    ajaxUrl = '/admin/ca-calls/ajax_clinic_form/' + caCallGroupId;
  } else if (type === 'consumer') {
    ajaxUrl = '/admin/ca-calls/ajax_consumer_form/' + caCallGroupId;
  }

  if (ajaxUrl) {
    fetch(ajaxUrl)
      .then(response => response.text())
      .then(data => {
        console.log('AJAX form loaded successfully: ' + type);
        const returnVmAjaxForm = document.querySelector('#return_vm_ajax_form');
        returnVmAjaxForm.innerHTML = data;
        returnVmAjaxForm.style.display = 'block';
        returnVmFromInvalid.style.display = 'none';
        locationAutocomplete();
        triggerChangeEvents(['#CaCallCallType']);
        document.querySelector('#CaCallGroupDidTheyAnswerVm').dispatchEvent(new Event('change'));
      })
      .catch(error => {
        console.log(error);
      });
  } else {
    const returnVmAjaxForm = document.querySelector('#return_vm_ajax_form');
    returnVmAjaxForm.innerHTML = '';
    returnVmAjaxForm.style.display = 'none';
    returnVmFromInvalid.style.display = 'block';
  }
}

function onChangeIsPatient(isPatient) {
  const patientDataElements = document.querySelectorAll('.patient-data');
  if (isPatient) {
    patientDataElements.forEach(element => {
      element.style.display = 'none';
    });
  } else {
    patientDataElements.forEach(element => {
      element.style.display = 'block';
    });
  }
  //updateVisibility();
  onChangePatientInfo();
}

function onChangeProspect(selectedProspect) {
  const isOverride = 0;
  let calculatedProspect = PROSPECT_NO;

  if (document.querySelector('#CaCallGroupTopicDeclined').checked) {
    calculatedProspect = PROSPECT_UNKNOWN;
  }

  Object.keys(prospectTopics).forEach(key => {
    if (document.querySelector(`#${prospectTopics[key]}`).checked) {
      calculatedProspect = PROSPECT_YES;
    }
  });

  if (document.querySelector("#CaCallCallType").value === CALL_TYPE_INBOUND_QUICK_PICK) {
    calculatedProspect = selectedProspect;
    if (calculatedProspect !== PROSPECT_YES && document.querySelector("#CaCallGroupStatus").value !== STATUS_INCOMPLETE) {
      isOverride = 1;
    }
  } else if (selectedProspect !== null) {
    if (selectedProspect !== calculatedProspect) {
      calculatedProspect = selectedProspect;
      isOverride = 1;
    }
  }

  // Do not overwrite prospect and override flag if we are still loading the page
  if (pageLoadComplete === false) {
    calculatedProspect = document.querySelector('#CaCallGroupProspect').value;
    isOverride = document.querySelector('#CaCallGroupIsProspectOverride').value;
  }
  document.querySelector('#CaCallGroupProspect').value = calculatedProspect;
  document.querySelector('#CaCallGroupIsProspectOverride').value = isOverride;

  if (calculatedProspect === PROSPECT_YES) {
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'block');
    const wantsAppt = document.querySelector('#CaCallGroupTopicWantsAppt').checked;
    const directBookType = document.querySelector("#CaCallGroupDirectBookType").value;
    const isDirectBookEarqOrBp = (directBookType === DIRECT_BOOK_BLUEPRINT) || (directBookType === DIRECT_BOOK_EARQ);
    const wantsHearingTest = document.querySelector('#CaCallGroupWantsHearingTest').value === '1';
    if (wantsAppt && (directBookType === DIRECT_BOOK_DM) && wantsHearingTest) {
      document.querySelectorAll('.directBookDm').forEach(element => element.style.display = 'block');
      document.querySelectorAll('.directBookBlueprintEarQ').forEach(element => element.style.display = 'none');
      document.querySelectorAll('.nonDirectBook').forEach(element => element.style.display = 'none');
    } else if (wantsAppt && isDirectBookEarqOrBp) {
      document.querySelectorAll('.directBookDm').forEach(element => element.style.display = 'none');
      document.querySelectorAll('.directBookBlueprintEarQ').forEach(element => element.style.display = 'block');
      document.querySelectorAll('.nonDirectBook').forEach(element => element.style.display = 'none');
    } else {
      document.querySelectorAll('.nonDirectBook').forEach(element => element.style.display = 'block');
      document.querySelectorAll('.directBookDm').forEach(element => element.style.display = 'none');
      document.querySelectorAll('.directBookBlueprintEarQ').forEach(element => element.style.display = 'none');
    }
    //updateVisibility();
  } else if (calculatedProspect === PROSPECT_NO) {
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'block');
    //updateVisibility();
    document.querySelector('#CaCallGroupScore').value = '';
    document.querySelector('#CaCallGroupScore').dispatchEvent(new Event('change'));
  } else if (calculatedProspect === PROSPECT_UNKNOWN) {
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'block');
    //updateVisibility();
  } else {
    // disconnected - no need to show any further script
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'none');
    //updateVisibility();
  }
}

function onChangeScore(score) {
  if (score === SCORE_APPT_SET || score === SCORE_APPT_SET_DIRECT) {
    // Appointment set
    document.querySelectorAll('.appt_date').forEach(element => element.style.display = 'block');
    document.querySelectorAll('.scheduled_call_date').forEach(element => element.style.display = 'block');
    //updateVisibility();
    document.querySelector("label[for='CaCallGroupScheduledCallDateMonth']").innerHTML = "Survey call date/time ("+easternTimezone+")";
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      onChangeApptDate();
    }
  } else if (score === SCORE_TENTATIVE_APPT) {
    // Left a voicemail with clinic - followup in 48 hours to verify if appointment has been set
    document.querySelectorAll('.appt_date').forEach(element => element.style.display = 'none');
    document.querySelector("label[for='CaCallGroupScheduledCallDateMonth']").innerHTML = "Next attempt to reach clinic ("+easternTimezone+")";
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      // Next call time should be 48 hours from now
      const nextCallDate = new Date();
      nextCallDate.setDate(nextCallDate.getDate() + 2);
      setDateField('CaCallGroupScheduledCallDate', nextCallDate);
      document.querySelectorAll('.scheduled_call_date').forEach(element => element.style.display = 'block');
    }
    if (IS_CALL_GROUP_EDIT_PAGE) {
      document.querySelectorAll('.scheduled_call_date').forEach(element => element.style.display = 'block');
    }
    //updateVisibility();
  } else if (score === SCORE_NOT_REACHED) {
    // Clinic not reached - needs followup to set appt
    document.querySelectorAll('.appt_date').forEach(element => element.style.display = 'none');
    document.querySelector("label[for='CaCallGroupScheduledCallDateMonth']").innerHTML = "Next attempt to reach clinic ("+easternTimezone+")";
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      // Next call time should be 15 minutes from now
      const callDate = new Date();
      callDate.setMinutes(callDate.getMinutes() + 15);
      setDateField('CaCallGroupScheduledCallDate', callDate);
      document.querySelectorAll('.scheduled_call_date').forEach(element => element.style.display = 'block');
    }
    if (IS_CALL_GROUP_EDIT_PAGE) {
      document.querySelectorAll('.scheduled_call_date').forEach(element => element.style.display = 'block');
    }
    //updateVisibility();
  } else {
    // Non-prospect/missed opportunity
    document.querySelectorAll('.appt_date').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.scheduled_call_date').forEach(element => element.style.display = 'none');
    // Disable any fields that are required and hidden, or the form will fail to validate.
    //updateVisibility();
  }
}

async function onChangeGroupSearch(group_id) {
  document.querySelector(".lock-error").style.display = "none";
  if (group_id) {
    try {
      const response = await fetch(`/ca-calls/get_call_group_data/${group_id}`, {
        method: "POST",
        dataType: "json"
      });
      const data = await response.json();
      if (data["lock_error"] === true) {
        document.querySelector(".lock-error").style.display = "block";
        document.querySelector(".group-found").style.display = "none";
        //updateVisibility();
        document.querySelector("span.lockTime").textContent = data["lock_time"];
        document.querySelector("span.lockedBy").textContent = data["locked_by"];
        document.querySelector("#CaCallGroupId").value = group_id;
      } else {
        handleCallGroupChange(data);
      }
    } catch (error) {
      console.error("Error:", error);
    }
    //todo
    /*
    try {
      fetch(`/ca-calls/get_call_group_data/${group_id}`, {
        method: "GET",
        headers: {
          'Accept': 'application/json',
        },
      })
      .then(response => response.json())
      .then(data => {
        var size = Object.keys(data).length;
        if (size > 0) {
          // Found multiple pending calls
          const groupSearchElement = document.querySelector('.group_search');
          groupSearchElement.innerHTML = '';
          groupSearchElement.appendChild(new Option('', ''));
          for (const key in data) {
            groupSearchElement.appendChild(new Option(data[key], key));
          }
        } else {
          console.log('getPreviousCalls failed');
          console.debug(data);
        }
      });
    } catch (error) {
      console.error(error);
    }*/
  } else {
    handleCallGroupChange(null);
  }
}

function handleCallGroupChange(data) {
  if (data && data["CaCallGroup"]) {
    document.querySelector("span.callGroupId").textContent = data["CaCallGroup"]["id"];
    document.querySelector("#CaCallCaCallGroupId").value = data["CaCallGroup"]["id"];
    document.querySelector("#CaCallGroupId").value = data["CaCallGroup"]["id"];
    document.querySelector("#CaCallGroupStatus").value = data["CaCallGroup"]["status"];
    document.querySelector("span.status").textContent = statuses[data["CaCallGroup"]["status"]];
    showGroupFound();
    document.querySelector("#CaCallGroupCallerFirstName").value = data["CaCallGroup"]["caller_first_name"];
    document.querySelector("#CaCallGroupCallerLastName").value = data["CaCallGroup"]["caller_last_name"];
    document.querySelector("#CaCallGroupCallerPhone").value = data["CaCallGroup"]["caller_phone"];
    document.querySelector("#CaCallGroupIsPatient").checked = data["CaCallGroup"]["is_patient"];
    document.querySelector("#CaCallGroupPatientFirstName").value = data["CaCallGroup"]["patient_first_name"];
    document.querySelector("#CaCallGroupPatientLastName").value = data["CaCallGroup"]["patient_last_name"];
    document.querySelector("#CaCallGroupTopicWantsAppt").checked = data["CaCallGroup"]["topic_wants_appt"];
    document.querySelector("#CaCallGroupTopicClinicHours").checked = data["CaCallGroup"]["topic_clinic_hours"];
    document.querySelector("#CaCallGroupTopicInsurance").checked = data["CaCallGroup"]["topic_insurance"];
    document.querySelector("#CaCallGroupTopicClinicInquiry").checked = data["CaCallGroup"]["topic_clinic_inquiry"];
    document.querySelector("#CaCallGroupTopicAidLostOld").checked = data["CaCallGroup"]["topic_aid_lost_old"];
    document.querySelector("#CaCallGroupTopicAidLostNew").checked = data["CaCallGroup"]["topic_aid_lost_new"];
    document.querySelector("#CaCallGroupTopicWarrantyOld").checked = data["CaCallGroup"]["topic_warranty_old"];
    document.querySelector("#CaCallGroupTopicWarrantyNew").checked = data["CaCallGroup"]["topic_warranty_new"];
    document.querySelector("#CaCallGroupTopicBatteries").checked = data["CaCallGroup"]["topic_batteries"];
    document.querySelector("#CaCallGroupTopicParts").checked = data["CaCallGroup"]["topic_parts"];
    document.querySelector("#CaCallGroupTopicCancelAppt").checked = data["CaCallGroup"]["topic_cancel_appt"];
    document.querySelector("#CaCallGroupTopicRescheduleAppt").checked = data["CaCallGroup"]["topic_reschedule_appt"];
    document.querySelector("#CaCallGroupTopicApptFollowup").checked = data["CaCallGroup"]["topic_appt_followup"];
    document.querySelector("#CaCallGroupTopicMedicalRecords").checked = data["CaCallGroup"]["topic_medical_records"];
    document.querySelector("#CaCallGroupTopicTinnitus").checked = data["CaCallGroup"]["topic_tinnitus"];
    document.querySelector("#CaCallGroupTopicMedicalInquiry").checked = data["CaCallGroup"]["topic_medical_inquiry"];
    document.querySelector("#CaCallGroupTopicSolicitor").checked = data["CaCallGroup"]["topic_solicitor"];
    document.querySelector("#CaCallGroupTopicPersonalCall").checked = data["CaCallGroup"]["topic_personal_call"];
    document.querySelector("#CaCallGroupTopicRequestFax").checked = data["CaCallGroup"]["topic_request_fax"];
    document.querySelector("#CaCallGroupTopicRequestName").checked = data["CaCallGroup"]["topic_request_name"];
    document.querySelector("#CaCallGroupTopicRemoveFromList").checked = data["CaCallGroup"]["topic_remove_from_list"];
    document.querySelector("#CaCallGroupTopicForeignLanguage").checked = data["CaCallGroup"]["topic_foreign_language"];
    document.querySelector("#CaCallGroupTopicOther").checked = data["CaCallGroup"]["topic_other"];
    document.querySelector("#CaCallGroupTopicDeclined").checked = data["CaCallGroup"]["topic_declined"];
    document.querySelector("#CaCallGroupProspect").value = data["CaCallGroup"]["prospect"];
    if (!IS_CLINIC_LOOKUP_PAGE) {
      // Don't overwrite the front desk name on the clinic lookup page
      document.querySelector("#ca-call-group-front-desk-name").value = data["CaCallGroup"]["front_desk_name"];
    }
    document.querySelector("#CaCallGroupScore").value = data["CaCallGroup"]["score"];
    document.querySelector("#CaCallGroupIsReviewNeeded").checked = data["CaCallGroup"]["is_review_needed"];
    if (document.querySelector("#ca-call-group-location-id").value != data["CaCallGroup"]["location_id"]) {
      // Only trigger a location change if different
      document.querySelector("#ca-call-group-location-id").value = data["CaCallGroup"]["location_id"];
    }
    setDateField("CaCallGroupApptDate", data["CaCallGroup"]["appt_date"]);
    setDateField("CaCallGroupScheduledCallDate", data["CaCallGroup"]["scheduled_call_date"]);
    showOutcome(data["CaCallGroup"]["status"]);
  } else {
    clearAllFields();
  }
}

function clearAllFields() {
  document.querySelectorAll("span.callGroupId").forEach((element) => {
    element.textContent = "";
  });

  const elementsToClear = [
    "#CaCallCaCallGroupId",
    "#CaCallGroupId",
    "#CaCallGroupCallerFirstName",
    "#CaCallGroupCallerLastName",
    "#CaCallGroupCallerPhone",
    "#CaCallGroupPatientFirstName",
    "#CaCallGroupPatientLastName",
    "#ca-call-group-front-desk-name",
  ];

  elementsToClear.forEach((selector) => {
    document.querySelector(selector).value = "";
    document.querySelector(selector).dispatchEvent(new Event("change"));
  });

  const checkboxesToUncheck = [
    "#CaCallGroupIsPatient",
    "#CaCallGroupTopicWantsAppt",
    "#CaCallGroupTopicClinicHours",
    "#CaCallGroupTopicInsurance",
    "#CaCallGroupTopicClinicInquiry",
    "#CaCallGroupTopicAidLostOld",
    "#CaCallGroupTopicAidLostNew",
    "#CaCallGroupTopicWarrantyOld",
    "#CaCallGroupTopicWarrantyNew",
    "#CaCallGroupTopicBatteries",
    "#CaCallGroupTopicParts",
    "#CaCallGroupTopicCancelAppt",
    "#CaCallGroupTopicRescheduleAppt",
    "#CaCallGroupTopicApptFollowup",
    "#CaCallGroupTopicMedicalRecords",
    "#CaCallGroupTopicTinnitus",
    "#CaCallGroupTopicMedicalInquiry",
    "#CaCallGroupTopicSolicitor",
    "#CaCallGroupTopicPersonalCall",
    "#CaCallGroupTopicRequestFax",
    "#CaCallGroupTopicRequestName",
    "#CaCallGroupTopicRemoveFromList",
    "#CaCallGroupTopicForeignLanguage",
    "#CaCallGroupTopicOther",
    "#CaCallGroupTopicDeclined",
  ];

  checkboxesToUncheck.forEach((selector) => {
    document.querySelector(selector).checked = false;
  });

  document.querySelector("#CaCallGroupStatus").value = statuses[STATUS_NEW];
  document.querySelector("span.status").textContent = statuses[STATUS_NEW];
  showGroupFound();

  document.querySelector("#CaCallGroupProspect").value = PROSPECT_NO;
  document.querySelector("#CaCallGroupProspect").dispatchEvent(new Event("change"));

  document.querySelector("#CaCallGroupScore").value = "";
  document.querySelector("#CaCallGroupScore").dispatchEvent(new Event("change"));

  const locationSearchInput = document.querySelector("#location-search");
  const locationIdInput = document.querySelector("#ca-call-group-location-id");

  if (locationSearchInput && locationSearchInput.value !== "") {
    // Changing the group id should not clear the location search
  } else if (locationIdInput.value !== "") {
    // Only trigger a location change if different
    locationIdInput.value = "";
    locationIdInput.dispatchEvent(new Event("change"));
  }

  setDateField("CaCallGroupApptDate", null);
  setDateField("CaCallGroupScheduledCallDate", null);

  showOutcome();
}

function doWeHaveLocationAndFrontDesk() {
  const locationId = document.querySelector("#ca-call-group-location-id").value;
  const frontDeskName = document.querySelector("#ca-call-group-front-desk-name").value;
  const locationAndFrontDeskElements = document.querySelectorAll(".have-location-and-front-desk");
  
  if (locationId && frontDeskName) {
    locationAndFrontDeskElements.forEach((element) => {
      element.style.display = "block";
    });
  } else {
    locationAndFrontDeskElements.forEach((element) => {
      element.style.display = "none";
    });
  }
  
  //updateVisibility();
}

function doWeHaveLocationInitially() {
  const locationId = document.querySelector("#ca-call-group-location-id").value;
  const initHaveLocationElements = document.querySelectorAll(".init_have_location");
  const initNoLocationElements = document.querySelectorAll(".init_no_location");

  if (locationId) {
    initHaveLocationElements.forEach((element) => {
      element.style.display = "block";
    });

    initNoLocationElements.forEach((element) => {
      element.style.display = "none";
    });
  } else {
    initHaveLocationElements.forEach((element) => {
      element.style.display = "none";
    });

    initNoLocationElements.forEach((element) => {
      element.style.display = "block";
    });
  }

  //updateVisibility();
}

function showGroupFound() {
  const groupId = document.querySelector("#ca-call-group-id").value;
  const frontDeskName = document.querySelector("#ca-call-group-front-desk-name").value;
  const groupFoundElement = document.querySelector(".group-found");
  const groupFoundButtonsElement = document.querySelector(".group-found-buttons");

  if (groupId && frontDeskName) {
    const groupNotLoaded = groupFoundElement && (groupFoundElement.dataset.groupId !== groupId);
    const isGroupLocked = document.querySelector(".lock-error") && document.querySelector(".lock-error").style.display === "block";

    if (groupNotLoaded && !isGroupLocked) {
      groupFoundElement.dataset.groupId = groupId;
      fetch(`/admin/ca-calls/ajax_outbound_followup_form/${groupId}`)
        .then((response) => response.text())
        .then((data) => {
          const status = document.querySelector("#CaCallGroupStatus").value;
          const callTypeElement = document.querySelector("#CaCallCallType");

          if (status === STATUS_OUTBOUND_CLINIC_ATTEMPTED || status === STATUS_APPT_SET) {
            callTypeElement.value = CALL_TYPE_OUTBOUND_CLINIC;
          } else if (status === STATUS_TENTATIVE_APPT) {
            callTypeElement.value = CALL_TYPE_FOLLOWUP_TENTATIVE_APPT;
          } else {
            callTypeElement.value = CALL_TYPE_FOLLOWUP_APPT;
          }

          groupFoundElement.innerHTML = data;
          groupFoundElement.style.display = "block";
          onPageLoad();
          questionsOnLoad();
          triggerChangeEvents(["#ca-call-group-location-id", "#CaCallCallType"]);
          document.querySelector("span.locationTitle").innerHTML = locationTitle;
        });
    }

    groupFoundButtonsElement.style.display = "block";
    //updateVisibility();
  } else {
    if (groupFoundElement) {
      groupFoundElement.innerHTML = "";
      groupFoundElement.style.display = "none";
    }
    if (groupFoundButtonsElement) {
      groupFoundButtonsElement.style.display = "none";
    }
    //updateVisibility();
  }
}

function showOutcome() {
  const status = document.querySelector('#status') ? document.querySelector('#status').value : document.querySelector('#ca-call-group-status').value;
  const outcomeElement = document.querySelector('#outcome');

  if (status) {
    if (status === STATUS_OUTBOUND_CLINIC_COMPLETE || status === STATUS_OUTBOUND_CUST_SURVEY_COMPLETE) {
      outcomeElement.style.display = 'block';
    } else {
      outcomeElement.style.display = 'none';
    }
  } else {
    outcomeElement.style.display = 'none';
  }

  //updateVisibility();
}

function onChangeApptDate() {
  const callDate = getDateField('CaCallGroupApptDate');
  callDate.setDate(callDate.getDate() + 1);
  setDateField('CaCallGroupScheduledCallDate', callDate);
}

function onChangeCallerFirstName(callerFirstName) {
  const callerFirstNameElement = document.querySelector('span.callerFirstName');
  callerFirstNameElement.textContent = callerFirstName;
  onChangePatientInfo();
}

function onChangeCallerLastName(callerLastName) {
  const callerLastNameElement = document.querySelector('span.callerLastName');
  callerLastNameElement.textContent = callerLastName;
  onChangePatientInfo();
}

function onChangeCallerPhone(callerPhone) {
  let formattedPhone = callerPhone;
  if (callerPhone.length === 10) {
    formattedPhone = callerPhone.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
  } else if (callerPhone.length === 11) {
    formattedPhone = callerPhone.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1-$2-$3-$4');
  }
  const callerPhoneElement = document.querySelector('span.callerPhone');
  callerPhoneElement.textContent = formattedPhone;
}

function onChangePatientInfo() {
  const isPatient = document.querySelector('#ca-call-group-is-patient, #is-patient').checked;
  if (isPatient) {
    document.querySelectorAll('span.not-self').forEach(element => {
      element.style.display = 'none';
    });
    document.querySelectorAll('span.self').forEach(element => {
      element.style.display = 'block';
    });
    document.querySelectorAll('span.isNotPatient').forEach(element => {
      element.style.display = 'none';
    });
    const patientNameElement = document.querySelector('span.patientName');
    if (patientNameElement) {
      const callerFirstName = document.querySelector('#ca-call-group-caller-first-name, #caller-first-name').value;
      const callerLastName = document.querySelector('#ca-call-group-caller-last-name, #caller-last-name').value;
      patientNameElement.textContent = callerFirstName + ' ' + callerLastName;
    }
  } else {
    document.querySelectorAll('span.isNotPatient').forEach(element => {
      element.style.display = 'block';
    });
    const patientNameElement = document.querySelector('span.patientName');
    if (patientNameElement) {
      const patientFirstName = document.querySelector('#ca-call-group-patient-first-name, #patient-first-name').value;
      const patientLastName = document.querySelector('#ca-call-group-patient-last-name, #patient-last-name').value;
      patientNameElement.textContent = patientFirstName + ' ' + patientLastName;
    }
    document.querySelectorAll('span.self').forEach(element => {
      element.style.display = 'none';
    });
    document.querySelectorAll('span.not-self').forEach(element => {
      element.style.display = 'block';
    });
  }
}

function onChangeFrontDeskName(frontDeskName) {
  const frontDeskNameElement = document.querySelector('span.frontDeskName');
  frontDeskNameElement.textContent = frontDeskName;
  doWeHaveLocationAndFrontDesk();
  showGroupFound();
}


function getDateField(prefix) {
  const month = document.querySelector(`#${prefix}Month`).value;
  const day = document.querySelector(`#${prefix}Day`).value;
  const year = document.querySelector(`#${prefix}Year`).value;
  const hour = document.querySelector(`#${prefix}Hour`).value;
  const min = document.querySelector(`#${prefix}Min`).value;
  const meridian = document.querySelector(`#${prefix}Meridian`).value;
  const date = new Date(`${year}/${month}/${day} ${hour}:${min} ${meridian}`);
  return date;
}

function setDateField(prefix, date) {
  let newDate;
  if (date) {
    if (typeof date === 'string') {
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
  let hour = newDate.getHours();
  let meridian;
  if (hour < 12 || hour === 24) {
    meridian = 'am';
  } else {
    meridian = 'pm';
  }
  if (hour > 12) {
    hour -= 12;
  }
  document.querySelector(`#${prefix}Month`).value = `0${newDate.getMonth() + 1}`.slice(-2).toString();
  document.querySelector(`#${prefix}Day`).value = `0${newDate.getDate()}`.slice(-2).toString();
  document.querySelector(`#${prefix}Year`).value = newDate.getFullYear().toString();
  document.querySelector(`#${prefix}Hour`).value = `0${hour}`.slice(-2).toString();
  document.querySelector(`#${prefix}Min`).value = `0${newDate.getMinutes()}`.slice(-2).toString();
  document.querySelector(`#${prefix}Meridian`).value = meridian;
}

function disableHiddenFields() {
  Array.from(document.querySelectorAll(`fieldset div[style*="display:none"] input, fieldset div[style*="display:none"] select`)).forEach(input => {
    input.setAttribute("disabled","disabled");
  });
}

function updateVisibility(className = 'form_fields') {
  // TODO: I DON'T THINK WE NEED THIS ANYMORE
  /*
  // This will disable all hidden fields and enable all visible fields within the specified class
  Array.from(document.querySelectorAll(`.${className} input[type="hidden"]`)).forEach(input => {
    //TODO: I DON'T KNOW IF THIS CODE IS CORRECT
    input.disabled = true;
  });
  // TODO:
  Array.from(document.querySelectorAll(`.${className} input:not([type="hidden"])`)).forEach(input => {
    input.disabled = false;
  });
  // We don't want to disable the hidden checkbox fields. These are important.
  Array.from(document.querySelectorAll('div.checkbox input')).forEach(input => {
    //todo:
    input.disabled = false;
  });
  */
}

function onChangeTopic() {
  const topics = [];
  let isTopicAidLost = false;
  let isTopicWarranty = false;

  document.querySelectorAll('[id^=CaCallGroupTopic]:checked').forEach(topic => {
    const topicLabel = topic.nextElementSibling.innerHTML;
    const topicId = topic.id;

    if (topicId.includes("CaCallGroupTopicAidLost")) {
      isTopicAidLost = true;
    } else if (topicId.includes("CaCallGroupTopicWarranty")) {
      isTopicWarranty = true;
    } else if (topicLabel !== undefined) {
      topics.push(topicLabel);
    }
  });

  if (isTopicAidLost) {
    topics.push("Hearing aid lost/broken");
  }
  if (isTopicWarranty) {
    topics.push("Hearing aid warranty question");
  }

  if (topics.length) {
    document.querySelector('span.callerTopics').innerHTML = topics.join(', ');
    document.getElementById('CaCallGroupTopicParts').setCustomValidity('');
  } else {
    document.querySelector('span.callerTopics').innerHTML = 'unknown';
    document.getElementById('CaCallGroupTopicParts').setCustomValidity('At least one topic is required');
  }

  // Calculate prospect based on topics selected
  onChangeProspect(null);
}

function onChangeTopicWantsAppt(wantsAppt) {
  const isDirectBookDm = document.getElementById("CaCallGroupDirectBookType").value === DIRECT_BOOK_DM;

  // If wants appt and this is a direct book DM location, show the hearing test question
  if (wantsAppt && isDirectBookDm) {
    document.querySelectorAll('.wantsHearingTest').forEach(element => {
      element.style.display = 'block';
    });
  } else {
    document.querySelectorAll('.wantsHearingTest').forEach(element => {
      element.style.display = 'none';
    });
  }

  updateVisibility();
}

function onChangeConsumerConsent(consumerConsent) {
  if (consumerConsent === 'yes') {
    document.querySelectorAll('.consumerConsentYes').forEach(element => {
      element.style.display = 'block';
    });
    document.querySelectorAll('.consumerConsentNo').forEach(element => {
      element.style.display = 'none';
    });
    document.querySelector('span.callTransferInstructions').innerHTML = "[Mute and listen to appointment info]";
  } else if (consumerConsent === 'no') {
    document.querySelectorAll('.consumerConsentYes').forEach(element => {
      element.style.display = 'none';
    });
    document.querySelectorAll('.consumerConsentNo').forEach(element => {
      element.style.display = 'block';
    });
    document.querySelector('span.callTransferInstructions').innerHTML = "[Hang up and score as 'Tentative appointment'.]";
    document.getElementById('CaCallGroupScore').value = SCORE_TENTATIVE_APPT;
    document.getElementById('CaCallGroupScore').dispatchEvent(new Event('change'));
  }
}

function onChangeDidClinicAnswer(didClinicAnswer) {
  const prospectOptions = document.querySelector('.prospectOptions');

  if (prospectOptions.style.display === 'none') {
    prospectOptions.style.display = 'block';
  }

  const didClinicAnswerYes = document.querySelectorAll('.didClinicAnswerYes');
  const didClinicAnswerNo = document.querySelectorAll('.didClinicAnswerNo');
  const didClinicAnswerVm = document.querySelectorAll('.didClinicAnswerVm');

  if (didClinicAnswer === 'yes') {
    didClinicAnswerYes.forEach(element => {
      element.style.display = 'block';
    });
    didClinicAnswerNo.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerVm.forEach(element => {
      element.style.display = 'none';
    });
    updateVisibility();
    document.getElementById('CaCallGroupScore').value = '';
    document.getElementById('CaCallGroupScore').dispatchEvent(new Event('change'));
  } else if (didClinicAnswer === 'no') {
    didClinicAnswerYes.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerNo.forEach(element => {
      element.style.display = 'block';
    });
    didClinicAnswerVm.forEach(element => {
      element.style.display = 'none';
    });
    updateVisibility();
    const groupProspect = document.getElementById('CaCallGroupProspect').value;
    if (groupProspect === PROSPECT_YES) {
      if (document.getElementById('ca-call-group-refused-name').checked) {
        document.getElementById('CaCallGroupScore').value = SCORE_MISSED_OPPORTUNITY;
      } else {
        document.getElementById('CaCallGroupScore').value = SCORE_NOT_REACHED;
      }
      document.getElementById('CaCallGroupScore').dispatchEvent(new Event('change'));
    }
  } else if (didClinicAnswer === 'vm') {
    // No, but we can leave a voicemail
    didClinicAnswerYes.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerNo.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerVm.forEach(element => {
      element.style.display = 'block';
    });
    updateVisibility();
    if (document.getElementById('CaCallGroupProspect').value === PROSPECT_YES) {
      document.getElementById('CaCallGroupScore').value = SCORE_TENTATIVE_APPT;
      document.getElementById('CaCallGroupScore').dispatchEvent(new Event('change'));
    }
  } else if (didClinicAnswer === 'cr') {
    document.getElementById('CaCallGroupScore').value = SCORE_DISCONNECTED;
    prospectOptions.style.display = 'none';
    didClinicAnswerYes.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerNo.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerVm.forEach(element => {
      element.style.display = 'none';
    });
    updateVisibility();
  } else {
    didClinicAnswerYes.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerNo.forEach(element => {
      element.style.display = 'none';
    });
    didClinicAnswerVm.forEach(element => {
      element.style.display = 'none';
    });
    document.querySelector('.scheduled_call_date').style.display = 'block';
    document.getElementById('CaCallGroupScore').value = '';
    document.getElementById('CaCallGroupScore').dispatchEvent(new Event('change'));
    updateVisibility();
  }
}

function onChangeDidTheyAnswerVm(didTheyAnswer) {
  const callDate = new Date();

  const didTheyAnswerYes = document.getElementById('didTheyAnswerYes');
  const didTheyAnswerNo = document.getElementById('didTheyAnswerNo');
  const didTheyAnswerVm = document.getElementById('didTheyAnswerVm');

  if (didTheyAnswer === 'yes') {
    didTheyAnswerYes.style.display = 'block';
    didTheyAnswerNo.style.display = 'none';
    didTheyAnswerVm.style.display = 'none';
    updateVisibility();
  } else if (didTheyAnswer === 'vm') {
    didTheyAnswerYes.style.display = 'none';
    didTheyAnswerNo.style.display = 'none';
    didTheyAnswerVm.style.display = 'block';
    updateVisibility();
  } else if (didTheyAnswer === 'noAttempt') {
    didTheyAnswerYes.style.display = 'none';
    didTheyAnswerNo.style.display = 'block';
    document.querySelector('#didTheyAnswerNo .scheduled_call_date').style.display = 'block';
    didTheyAnswerVm.style.display = 'none';
    updateVisibility();
    // Default next call time to 2 hours from now
    callDate.setMinutes(callDate.getMinutes() + 120);
    setDateField('NoAnswerScheduledCallDate', callDate);
  } else {
    didTheyAnswerYes.style.display = 'none';
    didTheyAnswerNo.style.display = 'block';
    document.querySelector('#didTheyAnswerNo .scheduled_call_date').style.display = 'block';
    didTheyAnswerVm.style.display = 'none';
    updateVisibility();
    // Default next call time to 30 minutes from now
    callDate.setMinutes(callDate.getMinutes() + 30);
    setDateField('NoAnswerScheduledCallDate', callDate);
  }
}

function onChangeDidTheyAnswerFollowup(answer) {
  const callType = $("#CaCallCallType").val();
  const didTheyAnswerFollowupYes = $(".didTheyAnswerFollowupYes");
  const didTheyAnswerFollowupNo = $(".didTheyAnswerFollowupNo");
  const didTheyAnswerFollowupVm = $(".didTheyAnswerFollowupVm");
  const followupForm = $(".followupForm");
  const scheduledCallDate = $(".scheduled_call_date");

  if (answer === 'yes') {
    didTheyAnswerFollowupYes.show();
    didTheyAnswerFollowupNo.hide();
    didTheyAnswerFollowupVm.hide();
    scheduledCallDate.hide();
  } else if (answer === 'vm') {
    const prospect = $("#CaCallGroupProspect").val();
    didTheyAnswerFollowupYes.hide();
    didTheyAnswerFollowupNo.hide();
    didTheyAnswerFollowupVm.show();
    if (callType === CALL_TYPE_FOLLOWUP_NO_ANSWER || prospect === PROSPECT_NO) {
      followupForm.hide();
      scheduledCallDate.hide();
    } else {
      followupForm.show();
      $('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
    }
  } else { // NO
    didTheyAnswerFollowupYes.hide();
    didTheyAnswerFollowupVm.hide();
    didTheyAnswerFollowupNo.show();
    followupForm.hide();
    scheduledCallDate.show();
    const nextCallDate = new Date();
    if (callType === CALL_TYPE_FOLLOWUP_APPT) {
      let nextCallMinutes = 15;
      switch ($("#CaCallGroupClinicFollowupCount").val()) {
        case '1':
          nextCallMinutes = 15; // 15 minutes
          break;
        case '2':
          nextCallMinutes = 120; // 2 hours
          break;
        default: // 3-8
          nextCallMinutes = 240; // 4 hours
          break;
      }
      nextCallDate.setMinutes(nextCallDate.getMinutes() + nextCallMinutes);
      setDateField('CaCallGroupScheduledCallDate', nextCallDate);
    } else if (
      callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT ||
      callType === CALL_TYPE_FOLLOWUP_NO_ANSWER
    ) {
      // Try again in 4 hours
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 240);
      setDateField('CaCallGroupScheduledCallDate', nextCallDate);
    } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST) {
      // Try again in 15 minutes
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 15);
      setDateField('CaCallGroupScheduledCallDate', nextCallDate);
    } else {
      // Try again in 15 minutes
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 15);
      setDateField('CaCallGroupScheduledCallDate', nextCallDate);
      $("label[for='CaCallGroupScheduledCallDateMonth']").html(
        "Next attempt to reach consumer (" + easternTimezone + ")"
      );
    }
  }
  updateVisibility();
}

function onChangeDidConsumerAnswer(answer) {
  const callType = $("#CaCallCallType").val();
  const didConsumerAnswerYes = $(".didConsumerAnswerYes");
  const didConsumerAnswerNo = $(".didConsumerAnswerNo");
  const didConsumerAnswerVm = $(".didConsumerAnswerVm");
  const didConsumerAnswerInvalid = $(".didConsumerAnswerInvalid");
  const followupForm = $(".followupForm");
  const scheduledCallDate = $(".scheduled_call_date");
  const nextCallDate = new Date();

  if (answer === 'yes') {
    didConsumerAnswerYes.show();
    didConsumerAnswerNo.hide();
    didConsumerAnswerVm.hide();
    didConsumerAnswerInvalid.hide();
    followupForm.show();
    scheduledCallDate.hide();
  } else if (answer === 'vm') {
    didConsumerAnswerYes.hide();
    didConsumerAnswerNo.hide();
    didConsumerAnswerVm.show();
    didConsumerAnswerInvalid.hide();
    if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST) {
      scheduledCallDate.show();
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 240);
      setDateField('CaCallGroupScheduledCallDate', nextCallDate);
    } else {
      followupForm.show();
      $('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
    }
  } else if (answer === 'invalid') {
    didConsumerAnswerYes.hide();
    didConsumerAnswerNo.hide();
    didConsumerAnswerVm.hide();
    didConsumerAnswerInvalid.show();
    followupForm.show();
    $('#CaCallGroupScore').val(SCORE_DISCONNECTED).trigger('change');
  } else { // NO
    const prospect = $("#CaCallGroupProspect").val();
    didConsumerAnswerYes.hide();
    didConsumerAnswerNo.show();
    didConsumerAnswerVm.hide();
    didConsumerAnswerInvalid.hide();
    if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT || prospect === PROSPECT_NO) {
      followupForm.hide();
    } else {
      followupForm.show();
      $('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
    }
  }
  updateVisibility();
}

function onChangeDidConsumerAnswer2(answer) {
  const didConsumerAnswer2Yes = $(".didConsumerAnswer2Yes");
  const didConsumerAnswer2No = $(".didConsumerAnswer2No");
  const followupForm = $(".followupForm");
  const scheduledCallDate = $(".scheduled_call_date");

  if (answer === 'yes') {
    didConsumerAnswer2Yes.show();
    didConsumerAnswer2No.hide();
    followupForm.show();
    scheduledCallDate.hide();
  } else { // NO
    didConsumerAnswer2Yes.hide();
    didConsumerAnswer2No.show();
    followupForm.show();
    $('#CaCallGroupScore').val(SCORE_TENTATIVE_APPT).trigger('change');
  }
  updateVisibility();
}

function onChangeDidTheyWantHelp(answer) {
  const wantHelpYes = $(".wantHelpYes");
  const wantHelpNo = $(".wantHelpNo");

  if (answer === 1) { // YES
    wantHelpYes.show();
    wantHelpNo.hide();
  } else { // NO
    wantHelpYes.hide();
    wantHelpNo.show();
  }
  updateVisibility();
}

function onChangeDidClinicContactConsumer(answer) {
  const didClinicContactConsumerYes = $(".didClinicContactConsumerYes");
  const didClinicContactConsumerNo = $(".didClinicContactConsumerNo");
  const followupForm = $(".followupForm");
  const callType = $("#CaCallCallType").val();

  if (answer === 1) { // YES
    didClinicContactConsumerYes.show();
    didClinicContactConsumerNo.hide();
    followupForm.show();
  } else { // NO
    didClinicContactConsumerYes.hide();
    didClinicContactConsumerNo.show();
    $('#CaCallGroupDidTheyWantHelp').val('');
    $('#CaCallGroupScore').val(SCORE_MISSED_OPPORTUNITY).trigger('change');
    if (callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT) {
      followupForm.show();
    } else { // CALL_TYPE_FOLLOWUP_NO_ANSWER
      followupForm.hide();
    }
  }
  updateVisibility();
}

function onChangeRefusedName() {
  const refusedNameNo = $('.refusedNameNo');
  const refusedNameYes = $('.refusedNameYes');
  const topicDeclined = $('#CaCallGroupTopicDeclined');

  if ($('#ca-call-group-refused-name').prop('checked')) {
    refusedNameNo.hide();
    refusedNameYes.show();
    if (pageLoadComplete) {
      topicDeclined.prop('checked', true).trigger('change');
    }
    // Don't leave vm at clinic if we don't know caller name
    $("#CaCallGroupDidClinicAnswer option[value='vm']").remove();
  } else {
    refusedNameNo.show();
    refusedNameYes.hide();
    if (pageLoadComplete) {
      topicDeclined.prop('checked', false).trigger('change');
    }
    if ($("#CaCallGroupDidClinicAnswer option[value='vm']").length === 0) {
      $("#CaCallGroupDidClinicAnswer").append('<option value="vm">No, but leave voicemail</option>');
    }
  }
  updateVisibility();
}

function onChangeDidClinicRefuse() {
  const didClinicRefuseYes = document.querySelector(".didClinicRefuseYes");
  const isReviewNeeded = document.querySelector('#CaCallGroupIsReviewNeeded');
  const score = document.querySelector('#CaCallGroupScore');
  if (document.querySelector('#CaCallGroupDidClinicRefuse').checked) {
    didClinicRefuseYes.style.display = "block";
    if (pageLoadComplete) {
      isReviewNeeded.checked = true;
      score.value = SCORE_MISSED_OPPORTUNITY;
      score.dispatchEvent(new Event('change'));
    }
  } else {
    didClinicRefuseYes.style.display = "none";
    if (pageLoadComplete) {
      isReviewNeeded.checked = false;
      score.value = SCORE_TENTATIVE_APPT;
      score.dispatchEvent(new Event('change'));
    }
  }
  updateVisibility();
}