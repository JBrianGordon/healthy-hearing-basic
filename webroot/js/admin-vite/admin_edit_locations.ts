import './admin_common';
import '../common-vite/provider';
import './nav_tabs';
import './ckpackage';
import * as sharedFunctions from './shared_profile_functions';

import $ from 'jquery';

class LocationsAdminEdit {
  constructor() {
    const editObj = this;

    document.body.addEventListener('change', (event: Event) => {
      const target = event.target as HTMLElement;
    });

    document.body.addEventListener('click', (event: MouseEvent) => {
      const target = event.target as HTMLElement;

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
        editObj.onClickHoursClosed(target as HTMLInputElement);
      }
      if (target.id === 'deleteBtn') {
        const deleteModalElement = document.getElementById('delete-modal');
        if (deleteModalElement && typeof bootstrap !== 'undefined') {
          const deleteModal = new bootstrap.Modal(deleteModalElement);
          deleteModal.show();
        }
      }
    });

    const tds = document.querySelectorAll<HTMLTableCellElement>('td.body');
    const filteredTds = Array.from(tds).filter((td) => td.textContent?.includes('yhn'));
    const us = document.querySelectorAll<HTMLElement>('u');
    const filteredUs = Array.from(us).filter((u) => u.textContent?.includes('YHN Import'));

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

    const importSelectElements = document.querySelectorAll<HTMLSelectElement>('.js-import-select');
    importSelectElements.forEach((element) => {
      element.addEventListener('change', function (this: HTMLSelectElement) {
        const importId = this.value;
        editObj.selectImport(importId);
      });
      element.dispatchEvent(new Event('change'));
    });

    const cqpImportSelectElements = document.querySelectorAll<HTMLSelectElement>('.js-cqp-import-select');
    cqpImportSelectElements.forEach((element) => {
      element.addEventListener('change', function (this: HTMLSelectElement) {
        const cqpImportId = this.value;
        editObj.selectCqpImport(cqpImportId);
      });
      element.dispatchEvent(new Event('change'));
    });

    document.body.addEventListener('change', (event: Event) => {
      const target = event.target as HTMLInputElement;
      if (target.type === 'file') {
        if (target.id === 'LocationAdFile') {
          sharedFunctions.onChangeLocationAdFile(target);
        } else {
          sharedFunctions.onChangeFileInput(target);
        }
      }
    });

    const directBookTypeElement = document.getElementById('direct-book-type') as HTMLSelectElement;
    if (directBookTypeElement) {
      directBookTypeElement.addEventListener('change', function (this: HTMLSelectElement) {
        // If directBookType is EarQ or Blueprint, display and require the direct_book_url
        // and direct_book_iframe fields. Otherwise hide those fields.
        const directBookType = this.value;
        const urlRequired = directBookType === 'Blueprint' || directBookType === 'EarQ';

        sharedFunctions.onChangeFeature(urlRequired, '#direct-book-url');
        sharedFunctions.onChangeFeature(urlRequired, '#direct-book-iframe');
      });
      directBookTypeElement.dispatchEvent(new Event('change'));
    }

    const isListingTypeFrozenElement = document.getElementById('is-listing-type-frozen') as HTMLInputElement;
    if (isListingTypeFrozenElement) {
      isListingTypeFrozenElement.addEventListener('change', function (this: HTMLInputElement) {
        sharedFunctions.onChangeFeature(this.checked, '#frozen-expiration');
      });
      isListingTypeFrozenElement.dispatchEvent(new Event('change'));
    }

    const featureContentLibraryElement = document.getElementById('feature-content-library') as HTMLInputElement;
    if (featureContentLibraryElement) {
      featureContentLibraryElement.addEventListener('change', function (this: HTMLInputElement) {
        sharedFunctions.onChangeFeature(this.checked, '#content-library-expiration');
      });
      featureContentLibraryElement.dispatchEvent(new Event('change'));
    }

    const locationHourIsClosedLunch = document.getElementById('location-hour-is-closed-lunch') as HTMLInputElement;
    if (locationHourIsClosedLunch) {
      locationHourIsClosedLunch.addEventListener('change', function (this: HTMLInputElement) {
        sharedFunctions.onChangeFeature(this.checked, '#location-hour-lunch-start');
        sharedFunctions.onChangeFeature(this.checked, '#location-hour-lunch-end');
        sharedFunctions.onChangeFeature(this.checked, '#closedLunch');
      });
      locationHourIsClosedLunch.dispatchEvent(new Event('change'));
    }

