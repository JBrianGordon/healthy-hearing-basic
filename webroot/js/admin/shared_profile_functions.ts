export function scrollToElement(selector: string): void {
  const element = document.querySelector<HTMLElement>(selector);
  if (element) {
    const elementPosition = element.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = elementPosition - 70;

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    });
  } else {
    console.error(`Element not found: ${selector}`);
  }
}

export function onChangeFileInput(obj: HTMLInputElement): void {
  const id = obj.id;

  const row = document.getElementById(id)?.closest('tr');
  const keyMatch = id.match(/(?:location-photo[s]?|logo-imageUpload|providers|location-ad)-?(\d*)-?(.*)/);

  if (!keyMatch) return;

  const firstNumberMatch = keyMatch.input.match(/\d+/);
  if (!firstNumberMatch) return;

  const key = parseInt(firstNumberMatch[0], 10);
  const newKey = key + 1;

  // Check if a file is selected
  if (!obj.files || obj.files.length === 0) {
    console.log('No file selected');
    return;
  }

  const filename = obj.files[0].name;
  const filesize = obj.files[0].size;

  const maxSize = id.match(/LocationLogo/) ? 500000 : 2000000;

  // Check for errors in the inputs
  let errors = false;

  if (filename.length === 0) {
    errors = true;
  }

  const match = filename.match(/\.(.+)/);
  let ext = '';

  if (match && match[1]) {
    ext = match[1].toLowerCase();
  }

  if (!['jpg', 'jpeg'].includes(ext)) {
    errors = true;
  }

  if (filesize > maxSize) {
    errors = true;
  }

  if (errors) {
    // Apply the error style to the input
    obj.style.background = 'rgba(200,100,100,.5)';
    if (keyMatch[0] === 'LocationLogo0Url') {
      const errorElement = document.getElementById('photo-add-error-logo');
      if (errorElement) errorElement.style.display = 'block';
    } else if (keyMatch[0].match(/Provider/)) {
      const errorElement = document.getElementById(`provider-photo-add-error-${key}`);
      if (errorElement) errorElement.style.display = 'block';
    } else {
      const errorElement = document.getElementById(`photo-add-error-${key}`);
      if (errorElement) errorElement.style.display = 'block';
    }
    document.querySelectorAll<HTMLInputElement>('.form-actions input').forEach(input => {
      input.disabled = true;
    });
    return;
  } else {
    // Remove the error style from the input and enable submit button
    obj.style.background = '';
    document.querySelectorAll<HTMLInputElement>('.form-actions input').forEach(input => {
      input.disabled = false;
    });
    document.querySelectorAll<HTMLElement>('.help-block.text-danger[style=""]').forEach(helpBlock => {
      helpBlock.style.display = 'none';
    });
    document.querySelectorAll<HTMLElement>('.help-block.text-danger').forEach(helpBlock => {
      helpBlock.style.display = 'none';
    });

    if (keyMatch[0].includes('location-photo')) {
      const photoError = document.getElementById(`photo-add-error-${key}`);
      const btnDelete = document.getElementById(`btn-photo-delete-${key}`);
      const photoDesc = document.getElementById(`photo-description-${key}`);
      const photoAlt = document.getElementById(`location-photos-${key}-alt`) as HTMLInputElement;

      if (photoError) photoError.style.display = 'none';
      if (btnDelete) btnDelete.style.display = 'block';
      if (photoDesc) photoDesc.style.display = 'block';
      if (photoAlt) photoAlt.disabled = false;

      const editForm = document.querySelector<HTMLElement>('#LocationClinicEditForm .help-block.col-md-9.hidden');
      if (editForm) {
        editForm.classList.remove('hidden');
      }

      // Add a new row to the photos table
      const newRow = document.createElement('tr');
      newRow.innerHTML =
        `<td>` +
        `<div class="row mt5 mb10">` +
        `<div class="col-md-offset-3 col-md-9">` +
        `<img id="photo-thumb-${newKey}">` +
        `</div>` +
        `</div>` +
        `<div class="mb-3 form-group file">` +
        `<label class="form-label" for="location-photo-imageUpload-${newKey}">Add a photo</label>` +
        `<input type="file" name="location_photos[${newKey}][photo_name]" id="location-photo-imageUpload-${newKey}" class="form-control">` +
        `</div>` +
        `<div id="photo-description-${newKey}" style="display:none;">` +
        `<div class="mb-3 form-group text required">` +
        `<label class="form-label" for="location-photos-${newKey}-alt">Description</label>` +
        `<input type="text" name="location_photos[${newKey}][alt]" disabled="disabled" required="required" id="location-photos-${newKey}-alt" aria-required="true" class="form-control" maxlength="100">` +
        `</div>` +
        `</div>` +
        `<span class="help-block col-md-9 col-md-offset-3 hidden">Describe your photo in detail. This will be read aloud for the visually impaired. Example: "Inside of [clinic name]", "Outside of [clinic name]", "[clinic name] staff", etc. This is NOT a caption.</span>` +
        `<span class="help-block text-danger" style="display:none;" id="photo-add-error-${newKey}">Photo is invalid. Must be a .jpg or .jpeg</span>` +
        `</td>`;

      const deleteButtonContainer = document.createElement('td');
      deleteButtonContainer.setAttribute('align', 'center');
      deleteButtonContainer.innerHTML = `<button type="button" class="btn btn-md btn-danger ck-location-photo-delete" data-key="${newKey}" id="btn-photo-delete-${newKey}" style="display:none;">Delete</button>`;

      // Add event listener to the delete button before appending it
      const newDeleteButton = deleteButtonContainer.querySelector<HTMLButtonElement>('button');
      if (newDeleteButton) {
        newDeleteButton.addEventListener('click', handleLocationPhotoDeleteClick);
      }

      newRow.appendChild(deleteButtonContainer);
      row?.after(newRow);
    }

    // Load the thumbnail image
    const files = obj.files;
    const reader = new FileReader();
    reader.onload = function (e: ProgressEvent<FileReader>) {
      const inputId = obj.id;
      let imgElement: HTMLImageElement | null = null;

      if (inputId === 'logo-imageUpload') {
        imgElement = document.querySelector<HTMLImageElement>('img#logo-imagePreview0');
      } else if (/providers-\d+-photo-name/.test(inputId)) {
        const keyMatch = inputId.match(/providers-(\d+)-photo-name/);
        if (keyMatch) {
          const key = keyMatch[1];
          imgElement = document.querySelector<HTMLImageElement>(`img#provider-imagePreview-${key}`);
        }
      } else if (/location-photo-imageUpload-\d+/.test(inputId)) {
        const keyMatch = inputId.match(/location-photo-imageUpload-(\d+)/);
        if (keyMatch) {
          const key = keyMatch[1];
          imgElement = document.querySelector<HTMLImageElement>(`img#photo-thumb-${key}`);
        }
      }

      if (imgElement && e.target?.result) {
        imgElement.src = e.target.result as string;
      }
    };
    reader.readAsDataURL(files[0]);
  }
}

