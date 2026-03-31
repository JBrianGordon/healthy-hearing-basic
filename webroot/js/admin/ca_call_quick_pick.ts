import './admin_common';
import { setElementInnerHTML, setElementValue, setElementChecked, showElement, hideElement, updateVisibility } from './ca_call_edit';

interface ClinicData {
  id: string;
  title: string;
  address: string;
  city: string;
  state: string;
  reviews_approved: string;
  average_rating: string;
  direct_book_type: string;
  direct_book_url?: string;
  google: {
    distance: {
      text: string;
      value?: number;
    };
    duration: {
      text: string;
      value?: number;
    };
    status: string;
  };
}

interface SearchInfo {
  numZipSearches: number;
  searchRadius: number;
}

function onPageLoadQuickPick(): void {
  // Listen for field changes
  const body = document.querySelector('body');

  if (!body) return;

  body.addEventListener('change', (e: Event) => {
    const target = e.target as HTMLInputElement;
    const targetId = target.id;
    const targetValue = target.value;
    const targetChecked = target.checked;

    if (targetId === 'ca-call-group-refused-name-quick-pick') {
      onChangeRefusedNameQuickPick(targetChecked);
    }

    if (targetId === 'ca-call-group-refused-name-again-quick-pick') {
      onChangeRefusedNameAgainQuickPick(targetChecked);
    }

    if (targetId === 'ca-call-group-is-direct-book-working') {
      onChangeIsDirectBookWorking(targetValue);
    }
  });

  // Listen for clicks
  body.addEventListener('click', (e: MouseEvent) => {
    const target = e.target as HTMLElement;
    const targetId = target.id;
    const targetChecked = (target as HTMLInputElement).checked;

    // Find closest clinics button
    if (targetId === 'findClosestLocations') {
      const addressInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-full-address');
      if (addressInput) {
        findClosestLocations(addressInput.value);
      }
    }

    // Load more clinics button
    if (targetId === 'loadMoreClinics') {
      loadMoreClinics();
    }

    if (targetId === 'ca-call-group-is-patient') {
      onChangePatientInfo(targetChecked);
    }
  });

  const patientAddressInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-address');
  const patientCityInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-city');
  const patientStateInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-state');
  const patientZipInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-zip');
  const patientFullAddressInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-full-address');

  if (!patientAddressInput || !patientCityInput || !patientStateInput || !patientZipInput || !patientFullAddressInput) {
    return;
  }

  const updateFullAddress = (): void => {
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

let closestClinics: ClinicData[] = [];
let chosenClinic: ClinicData | null = null;
let clinicCounter: number = 0;
let searchInfo: SearchInfo | null = null;

function onChangeRefusedNameQuickPick(refusedNameChecked: boolean): void {
  if (refusedNameChecked) {
    showElement('.refusedNameYesQuickPick');
    setElementChecked('#ca-call-group-refused-name-again-quick-pick', false);
  } else {
    setElementChecked('#ca-call-group-refused-name-again-quick-pick', false);
    hideElement('.refusedNameYesQuickPick');
  }
}

function onChangeRefusedNameAgainQuickPick(refusedNameAgainChecked: boolean): void {
  if (refusedNameAgainChecked) {
    showElement('.refusedNameYesAgainQuickPick');
    hideElement('.refusedNameNoQuickPick');
  } else {
    hideElement('.refusedNameYesAgainQuickPick');
    showElement('.refusedNameNoQuickPick');
  }
  updateVisibility();
}

function onChangePatientInfo(isPatient: boolean): void {
  if (isPatient) {
    document.querySelectorAll<HTMLElement>('span.not-self').forEach(element => {
      element.classList.toggle('hidden');
    });
    document.querySelectorAll<HTMLElement>('span.self').forEach(element => {
      element.classList.toggle('hidden');
    });
    document.querySelectorAll<HTMLElement>('span.isNotPatient').forEach(element => {
      element.classList.toggle('hidden');
    });
    const patientNameElement = document.querySelector<HTMLElement>('span.patientName');
    if (patientNameElement) {
      const callerFirstNameInput = document.querySelector<HTMLInputElement>('#ca-call-group-caller-first-name');
      const callerLastNameInput = document.querySelector<HTMLInputElement>('#ca-call-group-caller-last-name');
      const callerFirstName = callerFirstNameInput?.value || '';
      const callerLastName = callerLastNameInput?.value || '';
      patientNameElement.textContent = callerFirstName + ' ' + callerLastName;
    }
  } else {
    document.querySelectorAll<HTMLElement>('span.isNotPatient').forEach(element => {
      element.classList.toggle('hidden');
    });
    const patientNameElement = document.querySelector<HTMLElement>('span.patientName');
    if (patientNameElement) {
      const patientFirstNameInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-first-name');
      const patientLastNameInput = document.querySelector<HTMLInputElement>('#ca-call-group-patient-last-name');
      const patientFirstName = patientFirstNameInput?.value || '';
      const patientLastName = patientLastNameInput?.value || '';
      patientNameElement.textContent = patientFirstName + ' ' + patientLastName;
    }
    document.querySelectorAll<HTMLElement>('span.self').forEach(element => {
      element.classList.toggle('hidden');
    });
    document.querySelectorAll<HTMLElement>('span.not-self').forEach(element => {
      element.classList.toggle('hidden');
    });
  }
}

function findClosestLocations(originAddress: string): void {
  setElementInnerHTML('#closestClinics', '');

  closestClinics = [];
  clinicCounter = 0;

  const patientCityInput = document.querySelector<HTMLInputElement>("#ca-call-group-patient-city");
  const patientStateInput = document.querySelector<HTMLInputElement>("#ca-call-group-patient-state");

  if (!patientCityInput || !patientStateInput) return;

  const patientCity = patientCityInput.value.trim();
  const patientState = patientStateInput.value.trim();

  if (patientCity.length > 0 && patientState.length > 0) {
    fetch(`/admin/ca-calls/get-closest-clinics/${originAddress}`, {
      method: "GET",
      headers: {
        "Accept": "application/json"
      }
    })
      .then(response => response.json())
      .then((data: (ClinicData | SearchInfo)[]) => {
        searchInfo = data.pop() as SearchInfo;
        closestClinics = data as ClinicData[];
        displayClinicTemplates(closestClinics);
      })
      .catch((error: Error) => {
        console.log('getClosestClinics() error:');
        console.error(error);
      });

    const afterClinicFind = document.querySelector<HTMLElement>("#afterClinicFind");
    afterClinicFind?.classList.remove('hidden');
    patientStateInput.style.removeProperty('border');
    patientCityInput.style.removeProperty('border');
  } else {
    patientStateInput.style.border = "2px solid red";
    patientCityInput.style.border = "2px solid red";
    alert("Please enter a city and state before searching.");
  }
}

function clickedClinic(clinicDiv: HTMLElement): void {
  clinicCounter++;

  const firstChild = clinicDiv.firstElementChild as HTMLInputElement;
  const clinicIndex = parseInt(firstChild?.getAttribute('value') || '0', 10);
  chosenClinic = closestClinics[clinicIndex];

  if (!chosenClinic) return;

  setElementInnerHTML('.locationDistance', chosenClinic.google.distance.text);
  setElementInnerHTML('.locationTime', chosenClinic.google.duration.text);

  if (chosenClinic.google.distance.value === undefined || chosenClinic.google.duration.value === undefined) {
    hideElement('.hasDirections');
  } else {
    showElement('.hasDirections');
  }

  const numReviews = parseInt(chosenClinic.reviews_approved, 10);
  let ratingsReviewsText: string;

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
  const siblings = clinicDiv.parentNode?.children;
  if (siblings) {
    for (let sibling of Array.from(siblings)) {
      if (sibling !== clinicDiv) {
        (sibling as HTMLElement).style.backgroundColor = "transparent";
      }
    }
  }

  if (clinicCounter > 1) {
    hideElement('.firstClinic');
    showElement('.subsequentClinic');
  } else {
    showElement('.firstClinic');
    hideElement('.subsequentClinic');
  }

  const locationIdParagraph = clinicDiv.querySelector<HTMLParagraphElement>("p[id*='locationId']");
  const locationId = locationIdParagraph?.innerHTML || '';
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
      const directBookUrl = document.querySelector<HTMLAnchorElement>('#directBookUrl');
      if (directBookUrl && chosenClinic.direct_book_url) {
        directBookUrl.textContent = chosenClinic.direct_book_url;
        directBookUrl.setAttribute('href', chosenClinic.direct_book_url);
      }
    }
  }
  updateVisibility();
}

