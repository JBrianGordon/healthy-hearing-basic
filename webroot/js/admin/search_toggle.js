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
    if (this.options.toggle_text_id) {
      this.search_text = document.querySelector(this.options.toggle_text_id);
    } else {
      this.search_text = document.querySelector(this.options.toggle_id);
    }

    this.search_toggle.addEventListener('click', this.toggleSearch.bind(this));
  }

  toggleSearch(event) {
    if (this.advanced_search.style.display === 'block') {
      this.search_text.textContent = '+';
      this.advanced_search.style.display = 'none';
    } else {
      this.search_text.textContent = '-';
      this.advanced_search.style.display = 'block';
    }
  }
}

// Check for search toggle element on page
const adminSearchToggle = document.querySelector('#admin_search_toggle');
const advancedSearchToggle = document.querySelector('#advanced_search_toggle');

if (adminSearchToggle) {
  new SearchToggle({ toggle_id: "#admin_search_toggle", elem_id: "#admin_search", toggle_text_id: "#admin_search_text" });
}

if (advancedSearchToggle) {
  new SearchToggle({ toggle_id: "#advanced_search_toggle", elem_id: "#advanced_search", toggle_text_id: "#advanced_search_text" });
}

// Reorganize search options and change booleans into a toggle
const formAction = document.querySelector("form").getAttribute("action");

