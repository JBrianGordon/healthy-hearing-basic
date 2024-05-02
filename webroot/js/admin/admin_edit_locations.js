import './admin_common';
import '../common/provider';
import './nav_tabs';
import './datepicker';
import './ckpackage';

class locationsAdminEdit {
  constructor() {
    const editObj = this;

    document.body.addEventListener('change', (event) => {
      const target = event.target;
    });

    document.body.addEventListener('click', (event) => {
      const target = event.target;
      if (target.classList.contains('js-link-delete')) {
        editObj.deleteLink(target);
        return false;
      }
      if (target.classList.contains('js-photo-delete')) {
        editObj.removePhotoRow(target, 'photo');
        return false;
      }
      if (target.classList.contains('js-logo-delete')) {
        editObj.removePhotoRow(target, 'logo');
        return false;
      }
      if (target.classList.contains('js-ad-delete')) {
        editObj.removePhotoRow(target, 'ad');
        return false;
      }
      if (target.classList.contains('js-show-coupon-library')) {
        editObj.showCouponLibrary();
        return false;
      }
      if (target.classList.contains('js-choose-own-coupon')) {
        editObj.chooseOwnCoupon();
        return false;
      }
      if (target.classList.contains('js-coupon-select')) {
        editObj.addCoupon(target);
        return false;
      }
      if (target.classList.contains('is-closed-checkbox')) {
        editObj.onClickHoursClosed(target);
      }
    });

    const tds = document.querySelectorAll('td.body');
    const filteredTds = Array.from(tds).filter((td) => td.textContent.includes('yhn'));
    const us = document.querySelectorAll('u');
    const filteredUs = Array.from(us).filter((u) => u.textContent.includes('YHN Import'));

    if (document.querySelector('.navbar-logo.CA') && (filteredTds.length > 0 || filteredUs.length > 0)) {
      if (filteredTds.length > 0) {
        filteredTds.forEach((element) => {
          element.innerHTML = element.innerHTML.replace(/yhn[_]?/g, '');
        });
      }
      if (filteredUs.length > 0) {
        filteredUs.forEach((element) => {
          element.innerHTML = 'Import';
        });
      }
    }

    const importSelectElements = document.querySelectorAll('.js-import-select');
    importSelectElements.forEach((element) => {
      element.addEventListener('change', function () {
        const importId = this.value;
        editObj.selectImport(importId);
      });
      element.dispatchEvent(new Event('change'));
    });
    /*
    const cqpImportSelectElements = document.querySelectorAll('.js-cqp-import-select');
    cqpImportSelectElements.forEach((element) => {
      element.addEventListener('change', function () {
        const cqpImportId = this.value;
        editObj.selectCqpImport(cqpImportId);
      });
      element.dispatchEvent(new Event('change'));
    });*/

    document.body.addEventListener('change', (event) => {
      const target = event.target;
      if (target.type === 'file') {
        if (target.id === 'LocationAdFile') {
          editObj.onChangeLocationAdFile(target);
        } else {
          editObj.onChangeFileInput(target);
        }
      }
    });

    const directBookTypeElement = document.getElementById('direct-book-type');
    if (directBookTypeElement) {
      directBookTypeElement.addEventListener('change', function () {
        // If directBookType is EarQ or Blueprint, display and require the direct_book_url
        // and direct_book_iframe fields. Otherwise hide those fields.
        const directBookType = this.value;
        let urlRequired = false;
        if (directBookType === 'Blueprint' || directBookType === 'EarQ') {
          // Display and require the direct_book_url and direct_book_iframe fields
          urlRequired = true;
        }
        editObj.onChangeFeature(urlRequired, '#direct-book-url');
        editObj.onChangeFeature(urlRequired, '#direct-book-iframe');
      });
      directBookTypeElement.dispatchEvent(new Event('change'));
    }
    const isListingTypeFrozenElement = document.getElementById('is-listing-type-frozen');
    if (isListingTypeFrozenElement) {
      isListingTypeFrozenElement.addEventListener('change', function () {
        editObj.onChangeFeature(this.checked, '#frozen-expiration');
      });
      isListingTypeFrozenElement.dispatchEvent(new Event('change'));
    }
    const featureContentLibraryElement = document.getElementById('feature-content-library');
    if (featureContentLibraryElement) {
      featureContentLibraryElement.addEventListener('change', function () {
        editObj.onChangeFeature(this.checked, '#content-library-expiration');
      });
      featureContentLibraryElement.dispatchEvent(new Event('change'));
    }
  /* TODO: add special-feature-expiration field to view: ***
    document.getElementById('feature-special-announcement').addEventListener('change', function () {
      editObj.onChangeFeature(this.checked, '#feature-special-announcement');
    });
    document.getElementById('feature-special-announcement').dispatchEvent(new Event('change'));*/
    /* TODO: add hour-is-closed-lunch field to view: ***
    document.getElementById('hour-is-closed-lunch').addEventListener('change', function () {
      editObj.onChangeIsClosedLunch(this.checked);
    });
    document.getElementById('hour-is-closed-lunch').dispatchEvent(new Event('change'));*/

    document.getElementById('is-mobile').addEventListener('change', function () {
      editObj.onChangeFeature(this.checked, '#radius');
      editObj.onChangeFeature(this.checked, '#mobile-text');
      document.getElementById('addressHelp').classList.toggle("hidden");
      document.getElementById('radiusHelp').classList.toggle("hidden");
    });
    document.getElementById('is-mobile').dispatchEvent(new Event('change'));
    //*** TODO: uncomment once linked locations added to page: ***/
    //editObj.locationAutocomplete();
    editObj.initSpecialAnnouncements();
  }

