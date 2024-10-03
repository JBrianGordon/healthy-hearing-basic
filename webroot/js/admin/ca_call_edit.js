//import '../common/common';
//import '../jquery/jplayer/jquery.jplayer.min';
//import '../common/play_media';

var locationTitle = '';
var locationTimezoneOffset = '';
var pageLoadComplete = false;
var DIRECT_BOOK_NONE = DIRECT_BOOK_NONE ? DIRECT_BOOK_NONE : '';


const onPageLoad = () => {

  // Listen for button click events
  document.querySelector('body').addEventListener('click', e => {
    const targetId = e.target.id;

    if (targetId === 'cancelBtn') {
      const caCallGroupId = document.querySelector('#ca-call-group-id').value;
      const url = `/ca-calls/unlock_call_group/${caCallGroupId}`;

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
      const callGroupNoteValue = document.querySelector('[id^=ca-call-group-ca-call-group-note]').value.trim();

      //todo: make note required
      if (true) {
      //if (callGroupNoteValue) {
        const callType = document.querySelector('#call-type').value;
        const callTypeInboundOptions = [CALL_TYPE_INBOUND, CALL_TYPE_VM_CALLBACK_CLINIC, CALL_TYPE_VM_CALLBACK_CONSUMER, CALL_TYPE_INBOUND_QUICK_PICK];
        let callDate;

        if (callTypeInboundOptions.includes(callType)) {
          // If a new incoming call or VM follow-up call was disconnected, submit the form without validation.
          // This will just save the call in our database in case they call back.
          document.querySelector('#ca-call-group-status').value = STATUS_INCOMPLETE;
          document.querySelector('#ca-call-group-score').value = SCORE_DISCONNECTED;
        }

        document.querySelector('#CaCallForm').submit();
      } else {
        //TODO: Show the note required modal
        //document.querySelector('#note-required').modal('show');
      }
    }

    if (targetId === 'unlockBtn') {
      const caCallGroupId = document.querySelector('#ca-call-group-id').value;
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
        console.log('unlockCallGroup() error:');
        console.error(error);
      }
    }

    switch (targetId) {
      case'spamBtn':
        document.querySelector('#ca-call-group-is-spam').value = true;
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
        // If topics are hidden, remove the custom validation
        if (document.querySelector('#ca-call-group-topic-parts').hidden) {
          document.querySelector('#ca-call-group-topic-parts').setCustomValidity('');
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
        document.querySelector('.aid_age_topic').classList.remove('hidden');
      } else {
        document.querySelector('.aid_age_topic').classList.add('hidden');
      }

      // Trigger the change event for the age dialog, to make sure the correct (hidden) checkboxes are checked.
      triggerChange('#ca-call-group-hearing-aid-age');
    }

    if (targetId === 'ca-call-group-hearing-aid-age') {
      const warrantyChecked = document.querySelector('#ca-call-group-topic-warranty').checked;
      const aidLostChecked = document.querySelector('#ca-call-group-topic-aid-lost').checked;

      // Set the hidden checkboxes based on what topics are checked and the age of the hearing aid.
      document.querySelector('#ca-call-group-topic-aid-lost-old').checked = (aidLostChecked && targetValue === 'old');
      document.querySelector('#ca-call-group-topic-aid-lost-new').checked = (aidLostChecked && targetValue === 'new');
      document.querySelector('#ca-call-group-topic-warranty-old').checked = (warrantyChecked && targetValue === 'old');
      document.querySelector('#ca-call-group-topic-warranty-new').checked = (warrantyChecked && targetValue === 'new');
      document.querySelector('#ca-call-group-topic-warranty-new').dispatchEvent(new Event('change', {bubbles: true}));
    }

    if (targetId === 'is-wrong-number') {
      const isWrongNumberChecked = document.querySelector('#is-wrong-number').checked;
      if (isWrongNumberChecked) {
        setElementDisplay('.valid_number', 'none');
      } else {
        setElementDisplay('.valid_number', 'block');
      }
      updateVisibility();
    }

    if (targetId.includes('ca-call-group-topic')) {
      onChangeTopic();
    }

    //All other form logic using functions
    switch (targetId) {
      case 'ca-call-group-topic-wants-appt':
        //todo: Should we check for this in onChangeTopic()?
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
        document.querySelector('#call-type').value = targetValue;
        document.querySelector('#call-type').dispatchEvent(new Event('change', {bubbles: true}));
        break;
      case 'location-search':
        //TODO: Remove this when we fix autocomplete. This is temporary to handle a location id directly typed in.
        if (parseInt(targetValue) > 8119000000) {
          document.querySelector('#ca-call-group-location-id').value = targetValue;
          document.querySelector('#ca-call-group-location-id').dispatchEvent(new Event('change', {bubbles: true}));
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

  //Strip out default Cake validity inline code, and set up new validity check
  let requiredElements = document.querySelectorAll('input[required], select[required]');
  requiredElements.forEach( el => {
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
  const elements = ['#ca-call-group-location-id','#call-type','#ca-call-group-caller-first-name','#ca-call-group-caller-last-name','#ca-call-group-caller-phone','#ca-call-group-is-patient','#is-patient','#ca-call-group-patient-first-name','#ca-call-group-patient-last-name','#ca-call-group-prospect','#ca-call-group-front-desk-name','#ca-call-group-score','#ca-call-group-topic-warranty','#is-wrong-number','#ca-call-group-refused-name'];
  elements.forEach(element => {
    if (skipElements.indexOf(element) === -1) {
      triggerChange(element);
    }
  });
}

function triggerChange(element) {
  var selector = document.querySelector(element);
  if (selector !== null) {
    selector.dispatchEvent(new Event('change', {bubbles: true}));
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
  const locationId = document.querySelector("#ca-call-group-location-id").value.trim();
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
  const callType = document.querySelector("#call-type")?.value;
  const isVoicemailType =
    callType === CALL_TYPE_VM_CALLBACK_CLINIC ||
    callType === CALL_TYPE_VM_CALLBACK_CONSUMER;
  let calculateByScore = false;

  if (IS_CALL_GROUP_EDIT_PAGE) {
    // Do not automatically calculate a new status on the Edit Call Group page
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#ca-call-group-did-they-answer-followup").value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_SET_APPT;
    } else {
      document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_NO_ANSWER;
      document.querySelector("#ca-call-group-patient-followup-count").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#ca-call-group-did-they-answer-followup").value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      document.querySelector("#ca-call-group-status").value = STATUS_TENTATIVE_APPT;
    } else {
      document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_NO_ANSWER;
      document.querySelector("#ca-call-group-patient-followup-count").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST && !IS_CLINIC_LOOKUP_PAGE && document.querySelector("#ca-call-group-did-they-answer-followup").value === "no") {
    // Clinic did not answer followup call
    if (Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
      document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_APPT_REQUEST_FORM;
    } else {
      document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_NO_ANSWER;
      document.querySelector("#ca-call-group-patient-followup-count").value = 0;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT && !IS_CLINIC_LOOKUP_PAGE) {
    if (document.querySelector("#ca-call-group-did-consumer-answer").value === "yes" && document.querySelector("#ca-call-group-did-they-answer-followup").value === "no") {
      // Consumer answered but clinic did not. Next attempt will not be direct book.
      if (Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
        document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_APPT_REQUEST_FORM;
      } else {
        document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_NO_ANSWER;
        document.querySelector("#ca-call-group-patient-followup-count").value = 0;
      }
    } else if (document.querySelector("#ca-call-group-did-consumer-answer").value === "no" && document.querySelector("#ca-call-group-did-they-answer-followup2").value === "no") {
      // Neither consumer nor clinic answered
      if (
        Number(document.querySelector("#ca-call-group-clinic-followup-count").value) < MAX_CLINIC_FOLLOWUP_ATTEMPTS) {
        document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_APPT_REQUEST_FORM;
      } else {
        document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_NO_ANSWER;
        document.querySelector("#ca-call-group-patient-followup-count").value = 0;
      }
    } else {
      calculateByScore = true;
    }
  } else if (callType === CALL_TYPE_FOLLOWUP_NO_ANSWER) {
    if (document.querySelector("#ca-call-group-did-they-answer-followup").value === "yes") {
      // Patient answered
      if (document.querySelector("#ca-call-group-score").value === SCORE_APPT_SET) {
        document.querySelector("#ca-call-group-status").value = STATUS_APPT_SET;
      } else {
        document.querySelector("#ca-call-group-status").value = STATUS_MO_NO_ANSWER;
        document.querySelector("#ca-call-group-score").disabled = false;
        document.querySelector("#ca-call-group-score").value = SCORE_MISSED_OPPORTUNITY;
      }
    } else if (document.querySelector("#ca-call-group-did-they-answer-followup").value === "vm") {
      // Left a voicemail
      document.querySelector("#ca-call-group-status").value = STATUS_MO_NO_ANSWER;
      document.querySelector("#ca-call-group-score").disabled = false;
      document.querySelector("#ca-call-group-score").value = SCORE_MISSED_OPPORTUNITY;
    } else {
      // Patient did not answer
      if (Number(document.querySelector("#ca-call-group-patient-followup-count").value) < MAX_PATIENT_FOLLOWUP_ATTEMPTS) {
        document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_NO_ANSWER;
      } else {
        document.querySelector("#ca-call-group-status").value = STATUS_MO_NO_ANSWER;
        document.querySelector("#ca-call-group-score").disabled = false;
        document.querySelector("#ca-call-group-score").value = SCORE_MISSED_OPPORTUNITY;
      }
    }
  } else if (isVoicemailType && document.querySelector("#ca-call-group-did-they-answer-vm").value === "vm") {
    document.querySelector("#ca-call-group-status").value = STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS;
  } else if (isVoicemailType && (document.querySelector("#ca-call-group-did-they-answer-vm").value === "no" || document.querySelector("#ca-call-group-did-they-answer-vm").value === "")) {
    if (Number(document.querySelector("#ca-call-group-vm-outbound-count").value) < MAX_VM_OUTBOUND_ATTEMPTS) {
      document.querySelector("#ca-call-group-status").value = STATUS_VM_CALLBACK_ATTEMPTED;
    } else {
      document.querySelector("#ca-call-group-status").value = STATUS_VM_CALLBACK_TOO_MANY_ATTEMPTS;
    }
  } else if (isVoicemailType && document.querySelector("#ca-call-group-did-they-answer-vm").value === "noAttempt") {
    const vmCount = Number(document.querySelector("#ca-call-group-vm-outbound-count").value);
    document.querySelector("#ca-call-group-vm-outbound-count").value = vmCount - 1;
    document.querySelector("#ca-call-group-status").value = STATUS_VM_CALLBACK_ATTEMPTED;
  } else if (callType === CALL_TYPE_VM_CALLBACK_INVALID) {
    document.querySelector("#ca-call-group-status").value = STATUS_WRONG_NUMBER;
  } else if (document.querySelector("#is-wrong-number").checked) {
    document.querySelector("#ca-call-group-status").value = STATUS_WRONG_NUMBER;
  } else if (document.querySelector("#ca-call-group-refused-name-again-quick-pick") && document.querySelector("#ca-call-group-refused-name-again-quick-pick").checked) {
    document.querySelector("#ca-call-group-status").value = STATUS_QUICK_PICK_REFUSED_NAME_ADDRESS;
  } else if (document.querySelector("#ca-call-group-did-clinic-answer").value === "cr") {
    document.querySelector("#ca-call-group-status").value = STATUS_QUICK_PICK_CALLER_REFUSED_HELP;
  } else {
    // Inbound or Followup call
    calculateByScore = true;
  }

  if (calculateByScore) {
    const score = document.querySelector("#ca-call-group-score").value;
    const prospect = document.querySelector("#ca-call-group-prospect").value;
    if (prospect === PROSPECT_NO) {
      document.querySelector("#ca-call-group-status").value = STATUS_NON_PROSPECT;
    } else if (score === SCORE_DISCONNECTED || prospect === PROSPECT_DISCONNECTED) {
      document.querySelector("#ca-call-group-status").value = STATUS_INCOMPLETE;
      document.querySelector("#ca-call-group-score").value = SCORE_DISCONNECTED;
    } else if (score === SCORE_NOT_REACHED) {
      document.querySelector("#ca-call-group-status").value = STATUS_FOLLOWUP_SET_APPT;
    } else if (score === SCORE_APPT_SET || score === SCORE_APPT_SET_DIRECT) {
      document.querySelector("#ca-call-group-status").value = STATUS_APPT_SET;
    } else if (score === SCORE_TENTATIVE_APPT) {
      document.querySelector("#ca-call-group-status").value = STATUS_TENTATIVE_APPT;
    } else if (score === SCORE_MISSED_OPPORTUNITY) {
      document.querySelector("#ca-call-group-status").value = STATUS_MISSED_OPPORTUNITY;
    } else {
      document.querySelector("#ca-call-group-status").value = STATUS_NEW;
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
          document.querySelector("#ca-call-group-id").value = '';
          document.querySelector(".found-no-calls").style.display = 'block';
          document.querySelector(".found-multiple-calls").style.display = 'none';
          document.querySelector(".group-found").style.display = 'none';
          updateVisibility();
        } else if (count == 1) {
          // One previous call found. Automatically select it.
          document.querySelector(".found-no-calls").style.display = 'none';
          document.querySelector(".found-multiple-calls").style.display = 'none';
          updateVisibility();
          const dataKeys = Object.keys(data);
          const groupId = dataKeys[0];
          onChangeGroupSearch(groupId);
        } else {
          // Found multiple followup calls. User must select one.
          document.querySelector(".found-no-calls").style.display = 'none';
          document.querySelector(".found-multiple-calls").style.display = 'block';
          document.querySelector(".group-found").style.display = 'none';
          updateVisibility();
          document.querySelector("#ca-call-group-id").value = '';
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
        console.log('getPreviousCalls() error:');
        console.error(error);
      });
    } else {
      // No location selected
      document.querySelector(".found-no-calls").style.display = 'none';
      document.querySelector(".found-multiple-calls").style.display = 'none';
      updateVisibility();
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
          document.querySelectorAll('.group_search').forEach(groupSearchElement => {
            groupSearchElement.innerHTML = '';
            groupSearchElement.appendChild(new Option('', ''));
            for (const key in data) {
              groupSearchElement.appendChild(new Option(data[key], key));
            }
          });
        } else {
          console.log('getPreviousCalls failed');
          console.debug(data);
        }
      });
    } catch (error) {
      console.log('getPreviousCalls error:');
      console.error(error);
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
  const returnVmFromInvalid = document.querySelector('#return_vm_from_invalid');
  const caCallGroupId = document.querySelector('#ca-call-group-id').value;
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
        triggerChangeEvents(['#call-type']);
        triggerChange('#ca-call-group-did-they-answer-vm');
      })
      .catch(error => {
        console.log('Error in '+ajaxUrl);
        console.error(error);
      });
  } else {
    const returnVmAjaxForm = document.querySelector('#return_vm_ajax_form');
    returnVmAjaxForm.innerHTML = '';
    returnVmAjaxForm.style.display = 'none';
    returnVmFromInvalid.style.display = 'block';
  }
}

function onChangeIsPatient(isPatient) {
  if (isPatient) {
    setElementDisplay('.patient-data', 'none');
  } else {
    setElementDisplay('.patient-data', 'block');
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
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'block');
    const wantsAppt = document.querySelector('#ca-call-group-topic-wants-appt').checked;
    const directBookType = document.querySelector("#ca-call-group-direct-book-type")?.value;
    const isDirectBookEarqOrBp = (directBookType === DIRECT_BOOK_BLUEPRINT) || (directBookType === DIRECT_BOOK_EARQ);
    const wantsHearingTest = document.querySelector('#ca-call-group-wants-hearing-test')?.value === '1';
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
    updateVisibility();
  } else if (calculatedProspect === PROSPECT_NO) {
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'block');
    updateVisibility();
    document.querySelector('#ca-call-group-score').value = '';
    document.querySelector('#ca-call-group-score').dispatchEvent(new Event('change', {bubbles: true}));
  } else if (calculatedProspect === PROSPECT_UNKNOWN) {
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'block');
    updateVisibility();
  } else {
    // disconnected - no need to show any further script
    document.querySelectorAll('.prospectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.nonProspectTopic').forEach(element => element.style.display = 'none');
    document.querySelectorAll('.prospectUnknownTopic').forEach(element => element.style.display = 'none');
    updateVisibility();
  }
}