export const locations_crm_searches = () => {
	if (formAction.includes("/admin/locations") || formAction.includes("/admin/crm-searches")) {
	  const generalInputs = document.createElement("div");
	  const reviewInputs = document.createElement("div");
	  const managementInputs = document.createElement("div");
	  const upgrades = document.createElement("div");
	  const genInputsHeadline = "<div><h3 class='crm-group-header'>General demographics</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-minus'></span> Collapse section</span></div>";
	  const reviewsHeadline = "<div><h3 class='crm-group-header'>Reviews</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span> Expand section</span></div>";
	  const changeManagementHeadline = "<div><h3 class='crm-group-header'>Change management</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span> Expand section</span></div>";
	  const upgradeHeadline = "<div><h3 class='crm-group-header'>Upgrade Features</h3><span class='group-toggle btn btn-primary btn-sm'><span class='glyphicon glyphicon-plus'></span> Expand section</span></div>";
	  
	  generalInputs.classList.add("filter-group");
	  reviewInputs.classList.add("filter-group", "hidden");
	  managementInputs.classList.add("filter-group", "hidden");
	  upgrades.classList.add("filter-group", "hidden");
			
		//send form groups to proper parent divs
		const arrangeInputs = (modalToggleField, inputGroup) => {
		  modalToggleField.forEach((field) => {
		    field.closest(".form-group").appendTo(inputGroup);
		  });
		};

		const generalFields = [document.querySelector("#SearchId"), document.querySelector("#SearchOticonId"), document.querySelector("#SearchParentId"), document.querySelector("#SearchSfId"), document.querySelector("#SearchYhnLocationId"), document.querySelector("#SearchCqpPracticeId"), document.querySelector("#SearchCqpOfficeId"), document.querySelector("#SearchTitle"), document.querySelector("#SearchSubtitle"), document.querySelector("#SearchAddress"), document.querySelector("#SearchAddress2"), document.querySelector("#SearchCity"), document.querySelector("#SearchState"), document.querySelector("#SearchZip"), document.querySelector("#SearchIsMobile"), document.querySelector("#SearchPhone"), document.querySelector("#SearchEmail"), document.querySelector("#SearchListingType"), document.querySelector("#SearchPriority"), document.querySelector("#SearchIsActive"), document.querySelector("#SearchIsShow"), document.querySelector("#SearchIsListingTypeFrozen"), document.querySelector("#SearchOticonTier"), document.querySelector("#SearchYhnTier"), document.querySelector("#SearchCqpTier"), document.querySelector("#SearchListingType"), document.querySelector("#SearchIsOticon"), document.querySelector("#SearchIsRetail"), document.querySelector("#SearchIsYhn"), document.querySelector("#SearchIsCqp"), document.querySelector("#SearchIsHh"), document.querySelector("#SearchIsCqPremier"), document.querySelector("#SearchIsIrisPlus"), document.querySelector("#SearchNotes"), document.querySelector("#SearchFullName"), document.querySelector("#SearchIsBypassed"), document.querySelector("#SearchFilterHasPhoto"), document.querySelector("#SearchFilterInsurance"), document.querySelector("#SearchIsCallAssist"), document.querySelector("#SearchTimezone"), document.querySelector("#SearchHasUrl"), document.querySelector("#SearchNpiNumber"), document.querySelector("#SearchLocationSegment"), document.querySelector("#SearchEntitySegment"), document.querySelector("#SearchDirectBookType"), document.querySelector("#SearchFrozenExpirationStart"), document.querySelector("#SearchIsIdaVerified"), document.querySelector("#SearchIsServiceAgreementSigned"), document.querySelector("#SearchCovid19Statement"), document.querySelector("#SearchIsJunk"), document.querySelector("#SearchIsEmailAllowed")];
		const reviewFields = [document.querySelector("#SearchReviewsApproved"), document.querySelector("#SearchReviewStatus"), document.querySelector("#SearchAverageRating"), document.querySelector("#SearchLastReviewDateStart")];
		const managementFields = [document.querySelector("#SearchModifiedStart"), document.querySelector("#SearchLastContactDate"), document.querySelector("#SearchIsLastEditByOwner"), document.querySelector("#SearchLastEditByOwnerDate"), document.querySelector("#SearchCompleteness"), document.querySelector("#SearchLastNoteStatus"), document.querySelector("#SearchLastImportStatus"), document.querySelector("#SearchIsGracePeriod"), document.querySelector("#SearchGracePeriodEnd"), document.querySelector("#SearchReviewNeeded"), document.querySelector("#SearchEmailStatus"), document.querySelector("#SearchPhoneStatus"), document.querySelector("#SearchAddressStatus"), document.querySelector("#SearchTitleStatus"), document.querySelector("#SearchIsTitleIgnore"), document.querySelector("#SearchIsAddressIgnore"), document.querySelector("#SearchIsPhoneIgnore"), document.querySelector("#SearchIsEmailIgnore")];
		const upgradeFields = [document.querySelector("#SearchFeatureContentLibrary"), document.querySelector("#SearchFeatureSpecialAnnouncement"), document.querySelector("#SearchLogoUrl"), document.querySelector("#SearchBadgeCoffee"), document.querySelector("#SearchBadgeWifi"), document.querySelector("#SearchBadgeParking"), document.querySelector("#SearchBadgeCurbside"), document.querySelector("#SearchBadgeWheelchair"), document.querySelector("#SearchBadgeServicePets"), document.querySelector("#SearchBadgeCochlearImplants"), document.querySelector("#SearchBadgeAld"), document.querySelector("#SearchBadgePediatrics"), document.querySelector("#SearchBadgeMobileClinic"), document.querySelector("#SearchBadgeFinancing"), document.querySelector("#SearchBadgeTelehearing"), document.querySelector("#SearchBadgeAsl"), document.querySelector("#SearchBadgeTinnitus"), document.querySelector("#SearchBadgeBalance"), document.querySelector("#SearchBadgeHome"), document.querySelector("#SearchBadgeRemote"), document.querySelector("#SearchBadgeMask"), document.querySelector("#SearchBadgeSpanish"), document.querySelector("#SearchBadgeFrench"), document.querySelector("#SearchBadgeRussian"), document.querySelector("#SearchBadgeChinese"), document.querySelector("#SearchUsingLogo"), document.querySelector("#SearchUsingPhotos"), document.querySelector("#SearchUsingVideos"), document.querySelector("#SearchUsingBadges"), document.querySelector("#SearchUsingFlexSpace"), document.querySelector("#SearchUsingLinkedLocations")];
			
		arrangeInputs(generalFields, generalInputs);
		arrangeInputs(reviewFields, reviewInputs);
		arrangeInputs(managementFields, managementInputs);
		arrangeInputs(upgradeFields, upgrades);
		generalInputs.prepend(...generalFields);
		reviewInputs.prepend(...reviewFields);
		managementInputs.prepend(...managementFields);
		upgrades.prepend(...upgradeFields);

		document.querySelectorAll(".filter-group").forEach((group) => {
		  if (group.children.length === 0) {
		    group.remove();
		  }
		});

		// Custom labels
		const emailAllowedLabel = document.querySelector("label[for=SearchIsEmailAllowed]");
		emailAllowedLabel.textContent = 'Is profile update email allowed';

		// Change boolean inputs into switches
		const isOticonDropdown = document.querySelector("#SearchIsOticon");
		const isOticonSwitch = document.createElement("label");
		isOticonSwitch.classList.add("switch");
		isOticonSwitch.innerHTML = `
		  <input name="data[Search][is_oticon]" class="form-control" id="SearchIsOticon" type="text">
		  <span class="slider">
		    <span class="switch-negative"></span>
		    <span class="switch-off"></span>
		    <span class="switch-positive"></span>
		  </span>
		`;
		isOticonDropdown.replaceWith(isOticonSwitch);

		const filterGroupInputs = document.querySelectorAll(".filter-group input[placeholder='0 [or] 1']");
		filterGroupInputs.forEach(input => {
		  const switchContainer = document.createElement("label");
		  switchContainer.classList.add("switch");
		  input.parentNode.insertBefore(switchContainer, input);
		  switchContainer.appendChild(input);
		  const slider = document.createElement("span");
		  slider.classList.add("slider");
		  switchContainer.appendChild(slider);
		  slider.innerHTML = `
		    <span class="switch-negative"></span>
		    <span class="switch-off"></span>
		    <span class="switch-positive"></span>
		  `;
		});

		// Add value to hidden inputs when sliders are interacted with
		const sliderSpans = document.querySelectorAll("label .slider span");
		sliderSpans.forEach(span => {
		  span.addEventListener("mouseup", function() {
		    const slideClass = this.classList[0];
		    const input = this.parentNode.parentNode.querySelector("input");
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
		const switchInputs = document.querySelectorAll("label.switch input");
		switchInputs.forEach(input => {
		  if (input.value == 1) {
		    input.classList.add("switch-positive");
		  } else if (input.value !== "") {
		    input.classList.add("switch-negative");
		  }
		});
		
		// Add headlines to groups
		generalInputs.insertAdjacentHTML("beforebegin", genInputsHeadline);
		reviewInputs.insertAdjacentHTML("beforebegin", reviewsHeadline);
		managementInputs.insertAdjacentHTML("beforebegin", changeManagementHeadline);
		upgrades.insertAdjacentHTML("beforebegin", upgradeHeadline);

		// Expand/collapse button functionality
		const groupToggleButtons = document.querySelectorAll(".group-toggle");
		groupToggleButtons.forEach(button => {
		  button.addEventListener("click", function() {
		    const filterGroup = this.closest("div").nextElementSibling;
		    if (filterGroup.classList.contains("hidden")) {
		      this.innerHTML = "<span class='bi-minus-lg'> Collapse section</span>";
		      filterGroup.classList.remove("hidden");
		    } else {
		      this.innerHTML = "<span class='bi-plus-lg'> Expand section</span>";
		      filterGroup.classList.add("hidden");
		    }
		  });
		});
	}
}

// Export button modal and functionality
export const exportButtonFunctions = () => {
	const exportButton = document.getElementById("exportButton");
	const exportModal = document.getElementById("exportModal");
	const exportClose = document.getElementById("exportClose");

	exportButton.addEventListener("click", e => {
	  e.preventDefault();
	  exportModal.style.display = "block";
	  exportModal.classList.add("in");
	});

	exportClose.addEventListener("click", () => {
	  exportModal.style.display = "none";
	  exportModal.classList.remove("in");
	});
}

// Toggle values for switches
export const exportSwitchesFunctions = () => {
	const exportSwitches = document.querySelectorAll("#exportModal .form-control");
	exportSwitches.forEach(switchElement => {
	  switchElement.addEventListener("click", () => {
	    if (this.value === "0") {
	      this.value = "1";
	    } else {
	      this.value = "0";
	    }
	  });
	});
}

// Toggle classes and values for all switches, based on #allFieldsInput active class
export const allFieldsFunctions = () => {
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
}

export const exportSubmissionsFunctions = () => {
	const exportSubmit = document.querySelector("#exportModal #exportSubmit");
	const exportModalFormControls = document.querySelectorAll("#exportModal .form-control");

	exportSubmit.addEventListener("click", function() {
	  const searchAndExcludedFieldArray = exportButton.getAttribute("href").split("/admin/locations/crm").pop();
	  
	  let excludedFields = "";
	  exportModalFormControls.forEach(formControl => {
	    if (formControl.value === "0") {
	      const excludedFieldName = formControl.name;
	      excludedFields += ("/field%5B" + excludedFieldName + "%5D:" + excludedFieldName);
	    }
	  });
	  
	  window.location.pathname = "admin/locations/export" + searchAndExcludedFieldArray + excludedFields + ".csv";
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