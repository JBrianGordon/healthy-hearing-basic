import './common';
import './provider';
import '../modules/wordcount';
import './ck-clinic-package';
import * as sharedFunctions from '../admin/shared_profile_functions';

declare global {
  interface Window {
    UPLOAD_LIMIT?: number;
  }
}

// If there are any errors on the page, scroll down
const errorDivs = document.querySelectorAll<HTMLElement>('div.has-error');
if (errorDivs.length) {
  const firstErrorDiv = errorDivs[0];
  window.scrollTo({
    top: firstErrorDiv.offsetTop - 90,
    behavior: 'smooth'
  });
}

const addLink = async (locationId: string | number, key: number): Promise<void> => {
  const newLink = document.querySelector<HTMLInputElement>('.linked-location');
  const linkedLocationIdInput = document.querySelector<HTMLInputElement>('#LocationLinkedLocationId');

  if (!newLink || !linkedLocationIdInput) return;

  const linkedLocationId = linkedLocationIdInput.value;

  newLink.style.background = '';
  const linkError = document.querySelector<HTMLElement>("#link-error-" + key);
  if (linkError) {
    linkError.style.display = "none";
  }

  try {
    const response = await fetch(`/locations/ajax_add_linked_location/${locationId}/${linkedLocationId}`);
    const data = await response.json();

    if (data.error) {
      newLink.style.background = 'rgba(200, 100, 100, .5)';
      if (linkError) {
        linkError.innerHTML = data.error;
        linkError.style.display = "block";
      }
    } else {
      const divLink = document.querySelector<HTMLElement>("#div-link-" + key);
      const divAddDelete = document.querySelector<HTMLElement>("#div-add-delete-" + key);

      if (divLink) {
        divLink.innerHTML = data.locationData;
      }
      if (divAddDelete) {
        divAddDelete.innerHTML = '<td style="width:100px;" align="center"><button type="button" class="btn btn-md btn-danger js-link-delete" data-key="' + key + '" data-id="' + locationId + '" data-link="' + linkedLocationId + '">delete</button></td>';
      }

      const newKey = key + 1;
      const newRow = document.createElement('tr');
      newRow.id = "tr-link-" + newKey;
      newRow.innerHTML = '<td><div id="div-link-' + newKey + '"><input type="hidden" name="data[Location][id_linked_location]" id="LocationIdLinkedLocation"><input class="form-control linked-location" data-key="' + newKey + '" data-id="' + locationId + '" /><span class="help-block text-danger" style="display:none;" id="link-error-' + newKey + '"></span></div></td><td style="width:100px;" align="center"><div id="div-add-delete-' + newKey + '"></div></td>';

      const currentRow = document.querySelector<HTMLElement>("#tr-link-" + key);
      if (currentRow) {
        currentRow.after(newRow);
      }

      locationAutocomplete();
    }
  } catch (error) {
    newLink.style.background = 'rgba(200, 100, 100, .5)';
    if (linkError) {
      linkError.innerHTML = 'Error. Unable to add linked location.';
      linkError.style.display = "block";
    }
  }
};

const deleteLink = async (obj: HTMLElement): Promise<void> => {
  const key = obj.dataset.key;
  const locationId = obj.dataset.id;
  const linkedLocationId = obj.dataset.link;

  if (!key || !locationId || !linkedLocationId) return;

  try {
    const response = await fetch(`/locations/ajax_delete_linked_location/${locationId}/${linkedLocationId}`);
    const data = await response.json();

    if (response.ok) {
      const row = document.querySelector<HTMLElement>("#tr-link-" + key);
      if (row) {
        row.remove();
      }
    } else {
      const linkError = document.querySelector<HTMLElement>("#link-error-" + key);
      if (linkError) {
        linkError.innerHTML = 'Error. Unable to delete linked location.';
        linkError.style.display = "block";
      }
    }
  } catch (error) {
    const linkError = document.querySelector<HTMLElement>("#link-error-" + key);
    if (linkError) {
      linkError.innerHTML = 'Error. Unable to delete linked location.';
      linkError.style.display = "block";
    }
  }
};

