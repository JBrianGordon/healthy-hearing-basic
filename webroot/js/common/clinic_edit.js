import 'jquery-ui/ui/widgets/autocomplete';
import './provider';
import '../modules/wordcount';
import './ck-clinic-package';
import * as sharedFunctions from '../admin/shared_profile_functions';


// If there are any errors on the page, scroll down
const errorDivs = document.querySelectorAll('div.has-error');
if (errorDivs.length) {
  const firstErrorDiv = errorDivs[0];
  window.scrollTo({
    top: firstErrorDiv.offsetTop - 90,
    behavior: 'smooth'
  });
}

const addLink = async (locationId, key) => {
  const newLink = document.querySelector('.linked-location');
  const linkedLocationId = document.querySelector('#LocationLinkedLocationId').value;
  
  // Remove the error style from the input.
  newLink.style.background = '';
  document.querySelector("#link-error-" + key).style.display = "none";
  
  try {
    const response = await fetch(`/locations/ajax_add_linked_location/${locationId}/${linkedLocationId}`);
    const data = await response.json();
    
    if (data.error) {
      newLink.style.background = 'rgba(200, 100, 100, .5)';
      document.querySelector("#link-error-" + key).innerHTML = data.error;
      document.querySelector("#link-error-" + key).style.display = "block";
    } else {
      document.querySelector("#div-link-" + key).innerHTML = data.locationData;
      document.querySelector("#div-add-delete-" + key).innerHTML = '<td style="width:100px;" align="center"><button type="button" class="btn btn-md btn-danger js-link-delete" data-key="' + key + '" data-id="' + locationId + '" data-link="' + linkedLocationId + '">delete</button></td>';
      
      // Add the new row to the LocationLink table
      const newKey = key + 1;
      const newRow = document.createElement('tr');
      newRow.id = "tr-link-" + newKey;
      newRow.innerHTML = '<td><div id="div-link-' + newKey + '"><input type="hidden" name="data[Location][id_linked_location]" id="LocationIdLinkedLocation"><input class="form-control linked-location" data-key="' + newKey + '" data-id="' + locationId + '" /><span class="help-block text-danger" style="display:none;" id="link-error-' + newKey + '"></span></div></td><td style="width:100px;" align="center"><div id="div-add-delete-' + newKey + '"></div></td>';
      document.querySelector("#tr-link-" + key).after(newRow);
      
      locationAutocomplete();
    }
  } catch (error) {
    newLink.style.background = 'rgba(200, 100, 100, .5)';
    document.querySelector("#link-error-" + key).innerHTML = 'Error. Unable to add linked location.';
    document.querySelector("#link-error-" + key).style.display = "block";
  }
};

const deleteLink = async (obj) => {
  const key = obj.dataset.key;
  const locationId = obj.dataset.id;
  const linkedLocationId = obj.dataset.link;
  
  try {
    const response = await fetch(`/locations/ajax_delete_linked_location/${locationId}/${linkedLocationId}`);
    const data = await response.json();
    
    if (response.ok) {
      document.querySelector("#tr-link-" + key).remove();
    } else {
      document.querySelector("#link-error-" + key).innerHTML = 'Error. Unable to delete linked location.';
      document.querySelector("#link-error-" + key).style.display = "block";
    }
  } catch (error) {
    document.querySelector("#link-error-" + key).innerHTML = 'Error. Unable to delete linked location.';
    document.querySelector("#link-error-" + key).style.display = "block";
  }
};

const locationAutocomplete = () => {
  const linkedLocationInput = document.querySelector("input.linked-location");
  const locationId = linkedLocationInput.dataset.id;
  const key = linkedLocationInput.dataset.key;

  linkedLocationInput.addEventListener("input", async () => {
    const inputValue = linkedLocationInput.value.trim();
    if (inputValue.length >= 2) {
      try {
        const response = await fetch("/caautocomplete");
        const data = await response.json();
        
        if (response.ok) {
          const autocompleteResults = data.filter(item => item.label.toLowerCase().includes(inputValue.toLowerCase()));
          renderAutocompleteResults(autocompleteResults);
        }
      } catch (error) {
        console.error("Error fetching autocomplete data:", error);
      }
    }
  });

  const renderAutocompleteResults = (results) => {
    // Clear previous results
    const autocompleteResultsContainer = document.querySelector("#autocomplete-results");
    autocompleteResultsContainer.innerHTML = "";

    // Render new results
    results.forEach(item => {
      const option = document.createElement("div");
      option.classList.add("autocomplete-option");
      option.textContent = item.label;
      option.addEventListener("click", () => {
        linkedLocationInput.value = item.label;
        document.querySelector("#LocationLinkedLocationId").value = item.id;
        addLink(locationId, key);
        autocompleteResultsContainer.innerHTML = "";
      });
      autocompleteResultsContainer.appendChild(option);
    });
  };
};

