import '../common/common';

var locationTitle = '';
var locationTimezoneOffset = '';
var pageLoadComplete = false;
var DIRECT_BOOK_NONE = DIRECT_BOOK_NONE ? DIRECT_BOOK_NONE : '';


const onPageLoad = () => {

  // Listen for button click events
  document.querySelector('body').addEventListener('click', e => {
    const targetId = e.target.id;

    if (targetId === 'cancelBtn') {
      const caCallGroupId = document.querySelector('#ca-call-group-id')?.value;
      const url = `/ca-calls/unlock-call-group/${caCallGroupId}`;

      fetch(url)
        .then(response => response.json())
        .then(data => {
          if (data.unlock_status === true) {
            window.location = '/admin/ca-call-groups/outbound';
          }
        })
        .catch(error => {
          console.log('unlockCallGroup() error:');
          console.error('An error occurred:', error);
        });
    }

    if (targetId === 'disconnectedBtn') {
      // The "disconnected" button was clicked
      // Make sure the Notes field is filled in
      const callGroupNoteValue = document.querySelector('[id^=ca-call-group-ca-call-group-note]')?.value.trim();
      if (callGroupNoteValue) {
        const callType = document.querySelector('#call-type')?.value;
        const callTypeInboundOptions = [CALL_TYPE_INBOUND, CALL_TYPE_VM_CALLBACK_CLINIC, CALL_TYPE_VM_CALLBACK_CONSUMER, CALL_TYPE_INBOUND_QUICK_PICK];
        let callDate;

        if (callTypeInboundOptions.includes(callType)) {
          // If a new incoming call or VM follow-up call was disconnected, submit the form without validation.
          // This will just save the call in our database in case they call back.
          setElementValue('#ca-call-group-status', STATUS_INCOMPLETE);
          setElementValue('#ca-call-group-score', SCORE_DISCONNECTED);
        }

        document.querySelector('#CaCallForm').submit();
      } else {
        var noteRequiredModal = new bootstrap.Modal(document.getElementById('note-required'));
        noteRequiredModal.show();
      }
    }

    if (targetId === 'unlockBtn') {
      const caCallGroupId = document.querySelector('#ca-call-group-id')?.value;
      try {
        const response = fetch(`/ca-calls/unlock-call-group/${caCallGroupId}`, {
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
        console.log('unlockCallGroup() error:');
        console.error(error);
      }
    }

    switch (targetId) {
      case 'spamBtn':
        setElementValue('#ca-call-group-is-spam', true);
        document.querySelector('#CaCallForm').submit();
        break;
      case 'deleteBtn':
        // The "delete" button was clicked. Display the confirmation modal.
        document.querySelector('#delete-modal').modal('show');
      case 'submitBtn':
        // Disable hidden fields before submitting
        updateVisibility();
        // The "save" button was clicked
        // Verify that we have a valid clinic value
        validateLocationId();
        // Verify we have a valid prospect value
        validateProspect();
        // Calculate status
        calculateStatus();
        var topicPartsElement = document.querySelector('#ca-call-group-topic-parts');
        if (topicPartsElement) {
          // If topics are hidden, remove the custom validation
          if (isHidden(topicPartsElement)) {
            topicPartsElement.setCustomValidity('');
          }
        }
        break;
      default:
        break;
    }
  });

  // Listen for field changes
  document.querySelector('body').addEventListener('change', e => {
    const targetId = e.target.id;
    const targetValue = e.target.value;
    const targetChecked = e.target.checked;

    if (targetId === 'ca-call-group-topic-warranty' || targetId === 'ca-call-group-topic-aid-lost') {
      // Check the statuses of both of the related checkboxes.
      const warrantyChecked = document.querySelector('#ca-call-group-topic-warranty').checked;
      const aidLostChecked = document.querySelector('#ca-call-group-topic-aid-lost').checked;

      // If either of these are checked, show the 'How Old is your Hearing Aid' dialog.
      if (warrantyChecked || aidLostChecked) {
        showElement('.aid_age_topic');
      } else {
        hideElement('.aid_age_topic');
      }

      // Trigger the change event for the age dialog, to make sure the correct (hidden) checkboxes are checked.
      triggerChange('#ca-call-group-hearing-aid-age');
    }

    if (targetId === 'ca-call-group-hearing-aid-age') {
      const warrantyChecked = document.querySelector('#ca-call-group-topic-warranty').checked;
      const aidLostChecked = document.querySelector('#ca-call-group-topic-aid-lost').checked;

      // Set the hidden checkboxes based on what topics are checked and the age of the hearing aid.
      setElementChecked('#ca-call-group-topic-aid-lost-old', (aidLostChecked && targetValue === 'old'));
      setElementChecked('#ca-call-group-topic-aid-lost-new', (aidLostChecked && targetValue === 'new'));
      setElementChecked('#ca-call-group-topic-aid-warranty-old', (warrantyChecked && targetValue === 'old'));
      setElementChecked('#ca-call-group-topic-aid-warranty-new', (warrantyChecked && targetValue === 'new'));
    }

    if (targetId === 'is-wrong-number') {
      const isWrongNumberChecked = document.querySelector('#is-wrong-number').checked;
      if (isWrongNumberChecked) {
        hideElement('.valid_number');
      } else {
        showElement('.valid_number');
      }
      updateVisibility();
    }

    if (targetId.includes('ca-call-group-topic')) {
      onChangeTopic();
    }

    //All other form logic using functions
    switch (targetId) {
      case 'ca-call-group-topic-wants-appt':
        onChangeTopicWantsAppt(targetChecked);
        break;
      case 'ca-call-group-wants-hearing-test':
        onChangeProspect(null);
        break;
      case 'location-id':
      case 'ca-call-group-location-id':
        onChangeLocationId(targetValue);
        break;
      case 'call-type':
        onChangeCallType(targetValue);
        break;
      case 'ca-call-group-is-patient':
      case 'is-patient':
        onChangeIsPatient(targetChecked);
        break;
      case 'ca-call-group-prospect':
        onChangeProspect(targetValue);
        break;
      case 'ca-call-group-score':
        onChangeScore(targetValue);
        break;
      case 'ca-call-group-status':
        onChangeStatus(targetValue);
        break;
      case 'group-search':
        onChangeGroupSearch(targetValue);
        break;
      case 'ca-call-group-caller-first-name':
        onChangeCallerFirstName(targetValue);
        break;
      case 'ca-call-group-caller-last-name':
        onChangeCallerLastName(targetValue);
        break;
      case 'ca-call-group-caller-phone':
        onChangeCallerPhone(targetValue);
        break;
      case 'ca-call-group-patient-first-name':
      case 'ca-call-group-patient-last-name':
        onChangePatientInfo();
        break;
      case 'ca-call-group-front-desk-name':
        onChangeFrontDeskName(targetValue);
        break;
      case 'ca-call-group-appt-date':
        onChangeApptDate();
        break;
      case 'ca-call-group-consumer-consent':
        onChangeConsumerConsent(targetValue);
        break;
      case 'ca-call-group-did-clinic-answer':
      case 'ca-call-group-did-clinic-answer-unknown':
        onChangeDidClinicAnswer(targetValue);
        break;
      case 'ca-call-group-did-they-answer-vm':
        onChangeDidTheyAnswerVm(targetValue);
        break;
      case 'ca-call-group-did-they-answer-followup':
      case 'ca-call-group-did-they-answer-followup2':
        onChangeDidTheyAnswerFollowup(targetValue);
        break;
      case 'ca-call-group-did-consumer-answer':
        onChangeDidConsumerAnswer(targetValue);
        break;
      case 'ca-call-group-did-consumer-answer2':
        onChangeDidConsumerAnswer2(targetValue);
        break;
      case 'ca-call-group-did-they-want-help':
        onChangeDidTheyWantHelp(targetValue);
        break;
      case 'ca-call-group-did-clinic-contact-consumer':
        onChangeDidClinicContactConsumer(targetValue);
        break;
      case 'ca-call-group-refused-name':
        onChangeRefusedName();
        break;
      case 'ca-call-group-did-clinic-refuse':
        onChangeDidClinicRefuse();
        break;
      case 'ca-call-group-voicemail-from':
        //todo
        setElementValue('#call-type', targetValue);
        break;
      case 'location-search':
        //TODO: Remove this when we fix autocomplete. This is temporary to handle a location id directly typed in.
        if (parseInt(targetValue) > 8119000000) {
          setElementValue('#ca-call-group-location-id', targetValue)
        }
        break;
      default:
        break;
    }

  });

  document.querySelector('body').addEventListener('keyup', e => {
    const targetId = e.target.id;
    const targetValue = e.target.value;

    if (targetId === 'ca-call-group-front-desk-name') {
      onChangeFrontDeskName(targetValue);
    }
  });

  // When a modal is hidden, blur any active elements to prevent the “Blocked aria-hidden" warning
  document.querySelector('body').addEventListener('hide.bs.modal', event => {
      document.activeElement.blur()
  })

  //Strip out default Cake validity inline code, and set up new validity check
  let requiredElements = document.querySelectorAll('input[required], select[required]');
  requiredElements.forEach(el => {
    el.removeAttribute('oninvalid');
    el.removeAttribute('oninput');

    let errorMessageP = document.createElement('p');
    errorMessageP.className = 'error-message col-md-offset-3 pl10';
    el.parentNode.insertAdjacentElement('afterend', errorMessageP);

    el.addEventListener('invalid', function () {
      this.setCustomValidity('');
      if (!this.value) {
        this.setCustomValidity(this.dataset.validityMessage);
        errorMessageP.textContent = this.dataset.validityMessage || 'Please fill out this field';
        errorMessageP.style.color = 'red';
      }
    });

    el.addEventListener('input', function () {
      this.setCustomValidity('');
      errorMessageP.textContent = '';
      errorMessageP.style.color = '';
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  onPageLoad();
  IS_CLINIC_LOOKUP_PAGE = typeof IS_CLINIC_LOOKUP_PAGE !== 'undefined' ? IS_CLINIC_LOOKUP_PAGE : false;
  IS_CALL_GROUP_EDIT_PAGE = typeof IS_CALL_GROUP_EDIT_PAGE !== 'undefined' ? IS_CALL_GROUP_EDIT_PAGE : false;

  doWeHaveLocationInitially();
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
  const selectors = ['#ca-call-group-location-id', '#call-type', '#ca-call-group-caller-first-name', '#ca-call-group-caller-last-name', '#ca-call-group-caller-phone', '#ca-call-group-is-patient', '#is-patient', '#ca-call-group-patient-first-name', '#ca-call-group-patient-last-name', '#ca-call-group-prospect', '#ca-call-group-front-desk-name', '#ca-call-group-score', '#ca-call-group-topic-warranty', '#is-wrong-number', '#ca-call-group-refused-name'];
  selectors.forEach(selector => {
    if (skipElements.indexOf(selector) === -1) {
      triggerChange(selector);
    }
  });
}

function triggerChange(selector) {
  var element = document.querySelector(selector);
  if (element !== null) {
    element.dispatchEvent(new Event('change', { bubbles: true }));
  }
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
    // FOR NOW, IF I TYPE A CLINIC ID, MAP IT TO THE CORRECT FIELD
  }
}

function validateLocationId() {
  const locationSearchInput = "input[name*='location_search']";
  if (document.querySelectorAll(locationSearchInput).length === 0) {
    // location-search is hidden, so mark valid
    return true;
  }
  const locationId = document.querySelector("#ca-call-group-location-id")?.value.trim();
  if (locationId && (parseInt(locationId) > 8119000000)) {
    document.querySelector(locationSearchInput).setCustomValidity('');
  } else {
    document.querySelector(locationSearchInput).setCustomValidity('Please select a valid clinic before saving.');
  }
}

const validateProspect = () => {
  const prospectInput = document.querySelector("#ca-call-group-prospect");
  if (prospectInput) {
    let isProspectInvalid = false;
    if (prospectInput.value === PROSPECT_UNKNOWN) {
      const clinicAnswerUnknownInput = document.querySelector("#ca-call-group-did-clinic-answer-unknown");
      if (clinicAnswerUnknownInput?.value === 'no') {
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
  const callType = document.querySelector("#call-type")?.value;
  const isVoicemailType =
    callType === CALL_TYPE_VM_CALLBACK_CLINIC ||
    callType === CALL_TYPE_VM_CALLBACK_CONSUMER;
  let calculateByScore = false;

  if (IS_CALL_GROUP_EDIT_PAGE) {
    // Do not automatically calculate a new status on the Edit Call Group page
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#ca-call-group-did-they-answer-followup")?.value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#ca-call-group-clinic-followup-count")?.value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_SET_APPT);
    } else {
      setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_NO_ANSWER);
      document.querySelector("#ca-call-group-patient-followup-count").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#ca-call-group-did-they-answer-followup")?.value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#ca-call-group-clinic-followup-count")?.value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      setElementValue('#ca-call-group-status', STATUS_TENTATIVE_APPT);
    } else {
      setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_NO_ANSWER);
      document.querySelector("#ca-call-group-patient-followup-count").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#ca-call-group-did-they-answer-followup")?.value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_APPT_REQUEST_FORM);
    } else {
      setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_NO_ANSWER);
      document.querySelector("#ca-call-group-patient-followup-count").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT && !IS_CLINIC_LOOKUP_PAGE) {
    if (document.querySelector("#ca-call-group-did-consumer-answer")?.value === "yes" && document.querySelector("#ca-call-group-did-they-answer-followup")?.value === "no") {
      // Consumer answered but clinic did not. Next attempt will not be direct book.
      if (Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
        setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_APPT_REQUEST_FORM);
      } else {
        setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_NO_ANSWER);
        document.querySelector("#ca-call-group-patient-followup-count").value = 0;
      }
    } else if (document.querySelector("#ca-call-group-did-consumer-answer").value === "no" && document.querySelector("#ca-call-group-did-they-answer-followup2").value === "no") {
      // Neither consumer nor clinic answered
      if (
        Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
        setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_APPT_REQUEST_FORM);
      } else {
        setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_NO_ANSWER);
        document.querySelector("#ca-call-group-patient-followup-count").value = 0;
      }
    } else {
      calculateByScore = true;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_NO_ANSWER) {
    if (document.querySelector("#ca-call-group-did-they-answer-followup").value === "yes") {
      // Patient answered
      if (document.querySelector("#ca-call-group-score").value === SCORE_APPT_SET) {
        setElementValue('#ca-call-group-status', STATUS_APPT_SET);
      } else {
        setElementValue('#ca-call-group-status', STATUS_MO_NO_ANSWER);
        document.querySelector('#ca-call-group-score').disabled = false;
        setElementValue('#ca-call-group-score', SCORE_MISSED_OPPORTUNITY);
      }
    } else if (document.querySelector("#ca-call-group-did-they-answer-followup").value === "vm") {
      // Left a voicemail
      setElementValue('#ca-call-group-status', STATUS_MO_NO_ANSWER);
      document.querySelector('#ca-call-group-score').disabled = false;
      setElementValue('#ca-call-group-score', SCORE_MISSED_OPPORTUNITY);
    } else {
      // Patient did not answer
      if (Number(document.querySelector("#ca-call-group-patient-followup-count").value) < MAX_PATIENT_FOLLOWUP_ATTEMPTS) {
        setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_NO_ANSWER);
      } else {
        setElementValue('#ca-call-group-status', STATUS_MO_NO_ANSWER);
        document.querySelector('#ca-call-group-score').disabled = false;
        setElementValue('#ca-call-group-score', SCORE_MISSED_OPPORTUNITY);
      }
    }
  } else if (isVoicemailType && document.querySelector("#ca-call-group-did-they-answer-vm").value === "vm") {
    setElementValue('#ca-call-group-status', STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS);
  } else if (isVoicemailType && (document.querySelector("#ca-call-group-did-they-answer-vm").value === "no" || document.querySelector("#ca-call-group-did-they-answer-vm").value === "")) {
    if (Number(document.querySelector("#ca-call-group-vm-outbound-count").value) < MAX_VM_OUTBOUND_ATTEMPTS) {
      setElementValue('#ca-call-group-status', STATUS_VM_CALLBACK_ATTEMPTED);
    } else {
      setElementValue('#ca-call-group-status', STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS);
    }
  } else if (isVoicemailType && document.querySelector("#ca-call-group-did-they-answer-vm").value === "noAttempt") {
    const vmCount = Number(document.querySelector("#ca-call-group-vm-outbound-count").value);
    document.querySelector("#ca-call-group-vm-outbound-count").value = vmCount - 1;
    setElementValue('#ca-call-group-status', STATUS_VM_CALLBACK_ATTEMPTED);
  } else if (callType === CALL_TYPE_VM_CALLBACK_INVALID) {
    setElementValue('#ca-call-group-status', STATUS_WRONG_NUMBER);
  } else if (document.querySelector("#is-wrong-number") && document.querySelector("#is-wrong-number").checked) {
    setElementValue('#ca-call-group-status', STATUS_WRONG_NUMBER);
  } else if (document.querySelector("#ca-call-group-refused-name-again-quick-pick") && document.querySelector("#ca-call-group-refused-name-again-quick-pick").checked) {
    setElementValue('#ca-call-group-status', STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS);
  } else if (document.querySelector("#ca-call-group-did-clinic-answer") && document.querySelector("#ca-call-group-did-clinic-answer").value === "cr") {
    setElementValue('#ca-call-group-status', STATUS_QUICK_PICK_CALLER_REFUSED_HELP);
  } else {
    // Inbound or Followup call
    calculateByScore = true;
  }

  if (calculateByScore) {
    const score = document.querySelector("#ca-call-group-score").value;
    const prospect = document.querySelector("#ca-call-group-prospect").value;
    if (prospect === PROSPECT_NO) {
      setElementValue('#ca-call-group-status', STATUS_NON_PROSPECT);
    } else if (score === SCORE_DISCONNECTED || prospect === PROSPECT_DISCONNECTED) {
      setElementValue('#ca-call-group-status', STATUS_INCOMPLETE);
      setElementValue('#ca-call-group-score', SCORE_DISCONNECTED);
    } else if (score === SCORE_NOT_REACHED) {
      setElementValue('#ca-call-group-status', STATUS_FOLLOWUP_SET_APPT);
    } else if (score === SCORE_APPT_SET || score === SCORE_APPT_SET_DIRECT) {
      setElementValue('#ca-call-group-status', STATUS_APPT_SET);
    } else if (score === SCORE_TENTATIVE_APPT) {
      setElementValue('#ca-call-group-status', STATUS_TENTATIVE_APPT);
    } else if (score === SCORE_MISSED_OPPORTUNITY) {
      setElementValue('#ca-call-group-status', STATUS_MISSED_OPPORTUNITY);
    } else {
      // Score is blank. Mark as incomplete.
      setElementValue('#ca-call-group-status', STATUS_INCOMPLETE);
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
      console.log('getLocationData error:');
      console.error(error);
    }
  } else {
    handleLocationChange(null);
  }
}

function handleLocationChange(data) {
  setElementInnerHTML(".locationLink", data ? data['link'] : '');
  setElementInnerHTML(".locationTitle", data ? data['title'] : '');
  locationTitle = data ? data['title'] : '';
  setElementInnerHTML(".locationAddress", data ? data['address'] : '');
  setElementInnerHTML(".locationPhone", data ? data['phone'] : '');
  setElementInnerHTML(".locationCovid", data && data['covid'] ? `COVID-19 statement: ${data['covid']}` : '');
  setElementInnerHTML(".locationLandmarks", data && data['landmarks'] ? `Landmarks: ${data['landmarks']}` : '');
  setElementInnerHTML(".andYhn", data && data['isYhn'] === 1 ? 'and Your Hearing Network' : '');

  //todo: search
  //const locationSearchInput = document.querySelector("#CaCallLocationSearch");
  //if (!locationSearchInput.value && data) {
  //  locationSearchInput.value = data['searchTitle'];
  //}

  if (data) {
    setElementValue("#ca-call-group-direct-book-type", data['directBookType']);
    document.querySelectorAll("#directBookUrl").forEach(element => {
      element.textContent = data['directBookUrl'];
      element.href = data['directBookUrl'];
    });
  } else {
    setElementValue("#ca-call-group-direct-book-type", DIRECT_BOOK_NONE);
  }
  const locationCityStateStreet = data ? data['cityStateStreet'] : '';
  setElementInnerHTML(".locationCityStateStreet", locationCityStateStreet);

  let hours = data ? data['hours'] : '';
  if (hours !== '') {
    hours = '<u>Clinic hours</u><br>' + hours;
  }
  setElementInnerHTML(".locationHours", hours);

  let hoursToday = data ? data['hoursToday'] : '';
  if (hoursToday !== '') {
    if (hoursToday === 'closed') {
      hoursToday = 'They are closed today.';
    } else {
      hoursToday = 'Their hours today are <strong>' + hoursToday + '</strong>.';
    }
  }
  setElementInnerHTML(".locationHoursToday", hoursToday);

  const locationCurrentTime = data ? data['currentTime'] : '';
  setElementInnerHTML(".locationCurrentTime", locationCurrentTime);

  const locationTimezone = data ? data['timezone'] : '';
  locationTimezoneOffset = data ? data['timezoneOffset'] : '';
  const apptDateLabel = `Appointment date/time (${locationTimezone})<br><small class='text-muted'>This is the clinic's timezone</small>`;
  setElementInnerHTML("#appt-date-label", apptDateLabel);

  const locationId = data ? data['id'] : '';

  if (IS_CLINIC_LOOKUP_PAGE) {
    if (locationId) {
      fetch(`/admin/ca-calls/get-previous-calls/${locationId}/1`, {
        method: "GET",
        headers: {
          "Accept": "application/json"
        }
      })
      .then(response => response.json())
      .then(data => {
        const count = Object.keys(data).length;
        if (count === 0) {
          // No followup calls found
          setElementValue('#ca-call-group-id', '');
          showElement('.found-no-calls');
          hideElement('.found-multiple-calls');
          hideElement('.group-found');
          updateVisibility();
        } else if (count == 1) {
          // One previous call found. Automatically select it.
          hideElement('.found-no-calls');
          hideElement('.found-multiple-calls');
          updateVisibility();
          const dataKeys = Object.keys(data);
          const groupId = dataKeys[0];
          onChangeGroupSearch(groupId);
        } else {
          // Found multiple followup calls. User must select one.
          hideElement('.found-no-calls');
          showElement('.found-multiple-calls');
          hideElement('.group-found');
          updateVisibility();
          setElementValue('#ca-call-group-id', '');
          setElementTextContent('span.callCount', count);
          const groupSearchElement = document.querySelector('.group_search');
          groupSearchElement.innerHTML = '';
          groupSearchElement.appendChild(new Option('', ''));
          for (const key in data) {
            groupSearchElement.appendChild(new Option(data[key], key));
          }
        }
      })
      .catch(error => {
        console.log('getPreviousCalls() error:');
        console.error(error);
      });
    } else {
      // No location selected
      hideElement('.found-no-calls');
      hideElement('.found-multiple-calls');
      updateVisibility();
    }
  } else {
    if (locationId) {
      const url = `/admin/ca-calls/get-previous-calls/${locationId}`;
      fetch(url, {
        method: "GET",
        headers: {
          'Accept': 'application/json',
        },
      })
      .then(response => response.json())
      .then(data => {
          document.querySelectorAll('.group_search').forEach(groupSearchElement => {
            // Clear pending calls list
            groupSearchElement.innerHTML = '';
            groupSearchElement.appendChild(new Option('', ''));
            // If any pending calls were found, add them to options
            for (const key in data) {
              groupSearchElement.appendChild(new Option(data[key], key));
            }
          });
      })
      .catch(error => {
        console.log('getPreviousCalls() error:');
        console.error(error);
      });
    }
  }
}

function onChangeCallType(callType) {
  setElementInnerHTML("#call-type", callTypes[callType]);

  if (callType === CALL_TYPE_VM_CALLBACK_CONSUMER) {
    loadReturnVoicemailForm('consumer');
    updateVisibility();
    IS_CLINIC_LOOKUP_PAGE = false;
  } else if (callType === CALL_TYPE_VM_CALLBACK_CLINIC) {
    loadReturnVoicemailForm('clinic');
    updateVisibility();
    IS_CLINIC_LOOKUP_PAGE = true;
  } else if (callType === CALL_TYPE_VM_CALLBACK_INVALID) {
    loadReturnVoicemailForm('invalid');
    updateVisibility();
    IS_CLINIC_LOOKUP_PAGE = false;
  }
}

function loadReturnVoicemailForm(type) {
  const caCallGroupId = document.querySelector('#ca-call-group-id').value;
  let ajaxUrl = null;
  if (type === 'clinic') {
    ajaxUrl = '/admin/ca-calls/ajax-clinic-form/' + caCallGroupId;
  } else if (type === 'consumer') {
    ajaxUrl = '/admin/ca-calls/ajax-consumer-form/' + caCallGroupId;
  }

  if (ajaxUrl) {
    fetch(ajaxUrl)
      .then(response => response.text())
      .then(data => {
        console.log('AJAX form loaded successfully: ' + type);
        setElementInnerHTML('#return_vm_ajax_form', data);
        showElement('#return_vm_ajax_form');
        hideElement('#return_vm_from_invalid');
        locationAutocomplete();
        triggerChangeEvents(['#call-type']);
        triggerChange('#ca-call-group-did-they-answer-vm');
      })
      .catch(error => {
        console.log('Error in ' + ajaxUrl);
        console.error(error);
      });
  } else {
    setElementInnerHTML('#return_vm_ajax_form', "");
    hideElement('#return_vm_ajax_form');
    showElement('#return_vm_from_invalid');
  }
}

function onChangeIsPatient(isPatient) {
  if (isPatient) {
    hideElement('.patient-data');
  } else {
    showElement('.patient-data');
  }
  updateVisibility();
  onChangePatientInfo();
}

function onChangeProspect(selectedProspect) {
  var isOverride = 0;
  var calculatedProspect = PROSPECT_NO;

  const topicDeclined = document.querySelector('#ca-call-group-topic-declined');
  if (topicDeclined && topicDeclined.checked) {
    calculatedProspect = PROSPECT_UNKNOWN;
  }

  Object.keys(prospectTopics).forEach(key => {
    const topicElement = document.querySelector(`#${prospectTopics[key]}`);
    if (topicElement && topicElement.checked) {
      calculatedProspect = PROSPECT_YES;
    }
  });

  var callTypeElement = document.querySelector("#call-type");
  if (callTypeElement && (callTypeElement.value === CALL_TYPE_INBOUND_QUICK_PICK)) {
    calculatedProspect = selectedProspect;
    if (calculatedProspect !== PROSPECT_YES && document.querySelector("#ca-call-group-status").value !== STATUS_INCOMPLETE) {
      isOverride = 1;
    }
  } else if (selectedProspect !== null) {
    if (selectedProspect !== calculatedProspect) {
      calculatedProspect = selectedProspect;
      isOverride = 1;
    }
  }

  // Do not overwrite prospect and override flag if we are still loading the page
  const prospectElement = document.querySelector('#ca-call-group-prospect');
  const isOverrideElement = document.querySelector('#ca-call-group-is-prospect-override');
  if (pageLoadComplete === false) {
    if (prospectElement) {
      calculatedProspect = prospectElement.value;
    }
    if (isOverrideElement) {
      isOverride = isOverrideElement.value;
    }
  }
  if (prospectElement) {
    prospectElement.value = calculatedProspect;
  }
  if (isOverrideElement) {
    isOverrideElement.value = isOverride;
  }

  if (calculatedProspect === PROSPECT_YES) {
    showElement('.prospectTopic');
    hideElement('.nonProspectTopic');
    hideElement('.prospectUnknownTopic');
    const wantsAppt = document.querySelector('#ca-call-group-topic-wants-appt')?.checked;
    const directBookType = document.querySelector("#ca-call-group-direct-book-type")?.value;
    const isDirectBookEarqOrBp = (directBookType === DIRECT_BOOK_BLUEPRINT) || (directBookType === DIRECT_BOOK_EARQ);
    const wantsHearingTest = document.querySelector('#ca-call-group-wants-hearing-test')?.value === '1';
    if (wantsAppt && (directBookType === DIRECT_BOOK_DM) && wantsHearingTest) {
      showElement('.directBookDm');
      hideElement('.directBookBlueprintEarQ');
      hideElement('.nonDirectBook');
    } else if (wantsAppt && isDirectBookEarqOrBp) {
      hideElement('.directBookDm');
      showElement('.directBookBlueprintEarQ');
      hideElement('.nonDirectBook');
    } else {
      hideElement('.directBookDm');
      hideElement('.directBookBlueprintEarQ');
      showElement('.nonDirectBook');
    }
    updateVisibility();
  } else if (calculatedProspect === PROSPECT_NO) {
    hideElement('.prospectTopic');
    showElement('.nonProspectTopic');
    hideElement('.prospectUnknownTopic');
    updateVisibility();
    setElementValue('#ca-call-group-score', '');
  } else if (calculatedProspect === PROSPECT_UNKNOWN) {
    hideElement('.prospectTopic');
    hideElement('.nonProspectTopic');
    showElement('.prospectUnknownTopic');
    updateVisibility();
  } else {
    // disconnected - no need to show any further script
    hideElement('.prospectTopic');
    hideElement('.nonProspectTopic');
    hideElement('.prospectUnknownTopic');
    updateVisibility();
  }
}

function onChangeScore(score) {
  if (score === SCORE_APPT_SET || score === SCORE_APPT_SET_DIRECT) {
    // Appointment set
    showElement('.appt_date');
    hideElement('.scheduled_call_date');
    updateVisibility();
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      onChangeApptDate();
    }
  } else if (score === SCORE_TENTATIVE_APPT) {
    // Left a voicemail with clinic - followup in 48 hours to verify if appointment has been set
    hideElement('.appt_date');
    setElementInnerHTML('#scheduled-call-date-label', "Next attempt to reach clinic (" + easternTimezone + ")");
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      // Next call time should be 48 hours from now
      const nextCallDate = new Date();
      nextCallDate.setDate(nextCallDate.getDate() + 2);
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
      showElement('.scheduled_call_date');
    }
    if (IS_CALL_GROUP_EDIT_PAGE) {
      showElement('.scheduled_call_date');
    }
    updateVisibility();
  } else if (score === SCORE_NOT_REACHED) {
    // Clinic not reached - needs followup to set appt
    hideElement('.appt_date');
    setElementInnerHTML('#scheduled-call-date-label', "Next attempt to reach clinic (" + easternTimezone + ")");
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      // Next call time should be 15 minutes from now
      const callDate = new Date();
      callDate.setMinutes(callDate.getMinutes() + 15);
      setDateField('#ca-call-group-scheduled-call-date', callDate);
      showElement('.scheduled_call_date');
    }
    if (IS_CALL_GROUP_EDIT_PAGE) {
      showElement('.scheduled_call_date');
    }
    updateVisibility();
  } else {
    // Non-prospect/missed opportunity
    hideElement('.appt_date');
    hideElement('.scheduled_call_date');
    // Disable any fields that are required and hidden, or the form will fail to validate.
    updateVisibility();
  }
}