// Function to handle provider photo delete
export function setupProviderDelete(): void {
  document.querySelectorAll<HTMLButtonElement>('.provider-delete').forEach(function (button) {
    button.addEventListener('click', async (event: MouseEvent) => {
      const clickedButton = event.currentTarget as HTMLButtonElement;
      const locationId = clickedButton.getAttribute('data-provider-location-id');
      const providerId = clickedButton.getAttribute('data-provider-id');
      const csrfTokenMeta = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');
      const csrfToken = csrfTokenMeta?.getAttribute('content');

      if (!locationId || !providerId || !csrfToken) return;

      const userConfirmed = confirm("Are you sure you would like to delete this provider?");

      if (userConfirmed) {
        try {
          const response = await fetch('/admin/providers/delete-provider-from-clinic', {
            headers: {
              'Accept': 'application/json',
              'Content-type': 'application/json',
              'X-CSRF-Token': csrfToken
            },
            method: 'POST',
            body: JSON.stringify({
              providerId: providerId,
              locationId: locationId
            })
          });

          const providerDiv = clickedButton.closest<HTMLElement>('.well.provider');
          providerDiv?.remove();
        } catch (error) {
          alert("OH NO");
          console.error('Provider delete error:', error);
        }
      }
    });
  });
}

// Function to handle provider photo delete
export function setupProviderPhotoDelete(): void {
  document.querySelectorAll<HTMLButtonElement>('.provider-photo-delete-ck').forEach(function (button) {
    button.addEventListener('click', async (event: MouseEvent) => {
      const target = event.currentTarget as HTMLButtonElement;
      const providerCk = target.getAttribute('data-provider-ck');
      const providerIndex = target.getAttribute('data-provider-id');

      if (!providerIndex) return;

      const providerIdInput = document.querySelector<HTMLInputElement>('input[name="providers[' + providerIndex + '][id]"]');
      const providerId = providerIdInput?.value;
      const csrfTokenMeta = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');
      const csrfToken = csrfTokenMeta?.getAttribute('content');

      if (!csrfToken) return;

      try {
        const response = await fetch('/admin/providers/delete-provider-image', {
          headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
            'X-CSRF-Token': csrfToken
          },
          method: 'POST',
          body: JSON.stringify({
            ckBoxImageId: providerCk,
            providerId: providerId
          })
        });

        const photoInput = document.querySelector<HTMLInputElement>('#providers-' + providerIndex + '-photo-name');
        const photoImg = document.querySelector<HTMLImageElement>('#provider-pic-' + providerIndex);

        if (photoInput) photoInput.value = '';
        if (photoImg) photoImg.src = '';

      } catch (error) {
        alert("OH NO");
        console.error('Provider photo delete error:', error);
      }
    });
  });
}