const scrollTo = (selector, offset = 90) => {
  const element = document.querySelector(selector);
  if (element) {
    window.scrollTo({
      top: element.offsetTop - offset,
      behavior: "smooth"
    });
    return true;
  }
  return false;
};

const onChangeIsClosedLunch = (isClosedLunch) => {
  const closedLunch = document.querySelector("#closedLunch");
  const lunchStartHour = document.querySelector("#LocationHourLunchStartHour");
  const lunchStartMin = document.querySelector("#LocationHourLunchStartMin");
  const lunchStartMeridian = document.querySelector("#LocationHourLunchStartMeridian");
  const lunchEndHour = document.querySelector("#LocationHourLunchEndHour");
  const lunchEndMin = document.querySelector("#LocationHourLunchEndMin");
  const lunchEndMeridian = document.querySelector("#LocationHourLunchEndMeridian");

  if (isClosedLunch) {
    closedLunch.style.display = "block";
    lunchStartHour.required = true;
    lunchStartMin.required = true;
    lunchStartMeridian.required = true;
    lunchEndHour.required = true;
    lunchEndMin.required = true;
    lunchEndMeridian.required = true;
  } else {
    closedLunch.style.display = "none";
    lunchStartHour.required = false;
    lunchStartMin.required = false;
    lunchStartMeridian.required = false;
    lunchEndHour.required = false;
    lunchEndMin.required = false;
    lunchEndMeridian.required = false;
  }
};

const onChangeIsMobile = (isMobile) => {
  const radius = document.querySelector("#radius");
  const locationRadius = document.querySelector("#LocationRadius");

  if (isMobile) {
    radius.style.display = "block";
    locationRadius.required = true;
  } else {
    radius.style.display = "none";
    locationRadius.required = false;
  }
};

// Initialize the "Special Announcements" section.
// Coupon Library is currently only available to CQ Premier clinics
sharedFunctions.initSpecialAnnouncements();
	
// Clinic profile completion. Currently we are only checking the first provider
const providerArray = [
  document.querySelector("#provider-0-first-name"),
  document.querySelector("#providers-0-last-name"),
  document.querySelector("#provider-0-description"),
  document.querySelector("#provider-0-thumb-url")
];
const incompleteArray = [];
let completionPercentage = 100;

document.addEventListener("DOMContentLoaded", function() {
  const aboutUsElement = document.querySelector("#aboutUs");
  let nextSiblingDiv = aboutUsElement.nextElementSibling;

  while (nextSiblingDiv) {
    if (nextSiblingDiv.classList.contains('textarea')) {
      const ckContentElement = nextSiblingDiv.querySelector(".ck-content");
      if (ckContentElement && ckContentElement.innerHTML === "") {
        completionPercentage -= 25;
        incompleteArray.push("<li><a href='#aboutUs'>- About us</a></li>");
        document.querySelector("#aboutLabel").classList.add("red");
      }
      break;
    }
    nextSiblingDiv = nextSiblingDiv.nextElementSibling;
  }

  const servicesElement = document.querySelector("#services");
  nextSiblingDiv = servicesElement.nextElementSibling;

  while (nextSiblingDiv) {
    if (nextSiblingDiv.classList.contains('textarea')) {
      const ckContentElement = nextSiblingDiv.querySelector(".ck-content");
      if (ckContentElement && ckContentElement.innerHTML === "") {
        completionPercentage -= 25;
        incompleteArray.push("<li><a href='#services'>- Services</a></li>");
        document.querySelector("#servicesLabel").classList.add("red");
      }
      break;
    }
    nextSiblingDiv = nextSiblingDiv.nextElementSibling;
  }

  const providerDescription = document.querySelector("#providers-0-description");
  providerArray.forEach(function(input) {
    let nextSiblingDiv = providerDescription ? providerDescription.nextElementSibling : null;

    while (nextSiblingDiv) {
      if (nextSiblingDiv.classList.contains('textarea')) {
        const ckContentElement = nextSiblingDiv.querySelector(".ck-content");
        if ((!providerDescription && input.value === "") || (ckContentElement && ckContentElement.innerHTML === "")) {
          input.closest(".form-group").classList.add("has-error");
          input.closest(".form-group").previousElementSibling.classList.add("red");
        }
        break;
      }
      nextSiblingDiv = nextSiblingDiv.nextElementSibling;
    }
  });

  // Check provider description separately
  if (providerDescription) {
    let nextSiblingDiv = providerDescription.nextElementSibling;
    while (nextSiblingDiv) {
      if (nextSiblingDiv.classList.contains('textarea')) {
        const ckContentElement = nextSiblingDiv.querySelector(".ck-content");
        if (ckContentElement && ckContentElement.innerHTML === "") {
          completionPercentage -= 5;
          incompleteArray.push("<li><a href='#providers-0-description'>- Provider description</a></li>");
        }
        break;
      }
      nextSiblingDiv = nextSiblingDiv.nextElementSibling;
    }
  }
});

