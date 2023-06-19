/*** TODO: Make sure inactive tab content is hidden in views ***/
document.addEventListener('DOMContentLoaded', function() {

  // Display the selected tab
  const hash = window.location.hash;
  if (hash.length > 0) {
    const parentTabId = document.querySelector(`a[href="${hash}"]`).closest('.tab-pane')?.id;
    if (typeof parentTabId !== 'undefined') {
      // If tab is nested with a parent tab, click both
      document.querySelector(`a[href="#${parentTabId}"]`)?.click();
    }
    document.querySelector(`a[href="${hash}"]`)?.click();
  }

  // When a tab is clicked, change the URL to our new hash
  document.querySelectorAll('.nav-tabs a').forEach(link => {
    link.addEventListener('click', function() {
      const scrollmem = document.body.scrollTop || document.documentElement.scrollTop;
      window.location.hash = this.hash;
      document.documentElement.scrollTop = document.body.scrollTop = scrollmem;
    });
  });

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
    document.querySelectorAll('.nav-tabs li a').forEach(link => {
      const tab = document.querySelector(link.getAttribute('href'));
      if (tab && (tab.querySelector('div.has-error') || tab.querySelector('span.has-error') || tab.querySelector('input.form-error'))) {
        link.classList.add('tab-has-error');
        link.click();
      }
    });
  }
});