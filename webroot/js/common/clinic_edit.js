import 'jquery-ui/ui/widgets/autocomplete';
import './provider';
import '../modules/wordcount';
import './ck-clinic-package';
import '../admin/image_preview';


// If there are any errors on the page, scroll down
const errorDivs = document.querySelectorAll('div.has-error');
if (errorDivs.length) {
  const firstErrorDiv = errorDivs[0];
  window.scrollTo({
    top: firstErrorDiv.offsetTop - 90,
    behavior: 'smooth'
  });
}

const initSpecialAnnouncements = () => {
  const specialAnnouncements = document.querySelector("#specialAnnouncements");
  const isCqPremier = specialAnnouncements.dataset.iscqpremier;
  const adId = specialAnnouncements.dataset.adid;
  const couponId = specialAnnouncements.dataset.couponid;

  const couponLibrary = document.querySelector("#couponLibrary");
  const couponSelected = document.querySelector("#couponSelected");
  const uploadCoupon = document.querySelector("#uploadCoupon");

  if (isCqPremier && !adId) {
    if (couponId) {
      couponLibrary.style.display = "none";
      couponSelected.style.display = "block";
      uploadCoupon.style.display = "none";
    } else {
      couponLibrary.style.display = "block";
      couponSelected.style.display = "none";
      uploadCoupon.style.display = "none";
    }
  } else {
    couponLibrary.style.display = "none";
    couponSelected.style.display = "none";
    uploadCoupon.style.display = "block";
  }
};

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
initSpecialAnnouncements();
	
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
  if (document.querySelector("#location-about-us").nextSibling.querySelector(".ck-content").innerHTML === "") {
    completionPercentage -= 25;
    incompleteArray.push("<li><a href='#aboutUs'>- About us</a></li>");
    document.querySelector("#aboutLabel").classList.add("red");
  }
  if (document.querySelector("#location-services").nextSibling.querySelector(".ck-content").innerHTML === "") {
    completionPercentage -= 25;
    incompleteArray.push("<li><a href='#services'>- Services</a></li>");
    document.querySelector("#servicesLabel").classList.add("red");
  }
  const providerDescription = document.querySelector("#providers-0-description");
  providerArray.forEach(function(input) {
    if ((!providerDescription && input.value === "") || (providerDescription?.nextSibling.querySelector(".ck-content").innerHTML === "")) {
      input.closest(".form-group").classList.add("has-error");
      input.closest(".form-group").previousElementSibling.classList.add("red");
    }
  });
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

// Provider description
document.addEventListener("DOMContentLoaded", function() {
  if (document.querySelector("#providers-0-description").nextSibling.querySelector(".ck-content").innerHTML === "") {
    completionPercentage -= 5;
    incompleteArray.push("<li><a href='#providers-0-description'>- Provider description</a></li>");
  }
})

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
if (document.querySelector("#location-url").value === "") {
  completionPercentage -= 5;
  incompleteArray.push("<li><a href='#urlAnchor'>- Website URL</a></li>");
  document.querySelector("#location-url").parentElement.classList.add("has-error");
  document.querySelector("#location-url").previousElementSibling.classList.add("red");
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
    const firstName = document.querySelector('#Provider' + providerId + 'FirstName');
    const lastName = document.querySelector('#Provider' + providerId + 'LastName');
    const description = document.querySelector('#Provider' + providerId + 'Description');
    
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

function onChangeLocationAdFile(obj){
const id = obj.id;
const row = document.getElementById(id).closest('tr');
const filename = obj.files[0].name;
const filesize = obj.files[0].size;

// Check for errors in the inputs
let errors = false;
if (filename.length === 0) {
  // File is empty
  errors = true;
} else {
  document.getElementById('locationad-photo-url').value = filename;
}

const match = filename.match(/\.(.+)/);
let ext = '';
if (match && typeof match[1] !== 'undefined') {
  ext = match[1].toLowerCase();
}

if (!['jpg', 'jpeg'].includes(ext)) {
  // File is not a jpg
  errors = true;
}

if (filesize > 500000) {
  // File is larger than 2MB
  errors = true;
}

if (errors) {
  // Apply the error style to the input
  document.getElementById('locationad-photo-url').style.background = 'rgba(200,100,100,.5)';
  document.getElementById('location-ad-error').style.display = 'block';
  document.querySelectorAll("#LocationClinicEditForm input[type='submit'], #floatingSave").forEach((el) => {
    el.setAttribute('disabled', 'disabled');
  });
  return false;
} else {
  document.querySelectorAll("#LocationClinicEditForm input[type='submit'], #floatingSave").forEach((el) => {
    el.removeAttribute('disabled');
  });
  // Remove the error style from the input
  document.getElementById('LocationAdPhotoUrl').style.background = '';
  document.getElementById('location-ad-error').style.display = 'none';
}
};

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
		onChangeLocationAdFile(target);
	} else {
		onChangeFileInput(target);
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
	removePhotoRow(e.target, 'photo');
	e.preventDefault();
	return false;
}
if (e.target.classList.contains('js-logo-delete')) {
	removePhotoRow(e.target, 'logo');
	e.preventDefault();
	return false;
}
if (e.target.classList.contains('js-ad-delete')) {
	removePhotoRow(e.target, 'ad');
	e.preventDefault();
	return false;
}