function onChangeScore(score) {
  if (score === SCORE_APPT_SET || score === SCORE_APPT_SET_DIRECT) {
    // Appointment set
    setElementDisplay('.appt_date', 'block');
    setElementDisplay('.scheduled_call_date', 'none');
    updateVisibility();
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      onChangeApptDate();
    }
  } else if (score === SCORE_TENTATIVE_APPT) {
    // Left a voicemail with clinic - followup in 48 hours to verify if appointment has been set
    setElementDisplay('.appt_date', 'none');
    setElementInnerHTML('#scheduled-call-date-label', "Next attempt to reach clinic ("+easternTimezone+")");
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      // Next call time should be 48 hours from now
      const nextCallDate = new Date();
      nextCallDate.setDate(nextCallDate.getDate() + 2);
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
      setElementDisplay('.scheduled_call_date', 'block');
    }
    if (IS_CALL_GROUP_EDIT_PAGE) {
      setElementDisplay('.scheduled_call_date', 'block');
    }
    updateVisibility();
  } else if (score === SCORE_NOT_REACHED) {
    // Clinic not reached - needs followup to set appt
    setElementDisplay('.appt_date', 'none');
    setElementInnerHTML('#scheduled-call-date-label', "Next attempt to reach clinic ("+easternTimezone+")");
    // Do not modify the call date if we are loading the page and call date is already set
    if (pageLoadComplete || !isCallDateSet) {
      // Next call time should be 15 minutes from now
      const callDate = new Date();
      callDate.setMinutes(callDate.getMinutes() + 15);
      setDateField('#ca-call-group-scheduled-call-date', callDate);
      setElementDisplay('.scheduled_call_date', 'block');
    }
    if (IS_CALL_GROUP_EDIT_PAGE) {
      setElementDisplay('.scheduled_call_date', 'block');
    }
    updateVisibility();
  } else {
    // Non-prospect/missed opportunity
    setElementDisplay('.appt_date', 'none');
    setElementDisplay('.scheduled_call_date', 'none');
    // Disable any fields that are required and hidden, or the form will fail to validate.
    updateVisibility();
  }
}

