import './admin_common';
import '../common/provider';
import './nav_tabs';
import './datepicker';
import './ckpackage';
import * as sharedFunctions from './shared_profile_functions';

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
      if (target.classList.contains('js-show-coupon-library')) {
        sharedFunctions.showCouponLibrary();
        return false;
      }
      if (target.classList.contains('js-choose-own-coupon')) {
        sharedFunctions.chooseOwnCoupon();
        return false;
      }
      if (target.classList.contains('js-coupon-select')) {
        sharedFunctions.addCoupon(target);
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

    const cqpImportSelectElements = document.querySelectorAll('.js-cqp-import-select');
    cqpImportSelectElements.forEach((element) => {
      element.addEventListener('change', function () {
        const cqpImportId = this.value;
        editObj.selectCqpImport(cqpImportId);
      });
      element.dispatchEvent(new Event('change'));
    });

    document.body.addEventListener('change', (event) => {
      const target = event.target;
      if (target.type === 'file') {
        if (target.id === 'LocationAdFile') {
          sharedFunctions.onChangeLocationAdFile(target);
        } else {
          sharedFunctions.onChangeFileInput(target);
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
        sharedFunctions.onChangeFeature(urlRequired, '#direct-book-url');
        sharedFunctions.onChangeFeature(urlRequired, '#direct-book-iframe');
      });
      directBookTypeElement.dispatchEvent(new Event('change'));
    }
    const isListingTypeFrozenElement = document.getElementById('is-listing-type-frozen');
    if (isListingTypeFrozenElement) {
      isListingTypeFrozenElement.addEventListener('change', function () {
        sharedFunctions.onChangeFeature(this.checked, '#frozen-expiration');
      });
      isListingTypeFrozenElement.dispatchEvent(new Event('change'));
    }
    const featureContentLibraryElement = document.getElementById('feature-content-library');
    if (featureContentLibraryElement) {
      featureContentLibraryElement.addEventListener('change', function () {
        sharedFunctions.onChangeFeature(this.checked, '#content-library-expiration');
      });
      featureContentLibraryElement.dispatchEvent(new Event('change'));
    }
    document.getElementById('location-hour-is-closed-lunch').addEventListener('change', function () {
      sharedFunctions.onChangeFeature(this.checked, '#location-hour-lunch-start');
      sharedFunctions.onChangeFeature(this.checked, '#location-hour-lunch-end');
      sharedFunctions.onChangeFeature(this.checked, '#closedLunch');
    });
    document.getElementById('location-hour-is-closed-lunch').dispatchEvent(new Event('change'));
    editObj.locationAutocomplete();
    sharedFunctions.initSpecialAnnouncements();

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.ck-location-photo-delete').forEach(function(button) {
            button.addEventListener('click', sharedFunctions.handleLocationPhotoDeleteClick);
        });
    });

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
      this.clearHours(day);
    } else {
      this.setDefaultHours(day);
    }
  }

  //Function to clear the values in each field if closed
  clearHours(day) {
    const hourFields = [
      `#location-hour-${day}-open`,
      `#location-hour-${day}-close`,
    ];

    hourFields.forEach((field) => {
      document.querySelector(field).value = null;
    });
  }

  //Function to set the values to defaults if closed checkbox is unchecked
  setDefaultHours(day) {
    document.querySelector(`#location-hour-${day}-open`).value = "08:00";
    document.querySelector(`#location-hour-${day}-close`).value = "17:00";
  }
}

new locationsAdminEdit();

const providerCheckboxes = document.querySelectorAll(".provider .checkbox label input");

const insertAfter = (targetElement, htmlString) => {
  targetElement.insertAdjacentHTML("afterend", htmlString);
};

providerCheckboxes.forEach((checkbox) => {
  insertAfter(checkbox.parentNode, "<span class='slider' style='margin-left:235px'></span>");
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

//Vidscrip validation
const locationVidscripVidscrip = document.querySelector("#location-vidscrip-vidscrip");
const locationVidscripEmail = document.querySelector("#location-vidscrip-email");
//remove field requirements if neither constant has a value
const handleBlur = () => {
  if (locationVidscripVidscrip.value === "" && locationVidscripEmail.value === "") {
    locationVidscripVidscrip.required = false;
    locationVidscripEmail.required = false;
  } else {
    locationVidscripVidscrip.required = true;
    locationVidscripEmail.required = true;
  }
};
if (locationVidscripVidscrip) {
  locationVidscripVidscrip.addEventListener("blur", handleBlur);
  locationVidscripEmail.addEventListener("blur", handleBlur);
}

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
