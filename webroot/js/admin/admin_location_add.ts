import './admin_common';

const disableSubmit = (btn: HTMLButtonElement): void => {
	if (btn.disabled) {
		return;
	}
	btn.disabled = true;
	const form = btn.closest('form');
	if (form) {
		form.submit();
		console.log('form submitted.');
	}
};

const init = (): void => {
	const submitBtn = document.getElementById('submitBtn') as HTMLButtonElement;
	if (submitBtn) {
		submitBtn.addEventListener('click', function () {
			disableSubmit(this);
		});
	}
};

init();

// Change title and subtitle labels (US only)
const appNameMeta = document.querySelector<HTMLMetaElement>("meta[name='application-name']");
const titleLabel = document.querySelector<HTMLLabelElement>("label[for='ImportLocationTitle']");
const subtitleLabel = document.querySelector<HTMLLabelElement>("label[for='ImportLocationSubtitle']");

if (appNameMeta && appNameMeta.getAttribute("content") === "Healthy Hearing") {
	if (titleLabel) {
		titleLabel.innerHTML = "Practice Name";
	}
	if (subtitleLabel) {
		subtitleLabel.innerHTML = "Location Name";
	}
}