/*** TODO: uncomment when hhtv added: */
// document.querySelector("#hhtvButton").addEventListener("click", function() {
//   window.scrollTo({
//     top: document.querySelector("#hhTv").offsetTop,
//     behavior: 'smooth'
//   });
// });

// Remove error class if at least one photo field has a value
/***  TODO: uncomment when thumb urls are finally pulled in and update query selectors: ***
if (document.querySelector("#Provider0ThumbUrl").value !== "" || document.querySelector("#Provider0File").value !== "") {
  document.querySelector("#Provider0ThumbUrl").closest(".form-group").classList.remove("has-error");
  document.querySelector("#Provider0File").closest(".form-group").classList.remove("has-error");
  document.querySelector("#Provider0ThumbUrl").closest(".form-group").previousElementSibling.classList.remove("red");
  document.querySelector("#Provider0File").closest(".form-group").previousElementSibling.classList.remove("red");
}*/

// Provider first name
if (document.querySelector("#providers-0-first-name").value === "") {
  completionPercentage -= 5;
  incompleteArray.push("<li><a href='#providers-0-first-name'>- Provider first name</a></li>");
}

// Provider last name
if (document.querySelector("#providers-0-last-name").value === "") {
  completionPercentage -= 5;
  incompleteArray.push("<li><a href='#providers-0-last-name'>- Provider last name</a></li>");
}

// Provider photo
/*** TODO: uncomment when ~line 85 is uncommented above
if ((document.querySelector("#Provider0ThumbUrl").value === "" && document.querySelector("#Provider0File").value === "") || document.querySelector("#Provider0ThumbUrl") === undefined) {
  completionPercentage -= 10;
  incompleteArray.push("<li><a href='#provider0Photo'>- Provider photo</a></li>");
}*/

const days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
let isHoursIncomplete = false;

days.forEach((day) => {
  if (!isHoursIncomplete) {
    const isOpenHourEmpty = document.querySelector(`#locationhour-${day}-open`).value === "";
    const isCloseHourEmpty = document.querySelector(`#locationhour-${day}-close`).value === "";
    const isClosedChecked = !document.querySelector(`#locationhour-${day}-is-closed`).checked;
    const isByAppointmentChecked = !document.querySelector(`#locationhour-${day}-is-byappt`).checked;

    if (isOpenHourEmpty && isCloseHourEmpty && isClosedChecked && isByAppointmentChecked) {
      completionPercentage -= 10;
      incompleteArray.push(`<li><a href='#hoursOfOperation'>- Hours of operation</a></li>`);
      document.querySelector("#hoursLabel").classList.add("red");
      isHoursIncomplete = true;
    }
  }
});

// Payment section check
const paymentOptions = ["#payment2", "#payment4", "#payment8", "#payment16", "#payment64", "#payment128", "#payment256", "#payment512", "#payment1024", "#payment2048"];

const isPaymentIncomplete = paymentOptions.every(option => !document.querySelector(option).checked);

if (isPaymentIncomplete) {
  completionPercentage -= 10;
  incompleteArray.push("<li><a href='#payment'>- Accepted methods of payment</a></li>");
  document.querySelector("#paymentLabel").classList.add("red");
}

// Website url check
if (document.querySelector("#url").value === "") {
  completionPercentage -= 5;
  incompleteArray.push("<li><a href='#urlAnchor'>- Website URL</a></li>");
  document.querySelector("#url").parentElement.classList.add("has-error");
  document.querySelector("#url").previousElementSibling.classList.add("red");
}

// Vidscrip validation
const vidscripsVidscripInput = document.querySelector("#locationvidscrips-vidscrip");
const vidscripsEmailInput = document.querySelector("#locationvidscrips-email");