  selectImport(importId) {
    const importDivs = document.querySelectorAll('div.import');
    importDivs.forEach(div => {
      div.style.display = 'none';
      if (div.getAttribute('import') === importId) {
        div.style.display = 'block';
      }
    });
  }

  selectCqpImport(cqpImportId) {
    const cqpImportDivs = document.querySelectorAll('div.cqpImport');
    cqpImportDivs.forEach(div => {
      div.style.display = 'none';
      if (div.getAttribute('import') === cqpImportId) {
        div.style.display = 'block';
      }
    });
  }

  removePhotoRow(obj, type) {
    const row = obj.closest('tr');
    const key = obj.dataset.key;
    
    if (type === "photo") {
      document.querySelector(`#LocationPhoto${key}PhotoUrl`).value = '';
      const fileInput = document.querySelector(`#LocationPhoto${key}File`);
      if (fileInput !== null) {
        fileInput.value = '';
      }
      row.style.display = 'none';
    }
    
    if (type === "logo") {
      document.querySelector("#LocationLogo0Url").value = '';
      document.querySelector("#photo-thumb-logo").src = '';
      const fileInput = document.querySelector("#LocationLogo0File");
      if (fileInput !== null) {
        fileInput.value = '';
      }
    }
    
    if (type === "ad") {
      document.querySelector("#location-ad-preview").style.display = 'none';
      document.querySelector("#LocationAdFile").value = "";
      document.querySelector("#LocationAdTitle").value = "";
      document.querySelector("#LocationAdDescription").value = "";
      document.querySelector("#LocationAdPhotoUrl").value = "";
      document.querySelector("#LocationCouponId").value = null;
      document.querySelector('#specialAnnouncements').dataset.adid = null;
      document.querySelector('#specialAnnouncements').dataset.couponid = null;
      this.initSpecialAnnouncements();
    }
  }