// Function to handle provider image upload preview
export function setupProviderImageUpload(): void {
  document.querySelectorAll<HTMLInputElement>('.provider-imageUpload').forEach(function (providerImageUpload) {
    providerImageUpload.addEventListener('change', function (event: Event) {
      const target = event.target as HTMLInputElement;
      if (!target.files || target.files.length === 0) return;

      const reader = new FileReader();
      reader.onload = function () {
        const providerKey = providerImageUpload.getAttribute('data-provider-index');
        const output = document.getElementById('provider-imagePreview-' + providerKey) as HTMLImageElement;

        if (output && reader.result) {
          output.src = reader.result as string;
          output.style.display = 'block';
        }
      };
      reader.readAsDataURL(target.files[0]);
    });
  });
}

// Generic function to handle image upload preview
export function setupImageUpload(inputId: string, previewSelector: string): void {
  const fileInput = document.getElementById(inputId) as HTMLInputElement;

  if (!fileInput) {
    console.error(`File input element with ID ${inputId} not found`);
    return;
  }

  fileInput.addEventListener('change', function (event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    // Check if a file is selected
    if (!file) {
      return;
    }

    const reader = new FileReader();
    reader.onload = function () {
      const output = document.querySelector<HTMLImageElement>(previewSelector);

      if (!output) {
        console.error(`Output element with selector ${previewSelector} not found`);
        return;
      }

      if (reader.result) {
        output.src = reader.result as string;
        output.style.display = 'block';
        output.classList.remove('d-none');
      }
    };
    reader.readAsDataURL(file);
  });
}

export async function handleLocationPhotoDeleteClick(event: MouseEvent): Promise<void> {
  const clickedButton = event.currentTarget as HTMLButtonElement;
  const locationPhotoId = clickedButton.getAttribute('data-location-photo-id');
  const csrfTokenMeta = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');
  const csrfToken = csrfTokenMeta?.getAttribute('content');

  if (!csrfToken) return;

  try {
    if (locationPhotoId) { // Only perform for images already in CkBox
      const response = await fetch('/admin/locations/delete-location-photo', {
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/json',
          'X-CSRF-Token': csrfToken
        },
        method: 'POST',
        body: JSON.stringify({
          locationPhotoId: locationPhotoId
        })
      });
    }
    const row = clickedButton.closest('tr');
    row?.remove();
  } catch (error) {
    alert("OH NO");
    console.error('Location photo delete error:', error);
  }
}

export function initLocationPhotoDelete(): void {
  document.querySelectorAll<HTMLButtonElement>('.ck-location-photo-delete').forEach(function (button) {
    button.addEventListener('click', handleLocationPhotoDeleteClick);
  });
}