    editObj.locationAutocomplete();
  }

  selectImport(importId: string): void {
    const importDivs = document.querySelectorAll<HTMLDivElement>('div.import');
    importDivs.forEach(div => {
      div.style.display = 'none';
      if (div.getAttribute('import') === importId) {
        div.style.display = 'block';
      }
    });
  }

  selectCqpImport(cqpImportId: string): void {
    const cqpImportDivs = document.querySelectorAll<HTMLDivElement>('div.cqpImport');
    cqpImportDivs.forEach(div => {
      div.style.display = 'none';
      if (div.getAttribute('import') === cqpImportId) {
        div.style.display = 'block';
      }
    });
  }

  addLink(locationId: string, key: number): void {
    const editObj = this;
    const newLink = document.querySelector<HTMLInputElement>('.linked-location');
    const linkedLocationIdElement = document.getElementById('LocationLinkedLocationId') as HTMLInputElement;
    const linkedLocationId = linkedLocationIdElement?.value;

    if (!newLink || !linkedLocationId) return;

    // Remove the error style from the input.
    newLink.style.background = '';
    const linkError = document.getElementById(`link-error-${key}`);
    if (linkError) {
      linkError.style.display = 'none';
    }

    const url = `/locations/ajax_add_linked_location/${locationId}/${linkedLocationId}`;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .then(response => response.json())
      .then((data: { error?: string; locationData?: string }) => {
        if (data.error) {
          newLink.style.background = 'rgba(200,100,100,.5)';
          const errorElement = document.getElementById(`link-error-${key}`);
          if (errorElement) {
            errorElement.innerHTML = data.error;
            errorElement.style.display = 'block';
          }
        } else {
          const divLink = document.getElementById(`div-link-${key}`);
          const divAddDelete = document.getElementById(`div-add-delete-${key}`);

          if (divLink && data.locationData) {
            divLink.innerHTML = data.locationData;
          }

          if (divAddDelete) {
            divAddDelete.innerHTML = `<td style="width:100px;" align="center"><button type="button" class="btn btn-md btn-danger js-link-delete" data-key="${key}" data-id="${locationId}" data-link="${linkedLocationId}">delete</button></td>`;
          }

          // Add the new row to the LocationLink table
          const newKey = key + 1;
          const newRow = document.createElement('tr');
          newRow.id = `tr-link-${newKey}`;
          newRow.innerHTML = `<td><div id="div-link-${newKey}"><input type="hidden" name="data[Location][id_linked_location]" id="LocationIdLinkedLocation"><input class="form-control linked-location" data-key="${newKey}" data-id="${locationId}" /><span class="help-block text-danger" style="display:none;" id="link-error-${newKey}"></span></div></td><td style="width:100px;" align="center"><div id="div-add-delete-${newKey}"></div></td>`;

          const currentRow = document.getElementById(`tr-link-${key}`);
          currentRow?.after(newRow);

          editObj.locationAutocomplete();
        }
      })
      .catch((error: Error) => {
        newLink.style.background = 'rgba(200,100,100,.5)';
        const errorElement = document.getElementById(`link-error-${key}`);
        if (errorElement) {
          errorElement.innerHTML = 'Error. Unable to add linked location.';
          errorElement.style.display = 'block';
        }
        console.error('Add link error:', error);
      });
  }

  deleteLink(obj: HTMLElement): void {
    const key = obj.dataset.key;
    const locationId = obj.dataset.id;
    const linkedLocationId = obj.dataset.link;

    if (!key || !locationId || !linkedLocationId) return;

    const url = `/locations/ajax_delete_linked_location/${locationId}/${linkedLocationId}`;

    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .then(response => response.json())
      .then(() => {
        const linkRow = document.querySelector(`#tr-link-${key}`);
        linkRow?.remove();
      })
      .catch((error: Error) => {
        const linkError = document.querySelector<HTMLElement>(`#link-error-${key}`);
        if (linkError) {
          linkError.textContent = 'Error. Unable to delete linked location.';
          linkError.style.display = 'block';
        }
        console.error('Delete link error:', error);
      });
  }

  onChangeDirectBookType(directBookType: string): void {
    const directBookLinks = document.querySelector<HTMLElement>('#direct-book-links');

    if (!directBookLinks) return;

    if (directBookType === 'Blueprint' || directBookType === 'EarQ') {
      directBookLinks.style.position = 'static';
      directBookLinks.style.zIndex = '1';
    } else {
      directBookLinks.style.position = 'absolute';
      directBookLinks.style.zIndex = '-1';
    }
  }

  locationAutocomplete(): void {
    const linkedLocationInput = document.querySelector<HTMLInputElement>("input.linked-location");

    if (!linkedLocationInput) return;

    const editObj = this;
    const locationId = linkedLocationInput.dataset.id;
    const keyStr = linkedLocationInput.dataset.key;
    const key = keyStr ? parseInt(keyStr, 10) : 0;

    linkedLocationInput.addEventListener("input", function () {
      if (!linkedLocationInput.value || linkedLocationInput.value.length < 2) return;

      fetch("/caautocomplete")
        .then(response => response.json())
        .then((data: any) => {
          if (typeof $ !== 'undefined' && $.fn.autocomplete) {
            $(linkedLocationInput).autocomplete({
              source: data,
              minLength: 2,
              select: function (event: any, ui: any) {
                if (ui.item.id && locationId) {
                  const linkedLocationIdElement = document.getElementById("LocationLinkedLocationId") as HTMLInputElement;
                  if (linkedLocationIdElement) {
                    linkedLocationIdElement.value = ui.item.id;
                  }
                  editObj.addLink(locationId, key);
                }
              }
            });
          }
        })
        .catch((error: Error) => {
          console.error("An error occurred while fetching the autocomplete data:", error);
        });
    });
  }

  scrollTo(selector: string, offset: number = 90): boolean {
    const element = document.querySelector<HTMLElement>(selector);
    if (element) {
      window.scrollTo({
        top: element.offsetTop - offset,
        behavior: 'smooth'
      });
      return true;
    }
    return false;
  }

  scrollToElement(selector: string): void {
    const element = document.querySelector<HTMLElement>(selector);
    if (element) {
      element.scrollIntoView({ behavior: "smooth" });
    }
  }

  onClickHoursClosed(obj: HTMLInputElement): void {
    const day = obj.dataset.day;
    const isChecked = obj.checked;

    if (!day) return;

    if (isChecked) {
      this.clearHours(day);
    } else {
      this.setDefaultHours(day);
    }
  }

  clearHours(day: string): void {
    const hourFields = [
      `#location-hour-${day}-open`,
      `#location-hour-${day}-close`,
    ];

    hourFields.forEach((field) => {
      const element = document.querySelector<HTMLInputElement>(field);
      if (element) {
        element.value = '';
      }
    });
  }

  setDefaultHours(day: string): void {
    const openElement = document.querySelector<HTMLInputElement>(`#location-hour-${day}-open`);
    const closeElement = document.querySelector<HTMLInputElement>(`#location-hour-${day}-close`);

    if (openElement) openElement.value = "08:00";
    if (closeElement) closeElement.value = "17:00";
  }
}