function onChangeStatus(status) {
  setElementTextContent('span.status', statuses[status]);
}

async function onChangeGroupSearch(group_id) {
  hideElement('.lock-error');
  if (group_id) {
    try {
      fetch(`/admin/ca-calls/get-call-group-data/${group_id}`, {
        method: "GET",
        headers: {
          'Accept': 'application/json',
        },
      })
        .then(response => response.json())
        .then(data => {
          if (data["lock_error"] === true) {
            console.log('getCallGroupData failed. Locked.');
            showElement('.lock-error');
            hideElement('.group-found');
            updateVisibility();
            setElementTextContent('span.lockTime', data["lock_time"]);
            setElementTextContent('span.lockedBy', data["locked_by"]);
            setElementValue('#ca-call-group-id', group_id);
            setElementValue('#ca-call-ca-call-group-id', group_id);
          } else if (data["user_error"] === true) {
            console.error('getCallGroupData error: User ID is null.');
          } else {
            handleCallGroupChange(data);
          }
        });
    } catch (error) {
      console.log('getCallGroupData error:');
      console.error(error);
    }
  } else {
    handleCallGroupChange(null);
  }
}

function handleCallGroupChange(data) {
  if (data && data["id"]) {
    setElementTextContent('span.callGroupId', data['id']);
    setElementValue('#ca-call-ca-call-group-id', data['id']);
    setElementValue('#ca-call-group-id', data['id']);
    setElementValue('#ca-call-group-status', data['status']);
    showGroupFound();
    setElementValue('#ca-call-group-caller-first-name', data['caller_first_name']);
    setElementValue('#ca-call-group-caller-last-name', data['caller_last_name']);
    setElementValue('#ca-call-group-caller-phone', data['caller_phone']);
    setElementChecked('#ca-call-group-is-patient', data['is_patient']);
    setElementValue('#ca-call-group-patient-first-name', data['patient_first_name']);
    setElementValue('#ca-call-group-patient-last-name', data['patient_last_name']);
    setElementChecked('#ca-call-group-topic-wants-appt', data['topic_wants_appt']);
    setElementChecked('#ca-call-group-topic-clinic-hours', data['topic_clinic_hours']);
    setElementChecked('#ca-call-group-topic-insurance', data['topic_insurance']);
    setElementChecked('#ca-call-group-topic-clinic-inquiry', data['topic_clinic_inquiry']);
    setElementChecked('#ca-call-group-topic-aid-lost-old', data['topic_aid_lost_old']);
    setElementChecked('#ca-call-group-topic-aid-lost-new', data['topic_aid_lost_new']);
    setElementChecked('#ca-call-group-topic-warranty-old', data['topic_warranty_old']);
    setElementChecked('#ca-call-group-topic-warranty-new', data['topic_warranty_new']);
    setElementChecked('#ca-call-group-topic-batteries', data['topic_batteries']);
    setElementChecked('#ca-call-group-topic-parts', data['topic_parts']);
    setElementChecked('#ca-call-group-topic-cancel-appt', data['topic_cancel_appt']);
    setElementChecked('#ca-call-group-topic-reschedule-appt', data['topic_reschedule_appt']);
    setElementChecked('#ca-call-group-topic-appt-followup', data['topic_appt_followup']);
    setElementChecked('#ca-call-group-topic-medical-records', data['topic_medical_records']);
    setElementChecked('#ca-call-group-topic-tinnitus', data['topic_tinnitus']);
    setElementChecked('#ca-call-group-topic-medical-inquiry', data['topic_medical_inquiry']);
    setElementChecked('#ca-call-group-topic-solicitor', data['topic_solicitor']);
    setElementChecked('#ca-call-group-topic-personal-call', data['topic_personal_call']);
    setElementChecked('#ca-call-group-topic-request-fax', data['topic_request_fax']);
    setElementChecked('#ca-call-group-topic-request-name', data['topic_request_name']);
    setElementChecked('#ca-call-group-topic-remove-from-list', data['topic_remove_from_list']);
    setElementChecked('#ca-call-group-topic-foreign-language', data['topic_foreign_language']);
    setElementChecked('#ca-call-group-topic-other', data['topic_other']);
    setElementChecked('#ca-call-group-topic-declined', data['topic_declined']);
    setElementValue('#ca-call-group-prospect', data['prospect']);
    if (!IS_CLINIC_LOOKUP_PAGE) {
      // Don't overwrite the front desk name on the clinic lookup page
      setElementValue('#ca-call-group-front-desk-name', data['front_desk_name']);
    }
    setElementValue('#ca-call-group-score', data['score']);
    setElementChecked('#ca-call-group-is-review-needed', data['is_review_needed']);
    if (document.querySelector('#ca-call-group-location-id').value != data['location_id']) {
      // Only trigger a location change if different
      setElementValue('#ca-call-group-location-id', data['location_id']);
    }
    setDateField("#ca-call-group-appt-date", data["appt_date"]);
    setDateField("#ca-call-group-scheduled-call-date", data["scheduled_call_date"]);
  } else {
    clearAllFields();
  }
}

