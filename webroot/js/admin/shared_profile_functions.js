export function scrollToElement(selector) {
    const element = document.querySelector(selector);
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

export function onChangeFileInput(obj) {
    const editObj = this;
    const id = obj.id;

    const row = document.getElementById(id).closest('tr');
    const keyMatch = id.match(/(?:location-photo[s]?|logo-imageUpload|providers|location-ad)-?(\d*)-?(.*)/);
    const key = parseInt(keyMatch.input.match(/\d+/)[0]);
    const newKey = key + 1;
    // Check if a file is selected
    if (obj.files.length === 0) {
        // Clear any selection and return
        console.log('No file selected');
        return;
    }

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

    if (keyMatch[0].includes('location-photo')) {
      document.getElementById(`photo-add-error-${key}`).style.display = 'none';
      document.getElementById(`btn-photo-delete-${key}`).style.display = 'block';
      document.getElementById(`photo-description-${key}`).style.display = 'block';
      document.getElementById(`location-photos-${key}-alt`).disabled = false;
      if(document.querySelector('#LocationClinicEditForm')){
        document.querySelector('#LocationClinicEditForm .help-block.col-md-9.hidden').classList.remove('hidden');
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
      const newDeleteButton = deleteButtonContainer.querySelector('button');
      newDeleteButton.addEventListener('click', handleLocationPhotoDeleteClick);

      newRow.appendChild(deleteButtonContainer);
      row.after(newRow);
    }

    // Load the thumbnail image
    const files = obj.files;
    const reader = new FileReader();
    reader.onload = function(e) {
        const inputId = obj.id;
        let imgElement;
    
        if (inputId === 'logo-imageUpload') {
            imgElement = document.querySelector('img#logo-imagePreview0');
        } else if (/providers-\d+-photo-name/.test(inputId)) {
            const key = inputId.match(/providers-(\d+)-photo-name/)[1];
            imgElement = document.querySelector(`img#provider-imagePreview-${key}`);
        } else if (/location-photo-imageUpload-\d+/.test(inputId)) {
            const key = inputId.match(/location-photo-imageUpload-(\d+)/)[1];
            imgElement = document.querySelector(`img#photo-thumb-${key}`);
        }
    
        if (imgElement) {
            imgElement.src = e.target.result;
        }
    };
    reader.readAsDataURL(files[0]);
    }
  }

// Function to handle provider photo delete
export function setupProviderDelete() {
    document.querySelectorAll('.provider-delete').forEach(function(button) {
        button.addEventListener('click', async (event) => {
            const clickedButton = event.currentTarget;
            const locationId = event.currentTarget.getAttribute('data-provider-location-id');
            const providerId = event.currentTarget.getAttribute('data-provider-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

                    const providerDiv = clickedButton.closest('.well.provider').parentElement;
                    providerDiv.remove();
                } catch {
                    alert("OH NO");
                }
            }
        });
    });
}

// Function to handle provider photo delete
export function setupProviderPhotoDelete() {
    document.querySelectorAll('.provider-photo-delete-ck').forEach(function(button) {
        button.addEventListener('click', async (event) => {
            const providerCk = event.currentTarget.getAttribute('data-provider-ck');
            const providerIndex = event.currentTarget.getAttribute('data-provider-id');
            const providerId = document.querySelector('input[name="providers[' + providerIndex + '][id]"]').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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

                document.querySelector('#providers-' + providerIndex + '-photo-name').value = '';
                document.querySelector('#provider-pic-' + providerIndex).src = '';

            } catch {
                alert("OH NO");
            }
        });
    });
}

// Function to handle provider image upload preview
export function setupProviderImageUpload() {
    document.querySelectorAll('.provider-imageUpload').forEach(function(providerImageUpload) {
        providerImageUpload.addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var providerKey = providerImageUpload.getAttribute('data-provider-index');
                var output = document.getElementById('provider-imagePreview-' + providerKey);
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    });
}

// Generic function to handle image upload preview
export function setupImageUpload(inputId, previewSelector) {
    const fileInput = document.getElementById(inputId);
    
    if (!fileInput) {
        console.error(`File input element with ID ${inputId} not found`);
        return;
    }

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        // Check if a file is selected
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function() {
            const output = document.querySelector(previewSelector);
            
            if (!output) {
                console.error(`Output element with selector ${previewSelector} not found`);
                return;
            }

            output.src = reader.result;
            output.style.display = 'block';
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
}

export function addCoupon(obj) {
  var couponId = obj.getAttribute("data-coupon-id");
  document.getElementById("location-ad-image-name0").value = "";
  var specialAnnouncements = document.getElementById('specialAnnouncements');
  specialAnnouncements.dataset.adid = "";
  document.getElementById("couponId").value = couponId;
  specialAnnouncements.dataset.couponid = couponId;
  document.querySelector("#couponSelected .coupon-image").src = "/img/coupons/coupon-" + couponId + ".jpg";
  document.getElementById('couponLibrary').style.display = 'none';
  document.getElementById('couponSelected').style.display = 'block';
  document.getElementById('couponOption').style.display = 'block';
  document.getElementById('uploadCoupon').style.display = 'none';

  scrollToElement("#specialAnnouncements");
}

export async function handleLocationPhotoDeleteClick(event) {
    const clickedButton = event.currentTarget;
    const locationPhotoId = clickedButton.getAttribute('data-location-photo-id');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
      row.remove();
    } catch {
      // TODO
      alert ("OH NO");
    }
}

