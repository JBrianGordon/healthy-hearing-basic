// Track character count in message box
const addCharCounter = (textElement: string, maxCharLength: number): void => {
	let charLimit: HTMLElement | null = null;
	const textTarget = document.getElementById(textElement) as HTMLTextAreaElement | null;

	if (!textTarget) return;

	let infocus = false;
	const charSpan = document.createElement("span");
	charSpan.setAttribute("id", "charLimit");

	const checkLength = (): void => {
		if (infocus) {
			charLimit = document.getElementById("charLimit");
			if (!charLimit) return;

			if (textTarget.value.length < maxCharLength) {
				if (charLimit.classList.contains('max-chars')) {
					charLimit.classList.remove('max-chars');
				}
				const remaining = maxCharLength - textTarget.value.length;
				charLimit.innerHTML = `${remaining} character${remaining === 1 ? '' : 's'} remaining`;
			} else if (textTarget.value.length === maxCharLength) {
				charLimit.classList.add('max-chars');
				charLimit.innerHTML = "0 characters remaining";
			}
		}
	};

	const insertAfter = (newNode: HTMLElement, referenceNode: HTMLElement): void => {
		if (referenceNode.parentNode) {
			referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
		}
	};

	insertAfter(charSpan, textTarget);

	textTarget.onfocus = (): void => { infocus = true; };
	textTarget.onblur = (): void => { infocus = false; };

	setInterval(checkLength, 100);
};

// Pass textarea element id and max character count to function
const covidStatement = document.getElementById('LocationCovid19Statement');
const contactMessage = document.getElementById('ContactMessage');

if (covidStatement !== null) {
	addCharCounter('LocationCovid19Statement', 400);
} else if (contactMessage !== null) {
	addCharCounter('ContactMessage', 1000);
}