import './common';
import '../modules/wordcount';

// Form submission
const form = document.querySelector<HTMLFormElement>('form');
if (form) {
  form.addEventListener('submit', function (e: Event) {
    e.preventDefault();
    const submitInputs = document.querySelectorAll<HTMLInputElement>('input[type="submit"]');
    submitInputs.forEach(input => {
      input.disabled = true;
      input.value = 'Sending...';
    });
  });
}

// Contact hearing care professional
const contactHearingCareProfessional = document.getElementById('ContactHearingCareProfessional') as HTMLInputElement;
const contactCompany = document.getElementById('ContactCompany') as HTMLElement;

if (contactHearingCareProfessional && contactCompany) {
  contactHearingCareProfessional.addEventListener('click', function () {
    if (this.checked) {
      contactCompany.style.display = 'block';
    } else {
      contactCompany.style.display = 'none';
    }
  });
}

// Add reCAPTCHA script on form click
const pageContactUsForm = document.getElementById('PageContactUsForm') as HTMLFormElement;
const pageContactUsFormInputs = document.querySelectorAll<HTMLInputElement>('#PageContactUsForm input');
let isFocused = false;

if (pageContactUsForm) {
  pageContactUsFormInputs.forEach(input => {
    input.addEventListener('focus', function () {
      if (!isFocused) {
        isFocused = true;
        if (!pageContactUsForm.classList.contains('focused')) {
          pageContactUsForm.classList.add('focused');
          const recaptchaScript = document.createElement('script');
          recaptchaScript.src = 'https://www.google.com/recaptcha/api.js';
          document.head.appendChild(recaptchaScript);

          const recaptchaCheck = setInterval(function () {
            const grecaptchaBadge = document.querySelector<HTMLElement>('.grecaptcha-badge');
            if (grecaptchaBadge) {
              const submitInput = document.querySelector<HTMLInputElement>('input[data-callback="onSubmit"]');
              if (submitInput && submitInput.parentNode) {
                submitInput.parentNode.insertBefore(grecaptchaBadge, submitInput.nextSibling);
              }
              clearInterval(recaptchaCheck);
            }
          }, 250);
        }
      }
    });
  });
}

// Form submission callback
declare global {
  interface Window {
    onSubmit: (token: string) => void;
  }
}

window.onSubmit = (token: string): void => {
  const recaptchaResponse = document.getElementById('g-recaptcha-response') as HTMLInputElement;
  const contactForm = document.getElementById('PageContactUsForm') as HTMLFormElement;

  if (recaptchaResponse) {
    recaptchaResponse.value = token;
  }

  if (contactForm) {
    contactForm.submit();
  }
};