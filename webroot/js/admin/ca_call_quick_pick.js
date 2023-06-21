function onPageLoadQuickPick() {
	document.getElementById('CaCallGroupRefusedNameQuickPick').addEventListener('change', onChangeRefusedNameQuickPick);
	document.getElementById('CaCallGroupRefusedNameAgainQuickPick').addEventListener('change', onChangeRefusedNameAgainQuickPick);

	// Find closest clinics button
	document.getElementById('findClosestLocations').addEventListener('click', function() {
		findClosestLocations(document.getElementById('CaCallGroupPatientFullAddress').value);
	});

	// Load more clinics button
	document.getElementById('loadMoreClinics').addEventListener('click', loadMoreClinics);

	document.getElementById('CaCallGroupIsDirectBookWorking').addEventListener('change', function() {
		onChangeIsDirectBookWorking(this.value);
	});

	const patientAddressInput = document.getElementById('CaCallGroupPatientAddress');
	const patientCityInput = document.getElementById('CaCallGroupPatientCity');
	const patientStateInput = document.getElementById('CaCallGroupPatientState');
	const patientZipInput = document.getElementById('CaCallGroupPatientZip');
	const patientFullAddressInput = document.getElementById('CaCallGroupPatientFullAddress');

	const updateFullAddress = () => {
		patientFullAddressInput.value = `${patientAddressInput.value},${patientCityInput.value},${patientStateInput.value},${patientZipInput.value}`;
	};

	[patientAddressInput, patientCityInput, patientStateInput, patientZipInput].forEach(input => {
		input.addEventListener('keyup', updateFullAddress);
		input.addEventListener('blur', updateFullAddress);
	});
}

document.addEventListener('DOMContentLoaded', function() {
	onPageLoadQuickPick();
});

/****
 * Start of Functions
 ****/

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

let closestClinics;
let chosenClinic;
let clinicCounter = 0;
let searchInfo;

function findClosestLocations(originAddress) {
	document.querySelector("#closestClinics").innerHTML = "";

	closestClinics = [];
	clinicCounter = 0;

	const patientCityInput = document.querySelector("#CaCallGroupPatientCity");
	const patientCity = patientCityInput.value.trim();
	const patientStateInput = document.querySelector("#CaCallGroupPatientState");
	const patientState = document.querySelector("#CaCallGroupPatientState").value.trim();

	if (patientCity.length > 0 && patientState.length > 0) {
		fetch(`/ca_calls/get_closest_clinics/${originAddress}`)
			.then(response => response.json())
			.then(data => {
				searchInfo = data.pop();
				closestClinics = data;
				fixNoDirectionResults();
				displayClinicTemplates(closestClinics);
			})
			.catch(error => {
				console.error(error);
			});
		document.querySelector(".afterClinicFind").style.display = "block";
		patientStateInput.style.removeProperty('border');
		patientCityInput.style.removeProperty('border');
	} else {
		patientStateInput.style.border = "2px solid red";
		patientCityInput.style.border = "2px solid red";
		alert("Please enter a city and select a state before searching.");
	}
}

