import './admin_common';
import './nav_tabs';
import './ckpackage';

const toggleContentShow = (type: string): void => {
	const fileElement = document.querySelector<HTMLElement>("#file");
	const textElement = document.querySelector<HTMLElement>("#text");

	if (!fileElement || !textElement) return;

	fileElement.style.display = "none";
	textElement.style.display = "none";

	switch (type) {
		case "flv":
			fileElement.style.display = "block";
			break;
		default:
			textElement.style.display = "block";
			break;
	}
};

document.addEventListener('DOMContentLoaded', () => {
	//toggleContentShow(document.querySelector('#type').value);

	document.addEventListener('change', (e: Event) => {
		const target = e.target as HTMLSelectElement;
		if (target.matches('#type')) {
			toggleContentShow(target.value);
		}
	});

	document.addEventListener('click', (e: Event) => {
		const target = e.target as HTMLElement;
		if (target.matches('#facebook-image-width-override')) {
			const checkbox = target as HTMLInputElement;
			const widthInput = document.querySelector<HTMLInputElement>('#facebook-image-width');
			const parentElement = widthInput?.parentElement?.parentElement;

			if (!widthInput || !parentElement) return;

			if (checkbox.checked) {
				widthInput.removeAttribute('required');
				parentElement.classList.remove('required');
			} else {
				widthInput.setAttribute('required', 'required');
				parentElement.classList.add('required');
			}
		} else if (target.matches('#ApproveLink')) {
			const widthInput = document.querySelector<HTMLInputElement>('#facebook-image-width');
			const parentElement = widthInput?.parentElement?.parentElement;

			if (!widthInput || !parentElement) return;

			widthInput.removeAttribute('required');
			parentElement.classList.remove('required');
		}
	});

	document.addEventListener('change', (e: Event) => {
		const target = e.target as HTMLInputElement;
		const dateInput = document.querySelector<HTMLInputElement>('#date');
		const lastModifiedInput = document.querySelector<HTMLInputElement>('#last-modified');

		if (!dateInput || !lastModifiedInput) return;

		if (target.matches('#date')) {
			lastModifiedInput.value = dateInput.value;
		} else if (target.matches('#last-modified')) {
			if (dateInput.value === '') {
				dateInput.value = lastModifiedInput.value;
			}
		}
	});

	// Ensure the slug input is formatted correctly
	const slugInput = document.querySelector<HTMLInputElement>('#slug');

	if (slugInput) {
		slugInput.addEventListener('input', function () {
			let value = slugInput.value;

			// Replace spaces with hyphens
			value = value.replace(/\s+/g, '-');

			slugInput.value = value;
		});
	}

});

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

document.addEventListener('change', function (e: Event) {
	const target = e.target as HTMLInputElement;
	if (target && target.id === 'ContentDate') {
		const lastModifiedInput = document.getElementById('ContentLastModified') as HTMLInputElement;
		if (lastModifiedInput) {
			lastModifiedInput.value = target.value;
		}
	}
});

document.addEventListener('change', function (e: Event) {
	const target = e.target as HTMLInputElement;
	if (target && target.id === 'ContentLastModified') {
		const dateInput = document.getElementById('ContentDate') as HTMLInputElement;
		if (dateInput && dateInput.value === '') {
			dateInput.value = target.value;
		}
	}
});


document.addEventListener('DOMContentLoaded', () => {
	setupImageUpload('facebook-imageUpload0', '#facebook-imagePreview0');
});