function clearAllFields() {
  setElementTextContent('span.callGroupId', '');

  const elementsToClear = [
    "#ca-call-ca-call-group-id",
    "#ca-call-group-id",
    "#ca-call-group-caller-first-name",
    "#ca-call-group-caller-last-name",
    "#ca-call-group-caller-phone",
    "#ca-call-group-patient-first-name",
    "#ca-call-group-patient-last-name",
    "#ca-call-group-front-desk-name",
  ];

  elementsToClear.forEach((element) => {
    var selector = document.querySelector(element);
    if (selector) {
      selector.value = "";
      selector.dispatchEvent(new Event("change"));
    }
  });

  const checkboxesToUncheck = [
    "#ca-call-group-is-patient",
    "#ca-call-group-topic-wants-appt",
    "#ca-call-group-topic-clinic-hours",
    "#ca-call-group-topic-insurance",
    "#ca-call-group-topic-clinic-inquiry",
    "#ca-call-group-topic-aid-lost-old",
    "#ca-call-group-topic-aid-lost-new",
    "#ca-call-group-topic-warranty-old",
    "#ca-call-group-topic-warranty-new",
    "#ca-call-group-topic-batteries",
    "#ca-call-group-topic-parts",
    "#ca-call-group-topic-cancel-appt",
    "#ca-call-group-topic-reschedule-appt",
    "#ca-call-group-topic-appt-followup",
    "#ca-call-group-topic-medical-records",
    "#ca-call-group-topic-tinnitus",
    "#ca-call-group-topic-medical-inquiry",
    "#ca-call-group-topic-solicitor",
    "#ca-call-group-topic-personal-call",
    "#ca-call-group-topic-request-fax",
    "#ca-call-group-topic-request-name",
    "#ca-call-group-topic-remove-from-list",
    "#ca-call-group-topic-foreign-language",
    "#ca-call-group-topic-other",
    "#ca-call-group-topic-declined",
  ];

  checkboxesToUncheck.forEach((element) => {
    setElementChecked(element, false);
  });

  setElementValue('#ca-call-group-status', STATUS_NEW);
  showGroupFound();

  setElementValue('#ca-call-group-prospect', PROSPECT_NO);
  setElementValue('#ca-call-group-score', '');

  const locationSearchInput = document.querySelector("#location-search");
  const locationIdInput = document.querySelector("#ca-call-group-location-id");

  if (locationSearchInput && locationSearchInput.value !== "") {
    // Changing the group id should not clear the location search
  } else if (locationIdInput.value !== "") {
    // Only trigger a location change if different
    locationIdInput.value = "";
    locationIdInput.dispatchEvent(new Event("change"));
  }

  setDateField("#ca-call-group-appt-date", null);
  setDateField("#ca-call-group-scheduled-call-date", null);
}

