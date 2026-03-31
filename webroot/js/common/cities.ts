import './common';
import './appt_request';
import { directBookBtn } from './direct_book_btn';
//not importing until we decide to use it again
//import './responsive_slider';

directBookBtn();

const quickLinks = document.querySelectorAll<HTMLAnchorElement>(".quickLink");

quickLinks.forEach(link => {
  link.addEventListener("click", function (this: HTMLAnchorElement, e: MouseEvent) {
    e.preventDefault();
    const targetDiv = this.getAttribute("href");
    const navbar = document.querySelector<HTMLElement>(".navbar");

    if (!targetDiv || !navbar) return;

    const navbarHeight = navbar.offsetHeight;
    const targetElement = document.querySelector<HTMLElement>(targetDiv);

    if (targetElement) {
      window.scrollTo({
        top: targetElement.offsetTop - navbarHeight,
        behavior: "smooth"
      });
    }
  });
});

const windowHeight = window.innerHeight;
const footerContainer = document.getElementById("footerContainer");
const contentContainer = document.getElementById("top");

if (footerContainer && contentContainer) {
  const footerHeight = footerContainer.offsetHeight;

  function scrollCheck(): void {
    if (!contentContainer) return;

    const contentWidth = contentContainer.offsetWidth;
    const contentOffset = contentContainer.getBoundingClientRect();
    const backToTopLeftPosition = contentOffset.left + contentWidth - 170;
    const backToTopRightPosition = window.outerWidth + 170;
    const backToTopButton = document.getElementById("backToTop");

    if (backToTopButton) {
      if (window.scrollY > windowHeight) {
        backToTopButton.style.left = backToTopLeftPosition + "px";
      } else {
        backToTopButton.style.left = backToTopRightPosition + "px";
      }
    }
  }

  const scrollCheckInterval = setInterval(scrollCheck, 1000);
  const backToTopButton = document.getElementById("backToTop");

  if (backToTopButton) {
    backToTopButton.style.bottom = footerHeight + 10 + "px";
  }
}

document.addEventListener("focus", function handleFocus(e: FocusEvent) {
  const target = e.target as HTMLElement;
  const apptRequestForm = document.getElementById("CaCallApptRequestForm");

  if (target && target.matches && target.matches("#CaCallApptRequestForm input") && apptRequestForm && !apptRequestForm.classList.contains("focused")) {
    apptRequestForm.classList.add("focused");
    const recaptchaScript = document.createElement("script");
    recaptchaScript.src = "https://www.google.com/recaptcha/api.js";
    document.head.appendChild(recaptchaScript);
    target.removeEventListener("focus", handleFocus);
  }
}, true);