new LocationsAdminEdit();

const providerCheckboxes = document.querySelectorAll<HTMLInputElement>(".provider .checkbox label input");

const insertAfter = (targetElement: HTMLElement, htmlString: string): void => {
  targetElement.insertAdjacentHTML("afterend", htmlString);
};

providerCheckboxes.forEach((checkbox) => {
  const parent = checkbox.parentNode as HTMLElement;
  if (parent) {
    insertAfter(parent, "<span class='slider' style='margin-left:235px'></span>");
  }
});

const deletePhotoButtons = document.querySelectorAll<HTMLButtonElement>('.provider-photo-delete');
deletePhotoButtons.forEach(button => {
  button.addEventListener('click', () => {
    const target = button.getAttribute('data-target');
    if (!target) return;

    const img = button.nextElementSibling?.querySelector<HTMLImageElement>('img');
    const targetElement = document.getElementById(target) as HTMLInputElement;

    if (targetElement) {
      targetElement.value = '';
    }
    if (img) {
      img.setAttribute('src', '');
    }
  });
});

// Vidscript validation
const locationVidscripVidscrip = document.querySelector<HTMLInputElement>("#location-vidscrip-vidscrip");
const locationVidscripEmail = document.querySelector<HTMLInputElement>("#location-vidscrip-email");

const handleBlur = (): void => {
  if (!locationVidscripVidscrip || !locationVidscripEmail) return;

  if (locationVidscripVidscrip.value === "" && locationVidscripEmail.value === "") {
    locationVidscripVidscrip.required = false;
    locationVidscripEmail.required = false;
  } else {
    locationVidscripVidscrip.required = true;
    locationVidscripEmail.required = true;
  }
};

if (locationVidscripVidscrip && locationVidscripEmail) {
  locationVidscripVidscrip.addEventListener("blur", handleBlur);
  locationVidscripEmail.addEventListener("blur", handleBlur);
}

// Prevent enter button from submitting form in inputs
const inputElements = document.querySelectorAll<HTMLInputElement>("input");

const handleKeyDown = (e: KeyboardEvent): boolean => {
  if (e.keyCode === 13) {
    e.preventDefault();
    return false;
  }
  return true;
};

inputElements.forEach((element) => {
  element.addEventListener("keydown", handleKeyDown);
});