export function initSpecialAnnouncements(): void {
  const specialAnnouncements = document.querySelector<HTMLElement>('#specialAnnouncements');
  if (specialAnnouncements !== null) {
    const isCqPremier = specialAnnouncements.dataset.iscqpremier;
    const adId = specialAnnouncements.dataset.adid;
    const couponId = specialAnnouncements.dataset.couponid;

    const couponLibrary = document.querySelector<HTMLElement>('#couponLibrary');
    const couponSelected = document.querySelector<HTMLElement>('#couponSelected');
    const uploadCoupon = document.querySelector<HTMLElement>('#uploadCoupon');

    if (!couponLibrary || !couponSelected || !uploadCoupon) return;

    if (isCqPremier && !adId) {
      if (couponId) {
        couponLibrary.style.display = 'none';
        couponSelected.style.display = 'block';
        uploadCoupon.style.display = 'none';
      } else {
        couponLibrary.style.display = 'none';
        couponSelected.style.display = 'none';
        uploadCoupon.style.display = 'block';
      }
    } else {
      couponLibrary.style.display = 'none';
      couponSelected.style.display = 'none';
      uploadCoupon.style.display = 'block';
    }
  }
}

export function initSpecialAnnouncementHandlers(): void {
  const titleInput = document.getElementById('location-ad-title') as HTMLInputElement;
  const descriptionTextarea = document.getElementById('location-ad-description') as HTMLTextAreaElement;
  const panelHeading = document.querySelector<HTMLElement>('#location-ad-preview .panel-heading');
  const panelFooter = document.querySelector<HTMLElement>('#location-ad-preview .panel-footer');

  function handleInputChange(inputElement: HTMLInputElement | HTMLTextAreaElement, targetElement: HTMLElement): void {
    inputElement.addEventListener('input', function () {
      if (inputElement.value.trim() !== '') {
        targetElement.classList.remove('d-none');
        targetElement.innerHTML = inputElement.value;
      } else {
        targetElement.classList.add('d-none');
        targetElement.innerHTML = '';
      }
    });
  }

  if (titleInput && panelHeading) {
    handleInputChange(titleInput, panelHeading);
  }

  if (descriptionTextarea && panelFooter) {
    handleInputChange(descriptionTextarea, panelFooter);
  }
}

export const chooseOwnCoupon = (): void => {
  const couponLibrary = document.getElementById("couponLibrary");
  const couponSelected = document.getElementById("couponSelected");
  const uploadCoupon = document.getElementById("uploadCoupon");
  const couponOption = document.getElementById("couponOption");
  const specialAnnouncements = document.getElementById('specialAnnouncements') as HTMLElement;
  const locationAdIdElement = document.getElementById("location-ad-id") as HTMLInputElement;
  const couponIdInput = document.getElementById("couponId") as HTMLInputElement;

  if (couponLibrary) couponLibrary.style.display = 'none';
  if (couponSelected) couponSelected.style.display = 'none';
  if (uploadCoupon) uploadCoupon.style.display = 'block';
  if (couponOption) couponOption.style.display = 'block';

  if (specialAnnouncements && locationAdIdElement) {
    specialAnnouncements.dataset.adid = locationAdIdElement.value;
  }
  if (specialAnnouncements) {
    specialAnnouncements.dataset.couponid = "";
  }
  if (couponIdInput) {
    couponIdInput.value = "";
  }

  scrollToElement("#specialAnnouncements");
};

export const showCouponLibrary = (): void => {
  const couponLibrary = document.getElementById("couponLibrary");
  const couponSelected = document.getElementById("couponSelected");
  const uploadCoupon = document.getElementById("uploadCoupon");
  const couponOption = document.getElementById("couponOption");

  if (couponLibrary) couponLibrary.style.display = 'block';
  if (couponSelected) couponSelected.style.display = 'none';
  if (uploadCoupon) uploadCoupon.style.display = 'none';
  if (couponOption) couponOption.style.display = 'none';

  scrollToElement("#specialAnnouncements");
};