const locationAutocomplete = (): void => {
  const linkedLocationInput = document.querySelector<HTMLInputElement>("input.linked-location");
  if (!linkedLocationInput) return;

  const locationId = linkedLocationInput.dataset.id;
  const key = linkedLocationInput.dataset.key;

  linkedLocationInput.addEventListener("input", async () => {
    const inputValue = linkedLocationInput.value.trim();
    if (inputValue.length >= 2) {
      try {
        const response = await fetch("/caautocomplete");
        const data = await response.json();

        if (response.ok) {
          const autocompleteResults = data.filter((item: { label: string }) =>
            item.label.toLowerCase().includes(inputValue.toLowerCase())
          );
          renderAutocompleteResults(autocompleteResults);
        }
      } catch (error) {
        console.error("Error fetching autocomplete data:", error);
      }
    }
  });

  const renderAutocompleteResults = (results: { label: string; id: string }[]): void => {
    const autocompleteResultsContainer = document.querySelector<HTMLElement>("#autocomplete-results");
    if (!autocompleteResultsContainer) return;

    autocompleteResultsContainer.innerHTML = "";

    results.forEach(item => {
      const option = document.createElement("div");
      option.classList.add("autocomplete-option");
      option.textContent = item.label;
      option.addEventListener("click", () => {
        linkedLocationInput.value = item.label;
        const linkedLocationIdInput = document.querySelector<HTMLInputElement>("#LocationLinkedLocationId");
        if (linkedLocationIdInput) {
          linkedLocationIdInput.value = item.id;
        }
        if (locationId && key) {
          addLink(locationId, parseInt(key));
        }
        autocompleteResultsContainer.innerHTML = "";
      });
      autocompleteResultsContainer.appendChild(option);
    });
  };
};

const scrollTo = (selector: string, offset: number = 90): boolean => {
  const element = document.querySelector<HTMLElement>(selector);
  if (element) {
    window.scrollTo({
      top: element.offsetTop - offset,
      behavior: "smooth"
    });
    return true;
  }
  return false;
};

const onChangeIsClosedLunch = (isClosedLunch: boolean): void => {
  const closedLunch = document.querySelector<HTMLElement>("#closedLunch");
  const lunchStartHour = document.querySelector<HTMLInputElement>("#LocationHourLunchStartHour");
  const lunchStartMin = document.querySelector<HTMLInputElement>("#LocationHourLunchStartMin");
  const lunchStartMeridian = document.querySelector<HTMLInputElement>("#LocationHourLunchStartMeridian");
  const lunchEndHour = document.querySelector<HTMLInputElement>("#LocationHourLunchEndHour");
  const lunchEndMin = document.querySelector<HTMLInputElement>("#LocationHourLunchEndMin");
  const lunchEndMeridian = document.querySelector<HTMLInputElement>("#LocationHourLunchEndMeridian");

  if (closedLunch) {
    closedLunch.style.display = isClosedLunch ? "block" : "none";
  }

  if (lunchStartHour) lunchStartHour.required = isClosedLunch;
  if (lunchStartMin) lunchStartMin.required = isClosedLunch;
  if (lunchStartMeridian) lunchStartMeridian.required = isClosedLunch;
  if (lunchEndHour) lunchEndHour.required = isClosedLunch;
  if (lunchEndMin) lunchEndMin.required = isClosedLunch;
  if (lunchEndMeridian) lunchEndMeridian.required = isClosedLunch;
};

const onChangeIsMobile = (isMobile: boolean): void => {
  const radius = document.querySelector<HTMLElement>("#radius");
  const locationRadius = document.querySelector<HTMLInputElement>("#LocationRadius");

  if (radius) {
    radius.style.display = isMobile ? "block" : "none";
  }
  if (locationRadius) {
    locationRadius.required = isMobile;
  }
};

// Clinic profile completion. Currently we are only checking the first provider
const providerArray: (HTMLElement | null)[] = [
  document.querySelector<HTMLElement>("#provider-0-first-name"),
  document.querySelector<HTMLElement>("#providers-0-last-name"),
  document.querySelector<HTMLElement>("#provider-0-description"),
  document.querySelector<HTMLElement>("#provider-0-thumb-url")
];
const incompleteArray: string[] = [];
let completionPercentage = 100;