function doWeHaveLocationAndFrontDesk() {
  var doWeHaveLocationAndFrontDesk = false;
  const locationId = document.querySelector("#ca-call-group-location-id");
  const frontDeskName = document.querySelector("#ca-call-group-front-desk-name");

  if (locationId && frontDeskName) {
    if ((locationId.value > 0) && frontDeskName.value) {
      doWeHaveLocationAndFrontDesk = true;
    }
  }
  if (doWeHaveLocationAndFrontDesk) {
    showElement('.have-location-and-front-desk');
  } else {
    hideElement('.have-location-and-front-desk');
  }

  updateVisibility();
}

function doWeHaveLocationInitially() {
  const locationId = document.querySelector("#ca-call-group-location-id");

  if (locationId && (parseInt(locationId.value) > 0)) {
    showElement('.init_have_location');
    hideElement('.init_no_location');
  } else {
    hideElement('.init_have_location');
    showElement('.init_no_location');
  }

  updateVisibility();
}

function showGroupFound() {
  const groupId = document.querySelector("#ca-call-group-id").value;
  const frontDeskName = document.querySelector("#ca-call-group-front-desk-name").value;
  const groupFoundElement = document.querySelector(".group-found");

  if (groupId && frontDeskName) {
    const groupNotLoaded = groupFoundElement && (groupFoundElement.dataset.groupId !== groupId);
    const isGroupLocked = document.querySelector(".lock-error") && !isHidden('.lock-error');

    if (groupNotLoaded && !isGroupLocked) {
      groupFoundElement.dataset.groupId = groupId;
      fetch(`/admin/ca-calls/ajax-outbound-followup-form/${groupId}`)
        .then((response) => response.text())
        .then((data) => {
          const status = document.querySelector("#ca-call-group-status").value;
          const callTypeElement = document.querySelector("#call-type");

          if (status === STATUS_TENTATIVE_APPT) {
            callTypeElement.value = CALL_TYPE_FOLLOWUP_TENTATIVE_APPT;
          } else {
            callTypeElement.value = CALL_TYPE_FOLLOWUP_APPT;
          }

          setElementInnerHTML('.group-found', data);
          showElement('.group-found');
          onPageLoad();
          triggerChangeEvents(["#ca-call-group-location-id", "#call-type"]);
          setElementInnerHTML('span.locationTitle', locationTitle);
        });
    }

    showElement('.group-found-buttons');
    updateVisibility();
  } else {
    setElementInnerHTML('.group-found', "");
    hideElement('.group-found');
    hideElement('.group-found-buttons');
    updateVisibility();
  }
}

