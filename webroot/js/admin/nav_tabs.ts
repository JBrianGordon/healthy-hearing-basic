document.addEventListener('DOMContentLoaded', function (): void {
  // Display the selected tab
  const hash: string = window.location.hash;
  if (hash.length > 0) {
    const tab = document.querySelector<HTMLButtonElement>(`button[data-bs-target='${hash}']`);
    if (tab) {
      const parentTabPane = tab.closest<HTMLElement>('.tab-pane');
      if (parentTabPane) {
        // If tab is nested with a parent tab, click both
        const parentTab = document.querySelector<HTMLButtonElement>(`button[data-bs-target='#${parentTabPane.id}']`);
        if (parentTab) {
          parentTab.click();
        }
      }
      tab.click();
    }
  }

  // When a tab is clicked, change the URL to our new hash
  document.querySelectorAll<HTMLButtonElement>('button.nav-link').forEach((tabButton: HTMLButtonElement): void => {
    tabButton.addEventListener('click', function (this: HTMLButtonElement): void {
      const hash: string | null = this.getAttribute('data-bs-target');
      if (hash) {
        // Add a history entry and change the URL without causing the browser to navigate to the new URL
        history.pushState(null, '', hash);
      }
    });
  });

  // On submit, make any validation errors on tabs visible
  document.querySelectorAll<HTMLInputElement | HTMLButtonElement>('input[type=submit], button[type=submit]').forEach((submitBtn: HTMLInputElement | HTMLButtonElement): void => {
    submitBtn.addEventListener('click', function (this: HTMLInputElement | HTMLButtonElement): void {
      const form = this.closest<HTMLFormElement>('form');
      if (form && !form.checkValidity()) {
        displayErrorsOnTabs();
      }
    });
  });

  // Make validation errors on tabs more visible
  function displayErrorsOnTabs(): void {
    document.querySelectorAll<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>('input:invalid, textarea:invalid, select:invalid, input.form-error, textarea.form-error, select.form-error').forEach((input: HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement): void => {
      const parentDiv = input.parentElement;
      if (parentDiv) {
        parentDiv.classList.add('has-error');
      }
    });

    document.querySelectorAll<HTMLButtonElement>('.nav-tabs li button').forEach((button: HTMLButtonElement): void => {
      const targetSelector: string | null = button.getAttribute('data-bs-target');
      if (targetSelector) {
        const tab = document.querySelector<HTMLElement>(targetSelector);
        if (tab && (tab.querySelector('div.has-error') || tab.querySelector('span.has-error') || tab.querySelector('input.form-error'))) {
          button.classList.add('tab-has-error');
          button.click();
        }
      }
    });
  }
});