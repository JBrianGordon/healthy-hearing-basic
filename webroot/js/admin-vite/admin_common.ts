import '../common-vite/common';
import $ from 'jquery';

/*** TODO: check this code again once admin search bar is in place ***/

interface SearchToggleOptions {
	toggle_on_focus?: boolean;
	elem_id: string;
	toggle_id: string;
	toggle_text_id?: string;
}

class SearchToggle {
	private options: Required<SearchToggleOptions>;
	private toggle_on_focus: boolean;
	private advanced_search: HTMLElement | null;
	private search_toggle: HTMLElement | null;
	private search_text: HTMLElement | null;

	constructor(options: SearchToggleOptions) {
		const defaults: Required<SearchToggleOptions> = {
			toggle_on_focus: false,
			elem_id: '',
			toggle_id: '',
			toggle_text_id: '',
		};
		this.options = { ...defaults, ...options } as Required<SearchToggleOptions>;

		this.toggle_on_focus = this.options.toggle_on_focus;
		this.advanced_search = document.querySelector(this.options.elem_id);
		this.search_toggle = document.querySelector(this.options.toggle_id);
		this.search_text = this.options.toggle_text_id
			? document.querySelector(this.options.toggle_text_id)
			: document.querySelector(this.options.toggle_id);

		if (this.search_toggle) {
			this.search_toggle.addEventListener("click", this.toggleSearch.bind(this));
		}
	}

	toggleSearch(): void {
		if (!this.advanced_search || !this.search_text) return;

		if (this.advanced_search.style.display === "block") {
			this.search_text.innerHTML = "+";
			this.advanced_search.style.display = "none";
		} else {
			this.search_text.innerHTML = "-";
			this.advanced_search.style.display = "block";
		}
	}
}

// Check for search toggle element on page
if (document.querySelector("#admin_search_toggle")) {
	new SearchToggle({
		toggle_id: "#admin_search_toggle",
		elem_id: "#admin_search",
		toggle_text_id: "#admin_search_text",
	});
}

if (document.querySelector("#advanced_search_toggle")) {
	new SearchToggle({
		toggle_id: "#advanced_search_toggle",
		elem_id: "#advanced_search",
		toggle_text_id: "#advanced_search_text",
	});
}

// Export button modal and functionality
const exportBtn = document.querySelector<HTMLElement>("#exportBtn");
const exportModal = document.querySelector<HTMLElement>("#exportModal");

if (exportBtn && exportModal) {
	exportBtn.addEventListener("click", (e: Event) => {
		e.preventDefault();
		exportModal.style.display = "block";
		exportModal.classList.add("show", "in");
	});
}

const exportClose = document.querySelector<HTMLElement>("#exportClose");
if (exportClose && exportModal) {
	exportClose.addEventListener("click", () => {
		exportModal.style.display = "none";
		exportModal.classList.remove("show", "in");
	});
}

// Toggle values for switches
const formControls = document.querySelectorAll<HTMLInputElement>("#exportModal .form-control");
formControls.forEach((control) => {
	control.addEventListener("click", () => {
		if (control.value === "0") {
			control.value = "1";
		} else {
			control.value = "0";
		}
	});
});

// Toggle classes and values for all switches, based on #allFieldsInput active class
const allFieldsInput = document.querySelector<HTMLInputElement>("#allFieldsInput");
if (allFieldsInput !== null) {
	allFieldsInput.addEventListener("click", () => {
		setTimeout(() => {
			const exportLabelInputs = document.querySelectorAll<HTMLInputElement>(".export-label input");
			if (allFieldsInput.classList.contains("switch-positive")) {
				exportLabelInputs.forEach((input) => {
					input.classList.remove("switch-negative");
					input.classList.add("switch-positive");
					input.value = "1";
				});
			} else if (allFieldsInput.classList.contains("switch-negative")) {
				exportLabelInputs.forEach((input) => {
					input.classList.remove("switch-positive");
					input.classList.add("switch-negative");
					input.value = "0";
				});
			}
		}, 200);
	});
}

// Handle export submit
const exportSubmit = document.querySelector<HTMLElement>("#exportSubmit");
if (exportSubmit !== null) {
	exportSubmit.addEventListener("click", () => {
		// Read CSRF Token
		const csrfTokenElement = document.querySelector<HTMLInputElement>('input[name="_csrfToken"]');
		const csrfToken = csrfTokenElement?.value || '';

		const excludedFields: string[] = [];
		const formControlElements = document.querySelectorAll<HTMLInputElement>("#exportModal .form-control");

		formControlElements.forEach((element) => {
			if (element.value === "0") {
				excludedFields.push(element.name);
			}
		});

		fetch("/admin/locations/export", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
				"X-CSRF-Token": csrfToken
			},
			body: JSON.stringify({
				excludedFields: excludedFields,
				queryString: location.search
			}),
		})
			.then(response => response.json())
			.then((data: { success: boolean }) => {
				if (data.success === true) {
					console.debug('success');
					console.debug(data);
				} else {
					console.log('failed');
				}
			})
			.catch((error: Error) => {
				console.log('Error: ', error);
			});
	});
}

