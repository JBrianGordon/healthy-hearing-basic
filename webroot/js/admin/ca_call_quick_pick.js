import '../common/common';
import { setElementInnerHTML, setElementValue, showElement, hideElement, isHidden, updateVisibility } from './ca_call_edit';

function onPageLoadQuickPick() {
  // Listen for field changes
  document.querySelector('body').addEventListener('change', e => {
    const targetId = e.target.id;
    const targetValue = e.target.value;

    if (targetId === 'ca-call-group-refused-name-quick-pick') {
      onChangeRefusedNameQuickPick();
    }

    if (targetId === 'ca-call-group-refused-name-again-quick-pick') {
      onChangeRefusedNameAgainQuickPick();
    }

    if (targetId === 'ca-call-group-is-direct-book-working') {
      onChangeIsDirectBookWorking(targetValue);
    }
  });

  // Listen for clicks
  document.querySelector('body').addEventListener('click', e => {
    const targetId = e.target.id;
    const targetChecked = e.target.checked;

    // Find closest clinics button
    if (targetId === 'findClosestLocations') {
      findClosestLocations(document.querySelector('#ca-call-group-patient-full-address').value);
    }

    // Load more clinics button
    if (targetId === 'loadMoreClinics') {
      loadMoreClinics();
    }

    if (targetId === 'ca-call-group-is-patient') {
      onChangePatientInfo(targetChecked);
    }
  });

  const patientAddressInput = document.querySelector('#ca-call-group-patient-address');
  const patientCityInput = document.querySelector('#ca-call-group-patient-city');
  const patientStateInput = document.querySelector('#ca-call-group-patient-state');
  const patientZipInput = document.querySelector('#ca-call-group-patient-zip');
  const patientFullAddressInput = document.querySelector('#ca-call-group-patient-full-address');

  const updateFullAddress = () => {
    patientFullAddressInput.value = `${patientAddressInput.value},${patientCityInput.value},${patientStateInput.value},${patientZipInput.value}`;
  };

  [patientAddressInput, patientCityInput, patientStateInput, patientZipInput].forEach(input => {
    input.addEventListener('keyup', updateFullAddress);
    input.addEventListener('blur', updateFullAddress);
  });
}

document.addEventListener('DOMContentLoaded', function () {
  onPageLoadQuickPick();
});

/****
 * Start of Functions
 ****/

let closestClinics;
let chosenClinic;
let clinicCounter = 0;
let searchInfo;

function onChangeRefusedNameQuickPick() {
  document.querySelectorAll('.refusedNameYesQuickPick').forEach(element => {
    element.classList.toggle('hidden');
  });
}

function onChangeRefusedNameAgainQuickPick() {
  document.querySelectorAll('.refusedNameNoQuickPick, .refusedNameYesAgainQuickPick').forEach(element => {
    element.classList.toggle('hidden');
  });
  updateVisibility();
}

function onChangePatientInfo(isPatient) {
  if (isPatient) {
    document.querySelectorAll('span.not-self').forEach(element => {
      element.classList.toggle('hidden');
    });
    document.querySelectorAll('span.self').forEach(element => {
      element.classList.toggle('hidden');
    });
    document.querySelectorAll('span.isNotPatient').forEach(element => {
      element.classList.toggle('hidden');
    });
    const patientNameElement = document.querySelector('span.patientName');
    if (patientNameElement) {
      const callerFirstName = document.querySelector('#ca-call-group-caller-first-name').value;
      const callerLastName = document.querySelector('#ca-call-group-caller-last-name').value;
      patientNameElement.textContent = callerFirstName + ' ' + callerLastName;
    }
  } else {
    document.querySelectorAll('span.isNotPatient').forEach(element => {
      element.classList.toggle('hidden');
    });
    const patientNameElement = document.querySelector('span.patientName');
    if (patientNameElement) {
      const patientFirstName = document.querySelector('#ca-call-group-patient-first-name').value;
      const patientLastName = document.querySelector('#ca-call-group-patient-last-name').value;
      patientNameElement.textContent = patientFirstName + ' ' + patientLastName;
    }
    document.querySelectorAll('span.self').forEach(element => {
      element.classList.toggle('hidden');
    });
    document.querySelectorAll('span.not-self').forEach(element => {
      element.classList.toggle('hidden');
    });
  }
}

