/*** TODO: check this once it's pulled into results page ***/
import './common';
import {directBookBtn} from './direct_book_btn';
import './appt_request';
import './responsive_slider';

directBookBtn();

class LocationResults {
	constructor() {
		// Globals
		this.updateDiv = '#clinic-results';
		this.filterResults = '#filter-results';
		this.resultText = '#result-text';
		this.sort = '';
		this.filters = [];
		this.filterString = '';

		if (this.getFilters().length !== 0) {
		  this.submitFilters();
		}
	}

	submitFilters() {
	  const xhr = new XMLHttpRequest();
	  xhr.open('POST', location.pathname);
	  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	  xhr.onload = () => {
	    if (xhr.status === 200) {
	      this.handleRequest(xhr.responseText);
	    } else {
	      console.error('Error:', xhr.status);
	    }
	    // Hide loading indicator
	    document.querySelector('.loading').style.display = 'none';
	  };

	  // Show loading indicator
	  document.querySelector(this.filterResults).innerHTML = '';
	  document.querySelector('.loading').style.display = 'block';

	  const data = new URLSearchParams({
	    f: this.generateFilterString(),
	    s: this.getSort()
	  }).toString();

	  xhr.send(data);
	}

	handleRequest(data, textStatus) {
	  // Update the results
	  document.querySelector(this.updateDiv).innerHTML = data;

	  const filterCount = this.filters.length;
	  const clinics = document.querySelectorAll('.clinic-info').length;
	  let cPlural = 's';
	  if (clinics === 1) {
	    cPlural = '';
	  }
	  let fPlural = 's';
	  if (filterCount === 1) {
	    fPlural = '';
	  }
	  // Update the results text on the top based on clinics found and selections.
	  document.querySelector(this.filterResults).innerHTML = `<i>We found ${clinics} clinic${cPlural} based on your selection${fPlural}.</i> <a href="${location.pathname}" class="btn btn-default btn-xs">Reset</a>`;

	  // Update the error if we have zero clinics based on how many filters we have selected.
	  if (clinics === 0) {
	    if (filterCount === 1) {
	      document.querySelector(this.resultText).innerHTML = '<i>No clinics found with your selection. Please uncheck the filter above.</i>';
	    } else {
	      document.querySelector(this.resultText).innerHTML = '<i>No clinics found with your selections. Please uncheck some filters above.</i>';
	    }
	  }
	}


	getFilters() {
	  const filters = Array.from(document.querySelectorAll('input.filter-box[type="checkbox"]:checked')).map(checkbox => checkbox.value);
	  this.filters = filters;
	  return this.filters;
	}


	getSort() {
	  this.sort = document.querySelector('input.sort-box[type="radio"]:checked').value;
	  return this.sort;
	}

	generateFilterString() {
	  this.getFilters();
	  this.filterString = '[';
	  this.filters.forEach((filter, index) => {
	    if (index !== 0) {
	      this.filterString += ',';
	    }
	    this.filterString += `"${filter}"`;
	  });
	  this.filterString += ']';
	  return this.filterString;
	}

	startListeners() {
	  const filterBoxes = document.querySelectorAll('.filter-box');
	  const sortBoxes = document.querySelectorAll('.sort-box');

	  const submitFilters = () => {
	    this.submitFilters();
	  };

	  filterBoxes.forEach((filterBox) => {
	    filterBox.addEventListener('click', submitFilters);
	  });

	  sortBoxes.forEach((sortBox) => {
	    sortBox.addEventListener('click', submitFilters);
	  });
	}

}

window.LResults = new LocationResults();
LResults.startListeners();

const reviewLinks = document.getElementsByClassName("reviews");
const linkRegex = /\(\d+( Review[s]?)\)/gm;

Array.from(reviewLinks).forEach((reviewLink) => {
  const currentLink = reviewLink.children;
  if (currentLink.length > 0) {
    const linkText = currentLink[0].innerHTML.match(linkRegex);
    if (linkText) {
      const updatedLink = currentLink[0].innerHTML.replace(linkRegex, "");
      const newLink = `<p class='link-text'>${linkText}</p>`;
      currentLink[0].innerHTML = updatedLink + newLink;
    }
  }
});

function handleFocusEvent(e) {
  const apptRequestModal = document.getElementById("apptRequestModal");
  const focusedClass = "focused";
  const recaptchaScript = document.createElement('script');
  recaptchaScript.src = 'https://www.google.com/recaptcha/api.js';

  if (e.target.matches("#apptRequestModal input") && !apptRequestModal.classList.contains(focusedClass)) {
    apptRequestModal.classList.add(focusedClass);
    document.head.appendChild(recaptchaScript);
    document.removeEventListener("focus", handleFocusEvent);
  }
}

document.addEventListener("focus", handleFocusEvent);

function onMessage(e) {
  // Check sender origin to be trusted
  if (e.origin !== "https://booking.myearq.com") return;
  // Do not save appointment if no clinic id
  if (directBookClinicId == 0) return;
  if (e.data.func == "goThankYouAppointment") {
    fetch("/ca_calls/ajax_add_earq_appt/" + directBookClinicId, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(event.data),
    })
      .then(response => response.json())
      .then(data => {
        if (data === "error") {
          console.log('Failed to save EarQ appointment for ' + directBookClinicId);
        }
        directBookClinicId = 0;
      })
      .catch(error => {
        console.log('Failed to save EarQ appointment:', error);
        directBookClinicId = 0;
      });
  }
}