export function removePhotoRow(obj, type) {
    const row = obj.closest('tr');
    const key = obj.dataset.key;
    
    if (type === "photo") {
      document.querySelector(`#location-photos-${key}-photo-url`).value = '';
      const fileInput = document.querySelector(`#location-photos-${key}-file`);
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
      document.querySelector(".coupon-preview").classList.add('d-none');
      document.getElementById("location-ad-image-name0").value = "";
      document.getElementById("couponId").value = null;
      document.getElementById('specialAnnouncements').dataset.adid = "";
      document.getElementById('specialAnnouncements').dataset.couponid = "";

      scrollToElement("#specialAnnouncements");
      initSpecialAnnouncements();
    }
}

export function initSpecialAnnouncements() {
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

export const chooseOwnCoupon = () => {
  document.getElementById("couponLibrary").style.display = 'none';
  document.getElementById("couponSelected").style.display = 'none';
  document.getElementById("uploadCoupon").style.display = 'block';
  document.getElementById("couponOption").style.display = 'block';
  const specialAnnouncements = document.getElementById('specialAnnouncements');
  const locationAdIdElement = document.getElementById("location-ad-id");
  if (locationAdIdElement !== null) {
      specialAnnouncements.dataset.adid = locationAdIdElement.value;
  }
  specialAnnouncements.dataset.couponid = "";
  document.getElementById("couponId").value = "";
  scrollToElement("#specialAnnouncements");
};
  
export const showCouponLibrary = () => {
  document.getElementById("couponLibrary").style.display = 'block';
  document.getElementById("couponSelected").style.display = 'none';
  document.getElementById("uploadCoupon").style.display = 'none';
  document.getElementById("couponOption").style.display = 'none';
  scrollToElement("#specialAnnouncements");
};

export function initSpecialAnnouncementHandlers() {
  const titleInput = document.getElementById('location-ad-title');
  const descriptionTextarea = document.getElementById('location-ad-description');
  const panelHeading = document.querySelector('#location-ad-preview .panel-heading');
  const panelFooter = document.querySelector('#location-ad-preview .panel-footer');

  function handleInputChange(inputElement, targetElement) {
      inputElement.addEventListener('input', function() {
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

// Special announcement border selection
export function initSelectBorder() {
  document.querySelectorAll(".border-radio").forEach((radio) => {
    radio.addEventListener("click", () => {
      document.querySelector('.coupon-preview').classList.remove(document.querySelector('.selected-border input').value);
      document.querySelector(".selected-border").classList.remove("selected-border");
      radio.classList.add("selected-border");
      document.querySelector('.coupon-preview').classList.add(document.querySelector('.selected-border input').value);
    });
  })
}

export function onChangeLocationAdFile(obj) {
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
        document.getElementById('location-ad-image-url').value = filename;
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
        document.getElementById('location-ad-image-url').style.background = 'rgba(200,100,100,.5)';
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
        document.getElementById('location-ad-image-url').style.background = '';
        document.getElementById('location-ad-error').style.display = 'none';
    }
}

// Display and require an extra field based on if this feature is enabled
export function onChangeFeature(isFeature, requiredElementId) {
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

export function initIsMobile() {
  document.getElementById('is-mobile').addEventListener('change', e => {
    const isChecked = e.target.checked;
    onChangeFeature(isChecked, '#radius');
    onChangeFeature(isChecked, '#mobile-text');
    
    if (isChecked) {
      document.getElementById('addressHelp').classList.remove("hidden");
      document.getElementById('radiusHelp').classList.remove("hidden");
    } else {
      document.getElementById('addressHelp').classList.add("hidden");
      document.getElementById('radiusHelp').classList.add("hidden");
    }
  });
  document.getElementById('is-mobile').dispatchEvent(new Event('change'));
}

document.addEventListener('DOMContentLoaded', () => {
    setupProviderDelete();
    setupProviderPhotoDelete();
    setupProviderImageUpload();
    setupImageUpload('logo-imageUpload0', '#logo-imagePreview0');
    setupImageUpload('location-ad-image-name0', '.coupon-preview');
    initSpecialAnnouncementHandlers();
    initSelectBorder();
    initIsMobile();
});