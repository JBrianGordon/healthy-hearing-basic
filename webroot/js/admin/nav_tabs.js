document.addEventListener('DOMContentLoaded', function() {
  // Display the selected tab
  var hash = window.location.hash;
  if (hash.length > 0) {
    const tab = document.querySelector("button[data-bs-target='"+hash+"']");
    if (tab) {
      var parentTabPane = tab.closest('.tab-pane');
      if (parentTabPane) {
        // If tab is nested with a parent tab, click both
        const parentTab = document.querySelector("button[data-bs-target='#"+parentTabPane.id+"']");
        parentTab.click();
      }
      tab.click();
    }
  }

  // When a tab is clicked, change the URL to our new hash
  document.querySelectorAll('button.nav-link').forEach(tabButton => {
    tabButton.addEventListener('click', function() {
      const hash = this.getAttribute('data-bs-target');
      if (hash) {
        //var scrollmem = $('body').scrollTop() || $('html').scrollTop();
        window.location.hash = hash;
        //$('html,body').scrollTop(scrollmem);
      }
    });
  });

  // On submit, make any validation errors on tabs visible
  document.querySelectorAll('input[type=submit], button[type=submit]').forEach(submitBtn => {
    submitBtn.addEventListener('click', function() {
      const form = this.closest('form');
      if (form && !form.checkValidity()) {
        displayErrorsOnTabs();
      }
    });
  });

  // Make validation errors on tabs more visible
  function displayErrorsOnTabs() {
    document.querySelectorAll('input:invalid, textarea:invalid, select:invalid, input.form-error, textarea.form-error, select.form-error').forEach(input => {
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