// Reorganize search options and change booleans into a toggle
const formElement = document.querySelector<HTMLFormElement>("form");
if (formElement &&
	(formElement.action.includes("/admin/locations") ||
		formElement.action.includes("/admin/crm-searches") ||
		formElement.action.includes("/search") ||
		exportModal !== null)) {

	// Wrap binary search options in spans
	const inputElements = Array.from(
		document.querySelectorAll<HTMLInputElement>(".filter-group input[placeholder='0 [or] 1']")
	);

	inputElements.forEach((input) => {
		const label = document.createElement("label");
		label.classList.add("switch");
		if (input.style.width) {
			label.style.width = input.style.width;
		}

		const slider = document.createElement("span");
		slider.classList.add("slider");

		const switchNegative = document.createElement("span");
		switchNegative.classList.add("switch-negative");

		const switchOff = document.createElement("span");
		switchOff.classList.add("switch-off");

		const switchPositive = document.createElement("span");
		switchPositive.classList.add("switch-positive");

		slider.appendChild(switchNegative);
		slider.appendChild(switchOff);
		slider.appendChild(switchPositive);

		if (input.parentNode) {
			input.parentNode.insertBefore(label, input);
		}
		label.appendChild(input);
		label.appendChild(slider);
	});

	// Add value to hidden inputs when sliders are interacted with
	const sliders = Array.from(document.querySelectorAll<HTMLSpanElement>("label .slider span"));

	sliders.forEach((slider) => {
		slider.addEventListener("mouseup", function () {
			const slideClass = slider.classList.value;
			const label = slider.closest("label");
			const input = label?.querySelector<HTMLInputElement>("input");

			if (!input) return;

			if (slideClass === "switch-positive") {
				input.classList.remove("switch-negative", "d-none");
				input.classList.add("switch-positive");
				input.value = "1";
				input.disabled = false;
			} else if (slideClass === "switch-negative") {
				input.classList.remove("switch-positive", "d-none");
				input.classList.add("switch-negative");
				input.value = "0";
				input.disabled = false;
			} else {
				input.classList.remove("switch-negative", "switch-positive");
				input.classList.add("d-none");
				input.removeAttribute("value");
				input.disabled = true;
			}
		});
	});

	// Load styles when sliders have been used in a previous search
	const switchInputs = Array.from(
		document.querySelectorAll<HTMLInputElement>("label.switch input")
	);

	switchInputs.forEach((input) => {
		const value = input.value;

		if (value === "1") {
			input.classList.add("switch-positive");
		} else if (value !== "") {
			input.classList.add("switch-negative");
		}
	});

	// Expand/collapse button functionality
	const toggleGroup = (button: HTMLElement): void => {
		const group = (button.parentNode as Element)?.nextElementSibling as HTMLElement | null;
		if (group) {
			group.classList.toggle("hidden");
		}
		const span = button.querySelector("span");
		if (span) {
			span.classList.toggle("glyphicon-minus");
			span.classList.toggle("glyphicon-plus");
		}
	};

	const toggleButtons = document.querySelectorAll<HTMLElement>(".group-toggle");
	toggleButtons.forEach((button) => {
		button.addEventListener("click", () => toggleGroup(button));
	});
}

// Load styles when sliders have been used in a previous search
const switchInputsGlobal = Array.from(
	document.querySelectorAll<HTMLInputElement>("label.switch input")
);

switchInputsGlobal.forEach((input) => {
	const value = new URLSearchParams(window.location.search).get(input.name);

	if (value === "1") {
		input.classList.add("switch-positive");
		input.classList.remove("switch-negative");
		input.value = "1";
	} else if (value === "0") {
		input.classList.add("switch-negative");
		input.classList.remove("switch-positive");
		input.value = "0";
	}
});

// Toggle values for switches in export modal
if (exportModal !== null) {
	const exportSwitches = document.querySelectorAll<HTMLInputElement>("#exportModal .form-control");
	exportSwitches.forEach(switchElement => {
		switchElement.addEventListener("click", () => {
			if (switchElement.value === "0") {
				switchElement.value = "1";
			} else {
				switchElement.value = "0";
			}
		});
	});

	// Toggle classes and values for all switches, based on #allFieldsInput active class
	const allFieldsInputModal = document.querySelector<HTMLInputElement>("#allFieldsInput");
	if (allFieldsInputModal) {
		allFieldsInputModal.addEventListener("click", function () {
			setTimeout(function () {
				const exportLabelInputs = document.querySelectorAll<HTMLInputElement>(".export-label input");
				if (allFieldsInputModal.classList.contains("switch-positive")) {
					exportLabelInputs.forEach(input => {
						input.classList.remove("switch-negative");
						input.classList.add("switch-positive");
						input.value = "1";
					});
				} else if (allFieldsInputModal.classList.contains("switch-negative")) {
					exportLabelInputs.forEach(input => {
						input.classList.remove("switch-positive");
						input.classList.add("switch-negative");
						input.value = "0";
					});
				}
			}, 200);
		});
	}

	// Export button modal and functionality (jQuery version)
	$("#exportButton").on("click", function (e) {
		e.preventDefault();
		$("#exportModal").show().addClass("in");
	});

	$("#exportClose").on("click", function () {
		$("#exportModal").hide().removeClass("in");
	});
}