async function onChangeGroupSearch(group_id) {
//  document.querySelector(".lock-error").style.display = "none";
  document.querySelectorAll('.lock-error').forEach(element => element.style.display = 'none');
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
          document.querySelector(".lock-error").style.display = "block";
          document.querySelector(".group-found").style.display = "none";
          updateVisibility();
          document.querySelector("span.lockTime").textContent = data["lock_time"];
          document.querySelector("span.lockedBy").textContent = data["locked_by"];
          document.querySelector("#ca-call-group-id").value = group_id;
          document.querySelector("#ca-call-ca-call-group-id").value = group_id;
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
    document.querySelector("span.callGroupId").textContent = data["id"];
    document.querySelector("#ca-call-ca-call-group-id").value = data["id"];
    document.querySelector("#ca-call-group-id").value = data["id"];
    document.querySelector("#ca-call-group-status").value = data["status"];
    document.querySelector("span.status").textContent = statuses[data["status"]];
    showGroupFound();
    document.querySelector("#ca-call-group-caller-first-name").value = data["caller_first_name"];
    document.querySelector("#ca-call-group-caller-last-name").value = data["caller_last_name"];
    document.querySelector("#ca-call-group-caller-phone").value = data["caller_phone"];
    document.querySelector("#ca-call-group-is-patient").checked = data["is_patient"];
    document.querySelector("#ca-call-group-patient-first-name").value = data["patient_first_name"];
    document.querySelector("#ca-call-group-patient-last-name").value = data["patient_last_name"];
    document.querySelector("#ca-call-group-topic-wants-appt").checked = data["topic_wants_appt"];
    document.querySelector("#ca-call-group-topic-clinic-hours").checked = data["topic_clinic_hours"];
    document.querySelector("#ca-call-group-topic-insurance").checked = data["topic_insurance"];
    document.querySelector("#ca-call-group-topic-clinic-inquiry").checked = data["topic_clinic_inquiry"];
    document.querySelector("#ca-call-group-topic-aid-lost-old").checked = data["topic_aid_lost_old"];
    document.querySelector("#ca-call-group-topic-aid-lost-new").checked = data["topic_aid_lost_new"];
    document.querySelector("#ca-call-group-topic-warranty-old").checked = data["topic_warranty_old"];
    document.querySelector("#ca-call-group-topic-warranty-new").checked = data["topic_warranty_new"];
    document.querySelector("#ca-call-group-topic-batteries").checked = data["topic_batteries"];
    document.querySelector("#ca-call-group-topic-parts").checked = data["topic_parts"];
    document.querySelector("#ca-call-group-topic-cancel-appt").checked = data["topic_cancel_appt"];
    document.querySelector("#ca-call-group-topic-reschedule-appt").checked = data["topic_reschedule_appt"];
    document.querySelector("#ca-call-group-topic-appt-followup").checked = data["topic_appt_followup"];
    document.querySelector("#ca-call-group-topic-medical-records").checked = data["topic_medical_records"];
    document.querySelector("#ca-call-group-topic-tinnitus").checked = data["topic_tinnitus"];
    document.querySelector("#ca-call-group-topic-medical-inquiry").checked = data["topic_medical_inquiry"];
    document.querySelector("#ca-call-group-topic-solicitor").checked = data["topic_solicitor"];
    document.querySelector("#ca-call-group-topic-personal-call").checked = data["topic_personal_call"];
    document.querySelector("#ca-call-group-topic-request-fax").checked = data["topic_request_fax"];
    document.querySelector("#ca-call-group-topic-request-name").checked = data["topic_request_name"];
    document.querySelector("#ca-call-group-topic-remove-from-list").checked = data["topic_remove_from_list"];
    document.querySelector("#ca-call-group-topic-foreign-language").checked = data["topic_foreign_language"];
    document.querySelector("#ca-call-group-topic-other").checked = data["topic_other"];
    document.querySelector("#ca-call-group-topic-declined").checked = data["topic_declined"];
    document.querySelector("#ca-call-group-prospect").value = data["prospect"];
    if (!IS_CLINIC_LOOKUP_PAGE) {
      // Don't overwrite the front desk name on the clinic lookup page
      document.querySelector("#ca-call-group-front-desk-name").value = data["front_desk_name"];
    }
    document.querySelector("#ca-call-group-score").value = data["score"];
    document.querySelector("#ca-call-group-is-review-needed").checked = data["is_review_needed"];
    if (document.querySelector("#ca-call-group-location-id").value != data["location_id"]) {
      // Only trigger a location change if different
      document.querySelector("#ca-call-group-location-id").value = data["location_id"];
    }
    setDateField("#ca-call-group-appt-date", data["appt_date"]);
    setDateField("#ca-call-group-scheduled-call-date", data["scheduled_call_date"]);
  } else {
    clearAllFields();
  }
}

