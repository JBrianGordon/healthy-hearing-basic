import './datepicker';

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
if (
  document.querySelector("form").action.includes("/admin/locations") ||
  document.querySelector("form").action.includes("/admin/crm-searches")
) {
  const generalInputs = document.createElement("div");
  const reviewInputs = document.createElement("div");
  const managementInputs = document.createElement("div");
  const upgrades = document.createElement("div");
  const genInputsHeadline = `<div><h3 class='crm-group-header'>General demographics</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-minus'></span> Collapse section</span></div>`;
  const reviewsHeadline = `<div><h3 class='crm-group-header'>Reviews</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span> Expand section</span></div>`;
  const changeManagementHeadline = `<div><h3 class='crm-group-header'>Change management</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span> Expand section</span></div>`;
  const upgradeHeadline = `<div><h3 class='crm-group-header'>Upgrade Features</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span> Expand section</span></div>`;
  generalInputs.classList.add("filter-group");
  reviewInputs.classList.add("filter-group", "hidden");
  managementInputs.classList.add("filter-group", "hidden");
  upgrades.classList.add("filter-group", "hidden");

  // Send form groups to proper parent divs
  const arrangeInputs = (modalToggleField, inputGroup) => {
    modalToggleField.forEach((field) => {
      field.closest(".form-group").appendChild(inputGroup);
    });
  };

  const generalFields = [
    document.querySelector("#SearchId"),
    document.querySelector("#SearchOticonId"),
    document.querySelector("#SearchParentId"),
    document.querySelector("#SearchSfId"),
    document.querySelector("#SearchYhnLocationId"),
    document.querySelector("#SearchCqpPracticeId"),
    document.querySelector("#SearchXneCrmId"),
    document.querySelector("#SearchOticonComplaintId"),
    document.querySelector("#SearchExactLocationId"),
  ];
  const reviewFields = [
    document.querySelector("#SearchReviewResponse"),
    document.querySelector("#SearchReviewVendorId"),
  ];
  const managementFields = [
    document.querySelector("#SearchLastSentEmailId"),
    document.querySelector("#SearchLastSentDateId"),
    document.querySelector("#SearchNextFollowUpDateId"),
    document.querySelector("#SearchLastModifiedDateId"),
  ];
  const upgradeFields = [
    document.querySelector("#SearchCtaId"),
    document.querySelector("#SearchCtaDateId"),
  ];

  arrangeInputs(generalFields, generalInputs);
  arrangeInputs(reviewFields, reviewInputs);
  arrangeInputs(managementFields, managementInputs);
  arrangeInputs(upgradeFields, upgrades);

  if (generalInputs.innerHTML.trim() === "") {
    generalInputs.remove();
  }
  if (reviewInputs.innerHTML.trim() === "") {
    reviewInputs.remove();
  }
  if (managementInputs.innerHTML.trim() === "") {
    managementInputs.remove();
  }
  if (upgrades.innerHTML.trim() === "") {
    upgrades.remove();
  }

  document.querySelector("#admin_search .form-horizontal").appendChild(generalInputs);
  document.querySelector("#admin_search .form-horizontal").appendChild(reviewInputs);
  document.querySelector("#admin_search .form-horizontal").appendChild(managementInputs);
  document.querySelector("#admin_search .form-horizontal").appendChild(upgrades);

  // Update labels for specific elements
  const updateLabels = () => {
    document.querySelector("label[for='SearchCqpPracticeId']").textContent = "Practice";
    document.querySelector("label[for='SearchReviewResponse']").textContent = "Review Response";
  };

  updateLabels();

  // Transform boolean inputs into switches
  const createSwitch = (input) => {
    const switchContainer = document.createElement("label");
    switchContainer.classList.add("switch");

    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.id = input.id + "_switch";

    const slider = document.createElement("span");
    slider.classList.add("slider", "round");

    switchContainer.appendChild(checkbox);
    switchContainer.appendChild(slider);

    const inputParent = input.parentNode;
    inputParent.insertBefore(switchContainer, input);
    inputParent.removeChild(input);

    checkbox.checked = input.value === "true";

    checkbox.addEventListener("change", () => {
      input.value = checkbox.checked ? "true" : "false";
      slider.classList.toggle("switch-positive", checkbox.checked);
      slider.classList.toggle("switch-negative", !checkbox.checked);
    });
  };

  const booleanInputs = document.querySelectorAll(
    "input[type='hidden'][value='true'], input[type='hidden'][value='false']"
  );
  booleanInputs.forEach((input) => createSwitch(input));

  // Load styles for switches
  const loadSwitchStyles = () => {
    const switches = document.querySelectorAll(".switch input[type='checkbox']");
    switches.forEach((checkbox) => {
      const slider = checkbox.nextElementSibling;
      slider.classList.toggle("switch-positive", checkbox.checked);
      slider.classList.toggle("switch-negative", !checkbox.checked);
    });
  };

  loadSwitchStyles();

  // Add headlines to groups
  const addHeadlines = () => {
    const groups = document.querySelectorAll(".filter-group");
    const headlines = [genInputsHeadline, reviewsHeadline, changeManagementHeadline, upgradeHeadline];
    groups.forEach((group, index) => {
      const headline = document.createElement("div");
      headline.innerHTML = headlines[index];
      group.insertAdjacentElement("beforebegin", headline);
    });
  };

  addHeadlines();

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