function onChangeApptDate() {
  if (document.querySelector(`#ca-call-group-appt-date`).value) {
    var callDate = new Date(document.querySelector(`#ca-call-group-appt-date`).value);
    callDate.setDate(callDate.getDate() + 1);
    setDateField('#ca-call-group-scheduled-call-date', callDate);
  }
}

function onChangeCallerFirstName(callerFirstName) {
  setElementTextContent('span.callerFirstName', callerFirstName);
  onChangePatientInfo();
}

function onChangeCallerLastName(callerLastName) {
  setElementTextContent('span.callerLastName', callerLastName);
  onChangePatientInfo();
}

function onChangeCallerPhone(callerPhone) {
  let formattedPhone = callerPhone;
  if (callerPhone.length === 10) {
    formattedPhone = callerPhone.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
  } else if (callerPhone.length === 11) {
    formattedPhone = callerPhone.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1-$2-$3-$4');
  }
  setElementTextContent('span.callerPhone', formattedPhone);
}

function onChangePatientInfo() {
  const isPatient = document.querySelector('#ca-call-group-is-patient, #is-patient').checked;
  if (isPatient) {
    hideElement('span.not-self');
    showElement('span.self');
    hideElement('span.isNotPatient');
    const patientNameElement = document.querySelector('span.patientName');
    if (patientNameElement) {
      const callerFirstName = document.querySelector('#ca-call-group-caller-first-name, #caller-first-name').value;
      const callerLastName = document.querySelector('#ca-call-group-caller-last-name, #caller-last-name').value;
      setElementTextContent('span.patientName', callerFirstName + ' ' + callerLastName);
    }
  } else {
    showElement('span.isNotPatient');
    showElement('span.not-self');
    hideElement('span.self');
    const patientNameElement = document.querySelector('span.patientName');
    if (patientNameElement) {
      const patientFirstName = document.querySelector('#ca-call-group-patient-first-name, #patient-first-name').value;
      const patientLastName = document.querySelector('#ca-call-group-patient-last-name, #patient-last-name').value;
      setElementTextContent('span.patientName', patientFirstName + ' ' + patientLastName);
    }
  }
}