document.addEventListener("DOMContentLoaded", function () {
  const aboutUsElement = document.querySelector<HTMLElement>("#aboutUs");
  if (aboutUsElement) {
    let nextSiblingDiv = aboutUsElement.nextElementSibling as HTMLElement | null;

    while (nextSiblingDiv) {
      if (nextSiblingDiv.classList.contains('textarea')) {
        const ckContentElement = nextSiblingDiv.querySelector<HTMLElement>(".ck-content");
        if (ckContentElement && ckContentElement.innerHTML === "") {
          completionPercentage -= 25;
          incompleteArray.push("<li><a href='#aboutUs'>- About us</a></li>");
          const aboutLabel = document.querySelector<HTMLElement>("#aboutLabel");
          if (aboutLabel) {
            aboutLabel.classList.add("red");
          }
        }
        break;
      }
      nextSiblingDiv = nextSiblingDiv.nextElementSibling as HTMLElement | null;
    }
  }

  const servicesElement = document.querySelector<HTMLElement>("#services");
  if (servicesElement) {
    let nextSiblingDiv = servicesElement.nextElementSibling as HTMLElement | null;

    while (nextSiblingDiv) {
      if (nextSiblingDiv.classList.contains('textarea')) {
        const ckContentElement = nextSiblingDiv.querySelector<HTMLElement>(".ck-content");
        if (ckContentElement && ckContentElement.innerHTML === "") {
          completionPercentage -= 25;
          incompleteArray.push("<li><a href='#services'>- Services</a></li>");
          const servicesLabel = document.querySelector<HTMLElement>("#servicesLabel");
          if (servicesLabel) {
            servicesLabel.classList.add("red");
          }
        }
        break;
      }
      nextSiblingDiv = nextSiblingDiv.nextElementSibling as HTMLElement | null;
    }
  }

  const providerDescription = document.querySelector<HTMLInputElement>("#providers-0-description");
  providerArray.forEach(function (input) {
    if (!input) return;

    let nextSiblingDiv = providerDescription ? providerDescription.nextElementSibling as HTMLElement | null : null;

    while (nextSiblingDiv) {
      if (nextSiblingDiv.classList.contains('textarea')) {
        const ckContentElement = nextSiblingDiv.querySelector<HTMLElement>(".ck-content");
        const inputElement = input as HTMLInputElement;
        if ((!providerDescription && inputElement.value === "") || (ckContentElement && ckContentElement.innerHTML === "")) {
          const formGroup = input.closest<HTMLElement>(".form-group");
          if (formGroup) {
            formGroup.classList.add("has-error");
            const previousElement = formGroup.previousElementSibling as HTMLElement | null;
            if (previousElement) {
              previousElement.classList.add("red");
            }
          }
        }
        break;
      }
      nextSiblingDiv = nextSiblingDiv.nextElementSibling as HTMLElement | null;
    }
  });

  if (providerDescription) {
    let nextSiblingDiv = providerDescription.nextElementSibling as HTMLElement | null;
    while (nextSiblingDiv) {
      if (nextSiblingDiv.classList.contains('textarea')) {
        const ckContentElement = nextSiblingDiv.querySelector<HTMLElement>(".ck-content");
        if (ckContentElement && ckContentElement.innerHTML === "") {
          completionPercentage -= 5;
          incompleteArray.push("<li><a href='#providers-0-description'>- Provider description</a></li>");
        }
        break;
      }
      nextSiblingDiv = nextSiblingDiv.nextElementSibling as HTMLElement | null;
    }
  }
});

const providerFirstName = document.querySelector<HTMLInputElement>("#providers-0-first-name");
if (providerFirstName && providerFirstName.value === "") {
  completionPercentage -= 5;
  incompleteArray.push("<li><a href='#providers-0-first-name'>- Provider first name</a></li>");
}

const providerLastName = document.querySelector<HTMLInputElement>("#providers-0-last-name");
if (providerLastName && providerLastName.value === "") {
  completionPercentage -= 5;
  incompleteArray.push("<li><a href='#providers-0-last-name'>- Provider last name</a></li>");
}

const days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
let isHoursIncomplete = false;

