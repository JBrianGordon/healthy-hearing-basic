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

// Export button modal and functionality
const exportBtn = document.getElementById("exportBtn");
const exportModal = document.getElementById("exportModal");

if(exportBtn !== null){
	exportBtn.addEventListener("click", (e) => {
	  e.preventDefault();
	  exportModal.style.display = "block";
	  exportModal.classList.add("show", "in");
	});
}

const exportClose = document.getElementById("exportClose");
if(exportClose !== null){
	exportClose.addEventListener("click", () => {
	  exportModal.style.display = "none";
	  exportModal.classList.remove("show", "in");
	});
}

// Toggle values for switches
const formControls = document.querySelectorAll("#exportModal .form-control");
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
const allFieldsInput = document.getElementById("allFieldsInput");
if(allFieldsInput !== null){
	allFieldsInput.addEventListener("click", () => {
	  setTimeout(() => {
	    const exportLabelInputs = document.querySelectorAll(".export-label input");
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
const exportSubmit = document.getElementById("exportSubmit");
if(exportSubmit !== null){
	exportSubmit.addEventListener("click", () => {
    // Read CSRF Token
    var csrfToken = $('input[name="_csrfToken"]').val();

    var excludedFields = [];
	  const formControlElements = document.querySelectorAll("#exportModal .form-control");
	  formControlElements.forEach((element) => {
	    if (element.value === "0") {
	      const excludedFieldName = element.name;
	      excludedFields.push(element.name);
	    }
	  });

    var exportData = [];
    exportData['excludedFields'] = excludedFields;
    exportData['queryString'] = location.search;

    fetch("/admin/locations/export", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-Token": csrfToken
      },
      body: JSON.stringify({excludedFields: excludedFields, queryString: location.search}),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success == true) {
          console.debug('success');
          console.debug(data);
        } else {
          console.log('failed');
        }
      })
      .catch(error => {
        console.log('Error: ', error);
      });
	});
}

// Reorganize search options and change booleans into a toggle
if (document.querySelector("form").action.includes("/admin/locations") ||
		document.querySelector("form").action.includes("/admin/crm-searches") ||
		document.querySelector("form").action.includes("/search") ||
		exportModal !== null) {
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
	    const slideClass = slider.classList.value;

	    const input = slider.closest("label").querySelector("input");

	    if (slideClass === "switch-positive") {
	      input.classList.remove("switch-negative", "d-none");
	      input.classList.add("switch-positive");
	      input.value = 1;
		  input.disabled = false;
	    } else if (slideClass === "switch-negative") {
	      input.classList.remove("switch-positive", "d-none");
	      input.classList.add("switch-negative");
	      input.value = 0;
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

// Load styles when sliders have been used in a previous search
const switchInputs = Array.from(document.querySelectorAll("label.switch input"));

switchInputs.forEach((input) => {
	const value = new URLSearchParams(window.location.search).get(input.name);

	if (value === "1") {
		input.classList.add("switch-positive");
		input.classList.remove("switch-negative");
		input.value = 1;
	} else if (value === "0") {
		input.classList.add("switch-negative");
		input.classList.remove("switch-positive");
		input.value = 0;
	}
});

let minDate = '';
let maxDate = '';
if ($('.datepicker').attr('minDate')) {
	minDate = $('.datepicker').attr('minDate');
}

// Toggle values for switches
if(exportModal !== null) {
	const exportSwitches = document.querySelectorAll("#exportModal .form-control");
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
	const allFieldsInput = document.getElementById("allFieldsInput");
	allFieldsInput.addEventListener("click", function() {
	  setTimeout(function() {
	    const exportLabelInputs = document.querySelectorAll(".export-label input");
	    if (allFieldsInput.classList.contains("switch-positive")) {
	      exportLabelInputs.forEach(input => {
	        input.classList.remove("switch-negative");
	        input.classList.add("switch-positive");
	        input.value = "1";
	      });
	    } else if (allFieldsInput.classList.contains("switch-negative")) {
	      exportLabelInputs.forEach(input => {
	        input.classList.remove("switch-positive");
	        input.classList.add("switch-negative");
	        input.value = "0";
	      });
	    }
	  }, 200);
	});

	//export button modal and functionality
	$("#exportButton").on("click",function(e) {
		e.preventDefault();
		$("#exportModal").show().addClass("in");
	});

	$("#exportClose").on("click",function() {
		$("#exportModal").hide().removeClass("in");
	});

}

export const datepickerFunctions = () => {
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
}