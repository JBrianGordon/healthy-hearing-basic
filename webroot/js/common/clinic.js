import './appt_request';
// import './location_review';
import {directBookBtn} from './direct_book_btn';
import './common';

directBookBtn();

class Clinic {
  constructor() {
    this.time = null;
    this.start_time();
  }

  start_time() {
    this.time = new Date();
  }

  diff_time() {
    const now = new Date();
    return Math.round((now - this.time) * 0.001);
  }
}

const clinic = new Clinic();

document.addEventListener('DOMContentLoaded', () => {

	window.addEventListener('hashchange', () => {
	  const offset = window.pageYOffset;
	  window.scrollTo({
	    top: offset - 70,
	    behavior: 'smooth'
	  });
	});

	// Rearrange clinic elements on mobile
	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
	  const disclaimer = document.getElementById('disclaimer');
	  const callClinic = document.getElementById('callClinic');
	  disclaimer.parentNode.insertBefore(callClinic, disclaimer);
	}

	// EarQ and ida link functionality
	const earqLinks = document.querySelectorAll('.earq-link, .ida-link');
	earqLinks.forEach(link => {
	  link.addEventListener('click', e => {
	    e.preventDefault();
	    const targetDiv = link.getAttribute('href');
	    const closingAnimation = document.querySelectorAll('.closing-animation');
	    closingAnimation.forEach(element => element.classList.remove('closing-animation'));
	    window.scrollTo({
	      top: document.querySelector(targetDiv).offsetTop,
	      behavior: 'smooth'
	    });
	  });
	});
	
	// Add Google Maps link to Get Directions button
	const clinicAddr = document.querySelector(".address").textContent.trim().replace(/ /g, "+").replace("#", "");
	const directionsLink = document.querySelector(".directions-link");
	if(directionsLink){
		directionsLink.href = `https://www.google.com/maps/dir//${clinicAddr}`;
	}

	// Add recaptcha script on form click
	const formInputs = Array.from(document.querySelectorAll("#CaCallApptRequestForm input"));
	formInputs.forEach(input => {
	  input.addEventListener("focus", function handleFocus() {
	    if (!document.getElementById("CaCallApptRequestForm").classList.contains("focused")) {
	      document.getElementById("CaCallApptRequestForm").classList.add("focused");
	      const recaptchaScript = document.createElement('script');
	      recaptchaScript.src = 'https://www.google.com/recaptcha/api.js';
	      document.head.appendChild(recaptchaScript);
	      input.removeEventListener("focus", handleFocus);
	    }
	  });
	});

	const moreReviewsContainer = document.getElementById("more-reviews");
	if(moreReviewsContainer){
		const hiddenReviews = Array.from(moreReviewsContainer.querySelectorAll(".well"));

		hiddenReviews.forEach(review => {
		  review.classList.add("hidden-review");
		});

		const moreReviewsButton = document.getElementById("more-reviews-button");
		const fewerReviewsButton = document.getElementById("fewer-reviews-button");
		const hiddenReviewElements = Array.from(document.querySelectorAll(".hidden-review"));
		let hiddenRevNum = hiddenReviewElements.length;
		let hiddenIndex = 0;

		moreReviewsButton.addEventListener("click", function(e) {
			e.preventDefault();
		  fewerReviewsButton.style.display = "block";

		  for (let i = 0; i < 5; i++) {
		    hiddenReviewElements[hiddenIndex].classList.remove("hidden-review");
		    hiddenRevNum--;
		    hiddenIndex++;

		    if (hiddenRevNum === 0) {
		      moreReviewsButton.style.display = "none";
		      break;
		    }
		  }

		  const moreReviewsContainer = document.getElementById("more-reviews");
		  moreReviewsContainer.style.display = "block";

		  return false;
		});

		fewerReviewsButton.addEventListener("click", function(e) {
			e.preventDefault();
		  moreReviewsContainer.style.display = "none";
		  hiddenIndex = 0;

		  this.style.display = "none";

		  moreReviewsButton.style.display = "block";

		  window.scrollTo({
		    top: document.querySelector(".panel-section.reviews").offsetTop + 1114,
		    behavior: "smooth"
		  });

		  setTimeout(function() {
		    hiddenReviewElements.forEach(element => {
		      element.classList.add("hidden-review");
		    });
		    hiddenRevNum = document.querySelectorAll(".hidden-review").length;
		  }, 1100);

		  return false;
		});
	}
	
	const newestArr = Array.from(document.querySelectorAll(".well"));
	const ratingArr = [];

	const sortReviews = (chosenArray) => {
	  chosenArray.forEach((review, i) => {
	    if (document.getElementById("more-reviews")) {
	      if (i < 5) {
	        review.classList.remove("hidden-review");
	        document.getElementById("more-reviews").insertAdjacentElement("beforebegin", review);
	      } else {
	        review.classList.add("hidden-review");
	        document.getElementById("more-reviews").appendChild(review);
	      }
	    } else {
	      document.querySelector(".panel-section.reviews").appendChild(review);
	    }
	  });

	  document.getElementById("more-reviews-button").style.display = "block";
	  document.getElementById("fewer-reviews-button").style.display = "none";
	};

	const sortByRating = (chosenRating) => {
	  const ratingArray = [];
	  const fiveStar = [];
	  const fourHalfStar = [];
	  const fourStar = [];
	  const threeHalfStar = [];
	  const threeStar = [];
	  const twoHalfStar = [];
	  const twoStar = [];
	  const oneHalfStar = [];
	  const oneStar = [];

	  newestArr.forEach((review) => {
	    const fullStars = review.getElementsByClassName("hh-icon-full-star").length;
	    const halfStars = review.getElementsByClassName("hh-icon-half-star").length;

	    if (fullStars === 5) {
	      fiveStar.push(review);
	    } else if (fullStars === 4 && halfStars === 1) {
	      fourHalfStar.push(review);
	    } else if (fullStars === 4) {
	      fourStar.push(review);
	    } else if (fullStars === 3 && halfStars === 1) {
	      threeHalfStar.push(review);
	    } else if (fullStars === 3) {
	      threeStar.push(review);
	    } else if (fullStars === 2 && halfStars === 1) {
	      twoHalfStar.push(review);
	    } else if (fullStars === 2) {
	      twoStar.push(review);
	    } else if (fullStars === 1 && halfStars === 1) {
	      oneHalfStar.push(review);
	    } else if (fullStars === 1) {
	      oneStar.push(review);
	    }
	  });

	  if (chosenRating === "lowestRating") {
	    ratingArray.push(oneStar.concat(oneHalfStar.concat(twoStar.concat(twoHalfStar.concat(threeStar.concat(threeHalfStar.concat(fourStar.concat(fourHalfStar.concat(fiveStar)))))))));
	  } else {
	    ratingArray.push(fiveStar.concat(fourHalfStar.concat(fourStar.concat(threeHalfStar.concat(threeStar.concat(twoHalfStar.concat(twoStar.concat(oneHalfStar.concat(oneStar)))))))));
	  }

	  const sortedRatingArray = sortReviews(ratingArray[0]);
	  return sortedRatingArray;
	};
	
	const sortSelect = document.getElementById("sortSelect");

	if(sortSelect){
		sortSelect.addEventListener("change", function() {
		  if (this.value === "newestArr") {
		    sortReviews(newestArr);
		  } else {
		    sortByRating(this.value);
		  }
		});
	}
	
	/*** TODO: uncomment once "Open now!"" is pulled in on view: ***
	const clinicIsOpen = document.querySelector(".hours span").classList.contains("open");
	const currentDate = new Date();
	const currentDay = currentDate.getDay();
	const dayArray = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	const dayElement = Array.from(document.querySelectorAll("tr")).find(row =>
	  row.textContent.includes(dayArray[currentDay])
	);

	if (clinicIsOpen) {
	  dayElement.style.color = "#065903";
	  dayElement.style.backgroundColor = "#eff5f5";
	  dayElement.style.fontWeight = "bold";
	}*/
	
	const caCallGroupEmail = document.getElementById("CaCallGroupEmail");
	if(caCallGroupEmail){
		caCallGroupEmail.addEventListener("change", function() {
		  const pattern = new RegExp('[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}');
		  if (pattern.test(this.value)) {
		    this.setCustomValidity("");
		  } else {
		    this.setCustomValidity("Please enter a valid email address.");
		  }
		});
	}

	const caCallGroupCallerPhone = document.getElementById("CaCallGroupCallerPhone");
	if(caCallGroupCallerPhone){
		caCallGroupCallerPhone.addEventListener("change", function() {
		  // Phone number must be at least 10 numerical digits
		  const digits = this.value.replace(/\D/g, '');
		  if (digits.length < 10) {
		    this.setCustomValidity('Please enter a valid phone number.');
		  } else {
		    this.setCustomValidity('');
		  }
		});
	}
	
	const credList = {
	  "AuD": "Doctor of Audiology",
	  "BC-HIS": "Board Certified in Hearing Instrument Sciences",
	  "CCC-A/SLP": "Certificate of Clinical Competence in Audiology/Speech Language Pathology",
	  "CCC-A": "Certificate of Clinical Competence in Audiology",
	  "FAAA": "Fellow of the American Academy of Audiology",
	  "HAD": "Hearing Aid Dispenser/Dealer",
	  "HIS": "Hearing Instrument Specialist",
	  "LHIS": "Licensed Hearing Instrument Specialist",
	  "MA": "Master of Arts",
	  "MD": "Medical Doctor",
	  "MS": "Master of Science",
	  "PhD": "Doctor of Philosophy"
	};

	const providerQualifications = document.querySelectorAll(".provider-qualifications");
	for (let i = 0; i < providerQualifications.length; i++) {
	  const credArray = providerQualifications[i].innerHTML.replace(/\s+/g, '').replace(/\./g, '').split(",");
	  let popoverData = '';
	  for (let j = 0; j < credArray.length; j++) {
	    const currentCred = credArray[j];
	    if (credList[currentCred] !== undefined) {
	      popoverData += "<span class='cred-text'>" + currentCred + ' - ' + credList[currentCred] + '</span><br>';
	    }
	  }
	  if (popoverData !== "") {
	    const popoverElement = document.querySelector(".cred-popover-" + i);
	    popoverElement.setAttribute("data-content", popoverData);
	  } else {
	    const emptyPopoverElement = document.querySelector(".cred-popover-" + i);
	    if (emptyPopoverElement) {
	      emptyPopoverElement.remove();
	    }
	  }
	}

	const emptyLinks = document.querySelectorAll(".provider-qualifications a[data-bs-content='']");
	emptyLinks.forEach(function(link) {
	  link.remove();
	});
	
	const isInViewport = function (element) {
	  const elementTop = element.offsetTop;
	  const elementBottom = elementTop + element.offsetHeight;
	  const viewportTop = window.pageYOffset || document.documentElement.scrollTop;
	  const viewportBottom = viewportTop + window.innerHeight;

	  return elementBottom > viewportTop && elementTop < viewportBottom;
	};
	
	//photo gallery functions
	const photoGallery = document.querySelector('.photo-gallery');

	if (photoGallery) {
		
		const photoButtons = document.querySelectorAll('.photo-button');

		for (let i = 0; i < photoButtons.length; i++) {
		  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		    photoButtons[i].disabled = true;
		  }
		  if (photoButtons.length === 1) {
		    photoButtons[i].classList.add('col-xs-12', 'col-sm-6', 'offset-sm-3');
		    photoButtons[i].disabled = true;
		    break;
		  } else if (photoButtons.length === 2) {
		    photoButtons[i].classList.add('col-xs-12', 'col-sm-6');
		    photoButtons[i].disabled = true;
		  } else if (photoButtons.length === 3) {
		    photoButtons[i].disabled = true;
		  } else if (i < 3) {
		    photoButtons[i].classList.add('col-xs-12', 'col-sm-4');
		  } else {
		    photoButtons[i].classList.add('hidden');
		  }
		}

		if (photoButtons.length > 3) {
		  const galleryButton = document.createElement('button');
		  galleryButton.id = 'galleryButton';
		  galleryButton.className = 'btn btn-secondary mt20';
		  galleryButton.style.margin = '20px auto';
		  galleryButton.style.display = 'block';
		  galleryButton.style.clear = 'both';
		  galleryButton.setAttribute('data-target', '#photoModal');
		  galleryButton.textContent = 'View more photos';

		  photoGallery.after(galleryButton);

		  galleryButton.addEventListener('click', function () {
		    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && document.querySelectorAll('.photo-button.hidden').length < 1) {
		      for (let i = 3; i < photoButtons.length; i++) {
		        photoButtons[i].classList.add('hidden');
		      }
		      galleryButton.textContent = 'View more photos';
		    } else if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && photoButtons.length >= 4) {
		      const hiddenButtons = document.querySelectorAll('.photo-button.hidden');
		      for (let i = 0; i < hiddenButtons.length; i++) {
		        hiddenButtons[i].classList.remove('hidden');
		      }
		      galleryButton.textContent = 'View fewer photos';
		    } else {
		      const photoModal = document.querySelector('#photoModal');
		      photoModal.classList.add('in');
		      photoModal.style.display = 'block';
		    }
		  });

		  const closeButtons = document.querySelectorAll('#photoModal .close');
		  for (let i = 0; i < closeButtons.length; i++) {
		    closeButtons[i].addEventListener('click', function () {
		      const photoModal = document.querySelector('#photoModal');
		      photoModal.classList.remove('in');
		      photoModal.style.display = 'none';
		    });
		  }
		}

		
		const modalBody = document.querySelector('.modal-body');

		photoGallery.style.width = '100%';
		photoGallery.style.margin = '0';

		window.addEventListener('orientationchange', function () {
		  setTimeout(function () {
		    setArrow('.photo-gallery');
		  }, 200);
		});

		const photoModal = document.querySelector('#photoModal');
		photoModal.addEventListener('click', function () {
		  setTimeout(function () {
		    if (!document.body.classList.contains('modal-open')) {
		      const photoButtons = document.querySelectorAll('.photo-button');
		      for (let i = 0; i < photoButtons.length; i++) {
		        photoButtons[i].removeAttribute('disabled');
		      }

		      if (/Android|webOS|iPhone|iPad/i.test(navigator.userAgent)) {
		        const stickyFooter = document.querySelector('.sticky-footer');
		        stickyFooter.style.display = 'block';
		      }
		    }
		  }, 500);
		});
	}
});

window.addEventListener('load', function () {
  var source = 'unknown';
  var match = document.cookie.match(/utmcsr=(.*?)[|]/);
  if (match) {
    source = match[1];
    source = source.replace(/[()]/g, '');
  }
  var medium = 'unknown';
  match = document.cookie.match(/utmcmd=(.*?)[|]/);
  if (match) {
    medium = match[1];
    medium = medium.replace(/[()]/g, '');
  }
  document.querySelectorAll('CaCallGroup[traffic_source]').value = source;
  document.querySelectorAll('CaCallGroup[traffic_medium]').value = medium;
});
