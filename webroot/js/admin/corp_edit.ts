import './admin_common';
import './nav_tabs';
import './ckpackage';

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

            output.src = reader.result as string;
            output.style.display = 'block';
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupImageUpload('logo-imageUpload0', '#logo-imagePreview0');
    setupImageUpload('facebook-imageUpload0', '#facebook-imagePreview0');
});