days.forEach((day) => {
  if (!isHoursIncomplete) {
    const openHourInput = document.querySelector<HTMLInputElement>(`#locationhour-${day}-open`);
    const closeHourInput = document.querySelector<HTMLInputElement>(`#locationhour-${day}-close`);
    const isClosedCheckbox = document.querySelector<HTMLInputElement>(`#locationhour-${day}-is-closed`);
    const isByAppointmentCheckbox = document.querySelector<HTMLInputElement>(`#locationhour-${day}-is-byappt`);

    if (openHourInput && closeHourInput && isClosedCheckbox && isByAppointmentCheckbox) {
      const isOpenHourEmpty = openHourInput.value === "";
      const isCloseHourEmpty = closeHourInput.value === "";
      const isClosedChecked = !isClosedCheckbox.checked;
      const isByAppointmentChecked = !isByAppointmentCheckbox.checked;

      if (isOpenHourEmpty && isCloseHourEmpty && isClosedChecked && isByAppointmentChecked) {
        completionPercentage -= 10;
        incompleteArray.push(`<li><a href='#hoursOfOperation'>- Hours of operation</a></li>`);
        const hoursLabel = document.querySelector<HTMLElement>("#hoursLabel");
        if (hoursLabel) {
          hoursLabel.classList.add("red");
        }
        isHoursIncomplete = true;
      }
    }
  }
});

const paymentOptions = ["#payment2", "#payment4", "#payment8", "#payment16", "#payment64", "#payment128", "#payment256", "#payment512", "#payment1024", "#payment2048"];

const isPaymentIncomplete = paymentOptions.every(option => {
  const checkbox = document.querySelector<HTMLInputElement>(option);
  return !checkbox?.checked;
});

if (isPaymentIncomplete) {
  completionPercentage -= 10;
  incompleteArray.push("<li><a href='#payment'>- Accepted methods of payment</a></li>");
  const paymentLabel = document.querySelector<HTMLElement>("#paymentLabel");
  if (paymentLabel) {
    paymentLabel.classList.add("red");
  }
}

const urlInput = document.querySelector<HTMLInputElement>("#url");
if (urlInput && urlInput.value === "") {
  completionPercentage -= 5;
  incompleteArray.push("<li><a href='#urlAnchor'>- Website URL</a></li>");
  if (urlInput.parentElement) {
    urlInput.parentElement.classList.add("has-error");
  }
  if (urlInput.previousElementSibling) {
    (urlInput.previousElementSibling as HTMLElement).classList.add("red");
  }
}

const isClosedLunchCheckbox = document.getElementById("locationhour-is-closed-lunch");
if (isClosedLunchCheckbox) {
  isClosedLunchCheckbox.dispatchEvent(new Event("change"));
}

const isMobileCheckbox = document.getElementById("is-mobile");
if (isMobileCheckbox) {
  isMobileCheckbox.dispatchEvent(new Event("change"));
}

// Only set up observers after the page is fully loaded and CKEditor is ready
window.addEventListener('load', () => {
  // Small delay to ensure CKEditor is fully initialized
  setTimeout(() => {
    const elements = document.querySelectorAll<HTMLElement>("span.cke_path_item");

    elements.forEach((element) => {
      const nodeId = element.getAttribute("id");
      if (!nodeId) return;

      const node = document.getElementById(nodeId);
      if (!node) return;

      const formGroup = element.closest<HTMLElement>(".form-group");
      if (!formGroup || !formGroup.nextElementSibling) return;

      const message = formGroup.nextElementSibling.querySelector<HTMLElement>(".text-danger");
      if (!message) return;

      const callback = function (mutationsList: MutationRecord[]): void {
        if (node.classList.contains("cke_wordcountLimitReached")) {
          message.style.display = "block";
        } else {
          message.style.display = "none";
        }
      };

      const config: MutationObserverInit = { characterData: true, childList: true, subtree: true };
      const observer = new MutationObserver(callback);

      observer.observe(node, config);
    });
  }, 5000);
});

locationAutocomplete();

const submitButton = document.querySelectorAll<HTMLInputElement>('input[type=submit]');

submitButton.forEach((button) => {
  button.addEventListener('click', () => {
    const providers = document.querySelectorAll<HTMLElement>('.provider');

    providers.forEach((provider) => {
      const providerId = provider.getAttribute('provider');
      if (!providerId) return;

      const firstName = document.querySelector<HTMLInputElement>(`#providers-${providerId}-first-name`);
      const lastName = document.querySelector<HTMLInputElement>(`#providers-${providerId}-last-name`);
      const description = document.querySelector<HTMLInputElement>(`#providers-${providerId}-description`);

      if (firstName && lastName && description) {
        if (firstName.value.length > 0 || lastName.value.length > 0 || description.value.length > 0) {
          firstName.setAttribute('required', 'required');
          lastName.setAttribute('required', 'required');
        } else {
          firstName.removeAttribute('required');
          lastName.removeAttribute('required');
        }
      }
    });
  });
});