function findClosestLocations(originAddress) {
  setElementInnerHTML('#closestClinics', '');

  closestClinics = [];
  clinicCounter = 0;

  const patientCityInput = document.querySelector("#ca-call-group-patient-city");
  const patientCity = patientCityInput.value.trim();
  const patientStateInput = document.querySelector("#ca-call-group-patient-state");
  const patientState = patientStateInput.value.trim();

  if (patientCity.length > 0 && patientState.length > 0) {
    fetch(`/admin/ca-calls/get-closest-clinics/${originAddress}`, {
      method: "GET",
      headers: {
        "Accept": "application/json"
      }
    })
      .then(response => response.json())
      .then(data => {
        searchInfo = data.pop();
        closestClinics = data;
        displayClinicTemplates(closestClinics);
      })
      .catch(error => {
        console.log('getClosestClinics() error:');
        console.error(error);
      });
    document.querySelector("#afterClinicFind")?.classList.remove('hidden');
    patientStateInput.style.removeProperty('border');
    patientCityInput.style.removeProperty('border');
  } else {
    patientStateInput.style.border = "2px solid red";
    patientCityInput.style.border = "2px solid red";
    alert("Please enter a city and state before searching.");
  }
}

function clickedClinic(clinicDiv) {
  clinicCounter++;

  const clinicIndex = clinicDiv.firstElementChild.getAttribute('value');
  chosenClinic = closestClinics[clinicIndex];

  setElementInnerHTML('.locationDistance', chosenClinic.google.distance.text);
  setElementInnerHTML('.locationTime', chosenClinic.google.duration.text);

  if (chosenClinic.google.distance.value === undefined || chosenClinic.google.duration.value === undefined) {
    hideElement('.hasDirections');
  } else {
    showElement('.hasDirections');
  }

  const numReviews = parseInt(chosenClinic.reviews_approved, 10);
  let ratingsReviewsText;

  switch (numReviews) {
    case 0:
      ratingsReviewsText = "<strong>0</strong> reviews";
      break;
    case 1:
      ratingsReviewsText = `an average rating of <strong>${chosenClinic.average_rating} out of 5</strong> stars and <strong>1</strong> review`;
      break;
    default:
      ratingsReviewsText = `an average rating of <strong>${chosenClinic.average_rating} out of 5</strong> stars and <strong>${chosenClinic.reviews_approved}</strong> reviews`;
  }

  setElementInnerHTML('.locationRating', ratingsReviewsText);

  clinicDiv.style.backgroundColor = "#78afc9";
  const siblings = clinicDiv.parentNode.children;
  for (let sibling of siblings) {
    if (sibling !== clinicDiv) {
      sibling.style.backgroundColor = "transparent";
    }
  }

  if (clinicCounter > 1) {
    hideElement('.firstClinic');
    showElement('.subsequentClinic');
  } else {
    showElement('.firstClinic');
    hideElement('.subsequentClinic');
  }

  const locationId = clinicDiv.querySelector("p[id*='locationId']").innerHTML;
  setElementValue('#ca-call-group-location-id', locationId);

  if (clinicCounter % 3 === 0) {
    showElement('#purposeReminder');
    hideElement('#ifNoCall');
  } else {
    hideElement('#purposeReminder');
    showElement('#ifNoCall');
  }

  setElementInnerHTML('.scriptLocationAddress',
    chosenClinic.address + ', ' +
    chosenClinic.city + ', ' +
    chosenClinic.state);

  if (chosenClinic.direct_book_type === DIRECT_BOOK_NONE) {
    showElement('.nonDirectBookQuickPick');
    hideElement('.directBookQuickPick');
    hideElement('.isDirectBookWorking');
  } else {
    showElement('.directBookQuickPick');
    hideElement('.nonDirectBookQuickPick');
    showElement('.isDirectBookWorking');
    if (chosenClinic.direct_book_type === DIRECT_BOOK_DM) {
      showElement('.directBookDm');
      hideElement('.directBookBlueprintEarQ');
    } else { // Blueprint or EarQ
      hideElement('.directBookDm');
      showElement('.directBookBlueprintEarQ');
      const directBookUrl = document.querySelector('#directBookUrl');
      directBookUrl.textContent = chosenClinic.direct_book_url;
      directBookUrl.setAttribute('href', chosenClinic.direct_book_url);
    }
  }
  updateVisibility();
}

