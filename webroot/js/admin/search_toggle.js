import './datepicker';
/*** TODO: check this code again once admin search bar is in place ***/
class SearchToggle {
  constructor(options) {
    const defaults = {
      toggle_on_focus: false,
      elem_id: false,
      toggle_id: false,
      toggle_text_id: false,
    };
    this.options = { ...defaults, ...options };

    this.toggle_on_focus = this.options.toggle_on_focus;
    this.advanced_search = document.querySelector(this.options.elem_id);
    this.search_toggle = document.querySelector(this.options.toggle_id);
    this.search_text = this.options.toggle_text_id
      ? document.querySelector(this.options.toggle_text_id)
      : document.querySelector(this.options.toggle_id);

    this.search_toggle.addEventListener("click", this.toggleSearch.bind(this));
  }

  toggleSearch() {
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

// Reorganize search options and change booleans into a toggle
if (document.querySelector("form").action.includes("/admin/locations") || document.querySelector("form").action.includes("/admin/crm-searches")) {

  // Update labels for specific elements
  const updateLabels = () => {
    document.querySelector("label[for='id-cqp-practice']").textContent = "Practice";
  };

  updateLabels();

  //Wrap binary search options in spans
	const inputElements = Array.from(document.querySelectorAll(".filter-group input[placeholder='0 [or] 1']"));

	inputElements.forEach((input) => {
	  const label = document.createElement("label");
	  label.classList.add("switch");

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

	  input.parentNode.insertBefore(label, input);
	  label.appendChild(input);
	  label.appendChild(slider);
	});

	// Add value to hidden inputs when sliders are interacted with
	const sliders = Array.from(document.querySelectorAll("label .slider span"));

	sliders.forEach((slider) => {
	  slider.addEventListener("mouseup", function () {
	    const slideClass = this.classList.value;

	    const input = this.closest("label").querySelector("input");

	    if (slideClass === "switch-positive") {
	      input.classList.remove("switch-negative");
	      input.classList.add("switch-positive");
	      input.value = 1;
	    } else if (slideClass === "switch-negative") {
	      input.classList.remove("switch-positive");
	      input.classList.add("switch-negative");
	      input.value = 0;
	    } else {
	      input.classList.remove("switch-negative", "switch-positive");
	      input.removeAttribute("value");
	    }
	  });
	});

	// Load styles when sliders have been used in a previous search
	const switchInputs = Array.from(document.querySelectorAll("label.switch input"));

	switchInputs.forEach((input) => {
	  const value = input.value;

	  if (value === "1") {
	    input.classList.add("switch-positive");
	  } else if (value !== "") {
	    input.classList.add("switch-negative");
	  }
	});

  // Expand/collapse button functionality
  const toggleGroup = (button) => {
    const group = button.parentNode.nextElementSibling;
    group.classList.toggle("hidden");
    button.querySelector("span").classList.toggle("glyphicon-minus");
    button.querySelector("span").classList.toggle("glyphicon-plus");
  };

  const toggleButtons = document.querySelectorAll(".group-toggle");
  toggleButtons.forEach((button) => {
    button.addEventListener("click", () => toggleGroup(button));
  });
}

let minDate = '';
let maxDate = '';
if ($('.datepicker').attr('minDate')) {
	minDate = $('.datepicker').attr('minDate');
}
if ($('.datepicker').attr('maxDate')) {
	maxDate = $('.datepicker').attr('maxDate');
}
$('.datepicker').datepicker({
	dateFormat: 'yy-mm-dd',
	minDate: minDate,
	maxDate: maxDate
});