export function addCoupon(obj: HTMLElement): void {
  const couponId = obj.getAttribute("data-coupon-id");
  const locationAdImageElement = document.getElementById("location-ad-image-name0");
  const specialAnnouncements = document.getElementById('specialAnnouncements') as HTMLElement;
  const couponIdInput = document.getElementById("couponId") as HTMLInputElement;
  const couponImage = document.querySelector<HTMLImageElement>("#couponSelected .coupon-image");
  const couponLibrary = document.getElementById('couponLibrary');
  const couponSelected = document.getElementById('couponSelected');
  const couponOption = document.getElementById('couponOption');
  const uploadCoupon = document.getElementById('uploadCoupon');

  let locationAdImageInput: HTMLInputElement | null = null;
  if (locationAdImageElement instanceof HTMLInputElement) {
    locationAdImageInput = locationAdImageElement;
  }

  if (locationAdImageInput) locationAdImageInput.value = "";
  if (specialAnnouncements) specialAnnouncements.dataset.adid = "";
  if (couponIdInput && couponId) couponIdInput.value = couponId;
  if (specialAnnouncements && couponId) specialAnnouncements.dataset.couponid = couponId;
  if (couponImage && couponId) couponImage.src = "/img/coupons/coupon-" + couponId + ".jpg";
  if (couponLibrary) couponLibrary.style.display = 'none';
  if (couponSelected) couponSelected.style.display = 'block';
  if (couponOption) couponOption.style.display = 'block';
  if (uploadCoupon) uploadCoupon.style.display = 'none';

  scrollToElement("#specialAnnouncements");
}

export async function setupSpecialAnnouncementPhotoDelete(): Promise<void> {
  const adDeleteButtons = document.querySelectorAll<HTMLButtonElement>('.js-ad-delete');

  adDeleteButtons.forEach((button) => {
    button.addEventListener('click', async (e: MouseEvent) => {
      const target = e.currentTarget as HTMLButtonElement;
      const specialAnnouncements = document.getElementById('specialAnnouncements') as HTMLElement;
      const locationAdId = target.getAttribute('data-location-ad-id');
      const csrfTokenMeta = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');
      const csrfToken = csrfTokenMeta?.getAttribute('content');
      const couponSelected = document.getElementById('couponSelected');
      const uploadCoupon = document.getElementById('uploadCoupon');
      const imageInput = document.getElementById('location-ad-image-name0') as HTMLInputElement;
      const titlePreview = document.querySelector<HTMLElement>('#uploadCoupon .panel-heading');
      const descriptionPreview = document.querySelector<HTMLElement>('#uploadCoupon .panel-footer');
      const adTitle = document.getElementById('location-ad-title') as HTMLInputElement;
      const adImage = document.getElementById('location-ad-id-uploaded');
      const adDescription = document.getElementById('location-ad-description') as HTMLTextAreaElement;
      const couponIdInput = document.getElementById("couponId") as HTMLInputElement;

      if (specialAnnouncements) specialAnnouncements.dataset.couponid = '';
      if (couponIdInput) couponIdInput.value = "";
      if (imageInput) imageInput.value = '';
      if (couponSelected) couponSelected.style.display = 'none';
      if (uploadCoupon) uploadCoupon.style.display = 'block';
      if (titlePreview) titlePreview.classList.add('d-none');
      if (descriptionPreview) descriptionPreview.classList.add('d-none');
      if (adTitle) adTitle.value = '';
      if (adImage) adImage.classList.add('d-none');
      if (adDescription) adDescription.value = '';

      if (!csrfToken) return;

      try {
        if (locationAdId) { // Only perform for images already in CkBox
          const response = await fetch('/admin/locations/delete-location-ad', {
            headers: {
              'Accept': 'application/json',
              'Content-type': 'application/json',
              'X-CSRF-Token': csrfToken
            },
            method: 'POST',
            body: JSON.stringify({
              locationAdId: locationAdId
            })
          });
        }
      } catch (error) {
        alert("OH NO");
        console.error('Location ad delete error:', error);
      }
    });
  });
}