  onChangeFileInput(obj) {
    const id = obj.id;
    const row = document.getElementById(id).closest('tr');
    const keyMatch = id.match(/LocationPhoto|LocationLogo|Provider(\d+)(.+)/);
    const key = parseInt(keyMatch.input.match(/\d+/)[0]);
    const newKey = key + 1;
    const filename = obj.files[0].name;
    const filesize = obj.files[0].size;
    const maxSize = id.match(/LocationLogo/) ? 500000 : 2000000;

    // Check for errors in the inputs
    let errors = false;

    if (filename.length === 0) {
      // File is empty
      errors = true;
    }

    const match = filename.match(/\.(.+)/);
    let ext = '';

    if (match && match[1]) {
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
      if (keyMatch[0] === 'LocationLogo0Url') {
        document.getElementById('photo-add-error-logo').style.display = 'block';
      } else if (keyMatch[0].match(/Provider/)) {
        document.getElementById(`provider-photo-add-error-${key}`).style.display = 'block';
      } else {
        document.getElementById(`photo-add-error-${key}`).style.display = 'block';
      }
      document.querySelectorAll('.form-actions input').forEach(input => {
        input.disabled = true;
      });
      return false;
    } else {
      // Remove the error style from the input and enable submit button
      obj.style.background = '';
      document.querySelectorAll('.form-actions input').forEach(input => {
        input.disabled = false;
      });
      document.querySelectorAll('.help-block.text-danger[style=""]').forEach(helpBlock => {
        helpBlock.style.display = 'none';
      });
      document.querySelectorAll('.help-block.text-danger').forEach(helpBlock => {
        helpBlock.style.display = 'none';
      });

    if (keyMatch[0] === 'LocationPhoto') {
      document.getElementById(`photo-add-error-${key}`).style.display = 'none';
      document.getElementById(`btn-photo-delete-${key}`).style.display = 'block';
      document.getElementById(`photo-description-${key}`).style.display = 'block';
      document.getElementById(`LocationPhoto${key}Alt`).disabled = false;

      // Add a new row to the photos table
      const newRow = document.createElement('tr');
      newRow.innerHTML = `<td><div class="row mt5 mb10"><div class="col-md-offset-3 col-md-9"><img id="photo-thumb-${newKey}"></div></div>` +
        `<div class="form-group"><label for="LocationPhoto${newKey}File" class="col col-md-3 control-label">File name</label>` +
        `<div class="col col-md-9"><input type="file" name="data[LocationPhoto][${newKey}][file]" class="form-control photo-url" id="LocationPhoto${newKey}File"></div></div>` +
        `<div id="photo-description-${newKey}" style="display:none;"><div class="form-group required"><label for="LocationPhoto${newKey}Alt" class="col col-md-3 control-label">Description</label>` +
        `<div class="col col-md-9"><input name="data[LocationPhoto][${newKey}][alt]" class="form-control" required="required" type="text" maxlength="100" disabled="disabled" id="LocationPhoto${newKey}Alt"></div></div></div>` +
        `<span class="help-block text-danger" style="display:none;" id="photo-add-error-${newKey}">Photo is invalid. Must be a .jpg or .jpeg</span></td>`;

      const deleteButton = document.createElement('td');
      deleteButton.setAttribute('align', 'center');
      deleteButton.innerHTML = `<button class="btn btn-md btn-danger js-photo-delete" data-key="${newKey}" id="btn-photo-delete-${newKey}" style="display:none;">Delete</button>`;

      newRow.appendChild(deleteButton);
      row.after(newRow);
    }

    // Load the thumbnail image
    const files = obj.files;
    const reader = new FileReader();
    reader.onload = function(e) {
      const imgElement = keyMatch.input === 'LocationLogo0Url' ? document.querySelector('img#photo-thumb-logo') : document.querySelector(`img#photo-thumb-${key}`);
      imgElement.src = e.target.result;
    };
    reader.readAsDataURL(files[0]);
    }
  }

  onChangeLocationAdFile(obj) {
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
      document.getElementById('LocationAdPhotoUrl').value = filename;
    }

    const match = filename.match(/\.(.+)/);
    let ext = '';

