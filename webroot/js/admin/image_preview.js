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
    document.getElementById('logo-imageUpload').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('logo-imagePreview0');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupProviderPhotoDelete();
    setupProviderImageUpload();
    setupLogoImageUpload();
});