import './common';
import './appt_request';
import {directBookBtn} from './direct_book_btn';
//not importing until we decide to use it again
//import './responsive_slider';

directBookBtn();

const quickLinks = document.querySelectorAll(".quickLink");

quickLinks.forEach(link => {
  link.addEventListener("click", function(e) {
    e.preventDefault();
    const targetDiv = this.getAttribute("href");
    const navbarHeight = document.querySelector(".navbar").offsetHeight;

    window.scrollTo({
      top: document.querySelector(targetDiv).offsetTop - navbarHeight,
      behavior: "smooth"
    });
  });
});

const windowHeight = window.innerHeight;
const footerContainer = document.getElementById("footerContainer");
const footerHeight = footerContainer.offsetHeight;
const contentContainer = document.getElementById("top");

function scrollCheck() {
  const contentWidth = contentContainer.offsetWidth;
  const contentOffset = contentContainer.getBoundingClientRect();
  const backToTopLeftPosition = contentOffset.left + contentWidth - 125;
  const backToTopRightPosition = window.outerWidth + 125;

  if (window.scrollY > windowHeight) {
    document.getElementById("backToTop").style.left = backToTopLeftPosition + "px";
  } else {
    document.getElementById("backToTop").style.left = backToTopRightPosition + "px";
  }
}

const scrollCheckInterval = setInterval(scrollCheck, 1000);
const backToTopButton = document.getElementById("backToTop");

backToTopButton.style.bottom = footerHeight + 10 + "px";

document.addEventListener("focus", function handleFocus(e) {
  const target = e.target;
  if (target.matches("#CaCallApptRequestForm input") && !document.getElementById("CaCallApptRequestForm").classList.contains("focused")) {
    document.getElementById("CaCallApptRequestForm").classList.add("focused");
    const recaptchaScript = document.createElement("script");
    recaptchaScript.src = "https://www.google.com/recaptcha/api.js";
    document.head.appendChild(recaptchaScript);
    target.removeEventListener("focus", handleFocus);
  }
}, true);