    if (match && match[1]) {
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
      document.getElementById('LocationAdPhotoUrl').style.background = 'rgba(200,100,100,.5)';
      document.getElementById('location-ad-error').style.display = 'block';
      document.querySelectorAll('.form-actions input').forEach(input => {
        input.disabled = true;
      });
      return false;
    } else {
      document.querySelectorAll('.form-actions input').forEach(input => {
        input.disabled = false;
      });
      // Remove the error style from the input
      document.getElementById('LocationAdPhotoUrl').style.background = '';
      document.getElementById('location-ad-error').style.display = 'none';
    }
  }

  addLink(locationId, key) {
    const editObj = this;
    const newLink = document.querySelector('.linked-location');
    const linkedLocationId = document.getElementById('LocationLinkedLocationId').value;

    // Remove the error style from the input.
    newLink.style.background = '';
    document.getElementById(`link-error-${key}`).style.display = 'none';

    const url = `/locations/ajax_add_linked_location/${locationId}/${linkedLocationId}`;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          newLink.style.background = 'rgba(200,100,100,.5)';
          document.getElementById(`link-error-${key}`).innerHTML = data.error;
          document.getElementById(`link-error-${key}`).style.display = 'block';
        } else {
          document.getElementById(`div-link-${key}`).innerHTML = data.locationData;
          document.getElementById(`div-add-delete-${key}`).innerHTML = `<td style="width:100px;" align="center"><button type="button" class="btn btn-md btn-danger js-link-delete" data-key="${key}" data-id="${locationId}" data-link="${linkedLocationId}">delete</button></td>`;

          // Add the new row to the LocationLink table
          const newKey = key + 1;
          const newRow = document.createElement('tr');
          newRow.id = `tr-link-${newKey}`;
          newRow.innerHTML = `<td><div id="div-link-${newKey}"><input type="hidden" name="data[Location][id_linked_location]" id="LocationIdLinkedLocation"><input class="form-control linked-location" data-key="${newKey}" data-id="${locationId}" /><span class="help-block text-danger" style="display:none;" id="link-error-${newKey}"></span></div></td><td style="width:100px;" align="center"><div id="div-add-delete-${newKey}"></div></td>`;

          const currentRow = document.getElementById(`tr-link-${key}`);
          currentRow.after(newRow);

          editObj.locationAutocomplete();
        }
      })
      .catch(error => {
        newLink.style.background = 'rgba(200,100,100,.5)';
        document.getElementById(`link-error-${key}`).innerHTML = 'Error. Unable to add linked location.';
        document.getElementById(`link-error-${key}`).style.display = 'block';
      });
  }

  deleteLink(obj) {
    const key = obj.dataset.key;
    const locationId = obj.dataset.id;
    const linkedLocationId = obj.dataset.link;

    const url = `/locations/ajax_delete_linked_location/${locationId}/${linkedLocationId}`;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      const linkRow = document.querySelector(`#tr-link-${key}`);
      if (linkRow) {
        linkRow.remove();
      }
    })
    .catch(error => {
      const linkError = document.querySelector(`#link-error-${key}`);
      if (linkError) {
        linkError.textContent = 'Error. Unable to delete linked location.';
        linkError.style.display = 'block';
      }
    });
  }

  onChangeDirectBookType(directBookType) {
    const directBookLinks = document.querySelector('#direct-book-links');

    if (directBookType === 'Blueprint' || directBookType === 'EarQ') {
      directBookLinks.style.position = 'static';
      directBookLinks.style.zIndex = '1';
    } else {
      directBookLinks.style.position = 'absolute';
      directBookLinks.style.zIndex = '-1';
    }
  }

  // Display and require an extra field based on if this feature is enabled
  onChangeFeature(isFeature, requiredElementId) {
    const requiredElement = document.querySelector(requiredElementId);
    const formGroup = requiredElement.closest('.form-group');

    if (isFeature) {
      requiredElement.required = true;
      formGroup.style.display = 'flex';
      formGroup.classList.add('required');
    } else {
      requiredElement.required = false;
      formGroup.style.display = 'none';
      formGroup.classList.remove('required');
    }
  }

  locationAutocomplete() {
    const linkedLocationInput = document.querySelector("input.linked-location");
    const editObj = this;
    const locationId = linkedLocationInput.dataset.id;
    const key = linkedLocationInput.dataset.key;

    linkedLocationInput.addEventListener("input", function() {
      if (linkedLocationInput.value.length >= 2) {
        fetch("/caautocomplete")
          .then(response => response.json())
          .then(data => {
            $(linkedLocationInput).autocomplete({
              source: data,
              minLength: 2,
              select: function(event, ui) {
                if (ui.item.id) {
                  $("#LocationLinkedLocationId").val(ui.item.id);
                  editObj.addLink(locationId, key);
                }
              }
            });
          })
          .catch(error => {
            console.error("An error occurred while fetching the autocomplete data:", error);
          });
      }
    });
  }

  initSpecialAnnouncements() {
    const specialAnnouncements = document.querySelector('#specialAnnouncements');
    if(specialAnnouncements !== null){
      const isCqPremier = specialAnnouncements.dataset.iscqpremier;
      const adId = specialAnnouncements.dataset.adid;
      const couponId = specialAnnouncements.dataset.couponid;

      const couponLibrary = document.querySelector('#couponLibrary');
      const couponSelected = document.querySelector('#couponSelected');
      const uploadCoupon = document.querySelector('#uploadCoupon');

      if (isCqPremier && !adId) {
        if (couponId) {
          couponLibrary.style.display = 'none';
          couponSelected.style.display = 'block';
          uploadCoupon.style.display = 'none';
        } else {
          couponLibrary.style.display = 'block';
          couponSelected.style.display = 'none';
          uploadCoupon.style.display = 'none';
        }
      } else {
        couponLibrary.style.display = 'none';
        couponSelected.style.display = 'none';
        uploadCoupon.style.display = 'block';
      }
    }
  }

  scrollTo(selector, offset = 90) {
    const element = document.querySelector(selector);
    if (element) {
      window.scrollTo({
        top: element.offsetTop - offset,
        behavior: 'smooth'
      });
      return true;
    }
    return false;
  }

  chooseOwnCoupon() {
    const couponLibrary = document.querySelector('#couponLibrary');
    const couponSelected = document.querySelector('#couponSelected');
    const uploadCoupon = document.querySelector('#uploadCoupon');

    couponLibrary.style.display = 'none';
    couponSelected.style.display = 'none';
    uploadCoupon.style.display = 'block';

    scrollToElement('#specialAnnouncements');
  }

  showCouponLibrary() {
    const couponLibrary = document.querySelector('#couponLibrary');
    const couponSelected = document.querySelector('#couponSelected');
    const uploadCoupon = document.querySelector('#uploadCoupon');

    couponLibrary.style.display = 'block';
    couponSelected.style.display = 'none';
    uploadCoupon.style.display = 'none';

    scrollToElement('#specialAnnouncements');
  }

  addCoupon(obj) {
    const couponId = obj.getAttribute("data-coupon-id");
    const locationAdFile = document.querySelector("#LocationAdFile");
    const locationAdTitle = document.querySelector("#LocationAdTitle");
    const locationAdDescription = document.querySelector("#LocationAdDescription");
    const locationAdPhotoUrl = document.querySelector("#LocationAdPhotoUrl");
    const specialAnnouncements = document.querySelector("#specialAnnouncements");
    const locationCouponId = document.querySelector("#LocationCouponId");
    const couponSelectedImage = document.querySelector("#couponSelected .coupon-image");
    const couponLibrary = document.querySelector("#couponLibrary");
    const couponSelected = document.querySelector("#couponSelected");
    const uploadCoupon = document.querySelector("#uploadCoupon");

    locationAdFile.value = "";
    locationAdTitle.value = "";
    locationAdDescription.value = "";
    locationAdPhotoUrl.value = "";
    specialAnnouncements.dataset.adid = null;
    locationCouponId.value = couponId;
    specialAnnouncements.dataset.couponid = couponId;
    couponSelectedImage.setAttribute("src", "/img/coupons/coupon-" + couponId + ".jpg");
    couponLibrary.style.display = "none";
    couponSelected.style.display = "block";
    uploadCoupon.style.display = "none";

    scrollToElement("#specialAnnouncements");
  }

  //Scrolling function used in many of the above functions
  scrollToElement(selector) {
    const element = document.querySelector(selector);
    if (element) {
      element.scrollIntoView({ behavior: "smooth" });
    }
  }

  onClickHoursClosed(obj) {
    const day = obj.dataset.day;
    const isChecked = obj.checked;

    if (isChecked) {
      clearHours(day);
    } else {
      setDefaultHours(day);
    }
  }

  //Function to clear the values in each field if closed
  clearHours(day) {
    const hourFields = [
      `#LocationHour${day}OpenHour`,
      `#LocationHour${day}OpenMin`,
      `#LocationHour${day}OpenMeridian`,
      `#LocationHour${day}CloseHour`,
      `#LocationHour${day}CloseMin`,
      `#LocationHour${day}CloseMeridian`
    ];

    hourFields.forEach((field) => {
      document.querySelector(field).value = null;
    });
  }

  //Function to set the values to defaults if closed checkbox is unchecked
  setDefaultHours(day) {
    document.querySelector(`#LocationHour${day}OpenHour`).value = "08";
    document.querySelector(`#LocationHour${day}OpenMin`).value = "00";
    document.querySelector(`#LocationHour${day}OpenMeridian`).value = "am";
    document.querySelector(`#LocationHour${day}CloseHour`).value = "05";
    document.querySelector(`#LocationHour${day}CloseMin`).value = "00";
    document.querySelector(`#LocationHour${day}CloseMeridian`).value = "pm";
  }

  onChangeIsClosedLunch(isClosedLunch) {
    if (isClosedLunch) {
      document.querySelector("#closedLunch").style.display = "block";
      setRequiredFields(true);
    } else {
      document.querySelector("#closedLunch").style.display = "none";
      setRequiredFields(false);
    }
  }

  //Array of fields to cycle through to set true or false value
  setRequiredFields(required) {
    const requiredFields = [
      "#LocationHourLunchStartHour",
      "#LocationHourLunchStartMin",
      "#LocationHourLunchStartMeridian",
      "#LocationHourLunchEndHour",
      "#LocationHourLunchEndMin",
      "#LocationHourLunchEndMeridian"
    ];

    requiredFields.forEach((field) => {
      const element = document.querySelector(field);
      element.required = required;
    });
  }
}

