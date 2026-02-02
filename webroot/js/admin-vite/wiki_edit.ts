import './admin_common';
import './nav_tabs';
import './ckpackage';

// Leaving this largely alone due to use of datepicker
document.addEventListener('DOMContentLoaded', function (): void {

	document.addEventListener('click', function (e: MouseEvent): void {
		const target = e.target as HTMLElement;

		if (target.id === 'WikiFacebookImageBypass') {
			const bypass = target as HTMLInputElement;
			const widthInput = document.getElementById('WikiFacebookImageWidth') as HTMLInputElement;
			const widthParent = widthInput?.parentElement?.parentElement;

			if (bypass.checked) {
				widthInput?.removeAttribute('required');
				widthParent?.classList.remove('required');
			} else {
				widthInput?.setAttribute('required', 'required');
				widthParent?.classList.add('required');
			}
		}
	});

	document.addEventListener('click', function (e: MouseEvent): void {
		const target = e.target as HTMLElement;

		if (target.id === 'ApproveLink') {
			const widthInput = document.getElementById('WikiFacebookImageWidth') as HTMLInputElement;
			const widthParent = widthInput?.parentElement?.parentElement;

			widthInput?.removeAttribute('required');
			widthParent?.classList.remove('required');
		}
	});

	const isActiveCheckbox = document.getElementById('WikiIsActive') as HTMLInputElement;
	const draftParentInput = document.getElementById('WikiDraftParentId') as HTMLInputElement;

	if (isActiveCheckbox?.checked) {
		// active is checked, is this a draft???
		if (Number(draftParentInput?.value) > 0) {
			// yep, it's a draft.
			const datepickerElements = document.querySelectorAll<HTMLElement>(".datepicker_future");
			datepickerElements.forEach(element => {
				($(element) as any).datepicker({
					minDate: new Date(Date.now() + 24 * 60 * 60 * 1000)
				});
			});
		}
	}

	document.addEventListener('change', function (e: Event): void {
		const target = e.target as HTMLElement;

		if (target.id === 'WikiIsActive') {
			const draftParentInput = document.getElementById('WikiDraftParentId') as HTMLInputElement;

			if (Number(draftParentInput?.value) > 0) {
				const datepickerElements = document.querySelectorAll<HTMLElement>('.datepicker_future');
				datepickerElements.forEach(element => {
					($(element) as any).datepicker('option', 'minDate', new Date(Date.now() + 24 * 60 * 60 * 1000));
				});
			}
		}
	});

	// Only allow one reviewer at a time
	const reviewerBoxes = document.getElementsByName("data[Reviewer][Reviewer][]") as NodeListOf<HTMLInputElement>;
	for (let i = 0; i < reviewerBoxes.length; i++) {
		reviewerBoxes[i].onclick = function (this: HTMLInputElement): void {
			for (let j = 0; j < reviewerBoxes.length; j++) {
				if (reviewerBoxes[j] !== this && this.checked) {
					reviewerBoxes[j].checked = false;
				}
			}
		};
	}

	document.addEventListener('click', function (e: MouseEvent): void {
		const target = e.target as HTMLElement;

		if (target.classList.contains('ck_file_browser')) {
			console.log("browser");
			const CKFinder = (window as any).CKFinder;
			CKFinder.setupCKEditor();
			CKFinder.basePath = '/ckfinder/';	// The path for the installation of CKFinder (default = "/ckfinder/").
			CKFinder.startupPath = "Images:/";
			CKFinder.resourceType = "Images";
			CKFinder.popup({
				chooseFiles: true,
				resizeImages: false,
				onInit: function (finder: any): void {
					finder.on('files:choose', function (evt: any): void {
						const file = evt.data.files.first();
						const output = document.getElementById('WikiFacebookImage') as HTMLInputElement;
						const span = document.getElementById('facebook_image_span') as HTMLSpanElement;

						if (output && span) {
							output.value = file.getUrl();
							span.innerHTML = file.getUrl();
							const fileUrl = output.value;
							if (fileUrl !== "") {
								fetch("/admin/content/get_image_info", {
									method: "POST",
									headers: {
										"Content-Type": "application/json"
									},
									body: JSON.stringify({
										uri: fileUrl
									})
								})
									.then(response => response.json())
									.then((data: { width?: number; height?: number }) => {
										const widthInput = document.getElementById('WikiFacebookImageWidth') as HTMLInputElement;
										const heightInput = document.getElementById('WikiFacebookImageHeight') as HTMLInputElement;

										if (data.width && widthInput && heightInput) {
											widthInput.value = data.width.toString();
											heightInput.value = data.height.toString();
										} else {
											alert("Cannot find data for Facebook/Schema image. Please look in the Details tab to update.");
										}
									})
									.catch(() => {
										alert("Cannot find data for Facebook/Schema image. Please look in the Details tab to update.");
									});
							}
						}
					});
				}
			});
		}
	});

	// Initialize datepickers (still using jQuery UI datepicker)
	const datepickerFutureElements = document.querySelectorAll<HTMLElement>('.datepicker_future');
	datepickerFutureElements.forEach(element => {
		($(element) as any).datepicker({
			dateFormat: 'mm/dd/yy',
			minDate: new Date(Date.now() + 24 * 60 * 60 * 1000)
		});
	});

	const datepickerElements = document.querySelectorAll<HTMLElement>(".datepicker");
	datepickerElements.forEach(element => {
		($(element) as any).datepicker();
	});
});

// Generic function to handle image upload preview
export function setupImageUpload(inputId: string, previewSelector: string): void {
	const fileInput = document.getElementById(inputId) as HTMLInputElement;

	if (!fileInput) {
		console.error(`File input element with ID ${inputId} not found`);
		return;
	}

	fileInput.addEventListener('change', function (event: Event): void {
		const target = event.target as HTMLInputElement;
		const file = target.files?.[0];

		// Check if a file is selected
		if (!file) {
			return;
		}

		const reader = new FileReader();
		reader.onload = function (): void {
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

document.addEventListener('DOMContentLoaded', (): void => {
	setupImageUpload('facebook-imageUpload0', '#facebook-imagePreview0');
});