function clearAllFields() {
  document.querySelectorAll("span.callGroupId").forEach((element) => {
    element.textContent = "";
  });

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
    var selector = document.querySelector(element);
    if (selector) {
      selector.checked = false;
    }
  });

  document.querySelector("#ca-call-group-status").value = statuses[STATUS_NEW];
  document.querySelector("span.status").textContent = statuses[STATUS_NEW];
  showGroupFound();

  document.querySelector("#ca-call-group-prospect").value = PROSPECT_NO;
  document.querySelector("#ca-call-group-prospect").dispatchEvent(new Event("change"));

  document.querySelector("#ca-call-group-score").value = "";
  document.querySelector("#ca-call-group-score").dispatchEvent(new Event("change"));

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
    setElementDisplay('.have-location-and-front-desk', 'block');
  } else {
    setElementDisplay('.have-location-and-front-desk', 'none');
  }
  
  updateVisibility();
}

function doWeHaveLocationInitially() {
  const locationId = document.querySelector("#ca-call-group-location-id");

  if (locationId && (parseInt(locationId.value) > 0)) {
    setElementDisplay('.init_have_location', 'block');
    setElementDisplay('.init_no_location', 'none');
  } else {
    setElementDisplay('.init_have_location', 'none');
    setElementDisplay('.init_no_location', 'block');
  }

  updateVisibility();
}