new locationsAdminEdit();

const providerCheckboxes = document.querySelectorAll(".provider .checkbox label input");

const insertAfter = (targetElement, htmlString) => {
  targetElement.insertAdjacentHTML("afterend", htmlString);
};
const insertLabelBefore = (targetElement, labelText) => {
  const label = document.createElement("label");
  label.classList.add("col", "col-md-3", "pr30", "control-label");
  label.innerHTML = `<strong>${labelText}</strong>`;
  targetElement.parentNode.insertBefore(label, targetElement);
};

const locationIsIdaVerified = document.querySelector("#location-is-ida-verified");

providerCheckboxes.forEach((checkbox) => {
  insertAfter(checkbox.parentNode, "<span class='slider' style='margin-left:235px'></span>");
});
/* TODO: uncomment when provider info pulled into view:
insertLabelBefore(document.querySelector(".provider .checkbox .ida-verified"), "Ida verified provider");
insertLabelBefore(document.querySelector(".provider .checkbox .show-npi"), "Show NPI number");
insertLabelBefore(document.querySelector(".provider .checkbox .show-license"), "Show licenses");*/

//special announcement border selection
const borderRadioElements = document.querySelectorAll(".border-radio");

//remove selected-border class and add to recently clicked selection
const handleClick = e => {
  const parentDiv = e.target.closest('.border-radio');
  const selectedBorderElement = document.querySelector(".selected-border");
  
  if (selectedBorderElement) {
    selectedBorderElement.classList.remove("selected-border");
  }
  parentDiv.classList.add('selected-border');
};

borderRadioElements.forEach((element) => {
  element.addEventListener("click", handleClick);
});

//Vidscrip validation
const locationVidscripsVidscrip = document.querySelector("#LocationVidscripsVidscrip");
const locationVidscripsEmail = document.querySelector("#LocationVidscripsEmail");

//remove field requirements if neither constant has a value
const handleBlur = () => {
  if (locationVidscripsVidscrip.value === "" && locationVidscripsEmail.value === "") {
    locationVidscripsVidscrip.required = false;
    locationVidscripsEmail.required = false;
  } else {
    locationVidscripsVidscrip.required = true;
    locationVidscripsEmail.required = true;
  }
};
/*** TODO: uncomment when vidscrips is pulled into view: ***
locationVidscripsVidscrip.addEventListener("blur", handleBlur);
locationVidscripsEmail.addEventListener("blur", handleBlur);*/

//Prevent enter button from submitting form in inputs
const inputElements = document.querySelectorAll("input");

const handleKeyDown = (e) => {
  if (e.keyCode === 13) {
    e.preventDefault();
    return false;
  }
};

inputElements.forEach((element) => {
  element.addEventListener("keydown", handleKeyDown);
});
