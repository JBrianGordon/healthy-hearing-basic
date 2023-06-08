import './common';
import '../modules/wordcount';

// Form submission
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
  e.preventDefault();
  const submitInputs = document.querySelectorAll('input[type="submit"]');
  submitInputs.forEach(input => {
    input.disabled = true;
    input.value = 'Sending...';
  });
});

// Contact hearing care professional
const contactHearingCareProfessional = document.getElementById('ContactHearingCareProfessional');
const contactCompany = document.getElementById('ContactCompany');
contactHearingCareProfessional.addEventListener('click', function() {
  if (this.checked) {
    contactCompany.style.display = 'block';
  } else {
    contactCompany.style.display = 'none';
  }
});

// Add reCAPTCHA script on form click
const pageContactUsForm = document.getElementById('PageContactUsForm');
const pageContactUsFormInputs = document.querySelectorAll('#PageContactUsForm input');
pageContactUsFormInputs.forEach(input => {
  input.addEventListener('focus', function() {
    if (!pageContactUsForm.classList.contains('focused')) {
      pageContactUsForm.classList.add('focused');
      const recaptchaScript = document.createElement('script');
      recaptchaScript.src = 'https://www.google.com/recaptcha/api.js';
      document.head.appendChild(recaptchaScript);
      pageContactUsFormInputs.forEach(input => input.removeEventListener('focus'));
      const recaptchaCheck = setInterval(function() {
        if (document.querySelector('.grecaptcha-badge')) {
          const grecaptchaBadge = document.querySelector('.grecaptcha-badge');
          const submitInput = document.querySelector('input[data-callback="onSubmit"]');
          submitInput.parentNode.insertBefore(grecaptchaBadge, submitInput.nextSibling);
          clearInterval(recaptchaCheck);
        }
      }, 250);
    }
  });
});

// Form submission callback
window.onSubmit = token => {
  document.getElementById('g-recaptcha-response').value = token;
  document.getElementById('PageContactUsForm').submit();
};