function createClinicDiv(clinicData: ClinicData, index: number): HTMLDivElement {
  const clinicDiv = document.createElement("div");
  clinicDiv.id = `clinic-div-${index}`;
  clinicDiv.classList.add("pl20");

  const clinicNumberInput = document.createElement("input");
  clinicNumberInput.type = "hidden";
  clinicNumberInput.id = `clinic-${index}-number`;
  clinicNumberInput.value = index.toString();

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

function displayClinicTemplates(data: ClinicData[]): void {
  const closestClinicsContainer = document.getElementById("closestClinics");

  if (!closestClinicsContainer) return;

  const fragment = document.createDocumentFragment();

  data.forEach(function (item, index) {
    const clinicDiv = createClinicDiv(item, index);
    fragment.appendChild(clinicDiv);
  });

  closestClinicsContainer.appendChild(fragment);

  const clinicDivs = document.querySelectorAll<HTMLElement>("[id^=clinic-div-]");
  clinicDivs.forEach(function (clinicDiv) {
    clinicDiv.addEventListener("click", function (this: HTMLElement) {
      clickedClinic(this);
    });
  });

  const firstClinic = clinicDivs[0];
  firstClinic?.click();
}

function loadMoreClinics(): void {
  const allClinics = Array.from(document.querySelectorAll<HTMLElement>("#closestClinics div"));
  const hiddenClinics = allClinics.filter(item => item.offsetParent === null);

  if (hiddenClinics.length === 0) {
    let alertMessage: string;
    if (searchInfo && searchInfo.numZipSearches > 1) {
      alertMessage = "I'm sorry, these are the closest clinics we could find in our directory for the address you provided. Would you like to end the call or check another address?";
    } else {
      alertMessage = `I'm sorry, we don't have any other clinics in our directory within ${searchInfo?.searchRadius} miles of the address provided. Would you like to end the call or check another address?`;
    }
    alert(alertMessage);
  } else {
    const nextSetOfClinics = hiddenClinics.slice(0, 3);
    nextSetOfClinics.forEach(clinic => clinic.classList.remove('hidden'));
  }
}

function fixNoDirectionResults(): void {
  closestClinics.forEach(function (item, i) {
    if (item.google.status !== "OK") {
      item.google.duration = { text: "Google can't provide directions" };
      item.google.distance = { text: "Google can't provide directions" };
    }
  });
}

function onChangeIsDirectBookWorking(answer: string): void {
  if (answer === '0') { // NO
    hideElement(".directBookQuickPick");
    showElement(".nonDirectBookQuickPick");
  } else { // YES
    showElement(".directBookQuickPick");
    hideElement(".nonDirectBookQuickPick");
  }
  updateVisibility();
}