function onChangeFrontDeskName(frontDeskName) {
  setElementTextContent('span.frontDeskName', frontDeskName);
  doWeHaveLocationAndFrontDesk();
  showGroupFound();
}

function setDateField(selector, date) {
  // TODO: Do we want to round to nearest 15 minutes?
  setElementValue(selector, formatDateTime(date));
}

export function updateVisibility(selector = '.form_fields') {
  var querySelector = selector + ' input, ' + selector + ' select';
  if (selector == '.form_fields') {
    querySelector += ', fieldset input, fieldset select';
  }
  document.querySelectorAll(querySelector).forEach(input => {
    // Don't disable inputs with 'hidden' type
    if (input.type !== 'hidden') {
      if (isHidden(input)) {
        // This input is not currently visible - disable it
        input.setAttribute("disabled", "disabled");
      } else {
        // Input is visible - enable it
        input.removeAttribute("disabled");
      }
    }
  });
}

function onChangeTopic() {
  const topics = [];
  let isTopicAidLost = false;
  let isTopicWarranty = false;

  document.querySelectorAll('[id^=ca-call-group-topic]:checked').forEach(topic => {
    const topicLabel = topic.nextElementSibling.innerHTML;
    const topicId = topic.id;

    if (topicId.includes("ca-call-group-topic-aid-lost")) {
      isTopicAidLost = true;
    } else if (topicId.includes("ca-call-group-topic-warranty")) {
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
    setElementInnerHTML('span.callerTopics', topics.join(', '));
    document.getElementById('ca-call-group-topic-parts').setCustomValidity('');
  } else {
    setElementInnerHTML('span.callerTopics', 'unknown');
    document.getElementById('ca-call-group-topic-parts').setCustomValidity('At least one topic is required');
  }

  // Calculate prospect based on topics selected
  onChangeProspect(null);
}

function onChangeTopicWantsAppt(wantsAppt) {
  const isDirectBookDm = document.getElementById("ca-call-group-direct-book-type").value === DIRECT_BOOK_DM;

  // If wants appt and this is a direct book DM location, show the hearing test question
  if (wantsAppt && isDirectBookDm) {
    showElement('.wantsHearingTest');
  } else {
    hideElement('.wantsHearingTest');
  }

  updateVisibility();
}

function onChangeConsumerConsent(consumerConsent) {
  if (consumerConsent === 'yes') {
    showElement('.consumerConsentYes');
    hideElement('.consumerConsentNo');
    setElementInnerHTML('span.callTransferInstructions', "[Mute and listen to appointment info]");
  } else if (consumerConsent === 'no') {
    hideElement('.consumerConsentYes');
    showElement('.consumerConsentNo');
    setElementInnerHTML('span.callTransferInstructions', "[Hang up and score as 'Tentative appointment'.]");
    setElementValue('#ca-call-group-score', SCORE_TENTATIVE_APPT);
  }
}

function onChangeDidClinicAnswer(didClinicAnswer) {
  showElement('.prospectOptions');

  if (didClinicAnswer === 'yes') {
    showElement('.didClinicAnswerYes');
    hideElement('.didClinicAnswerNo');
    hideElement('.didClinicAnswerVm');
    updateVisibility();
    setElementValue('#ca-call-group-score', '');
  } else if (didClinicAnswer === 'no') {
    hideElement('.didClinicAnswerYes');
    showElement('.didClinicAnswerNo');
    hideElement('.didClinicAnswerVm');
    updateVisibility();
    const groupProspect = document.getElementById('ca-call-group-prospect').value;
    if (groupProspect === PROSPECT_YES) {
      if (document.getElementById('ca-call-group-refused-name')?.checked || document.getElementById('ca-call-group-refused-name-again-quick-pick')?.checked ) {
        setElementValue('#ca-call-group-score', SCORE_MISSED_OPPORTUNITY);
      } else {
        setElementValue('#ca-call-group-score', SCORE_NOT_REACHED);
      }
    }
  } else if (didClinicAnswer === 'vm') {
    // No, but we can leave a voicemail
    hideElement('.didClinicAnswerYes');
    hideElement('.didClinicAnswerNo');
    showElement('.didClinicAnswerVm');
    showElement('.followupForm');
    updateVisibility();
    if (document.getElementById('ca-call-group-prospect').value === PROSPECT_YES) {
      setElementValue('#ca-call-group-score', SCORE_TENTATIVE_APPT);
    }
  } else if (didClinicAnswer === 'cr') {
    // caller refused
    setElementValue('#ca-call-group-score', SCORE_DISCONNECTED);
    hideElement('.prospectOptions');
    hideElement('.didClinicAnswerYes');
    hideElement('.didClinicAnswerNo');
    hideElement('.didClinicAnswerVm');
    updateVisibility();
  } else {
    hideElement('.didClinicAnswerYes');
    hideElement('.didClinicAnswerNo');
    hideElement('.didClinicAnswerVm');
    showElement('.scheduled_call_date');
    setElementValue('#ca-call-group-score', '');
    updateVisibility();
  }
}

function onChangeDidTheyAnswerVm(didTheyAnswer) {
  const callDate = new Date();

  if (didTheyAnswer === 'yes') {
    showElement('#didTheyAnswerYes');
    hideElement('#didTheyAnswerNo');
    hideElement('#didTheyAnswerVm');
    updateVisibility();
  } else if (didTheyAnswer === 'vm') {
    hideElement('#didTheyAnswerYes');
    hideElement('#didTheyAnswerNo');
    showElement('#didTheyAnswerVm');
    updateVisibility();
  } else if (didTheyAnswer === 'noAttempt') {
    hideElement('#didTheyAnswerYes');
    showElement('#didTheyAnswerNo');
    showElement('#didTheyAnswerNo .scheduled_call_date');
    hideElement('#didTheyAnswerVm');
    updateVisibility();
    // Default next call time to 2 hours from now
    callDate.setMinutes(callDate.getMinutes() + 120);
    setDateField('#NoAnswerScheduledCallDate', callDate);
  } else {
    hideElement('#didTheyAnswerYes');
    showElement('#didTheyAnswerNo');
    showElement('#didTheyAnswerNo .scheduled_call_date');
    hideElement('#didTheyAnswerVm');
    updateVisibility();
    // Default next call time to 30 minutes from now
    callDate.setMinutes(callDate.getMinutes() + 30);
    setDateField('#NoAnswerScheduledCallDate', callDate);
  }
}

function onChangeDidTheyAnswerFollowup(answer) {
  const callType = document.querySelector("#call-type").value;

  if (answer === 'yes') {
    showElement('.didTheyAnswerFollowupYes');
    hideElement('.didTheyAnswerFollowupNo');
    hideElement('.didTheyAnswerFollowupVm');
    hideElement('.scheduled_call_date');
  } else if (answer === 'vm') {
    const prospect = document.querySelector("#ca-call-group-prospect").value;
    hideElement('.didTheyAnswerFollowupYes');
    hideElement('.didTheyAnswerFollowupNo');
    showElement('.didTheyAnswerFollowupVm');
    if (callType === CALL_TYPE_FOLLOWUP_NO_ANSWER || prospect === PROSPECT_NO) {
      hideElement('.followupForm');
      hideElement('.scheduled_call_date"');
    } else {
      showElement('.followupForm');
      setElementValue('#ca-call-group-score', SCORE_TENTATIVE_APPT);
    }
  } else { // NO
    hideElement('.didTheyAnswerFollowupYes');
    showElement('.didTheyAnswerFollowupNo');
    hideElement('.didTheyAnswerFollowupVm');
    hideElement('.followupForm');
    showElement('.scheduled_call_date');
    const nextCallDate = new Date();
    if (callType === CALL_TYPE_FOLLOWUP_APPT) {
      let nextCallMinutes = 15;
      switch (document.querySelector("#ca-call-group-clinic-followup-count").value) {
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
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
    } else if (
      callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT ||
      callType === CALL_TYPE_FOLLOWUP_NO_ANSWER
    ) {
      // Try again in 4 hours
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 240);
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
    } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST) {
      // Try again in 15 minutes
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 15);
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
    } else {
      // Try again in 15 minutes
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 15);
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
      setElementInnerHTML('#scheduled-call-date-label', "Next attempt to reach consumer (" + easternTimezone + ")");
    }
  }
  updateVisibility();
}