function createClinicDiv(clinicData, index) {
  const clinicDiv = document.createElement("div");
  clinicDiv.id = `clinic-div-${index}`;
  clinicDiv.classList.add("pl20");

  const clinicNumberInput = document.createElement("input");
  clinicNumberInput.type = "hidden";
  clinicNumberInput.id = `clinic-${index}-number`;
  clinicNumberInput.value = index;

  const locationIdParagraph = document.createElement("p");
  locationIdParagraph.hidden = true;
  locationIdParagraph.id = `clinic-${index}-locationId`;
  locationIdParagraph.textContent = clinicData.id;

  const clinicTitleParagraph = document.createElement("p");
  clinicTitleParagraph.classList.add(`mt5`, `mb5`, `clinic-${index}-Title`);
  clinicTitleParagraph.textContent = `${clinicData.title} (${clinicData.google.distance.text} / ${clinicData.google.duration.text})`;

  const hrElement = document.createElement("hr");
  hrElement.style.borderTop = "2px solid gray";
  hrElement.classList.add("m0");

  clinicDiv.appendChild(clinicNumberInput);
  clinicDiv.appendChild(locationIdParagraph);
  clinicDiv.appendChild(clinicTitleParagraph);
  clinicDiv.appendChild(hrElement);

  if (index > 2) {
    clinicDiv.classList.add('hidden');
  }

  return clinicDiv;
}

function displayClinicTemplates(data) {
  const closestClinicsContainer = document.getElementById("closestClinics");
  const fragment = document.createDocumentFragment();

  data.forEach(function (item, index) {
    const clinicDiv = createClinicDiv(item, index);
    fragment.appendChild(clinicDiv);
  });

  closestClinicsContainer.appendChild(fragment);

  const clinicDivs = document.querySelectorAll("[id^=clinic-div-]");
  clinicDivs.forEach(function (clinicDiv) {
    clinicDiv.addEventListener("click", function () {
      clickedClinic(this);
    });
  });

  clinicDivs[0].click();
}

function loadMoreClinics() {
  const allClinics = Array.from(document.querySelectorAll("#closestClinics div"));
  const hiddenClinics = allClinics.filter(item => item.offsetParent === null);

  if (hiddenClinics.length == 0) {
    let alertMessage;
    if (searchInfo.numZipSearches > 1) {
      alertMessage = "I'm sorry, these are the closest clinics we could find in our directory for the address you provided. Would you like to end the call or check another address?";
    } else {
      alertMessage = "I'm sorry, we don't have any other clinics in our directory within " + searchInfo.searchRadius + " miles of the address provided. Would you like to end the call or check another address?";
    }
    alert(alertMessage);
  } else {
    const nextSetOfClinics = hiddenClinics.slice(0, 3);
    nextSetOfClinics.forEach(clinic => clinic.classList.remove('hidden'));
  }
}

function fixNoDirectionResults() {
  closestClinics.forEach(function (item, i) {
    if (item.google.status !== "OK") {
      item.google.duration = { text: "Google can't provide directions" };
      item.google.distance = { text: "Google can't provide directions" };
    }
  });
}

function onChangeIsDirectBookWorking(answer) {
  if (answer == 0) { // NO
    hideElement(".directBookQuickPick");
    showElement(".nonDirectBookQuickPick");
  } else { // YES
    showElement(".directBookQuickPick");
    hideElement(".nonDirectBookQuickPick");
  }
  updateVisibility();
}