const { target } = e;

if (target.matches('.js-link-delete')) {
	deleteLink(target);
	e.preventDefault();
} else if (target.matches('.js-coupon-select')) {
	addCoupon(target);
	e.preventDefault();
} else if (target.matches('.js-choose-own-coupon')) {
	chooseOwnCoupon();
	e.preventDefault();
} else if (target.matches('.js-show-coupon-library')) {
	showCouponLibrary();
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

const removePhotoRow = (obj, type) => {
const row = obj.closest('tr');
const key = obj.dataset.key;
if (type === 'photo') {
  document.getElementById(`locationphoto-${key}-photo-url`).value = '';
  if (document.getElementById(`locationphoto-${key}-file`) !== null) {
    document.getElementById(`locationphoto-${key}-file`).value = '';
  }
  row.style.display = 'none';
}
if (type === 'logo') {
  document.getElementById('LocationLogoUrl').value = '';
  document.getElementById('photo-thumb-logo').setAttribute('src', '');
  if (document.getElementById('LocationLogo0File') !== null) {
    document.getElementById('LocationLogo0File').value = '';
  }
}
if (type === 'ad') {
  document.getElementById('location-ad-preview').style.display = 'none';
  document.getElementById('locationad-photo-url').value = '';
  document.getElementById('locationad-title').value = '';
  document.getElementById('locationad-description').value = '';
  document.getElementById('locationad-photo-url').value = '';
  document.getElementById('id-coupon').value = null;
  document.getElementById('specialAnnouncements').dataset.adid = null;
  document.getElementById('specialAnnouncements').dataset.couponid = null;
  initSpecialAnnouncements();
}
};

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

const addCoupon = (obj) => {
const couponId = obj.getAttribute("data-coupon-id");
document.getElementById("LocationAdFile").value = "";
document.getElementById("LocationAdTitle").value = "";
document.getElementById("LocationAdDescription").value = "";
document.getElementById("LocationAdPhotoUrl").value = "";
document.getElementById("specialAnnouncements").dataset.adid = null;
document.getElementById("id-coupon").value = couponId;
document.getElementById("specialAnnouncements").dataset.couponid = couponId;
document.querySelector("#couponSelected .coupon-image").setAttribute("src", `/img/coupons/coupon-${couponId}.jpg`);
document.getElementById("couponLibrary").style.display = 'none';
document.getElementById("couponSelected").style.display = 'block';
document.getElementById("uploadCoupon").style.display = 'none';
scrollToElement("#specialAnnouncements");
};

const chooseOwnCoupon = () => {
document.getElementById("couponLibrary").style.display = 'none';
document.getElementById("couponSelected").style.display = 'none';
document.getElementById("uploadCoupon").style.display = 'block';
scrollToElement("#specialAnnouncements");
};

const showCouponLibrary = () => {
document.getElementById("couponLibrary").style.display = 'block';
document.getElementById("couponSelected").style.display = 'none';
document.getElementById("uploadCoupon").style.display = 'none';
scrollToElement("#specialAnnouncements");
};

const onChangeFileInput = (obj) => {
const id = obj.id;
const row = document.getElementById(id).closest('tr');
const keyMatch = id.match(/locationphoto|logo-imageUpload|locationad|provider-(\d+)(.+)/);
let key;
if (keyMatch && keyMatch[1]) {
  key = parseInt(keyMatch.input.match(/\d+/)[0]);
} else {
  key = 0;
}
const newKey = Number(key) + 1;
const filename = obj.files[0].name;
const filesize = obj.files[0].size;
const maxSize = id.match(/LocationLogo/) ? 500000 : 2000000;

// Check for errors in the inputs
let errors = false;

/*** TODO: Delete this block if unused: 
// if (filename.length === 0) {
//   // File is empty
//   errors = true;
//   document.querySelector(`.upload-text-${key}`).innerHTML = 'Click the button to choose a photo from your computer.';
// } else {
//   document.querySelector(`.upload-text-${key}`).innerHTML = filename;
// }***/

const match = filename.match(/\.(.+)/);
let ext = '';
if (match && (typeof match[1] !== undefined)) {
  ext = match[1].toLowerCase();
}

if (!['jpg', 'jpeg'].includes(ext)) {
  // File is not a jpg
  errors = true;
}

if (filesize > maxSize) {
  // File is larger than 500KB for logos, 2MB for photo gallery
  errors = true;
}

if (errors) {
  // Apply the error style to the input
  obj.style.background = 'rgba(200,100,100,.5)';

  if(keyMatch){
    if (keyMatch.input === 'logo-imageUpload') {
      document.getElementById('logo-imageUpload').style.background = 'rgba(200,100,100,.5)';
    } else if (keyMatch[0].match(/Provider/)) {
      document.getElementById('provider-photo-add-error-' + key).style.display = 'block';
    } else {
      document.getElementById('photo-add-error-' + key).style.display = 'block';
    }

    document.querySelector("#LocationClinicEditForm input[type='submit']").setAttribute('disabled', 'disabled');
  }
  return false;
} else {
  // Remove the error style from the input
  obj.style.background = '';
  document.querySelector("#LocationClinicEditForm input[type='submit']").removeAttribute('disabled');
  const helpBlocks = document.querySelectorAll(".help-block.text-danger[style='']");
  helpBlocks.forEach((block) => {
    block.style.display = 'none';
  });
  if(document.getElementById("photo-add-error-" + key)){
    document.getElementById("photo-add-error-" + key).style.display = 'none';
    document.getElementById("btn-photo-delete-" + key).style.display = 'block';
    document.getElementById("photo-description-" + key).style.display = 'block';
  }
  if (keyMatch && keyMatch[0] === 'LocationPhoto') {
    document.getElementById("photo-add-error-" + key).style.display = 'none';
    document.getElementById("btn-photo-delete-" + key).style.display = 'block';
    document.getElementById("photo-description-" + key).style.display = 'block';
    document.querySelector("input#LocationPhoto" + key + "Alt").removeAttribute('disabled');

    // Add a new row to the photos table
    const newRow = document.createElement('tr');
    newRow.innerHTML = `<td>
      <div class="row mt5 mb10">
        <div class="col-md-offset-3 col-md-9">
          <img id="photo-thumb-${newKey}">
        </div>
      </div>
      <div class="form-group">
        <label for="LocationPhoto${newKey}File" class="col col-md-3 control-label">File name</label>
        <div class="col col-md-9">
          <input type="file" name="data[LocationPhoto][${newKey}][file]" class="form-control photo-url" id="LocationPhoto${newKey}File">
        </div>
      </div>
      <div id="photo-description-${newKey}" style="display:none;">
        <div class="form-group required">
          <label for="LocationPhoto${newKey}Alt" class="col col-md-3 control-label">Description</label>
          <div class="col col-md-9">
            <input name="data[LocationPhoto][${newKey}][alt]" class="form-control" required="required" type="text" maxlength="100" disabled="disabled" id="LocationPhoto${newKey}Alt">
          </div>
        </div>
      </div>
      <span class="help-block text-danger" style="display:none;" id="photo-add-error-${newKey}">Photo is invalid. Must be a .jpg or .jpeg</span>
    </td>`;
    newRow.innerHTML += `<td align="center">
      <button class="btn btn-md btn-danger js-photo-delete" data-key="${newKey}" id="btn-photo-delete-${newKey}" style="display:none;">Delete</button>
    </td>`;
    row.parentNode.insertBefore(newRow, row.nextSibling);
  }

  // Load the thumbnail image
  const files = obj.files;
  const reader = new FileReader();
  reader.onload = function (e) {
    if(keyMatch){
      if (keyMatch.input === 'logo-imageUpload') {
        document.querySelector('img#logo-imagePreview0').src = e.target.result;
      } else {
        document.querySelector('img#photo-thumb-' + key).src = e.target.result;
      }
    }
  };
  reader.readAsDataURL(files[0]);
};

// Close completion check modal
if(document.querySelector("#incompleteModal") !== null) {
document.querySelector("#incompleteModal .close-modal").addEventListener("click", () => {
  document.querySelector("#incompleteModal").classList.remove("in");
  document.querySelector("#incompleteModal").style.display = "none";
});
}

if(document.querySelector("#completeModal") !== null) {
document.querySelector("#completeModal .close-modal").addEventListener("click", () => {
  document.querySelector("#completeModal").classList.remove("in");
  document.querySelector("#completeModal").style.display = "none";
});
}

// Close new user modal
if(document.querySelector("#newUserModal") !== null) {
document.querySelector("#newUserModal .close-modal").addEventListener("click", () => {
  document.querySelector("#newUserModal").classList.remove("show", "in");
  document.querySelector("#newUserModal").style.display = "none";
  document.querySelector("#faqTab").animate({ "bottom": 0 }, 500);
});
}
}

// Special announcement border selection
document.querySelectorAll(".border-radio").forEach((radio) => {
radio.addEventListener("click", () => {
  document.querySelector(".selected-border").classList.remove("selected-border");
  radio.classList.add("selected-border");
});
});