function onChangeDidConsumerAnswer(answer) {
  const callType = document.querySelector("#call-type").value;
  const nextCallDate = new Date();
  if (answer === 'yes') {
    showElement('.didConsumerAnswerYes');
    hideElement('.didConsumerAnswerNo');
    hideElement('.didConsumerAnswerVm');
    hideElement('.didConsumerAnswerInvalid');
    showElement('.followupForm');
    hideElement('.scheduled_call_date');
  } else if (answer === 'vm') {
    hideElement('.didConsumerAnswerYes');
    hideElement('.didConsumerAnswerNo');
    showElement('.didConsumerAnswerVm');
    hideElement('.didConsumerAnswerInvalid');
    if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST) {
      showElement('.scheduled_call_date');
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 240);
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
    } else {
      showElement('.followupForm');
      setElementValue('#ca-call-group-score', SCORE_TENTATIVE_APPT);
    }
  } else if (answer === 'invalid') {
    hideElement('.didConsumerAnswerYes');
    hideElement('.didConsumerAnswerNo');
    hideElement('.didConsumerAnswerVm');
    showElement('.didConsumerAnswerInvalid');
    showElement('.followupForm');
    setElementValue('#ca-call-group-score', SCORE_DISCONNECTED);
  } else { // NO
    const prospect = document.querySelector("#ca-call-group-prospect").value;
    hideElement('.didConsumerAnswerYes');
    showElement('.didConsumerAnswerNo');
    hideElement('.didConsumerAnswerVm');
    hideElement('.didConsumerAnswerInvalid');
    if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT || prospect === PROSPECT_NO) {
      hideElement('.followupForm');
    } else {
      showElement('.followupForm');
      setElementValue('#ca-call-group-score', SCORE_TENTATIVE_APPT);
    }
  }
  updateVisibility();
}

