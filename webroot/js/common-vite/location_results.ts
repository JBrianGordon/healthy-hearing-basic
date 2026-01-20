/*** TODO: check this once it's pulled into results page ***/
import './common';
import './appt_request';
import { directBookBtn } from './direct_book_btn';
//import './responsive_slider';

directBookBtn();

declare global {
  interface Window {
    // Commented until either sorting or filtering is needed.
    //LResults: LocationResults;
    directBookClinicId: number;
  }
}

// Commented until either sorting or filtering is needed.
// class LocationResults {
//   private updateDiv: string;
//   private filterResults: string;
//   private resultText: string;
//   private sort: string;
//   private filters: string[];
//   private filterString: string;

//   constructor() {
//     // Globals
//     this.updateDiv = '#clinic-results';
//     this.filterResults = '#filter-results';
//     this.resultText = '#result-text';
//     this.sort = '';
//     this.filters = [];
//     this.filterString = '';

//     if (this.getFilters().length !== 0) {
//       this.submitFilters();
//     }
//   }

//   submitFilters(): void {
//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', location.pathname);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//     xhr.onload = () => {
//       if (xhr.status === 200) {
//         this.handleRequest(xhr.responseText);
//       } else {
//         console.error('Error:', xhr.status);
//       }
//       // Hide loading indicator
//       const loadingElement = document.querySelector<HTMLElement>('.loading');
//       if (loadingElement) {
//         loadingElement.style.display = 'none';
//       }
//     };

//     // Show loading indicator
//     const filterResultsElement = document.querySelector<HTMLElement>(this.filterResults);
//     const loadingElement = document.querySelector<HTMLElement>('.loading');

//     if (filterResultsElement) {
//       filterResultsElement.innerHTML = '';
//     }
//     if (loadingElement) {
//       loadingElement.style.display = 'block';
//     }

//     const data = new URLSearchParams({
//       f: this.generateFilterString(),
//       s: this.getSort()
//     }).toString();

//     xhr.send(data);
//   }

//   handleRequest(data: string): void {
//     // Update the results
//     const updateElement = document.querySelector<HTMLElement>(this.updateDiv);
//     if (updateElement) {
//       updateElement.innerHTML = data;
//     }

//     const filterCount = this.filters.length;
//     const clinics = document.querySelectorAll('.clinic-info').length;
//     let cPlural = 's';
//     if (clinics === 1) {
//       cPlural = '';
//     }
//     let fPlural = 's';
//     if (filterCount === 1) {
//       fPlural = '';
//     }

//     // Update the results text on the top based on clinics found and selections.
//     const filterResultsElement = document.querySelector<HTMLElement>(this.filterResults);
//     if (filterResultsElement) {
//       filterResultsElement.innerHTML = `<i>We found ${clinics} clinic${cPlural} based on your selection${fPlural}.</i> <a href="${location.pathname}" class="btn btn-default btn-xs">Reset</a>`;
//     }

//     // Update the error if we have zero clinics based on how many filters we have selected.
//     if (clinics === 0) {
//       const resultTextElement = document.querySelector<HTMLElement>(this.resultText);
//       if (resultTextElement) {
//         if (filterCount === 1) {
//           resultTextElement.innerHTML = '<i>No clinics found with your selection. Please uncheck the filter above.</i>';
//         } else {
//           resultTextElement.innerHTML = '<i>No clinics found with your selections. Please uncheck some filters above.</i>';
//         }
//       }
//     }
//   }

//   getFilters(): string[] {
//     const filters = Array.from(
//       document.querySelectorAll<HTMLInputElement>('input.filter-box[type="checkbox"]:checked')
//     ).map(checkbox => checkbox.value);
//     this.filters = filters;
//     return this.filters;
//   }

//   getSort(): string {
//     const sortElement = document.querySelector<HTMLInputElement>('input.sort-box[type="radio"]:checked');
//     if (sortElement) {
//       this.sort = sortElement.value;
//     }
//     return this.sort;
//   }

//   generateFilterString(): string {
//     this.getFilters();
//     this.filterString = '[';
//     this.filters.forEach((filter, index) => {
//       if (index !== 0) {
//         this.filterString += ',';
//       }
//       this.filterString += `"${filter}"`;
//     });
//     this.filterString += ']';
//     return this.filterString;
//   }

//   startListeners(): void {
//     const filterBoxes = document.querySelectorAll<HTMLInputElement>('.filter-box');
//     const sortBoxes = document.querySelectorAll<HTMLInputElement>('.sort-box');

//     const submitFilters = (): void => {
//       this.submitFilters();
//     };

//     filterBoxes.forEach((filterBox) => {
//       filterBox.addEventListener('click', submitFilters);
//     });

//     sortBoxes.forEach((sortBox) => {
//       sortBox.addEventListener('click', submitFilters);
//     });
//   }
// }

//window.LResults = new LocationResults();
//window.LResults.startListeners();

const reviewLinks = document.getElementsByClassName("reviews");
const linkRegex = /\(\d+( Review[s]?)\)/gm;

Array.from(reviewLinks).forEach((reviewLink) => {
  const currentLink = reviewLink.children;
  if (currentLink.length > 0) {
    const linkElement = currentLink[0] as HTMLElement;
    const linkText = linkElement.innerHTML.match(linkRegex);
    if (linkText) {
      const updatedLink = linkElement.innerHTML.replace(linkRegex, "");
      const newLink = `<p class='link-text'>${linkText}</p>`;
      linkElement.innerHTML = updatedLink + newLink;
    }
  }
});

function handleFocusEvent(e: FocusEvent): void {
  const apptRequestModal = document.getElementById("apptRequestModal");
  const focusedClass = "focused";
  const target = e.target as HTMLElement;

  if (target && target.matches && target.matches("#apptRequestModal input") && apptRequestModal && !apptRequestModal.classList.contains(focusedClass)) {
    apptRequestModal.classList.add(focusedClass);
    const recaptchaScript = document.createElement('script');
    recaptchaScript.src = 'https://www.google.com/recaptcha/api.js';
    document.head.appendChild(recaptchaScript);
    document.removeEventListener("focus", handleFocusEvent, true);
  }
}

document.addEventListener("focus", handleFocusEvent, true);

function onMessage(e: MessageEvent): void {
  // Check sender origin to be trusted
  if (e.origin !== "https://booking.myearq.com") return;
  // Do not save appointment if no clinic id
  if (typeof window.directBookClinicId === 'undefined' || window.directBookClinicId === 0) return;

  if (e.data.func === "goThankYouAppointment") {
    fetch(`/ca_calls/ajax_add_earq_appt/${window.directBookClinicId}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(e.data),
    })
      .then(response => response.json())
      .then((data: string) => {
        if (data === "error") {
          console.log(`Failed to save EarQ appointment for ${window.directBookClinicId}`);
        }
        window.directBookClinicId = 0;
      })
      .catch((error: Error) => {
        console.log('Failed to save EarQ appointment:', error);
        window.directBookClinicId = 0;
      });
  }
}

window.addEventListener("message", onMessage, false);