function showGroupFound() {
  const groupId = document.querySelector("#ca-call-group-id").value;
  const frontDeskName = document.querySelector("#ca-call-group-front-desk-name").value;
  const groupFoundElement = document.querySelector(".group-found");

  if (groupId && frontDeskName) {
    const groupNotLoaded = groupFoundElement && (groupFoundElement.dataset.groupId !== groupId);
    const isGroupLocked = document.querySelector(".lock-error") && document.querySelector(".lock-error").style.display === "block";

    if (groupNotLoaded && !isGroupLocked) {
      groupFoundElement.dataset.groupId = groupId;
      fetch(`/admin/ca-calls/ajax_outbound_followup_form/${groupId}`)
        .then((response) => response.text())
        .then((data) => {
          const status = document.querySelector("#ca-call-group-status").value;
          const callTypeElement = document.querySelector("#call-type");

          if (status === STATUS_TENTATIVE_APPT) {
            callTypeElement.value = CALL_TYPE_FOLLOWUP_TENTATIVE_APPT;
          } else {
            callTypeElement.value = CALL_TYPE_FOLLOWUP_APPT;
          }

          groupFoundElement.innerHTML = data;
          groupFoundElement.style.display = "block";
          onPageLoad();
          triggerChangeEvents(["#ca-call-group-location-id", "#call-type"]);
          setElementInnerHTML('span.locationTitle', locationTitle);
        });
    }

    setElementDisplay('.group-found-buttons', 'block');
    updateVisibility();
  } else {
    if (groupFoundElement) {
      groupFoundElement.innerHTML = "";
      groupFoundElement.style.display = 'none';
    }
    setElementDisplay('.group-found-buttons', 'none');
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
  document.querySelectorAll('span.callerFirstName').forEach(element => {
    element.textContent = callerFirstName;
  });
  onChangePatientInfo();
}

function onChangeCallerLastName(callerLastName) {
  document.querySelectorAll('span.callerLastName').forEach(element => {
    element.textContent = callerLastName;
  });
  onChangePatientInfo();
}

function onChangeCallerPhone(callerPhone) {
  let formattedPhone = callerPhone;
  if (callerPhone.length === 10) {
    formattedPhone = callerPhone.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
  } else if (callerPhone.length === 11) {
    formattedPhone = callerPhone.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1-$2-$3-$4');
  }
  document.querySelectorAll('span.callerPhone').forEach(element => {
    element.textContent = formattedPhone;
  });
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
  document.querySelectorAll('span.frontDeskName').forEach(element => {
    element.textContent = frontDeskName;
  });
  doWeHaveLocationAndFrontDesk();
  showGroupFound();
}

function setDateField(selector, date) {
  // TODO: Do we want to round to nearest 15 minutes?
  document.querySelector(selector).value = formatDateTime(date);
}

function isHidden(el) {
    return (el.offsetParent === null);
}

function updateVisibility(className = 'form_fields') {
  document.querySelectorAll('.'+className+' input, .'+className+' select').forEach(input => {
    // Don't disable inputs with 'hidden' type
    if (input.type !== 'hidden') {
      if (isHidden(input)) {
        // This input is not currently visible - disable it
        input.setAttribute("disabled","disabled");
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
    setElementDisplay('.consumerConsentYes', 'block');
    setElementDisplay('.consumerConsentNo', 'none');
    setElementInnerHTML('span.callTransferInstructions', "[Mute and listen to appointment info]");
  } else if (consumerConsent === 'no') {
    setElementDisplay('.consumerConsentYes', 'none');
    setElementDisplay('.consumerConsentNo', 'block');
    setElementInnerHTML('span.callTransferInstructions', "[Hang up and score as 'Tentative appointment'.]");
    document.getElementById('ca-call-group-score').value = SCORE_TENTATIVE_APPT;
    document.getElementById('ca-call-group-score').dispatchEvent(new Event('change', {bubbles: true}));
  }
}

function onChangeDidClinicAnswer(didClinicAnswer) {
  const didClinicAnswerYes = document.querySelectorAll('.didClinicAnswerYes');
  const didClinicAnswerNo = document.querySelectorAll('.didClinicAnswerNo');
  const didClinicAnswerVm = document.querySelectorAll('.didClinicAnswerVm');
  const callGroupScore = document.getElementById('ca-call-group-score');

  document.querySelectorAll('.prospectOptions').forEach(element => {
    element.style.display = 'block';
  });

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
    callGroupScore.value = '';
    callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
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
    const groupProspect = document.getElementById('ca-call-group-prospect').value;
    if (groupProspect === PROSPECT_YES) {
      if (document.getElementById('ca-call-group-refused-name').checked) {
        callGroupScore.value = SCORE_MISSED_OPPORTUNITY;
      } else {
        callGroupScore.value = SCORE_NOT_REACHED;
      }
      callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
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
    if (document.getElementById('ca-call-group-prospect').value === PROSPECT_YES) {
      callGroupScore.value = SCORE_TENTATIVE_APPT;
      callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
    }
  } else if (didClinicAnswer === 'cr') {
    callGroupScore.value = SCORE_DISCONNECTED;
    document.querySelectorAll('.prospectOptions').forEach(element => {
      element.style.display = 'none'
    });
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
    callGroupScore.value = '';
    callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
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
    setDateField('#NoAnswerScheduledCallDate', callDate);
  } else {
    didTheyAnswerYes.style.display = 'none';
    didTheyAnswerNo.style.display = 'block';
    document.querySelector('#didTheyAnswerNo .scheduled_call_date').style.display = 'block';
    didTheyAnswerVm.style.display = 'none';
    updateVisibility();
    // Default next call time to 30 minutes from now
    callDate.setMinutes(callDate.getMinutes() + 30);
    setDateField('#NoAnswerScheduledCallDate', callDate);
  }
}

function onChangeDidTheyAnswerFollowup(answer) {
  const callType = document.querySelector("#call-type").value;
  const didTheyAnswerFollowupYes = document.querySelector(".didTheyAnswerFollowupYes");
  const didTheyAnswerFollowupNo = document.querySelector(".didTheyAnswerFollowupNo");
  const didTheyAnswerFollowupVm = document.querySelector(".didTheyAnswerFollowupVm");
  const followupForm = document.querySelector(".followupForm");
  const scheduledCallDate = document.querySelector(".scheduled_call_date");

  if (answer === 'yes') {
    didTheyAnswerFollowupYes.style.display = 'block';
    if (didTheyAnswerFollowupNo) {
      didTheyAnswerFollowupNo.style.display = 'none';
    }
    didTheyAnswerFollowupVm.style.display = 'none';
    scheduledCallDate.style.display = 'none';
  } else if (answer === 'vm') {
    const prospect = document.querySelector("#ca-call-group-prospect").value;
    didTheyAnswerFollowupYes.style.display = 'none';
    if (didTheyAnswerFollowupNo) {
      didTheyAnswerFollowupNo.style.display = 'none';
    }
    didTheyAnswerFollowupVm.style.display = 'block';
    if (callType === CALL_TYPE_FOLLOWUP_NO_ANSWER || prospect === PROSPECT_NO) {
      followupForm.style.display = 'none';
      scheduledCallDate.style.display = 'none';
    } else {
      followupForm.style.display = 'block';
      callGroupScore.value = SCORE_TENTATIVE_APPT;
      callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
    }
  } else { // NO
    didTheyAnswerFollowupYes.style.display = 'none';
    didTheyAnswerFollowupVm.style.display = 'none';
    if (didTheyAnswerFollowupNo) {
      didTheyAnswerFollowupNo.style.display = 'block';
    }
    followupForm.style.display = 'none';
    scheduledCallDate.style.display = 'block';
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
      setElementInnerHTML('#scheduled-call-date-label', "Next attempt to reach consumer ("+easternTimezone+")");
    }
  }
  updateVisibility();
}

function onChangeDidConsumerAnswer(answer) {
  const callType = document.querySelector("#call-type").value;
  const didConsumerAnswerYes = document.querySelector(".didConsumerAnswerYes");
  const didConsumerAnswerNo = document.querySelector(".didConsumerAnswerNo");
  const didConsumerAnswerVm = document.querySelector(".didConsumerAnswerVm");
  const didConsumerAnswerInvalid = document.querySelector(".didConsumerAnswerInvalid");
  const followupForm = document.querySelector(".followupForm");
  const scheduledCallDate = document.querySelector(".scheduled_call_date");
  const callGroupScore = document.querySelector("#ca-call-group-score");
  const nextCallDate = new Date();

  if (answer === 'yes') {
    didConsumerAnswerYes.style.display = 'block';
    didConsumerAnswerNo.style.display = 'none';
    didConsumerAnswerVm.style.display = 'none';
    didConsumerAnswerInvalid.style.display = 'none';
    followupForm.style.display = 'block';
    scheduledCallDate.style.display = 'none';
  } else if (answer === 'vm') {
    didConsumerAnswerYes.style.display = 'none';
    didConsumerAnswerNo.style.display = 'none';
    didConsumerAnswerVm.style.display = 'block';
    didConsumerAnswerInvalid.style.display = 'none';
    if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST) {
      scheduledCallDate.style.display = 'block';
      nextCallDate.setMinutes(nextCallDate.getMinutes() + 240);
      setDateField('#ca-call-group-scheduled-call-date', nextCallDate);
    } else {
      followupForm.style.display = 'block';
      callGroupScore.value = SCORE_TENTATIVE_APPT;
      callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
    }
  } else if (answer === 'invalid') {
    didConsumerAnswerYes.style.display = 'none';
    didConsumerAnswerNo.style.display = 'none';
    didConsumerAnswerVm.style.display = 'none';
    didConsumerAnswerInvalid.style.display = 'block';
    followupForm.style.display = 'block';
    callGroupScore.value = SCORE_DISCONNECTED;
    callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
  } else { // NO
    const prospect = document.querySelector("#ca-call-group-prospect").value;
    didConsumerAnswerYes.style.display = 'none';
    didConsumerAnswerNo.style.display = 'block';
    didConsumerAnswerVm.style.display = 'none';
    didConsumerAnswerInvalid.style.display = 'none';
    if (callType === CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT || prospect === PROSPECT_NO) {
      followupForm.style.display = 'none';
    } else {
      followupForm.style.display = 'block';
      callGroupScore.value = SCORE_TENTATIVE_APPT;
      callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
    }
  }
  updateVisibility();
}

function onChangeDidConsumerAnswer2(answer) {
  const didConsumerAnswer2Yes = document.querySelector(".didConsumerAnswer2Yes");
  const didConsumerAnswer2No = document.querySelector(".didConsumerAnswer2No");
  const followupForm = document.querySelector(".followupForm");
  const scheduledCallDate = document.querySelector(".scheduled_call_date");
  const callGroupScore = document.querySelector("#ca-call-group-score");

  if (answer === 'yes') {
    didConsumerAnswer2Yes.style.display = 'block';
    didConsumerAnswer2No.style.display = 'none';
    followupForm.style.display = 'block';
    scheduledCallDate.style.display = 'none';
  } else { // NO
    didConsumerAnswer2Yes.style.display = 'none';
    didConsumerAnswer2No.style.display = 'block';
    followupForm.style.display = 'block';
    callGroupScore.value = SCORE_TENTATIVE_APPT;
    callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
  }
  updateVisibility();
}

function onChangeDidTheyWantHelp(answer) {
  const wantHelpYes = document.querySelector(".wantHelpYes");
  const wantHelpNo = document.querySelector(".wantHelpNo");

  if (answer === 1) { // YES
    wantHelpYes.style.display = 'block';
    wantHelpNo.style.display = 'none';
  } else { // NO
    wantHelpYes.style.display = 'none';
    wantHelpNo.style.display = 'block';
  }
  updateVisibility();
}

function onChangeDidClinicContactConsumer(answer) {
  const didClinicContactConsumerYes = document.querySelector(".didClinicContactConsumerYes");
  const didClinicContactConsumerNo = document.querySelector(".didClinicContactConsumerNo");
  const followupForm = document.querySelector(".followupForm");
  const callType = document.querySelector("#call-type").value;
  const callGroupScore = document.querySelector("#ca-call-group-score");

  if (answer === 1) { // YES
    didClinicContactConsumerYes.style.display = 'block';
    didClinicContactConsumerNo.style.display = 'none';
    followupForm.style.display = 'block';
  } else { // NO
    didClinicContactConsumerYes.style.display = 'none';
    didClinicContactConsumerNo.style.display = 'block';
    document.querySelector('#ca-call-group-did-they-want-help').value = '';
    callGroupScore.value = SCORE_MISSED_OPPORTUNITY;
    callGroupScore.dispatchEvent(new Event('change', {bubbles: true}));
    if (callType === CALL_TYPE_FOLLOWUP_TENTATIVE_APPT) {
      followupForm.style.display = 'block';
    } else { // CALL_TYPE_FOLLOWUP_NO_ANSWER
      followupForm.style.display = 'none';
    }
  }
  updateVisibility();
}

function onChangeRefusedName() {
  const topicDeclined = document.querySelector('#ca-call-group-topic-declined');

  if (document.getElementById('ca-call-group-refused-name').checked) {
    setElementDisplay('.refusedNameNo', 'none');
    setElementDisplay('.refusedNameYes', 'block');
    if (pageLoadComplete) {
      topicDeclined.checked = true;
      topicDeclined.dispatchEvent(new Event('change', {bubbles: true}));
    }
    // Don't leave vm at clinic if we don't know caller name
    document.querySelector("#ca-call-group-did-clinic-answer option[value='vm']").remove();
  } else {
    setElementDisplay('.refusedNameNo', 'block');
    setElementDisplay('.refusedNameYes', 'none');
    if (pageLoadComplete) {
      topicDeclined.checked = false;
      topicDeclined.dispatchEvent(new Event('change', {bubbles: true}));
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
  const didClinicRefuseYes = document.querySelector(".didClinicRefuseYes");
  const isReviewNeeded = document.querySelector('#ca-call-group-is-review-needed');
  const score = document.querySelector('#ca-call-group-score');
  if (document.querySelector('#ca-call-group-did-clinic-refuse').checked) {
    didClinicRefuseYes.style.display = "block";
    if (pageLoadComplete) {
      isReviewNeeded.checked = true;
      score.value = SCORE_MISSED_OPPORTUNITY;
      score.dispatchEvent(new Event('change', {bubbles: true}));
    }
  } else {
    didClinicRefuseYes.style.display = "none";
    if (pageLoadComplete) {
      isReviewNeeded.checked = false;
      score.value = SCORE_TENTATIVE_APPT;
      score.dispatchEvent(new Event('change', {bubbles: true}));
    }
  }
  updateVisibility();
}

function formatDateTime(date) {
  // Format a date as YYYY-mm-ddTHH:mm
  return date.getFullYear() +
      '-' + pad(date.getMonth()+1) +
      '-' + pad(date.getDate()) +
      'T' + pad(date.getHours()) +
      ':' + pad(date.getMinutes());
}

function pad(num, size=2) {
    num = num.toString();
    while (num.length < size) num = "0" + num;
    return num;
}

function setElementInnerHTML(selector, innerHtmlValue) {
  document.querySelectorAll(selector).forEach(element => {
    element.innerHTML = innerHtmlValue || '';
  });
}

function setElementDisplay(selector, displayValue) {
  document.querySelectorAll(selector).forEach(element => {
    element.style.display = displayValue || '';
  });
}

function setElementValue(selector, value) {
  document.querySelectorAll(selector).forEach(element => {
    element.value = value || '';
  });
}