// Special announcement border selection
export function initSelectBorder(): void {
  document.querySelectorAll<HTMLElement>(".border-radio").forEach((radio) => {
    radio.addEventListener("click", () => {
      const couponPreview = document.querySelector<HTMLElement>('.coupon-preview');
      const selectedBorderInput = document.querySelector<HTMLInputElement>('.selected-border input');
      const selectedBorder = document.querySelector<HTMLElement>(".selected-border");

      if (couponPreview && selectedBorderInput) {
        couponPreview.classList.remove(selectedBorderInput.value);
      }
      if (selectedBorder) {
        selectedBorder.classList.remove("selected-border");
      }

      radio.classList.add("selected-border");

      const newSelectedInput = document.querySelector<HTMLInputElement>('.selected-border input');
      if (couponPreview && newSelectedInput) {
        couponPreview.classList.add(newSelectedInput.value);
      }
    });
  });
}

export function onChangeLocationAdFile(obj: HTMLInputElement): void {
  const id = obj.id;
  const row = document.getElementById(id)?.closest('tr');

  if (!obj.files || obj.files.length === 0) return;

  const filename = obj.files[0].name;
  const filesize = obj.files[0].size;

  // Check for errors in the inputs
  let errors = false;

  if (filename.length === 0) {
    errors = true;
  } else {
    const urlInput = document.getElementById('location-ad-image-url') as HTMLInputElement;
    if (urlInput) urlInput.value = filename;
  }

  const match = filename.match(/\.(.+)/);
  let ext = '';

  if (match && match[1]) {
    ext = match[1].toLowerCase();
  }

  if (!['jpg', 'jpeg'].includes(ext)) {
    errors = true;
  }

  if (filesize > 500000) {
    errors = true;
  }

  const urlInput = document.getElementById('location-ad-image-url') as HTMLInputElement;
  const errorElement = document.getElementById('location-ad-error');

  if (errors) {
    // Apply the error style to the input
    if (urlInput) urlInput.style.background = 'rgba(200,100,100,.5)';
    if (errorElement) errorElement.style.display = 'block';
    document.querySelectorAll<HTMLInputElement>('.form-actions input').forEach(input => {
      input.disabled = true;
    });
    return;
  } else {
    document.querySelectorAll<HTMLInputElement>('.form-actions input').forEach(input => {
      input.disabled = false;
    });
    // Remove the error style from the input
    if (urlInput) urlInput.style.background = '';
    if (errorElement) errorElement.style.display = 'none';
  }
}

// Display and require an extra field based on if this feature is enabled
export function onChangeFeature(isFeature: boolean, requiredElementId: string): void {
  const requiredElement = document.querySelector<HTMLInputElement>(requiredElementId);
  const formGroup = requiredElement?.closest<HTMLElement>('.form-group');

  if (!requiredElement || !formGroup) return;

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

export function initIsMobile(): void {
  const isMobileElement = document.getElementById('is-mobile') as HTMLInputElement;

  if (!isMobileElement) return;

  isMobileElement.addEventListener('change', (e: Event) => {
    const target = e.target as HTMLInputElement;
    const isChecked = target.checked;
    onChangeFeature(isChecked, '#radius');
    onChangeFeature(isChecked, '#mobile-text');

    const addressHelp = document.getElementById('addressHelp');
    const radiusHelp = document.getElementById('radiusHelp');

    if (isChecked) {
      addressHelp?.classList.remove("hidden");
      radiusHelp?.classList.remove("hidden");
    } else {
      addressHelp?.classList.add("hidden");
      radiusHelp?.classList.add("hidden");
    }
  });
  isMobileElement.dispatchEvent(new Event('change'));
}

document.addEventListener('DOMContentLoaded', () => {
  setupProviderDelete();
  setupProviderPhotoDelete();
  setupProviderImageUpload();
  setupImageUpload('logo-imageUpload0', '#logo-imagePreview0');
  if (document.getElementById('location-ad-image-name0')) {
    setupImageUpload('location-ad-image-name0', '.coupon-preview');
  }
  initLocationPhotoDelete();
  initSpecialAnnouncements();
  initSpecialAnnouncementHandlers();
  initSelectBorder();
  setupSpecialAnnouncementPhotoDelete();
  initIsMobile();
});