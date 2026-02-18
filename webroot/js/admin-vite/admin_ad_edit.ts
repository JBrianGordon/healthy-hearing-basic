import './admin_common';

const imageUpload = document.getElementById('imageUpload') as HTMLInputElement;
const imagePreview = document.getElementById('imagePreview') as HTMLImageElement;
const adImage = document.getElementById('adImage') as HTMLImageElement;

// Function to display the image preview
export function displayImagePreview(src: string): void {
    imagePreview.src = src;
    imagePreview.style.display = 'block';
}

// Function to populate the adImage field
export function populateAdImageField(src: string): void {
    adImage.src = src;
}

export function showImagePreview(): void {
    // Add change event listener to the image upload input
    if (imageUpload) {
        imageUpload.addEventListener('change', function (event: Event) {
            const target = event.target as HTMLInputElement;
            const file = target.files?.[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function () {
                const result = reader.result as string;
                displayImagePreview(result);
                populateAdImageField(result);
            };
            reader.readAsDataURL(file);
        });
    }

    // Check if there is already an image value on page load
    if (imagePreview && imagePreview.src && imagePreview.src !== '#') {
        displayImagePreview(imagePreview.src);
        populateAdImageField(imagePreview.src);
    }
}

showImagePreview();