function onChangeDidConsumerAnswer2(answer) {
  if (answer === 'yes') {
    showElement('.didConsumerAnswer2Yes');
    hideElement('.didConsumerAnswer2No');
    showElement('.followupForm');
    hideElement('.scheduled_call_date');
  } else { // NO
    hideElement('.didConsumerAnswer2Yes');
    showElement('.didConsumerAnswer2No');
    showElement('.followupForm');
    setElementValue('#ca-call-group-score', SCORE_TENTATIVE_APPT);
  }
  updateVisibility();
}

function onChangeDidTheyWantHelp(answer) {
  if (answer === 1) { // YES
    showElement('.wantHelpYes');
    hideElement('.wantHelpNo');
  } else { // NO
    hideElement('.wantHelpYes');
    showElement('.wantHelpNo');
  }
  updateVisibility();
}

function onChangeDidClinicContactConsumer(answer) {
  const callType = document.querySelector("#call-type").value;

  if (answer === 1) { // YES
    showElement('.didClinicContactConsumerYes');
    hideElement('.didClinicContactConsumerNo');
    showElement('.followupForm');
  } else { // NO
    hideElement('.didClinicContactConsumerYes');
    showElement('.didClinicContactConsumerNo');
    setElementValue('#ca-call-group-did-they-want-help', '');
    setElementValue('#ca-call-group-score', SCORE_MISSED_OPPORTUNITY);
    if (callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT) {
      showElement('.followupForm');
    } else { // CALL_TYPE_FOLLOWUP_NO_ANSWER
      hideElement('.followupForm');
    }
  }
  updateVisibility();
}

function onChangeRefusedName() {
  if (document.getElementById('ca-call-group-refused-name').checked) {
    hideElement('.refusedNameNo');
    showElement('.refusedNameYes');
    if (pageLoadComplete) {
      setElementChecked('#ca-call-group-topic-declined', true);
    }
    // Don't leave vm at clinic if we don't know caller name
    document.querySelector("#ca-call-group-did-clinic-answer option[value='vm']").remove();
  } else {
    showElement('.refusedNameNo');
    hideElement('.refusedNameYes');
    if (pageLoadComplete) {
      setElementChecked('#ca-call-group-topic-declined', false);
    }
    if (document.querySelector("#ca-call-group-did-clinic-answer")) {
      if (document.querySelector("#ca-call-group-did-clinic-answer option[value='vm']").length === 0) {
        document.querySelector("#ca-call-group-did-clinic-answer").append('<option value="vm">No, but leave voicemail</option>');
      }
    }
  }
  updateVisibility();
}

function onChangeDidClinicRefuse() {
  if (document.querySelector('#ca-call-group-did-clinic-refuse').checked) {
    showElement('.didClinicRefuseYes');
    if (pageLoadComplete) {
      setElementChecked('#ca-call-group-is-review-needed', true);
      setElementValue('#ca-call-group-score', SCORE_MISSED_OPPORTUNITY);
    }
  } else {
    hideElement('.didClinicRefuseYes');
    if (pageLoadComplete) {
      setElementChecked('#ca-call-group-is-review-needed', false);
      setElementValue('#ca-call-group-score', SCORE_TENTATIVE_APPT);
    }
  }
  updateVisibility();
}

function formatDateTime(date) {
  if (date == null) {
    date = new Date();
  }
  // Format a date as YYYY-mm-ddTHH:mm
  return date.getFullYear() +
    '-' + pad(date.getMonth() + 1) +
    '-' + pad(date.getDate()) +
    'T' + pad(date.getHours()) +
    ':' + pad(date.getMinutes());
}

function pad(num, size = 2) {
  num = num.toString();
  while (num.length < size) num = "0" + num;
  return num;
}

function setElementTextContent(selector, textContentValue) {
  document.querySelectorAll(selector).forEach(element => {
    element.textContent = textContentValue || '';
  });
}

export function setElementInnerHTML(selector, innerHtmlValue) {
  document.querySelectorAll(selector).forEach(element => {
    element.innerHTML = innerHtmlValue || '';
  });
}

function setElementDisplay(selector, displayValue) {
  document.querySelectorAll(selector).forEach(element => {
    element.style.display = displayValue || '';
  });
}

export function setElementValue(selector, value) {
  document.querySelectorAll(selector).forEach(element => {
    var oldValue = element.value;
    var newValue = value || '';
    if (newValue != oldValue) {
      element.value = newValue;
      element.dispatchEvent(new Event('change', { bubbles: true }));
    }
  });
}

export function setElementChecked(selector, checkedValue) {
  document.querySelectorAll(selector).forEach(element => {
    var oldCheckedValue = element.checked;
    var newCheckedValue = checkedValue || false;
    if (newCheckedValue != oldCheckedValue) {
      element.checked = newCheckedValue;
      element.dispatchEvent(new Event('change', { bubbles: true }));
    }
  });
}

export function showElement(selector) {
  document.querySelectorAll(selector).forEach(element => {
    element.classList.remove('hidden');
  });
  updateVisibility(selector);
}

export function hideElement(selector) {
  document.querySelectorAll(selector).forEach(element => {
    element.classList.add('hidden');
  });
  updateVisibility(selector);
}

export function isHidden(el) {
  if (el) {
    // Element exists - return true if hidden, false if shown
    return (el.offsetParent === null);
  } else {
    // Couldn't find element
    console.debug('Warning: isHidden() could not find element ' + el);
    return true;
  }
}