const closedCheckboxes = document.querySelectorAll<HTMLInputElement>('.is-closed-checkbox');

closedCheckboxes.forEach(function (checkbox) {
  checkbox.addEventListener('click', function () {
    const day = this.dataset.day;
    if (!day) return;

    const isOpen = !this.checked;

    const openHour = document.querySelector<HTMLInputElement>(`#locationhour-${day}-open`);
    const closeHour = document.querySelector<HTMLInputElement>(`#locationhour-${day}-close`);

    if (openHour && closeHour) {
      if (isOpen) {
        openHour.value = '08:00:00';
        closeHour.value = '17:00:00';
      } else {
        openHour.value = '';
        closeHour.value = '';
      }
    }
  });
});

function hhGetFileSize(fileid: string): number {
  try {
    let fileSize = 0;

    const fileInput = document.getElementById(fileid) as HTMLInputElement;
    if (!fileInput) return 0;

    if (fileInput.files && fileInput.files.length > 0) {
      fileSize = fileInput.files[0].size;
    }

    if (fileSize !== 0) {
      fileSize = fileSize / (1024 * 1024);
    }

    return fileSize;
  } catch (e) {
    alert("Error: " + e);
    return 0;
  }
}

function hhCanSubmit(completeCheck?: string): boolean {
  let totalUpload = 0;
  let uploadLimit = 0;

  if (typeof window.UPLOAD_LIMIT !== 'undefined') {
    uploadLimit = window.UPLOAD_LIMIT;
  } else {
    alert('Error: UPLOAD_LIMIT is not set');
    return false;
  }

  const inputFiles = document.querySelectorAll<HTMLInputElement>('.input_file');
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

document.querySelectorAll<HTMLInputElement>(".input_file").forEach((element) => {
  element.addEventListener("change", () => {
    hhCanSubmit();
  });
});

document.body.addEventListener("change", (e: Event) => {
  const target = e.target as HTMLElement;

  if (target.matches('input[type="file"]')) {
    const fileInput = target as HTMLInputElement;
    if (fileInput.id === 'LocationAdFile') {
      sharedFunctions.onChangeLocationAdFile(fileInput);
    } else {
      sharedFunctions.onChangeFileInput(fileInput);
    }
  }

  if (target.matches('#LocationIsMobile')) {
    const checkbox = target as HTMLInputElement;
    onChangeIsMobile(checkbox.checked);
  }

  if (target.matches('#LocationHourIsClosedLunch')) {
    const checkbox = target as HTMLInputElement;
    onChangeIsClosedLunch(checkbox.checked);
    e.preventDefault();
  }
});

document.body.addEventListener("click", (e: Event) => {
  const target = e.target as HTMLElement;

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

const deletePhotoButtons = document.querySelectorAll<HTMLButtonElement>('.provider-photo-delete');

deletePhotoButtons.forEach(button => {
  button.addEventListener('click', () => {
    const target = button.getAttribute('data-target');
    if (!target) return;

    const img = button.nextElementSibling?.querySelector<HTMLImageElement>('img');
    const input = document.getElementById(target) as HTMLInputElement;

    if (input) {
      input.value = '';
    }
    if (img) {
      img.setAttribute('src', '');
    }
  });
});

const validatePhotoAlt = (key: string | number): void => {
  const pattern = new RegExp("^.*[\\+]?[(]?[0-9]{3}[)]?[-\\s\\.]?[0-9]{3}[-\\s\\.]?[0-9]{4,6}.*$");
  const altInput = document.getElementById(`LocationPhoto${key}Alt`) as HTMLInputElement;
  const submitBtn = document.querySelector<HTMLInputElement>("input[type='submit']");
  const helpBlock = document.querySelector<HTMLElement>(`.help-block-desc-${key}`);

  if (!altInput) return;

  if (pattern.test(altInput.value)) {
    if (submitBtn) {
      submitBtn.setAttribute("disabled", "disabled");
    }
    if (helpBlock) {
      helpBlock.style.display = 'block';
    }
    if (altInput.parentNode) {
      (altInput.parentNode as HTMLElement).classList.add("has-error");
    }
  } else {
    if (submitBtn) {
      submitBtn.removeAttribute("disabled");
    }
    if (helpBlock) {
      helpBlock.style.display = 'none';
    }
    if (altInput.parentNode) {
      (altInput.parentNode as HTMLElement).classList.remove("has-error");
    }
  }
};