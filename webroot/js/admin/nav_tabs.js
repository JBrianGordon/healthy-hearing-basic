/*** TODO: Make sure inactive tab content is hidden in views ***/
document.addEventListener('DOMContentLoaded', function() {

  // On submit, make any validation errors on tabs visible
  document.querySelectorAll('input[type=submit]').forEach(submitBtn => {
    submitBtn.addEventListener('click', function() {
      const form = this.closest('form');
      if (form && !form.checkValidity()) {
        displayErrorsOnTabs();
      }
    });
  });

  // Make validation errors on tabs more visible
  function displayErrorsOnTabs() {
    document.querySelectorAll('input:invalid').forEach(input => {
      const parentDiv = input.parentElement;
      if (parentDiv) {
        parentDiv.classList.add('has-error');
      }
    });
    document.querySelectorAll('input.form-error').forEach(input => {
      const parentDiv = input.parentElement;
      if (parentDiv) {
        parentDiv.classList.add('has-error');
      }
    });
    document.querySelectorAll('.nav-tabs li button').forEach(button => {
      const tab = document.querySelector(button.getAttribute('data-bs-target'));
      if (tab && (tab.querySelector('div.has-error') || tab.querySelector('span.has-error') || tab.querySelector('input.form-error'))) {
        button.classList.add('tab-has-error');
        button.click();
      }
    });
  }
});