const handleVidscripBlur = () => {
  if (vidscripsVidscripInput.value === "" && vidscripsEmailInput.value === "") {
    vidscripsVidscripInput.required = false;
    vidscripsEmailInput.required = false;
  } else {
    vidscripsVidscripInput.required = true;
    vidscripsEmailInput.required = true;
  }
};

if(vidscripsVidscripInput !== null){
	vidscripsVidscripInput.addEventListener("blur", handleVidscripBlur);
	vidscripsEmailInput.addEventListener("blur", handleVidscripBlur);
}

// Only display the completion modal once per session. Display again if the percentage changes.
/*** TODO: uncomment when isClinic check added:
const sessionCompletionPercentage = sessionStorage.getItem("sessionCompletionPercentage");
if (sessionCompletionPercentage !== String(completionPercentage)) {
  if (completionPercentage < 100) {
    document.getElementById("completionPercentage").textContent = completionPercentage;
    document.getElementById("completionList").innerHTML = incompleteArray.join('');
    document.getElementById("incompleteModal").style.display = "block";
    document.getElementById("incompleteModal").classList.add("in");
  } else if (completionPercentage === 100) {
    document.getElementById("completeModal").style.display = "block";
    document.getElementById("completeModal").classList.add("in");
  }
  sessionStorage.setItem("sessionCompletionPercentage", completionPercentage);
}*/

// Trigger change events
document.getElementById("locationhour-is-closed-lunch").dispatchEvent(new Event("change"));
document.getElementById("is-mobile").dispatchEvent(new Event("change"));

const elements = document.querySelectorAll("span.cke_path_item");

elements.forEach((element) => {
  const node = document.getElementById(element.getAttribute("id"));
  const message = element.closest(".form-group").nextElementSibling.querySelector(".text-danger");
  const callback = function (mutationsList) {
    if (node.classList.contains("cke_wordcountLimitReached")) {
      message.style.display = "block";
    } else {
      message.style.display = "none";
    }
  };
  const config = { characterData: true, childList: true, subtree: true };
  const observer = new MutationObserver(callback);

  observer.observe(node, config);
});

locationAutocomplete();


const submitButton = document.querySelectorAll('input[type=submit]');

submitButton.forEach((button) => {
button.addEventListener('click', () => {
  const providers = document.querySelectorAll('.provider');
  
  providers.forEach((provider) => {
    const providerId = provider.getAttribute('provider');
    const firstName = document.querySelector(`#providers-${providerId}-first-name`);
    const lastName = document.querySelector(`#providers-${providerId}-last-name`);
    const description = document.querySelector(`#providers-${providerId}-description`);
    
    if (firstName.value.length > 0 || lastName.value.length > 0 || description.value.length > 0) {
      firstName.setAttribute('required', 'required');
      lastName.setAttribute('required', 'required');
    } else {
      firstName.removeAttribute('required');
      lastName.removeAttribute('required');
    }
  });
});
});

const closedCheckboxes = document.querySelectorAll('.is-closed-checkbox');

closedCheckboxes.forEach(function(checkbox) {
checkbox.addEventListener('click', function() {
  const day = this.dataset.day;
  const isOpen = !this.checked;
  
  const openHour = document.querySelector(`#locationhour-${day}-open`);
  const closeHour = document.querySelector(`#locationhour-${day}-close`);
  
  if (isOpen) {
    openHour.value = '08:00:00';
    closeHour.value = '17:00:00';
  } else {
    openHour.value = null;
    closeHour.value = null;
  }
});
});

function hhGetFileSize(fileid) {
try {
  let fileSize = 0;
  
  if (navigator.userAgent.match(/msie/i)) { // For IE
    // Before making an object of ActiveXObject,
    // please make sure ActiveX is enabled in your IE browser
    const objFSO = new ActiveXObject("Scripting.FileSystemObject");
    const filePath = document.getElementById(fileid).value;
    const objFile = objFSO.getFile(filePath);
    fileSize = objFile.size; // Size in bytes
  } else if (document.getElementById(fileid).files.length > 0) { // For FF, Safari, Opera, and others
    fileSize = document.getElementById(fileid).files[0].size; // Size in bytes
  }
  
  if (fileSize !== 0) {
    fileSize = fileSize / (1024 * 1024); // Convert size to MB
  }
  
  // alert("Uploaded File Size is " + fileSize + " MB");
  return fileSize;
} catch (e) {
  alert("Error: " + e);
}
}

