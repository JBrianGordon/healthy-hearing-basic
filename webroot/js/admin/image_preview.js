export function onChangeFileInput(obj) {
    const editObj = this;
    const id = obj.id;

    const row = document.getElementById(id).closest('tr');
    const keyMatch = id.match(/location-photo|logo-imageUpload|Provider(\d+)(.+)/);
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

    if (keyMatch[0] === 'location-photo') {
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
      const imgElement = keyMatch.input === 'logo-imageUpload' ? document.querySelector('img#logo-imagePreview0') : document.querySelector(`img#photo-thumb-${key}`);
      imgElement.src = e.target.result;
    };
    reader.readAsDataURL(files[0]);
    }
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

// Function to handle logo image upload preview
export function setupLogoImageUpload() {
    document.getElementById('logo-imageUpload0').addEventListener('change', function(event) {
        const file = event.target.files[0];

        // Check if a file is selected
        if (!file) {
            return;
        }

        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('logo-imagePreview0');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
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

document.addEventListener('DOMContentLoaded', () => {
    setupProviderPhotoDelete();
    setupProviderImageUpload();
    setupLogoImageUpload();
});