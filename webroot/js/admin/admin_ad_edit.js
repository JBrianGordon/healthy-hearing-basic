import './admin_common';

const imageUpload = document.getElementById('imageUpload');
const imagePreview = document.getElementById('imagePreview');
const adImage = document.getElementById('adImage');

// Function to display the image preview
export function displayImagePreview(src) {
    imagePreview.src = src;
    imagePreview.style.display = 'block';
}

// Function to populate the adImage field
export function populateAdImageField(src) {
    adImage.src = src;
}

export function showImagePreview() {
    // Add change event listener to the image upload input
    imageUpload.addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            const result = reader.result;
            displayImagePreview(result);
            populateAdImageField(result);
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    // Check if there is already an image value on page load
    if (imagePreview.src && imagePreview.src !== '#') {
        displayImagePreview(imagePreview.src);
        populateAdImageField(imagePreview.src);
    }
}

showImagePreview();