function hhCanSubmit(completeCheck) {
let totalUpload = 0;
let uploadLimit = 0;

if (typeof UPLOAD_LIMIT !== 'undefined') {
  uploadLimit = UPLOAD_LIMIT;
} else {
  alert('Error: UPLOAD_LIMIT is not set');
  return false;
}

const inputFiles = document.querySelectorAll('.input_file');
inputFiles.forEach((inputFile) => {
  totalUpload += hhGetFileSize(inputFile.id);
});

if (totalUpload > uploadLimit) {
  totalUpload = Math.round(totalUpload * 100) / 100;
  alert(`Note - Combined files queued for upload (${totalUpload} MB) are more than the limit allowed (${uploadLimit} MB). We cannot upload your picture(s). Please try again with smaller picture file(s). If you need assistance, please email contactHH@healthyhearing.com.`);
  return false;
}

return true;
}

/*** TODO: possibly deletable block: ***/
// Allow form submission if user clicks modal continue
// document.querySelector("#saveAndContinue").addEventListener("click", () => {
// 	document.querySelector("#LocationClinicEditForm").setAttribute("onsubmit", "return $.hhCanSubmit('Continue');");
// 	document.querySelector("#LocationClinicEditForm").submit();
// });

// Notice on input.
document.querySelectorAll(".input_file").forEach((element) => {
element.addEventListener("change", () => {
	hhCanSubmit();
});
});

document.body.addEventListener("change", (e) => {
const { target } = e;

if (target.matches('input[type="file"]')) {
	if (target.id === 'LocationAdFile') {
		sharedFunctions.onChangeLocationAdFile(target);
	} else {
		sharedFunctions.onChangeFileInput(target);
	}
}

if (target.matches('#LocationIsMobile')) {
	onChangeIsMobile(target.checked);
}

if (target.matches('#LocationHourIsClosedLunch')) {
	onChangeIsClosedLunch(target.checked);
	e.preventDefault();
}
});

document.body.addEventListener("click", (e) => {
  if (e.target.classList.contains('js-photo-delete')) {
    sharedFunctions.removePhotoRow(e.target, 'photo');
    e.preventDefault();
    return false;
  }
  if (e.target.classList.contains('js-logo-delete')) {
    sharedFunctions.removePhotoRow(e.target, 'logo');
    e.preventDefault();
    return false;
  }
  if (e.target.classList.contains('js-ad-delete')) {
    sharedFunctions.removePhotoRow(e.target, 'ad');
    e.preventDefault();
    return false;
  }

  const { target } = e;

  if (target.matches('.js-link-delete')) {
    deleteLink(target);
    e.preventDefault();
  } else if (target.matches('.js-coupon-select')) {
    sharedFunctions.addCoupon(target);
    e.preventDefault();
  } else if (target.matches('.js-choose-own-coupon')) {
    sharedFunctions.chooseOwnCoupon();
    e.preventDefault();
  } else if (target.matches('.js-show-coupon-library')) {
    sharedFunctions.showCouponLibrary();
    e.preventDefault();
  }
});

const deletePhotoButtons = document.querySelectorAll('.provider-photo-delete');

deletePhotoButtons.forEach(button => {
button.addEventListener('click', () => {
	const target = button.getAttribute('data-target');
	const img = button.nextElementSibling.querySelector('img');
	document.getElementById(target).value = '';
	img.setAttribute('src', '');
});
});

//Delete buttons for location photos
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.ck-location-photo-delete').forEach(function(button) {
      button.addEventListener('click', sharedFunctions.handleLocationPhotoDeleteClick);
  });
});

const validatePhotoAlt = (key) => {
const pattern = new RegExp("^.*[\\+]?[(]?[0-9]{3}[)]?[-\\s\\.]?[0-9]{3}[-\\s\\.]?[0-9]{4,6}.*$");
const altInput = document.getElementById(`LocationPhoto${key}Alt`);
if (pattern.test(altInput.value)) {
  document.querySelector("input[type='submit']").setAttribute("disabled", "disabled");
  document.querySelector(`.help-block-desc-${key}`).style.display = 'block';
  altInput.parentNode.classList.add("has-error");
} else {
  document.querySelector("input[type='submit']").removeAttribute("disabled");
  document.querySelector(`.help-block-desc-${key}`).style.display = 'none';
  altInput.parentNode.classList.remove("has-error");
}
};

// Special announcement border selection
document.querySelectorAll(".border-radio").forEach((radio) => {
radio.addEventListener("click", () => {
  document.querySelector(".selected-border").classList.remove("selected-border");
  radio.classList.add("selected-border");
});
});