function clickedClinic(clinicDiv) {
	clinicCounter++;

	const clinicIndex = clinicDiv.firstElementChild.getAttribute('value');
	chosenClinic = closestClinics[clinicIndex];

	document.querySelector(".locationDistance").innerHTML = chosenClinic.distance.text;
	document.querySelector(".locationTime").innerHTML = chosenClinic.duration.text;

	if (chosenClinic.distance.value === undefined || chosenClinic.duration.value === undefined) {
		document.querySelector(".hasDirections").style.display = "none";
	} else {
		document.querySelector(".hasDirections").style.display = "block";
	}

	const numReviews = parseInt(chosenClinic.Location.reviews_approved, 10);
	let ratingsReviewsText;

	switch (numReviews) {
		case 0:
			ratingsReviewsText = "<strong>0</strong> reviews";
			break;
		case 1:
			ratingsReviewsText = `an average rating of <strong>${chosenClinic.Location.average_rating} out of 5</strong> stars and <strong>1</strong> review`;
			break;
		default:
			ratingsReviewsText = `an average rating of <strong>${chosenClinic.Location.average_rating} out of 5</strong> stars and <strong>${chosenClinic.Location.reviews_approved}</strong> reviews`;
	}

	document.querySelector(".locationRating").innerHTML = ratingsReviewsText;

	clinicDiv.style.backgroundColor = "#78afc9";
	const siblings = clinicDiv.parentNode.children;
	for (let sibling of siblings) {
		if (sibling !== clinicDiv) {
			sibling.style.backgroundColor = "transparent";
		}
	}

	if (clinicCounter > 1) {
		document.querySelector(".firstClinic").style.display = "none";
		document.querySelector(".subsequentClinic").style.display = "block";
	} else {
		document.querySelector(".firstClinic").style.display = "block";
		document.querySelector(".subsequentClinic").style.display = "none";
	}

	const locationId = clinicDiv.querySelector("p[id*='locationId']").innerHTML;
	const CaCallGroupLocationId = document.querySelector("#CaCallGroupLocationId");
	CaCallGroupLocationId.value = locationId;
	triggerChangeEvent(CaCallGroupLocationId);

	if (clinicCounter % 3 === 0) {
		document.querySelector("#purposeReminder").style.display = "block";
		document.querySelector("#ifNoCall").style.display = "none";
	} else {
		document.querySelector("#purposeReminder").style.display = "none";
		document.querySelector("#ifNoCall").style.display = "block";
	}

	document.querySelector(".scriptLocationAddress").innerHTML =
		chosenClinic.Location.address + ', ' +
		chosenClinic.Location.city + ', ' +
		chosenClinic.Location.state;

	if (chosenClinic.Location.direct_book_type === DIRECT_BOOK_NONE) {
		document.querySelectorAll('.nonDirectBookQuickPick').forEach(element => {
			element.style.display = "block";
		});
		document.querySelectorAll('.directBookQuickPick').forEach(element => {
			element.style.display = "none";
		});
		document.querySelectorAll('.isDirectBookWorking').forEach(element => {
			element.style.display = "none";
		});
	} else {
		document.querySelectorAll('.directBookQuickPick').forEach(element => {
			element.style.display = "block";
		});
		document.querySelectorAll('.nonDirectBookQuickPick').forEach(element => {
			element.style.display = "none";
		});
		document.querySelectorAll('.isDirectBookWorking').forEach(element => {
			element.style.display = "block";
		});
		if (chosenClinic.Location.direct_book_type === DIRECT_BOOK_DM) {
			document.querySelectorAll('.directBookDm').forEach(element => {
				element.style.display = "block";
			});
			document.querySelectorAll('.directBookBlueprintEarQ').forEach(element => {
				element.style.display = "none";
			});
		} else { // Blueprint or EarQ
			document.querySelectorAll('.directBookDm').forEach(element => {
				element.style.display = "none";
			});
			document.querySelectorAll('.directBookBlueprintEarQ').forEach(element => {
				element.style.display = "block";
			});
			const directBookUrl = document.querySelector('#directBookUrl');
			directBookUrl.textContent = chosenClinic.Location.direct_book_url;
			directBookUrl.setAttribute('href', chosenClinic.Location.direct_book_url);
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
	locationIdParagraph.textContent = clinicData.Location.id;

	const clinicTitleParagraph = document.createElement("p");
	clinicTitleParagraph.classList.add(`mt5`, `mb5`, `clinic-${index}-Title`);
	clinicTitleParagraph.textContent = `${clinicData.Location.title} (${clinicData.distance.text} / ${clinicData.duration.text})`;

	const hrElement = document.createElement("hr");
	hrElement.style.borderTop = "2px solid gray";
	hrElement.classList.add("m0");

	clinicDiv.appendChild(clinicNumberInput);
	clinicDiv.appendChild(locationIdParagraph);
	clinicDiv.appendChild(clinicTitleParagraph);
	clinicDiv.appendChild(hrElement);

	if (index > 2) {
		clinicDiv.style.display = "none";
	}

	return clinicDiv;
}

function displayClinicTemplates(data) {
	const closestClinicsContainer = document.getElementById("closestClinics");
	const fragment = document.createDocumentFragment();

	data.forEach(function(item, index) {
		const clinicDiv = createClinicDiv(item, index);
		fragment.appendChild(clinicDiv);
	});

	closestClinicsContainer.appendChild(fragment);

	const clinicDivs = document.querySelectorAll("[id^=clinic-div-]");
	clinicDivs.forEach(function(clinicDiv) {
		clinicDiv.addEventListener("click", function() {
			clickedClinic(this);
		});
	});

	clinicDivs[0].click();
}

function loadMoreClinics() {
	const visibleClinics = Array.from(document.querySelectorAll("#closestClinics div:visible"));
	const nextSetOfClinics = visibleClinics.slice(-1)[0]?.nextElementSibling;

	if (!nextSetOfClinics) {
		let alertMessage;
		if (searchInfo.numZipSearches > 1) {
			alertMessage = "I'm sorry, these are the closest clinics we could find in our directory for the address you provided. Would you like to end the call or check another address?";
		} else {
			alertMessage = "I'm sorry, we don't have any other clinics in our directory within " + searchInfo.searchRadius + " miles of the address provided. Would you like to end the call or check another address?";
		}
		alert(alertMessage);
	} else {
		const nextSetOfClinicsSlice = Array.from(nextSetOfClinics.nextElementSibling.children).slice(0, 3);
		nextSetOfClinicsSlice.forEach(clinic => clinic.style.display = "block");
	}
}

function fixNoDirectionResults() {
	closestClinics.forEach(function(item, i) {
		if (item.status !== "OK") {
			item.duration = { text: "Google can't provide directions" };
			item.distance = { text: "Google can't provide directions" };
		}
	});
}

function onChangeIsDirectBookWorking(answer) {
	const directBookQuickPickElements = document.querySelectorAll(".directBookQuickPick");
	const nonDirectBookQuickPickElements = document.querySelectorAll(".nonDirectBookQuickPick");

	if (answer == 0) { // NO
		directBookQuickPickElements.forEach(element => element.style.display = "none");
		nonDirectBookQuickPickElements.forEach(element => element.style.display = "block");
	} else { // YES
		directBookQuickPickElements.forEach(element => element.style.display = "block");
		nonDirectBookQuickPickElements.forEach(element => element.style.display = "none");
	}
	updateVisibility();
}
