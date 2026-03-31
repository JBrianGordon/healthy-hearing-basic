import '../common/common';

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll<HTMLElement>('.js-copy-left').forEach(element => {
    element.addEventListener('click', function (this: HTMLElement) {
      copyLeft(this);
      return false;
    });
  });

  document.querySelectorAll<HTMLElement>('.js-link').forEach(element => {
    element.addEventListener('click', function (this: HTMLElement) {
      link(this);
      return false;
    });
  });

  document.querySelectorAll<HTMLElement>('.js-add-all').forEach(element => {
    element.addEventListener('click', function () {
      addAll();
      return false;
    });
  });

  document.querySelectorAll<HTMLElement>('.js-add-provider').forEach(element => {
    element.addEventListener('click', function (this: HTMLElement) {
      addProvider(this);
      return false;
    });
  });

  document.querySelectorAll<HTMLElement>('.js-link-delete').forEach(element => {
    element.addEventListener('click', function (this: HTMLElement) {
      deleteProvider(this);
      return false;
    });
  });

  document.querySelectorAll<HTMLElement>('.js-link-cancel').forEach(element => {
    element.addEventListener('click', function (this: HTMLElement) {
      linkCancel(this);
      return false;
    });
  });

  highlightDifferences();
});

function copyLeft(obj: HTMLElement): boolean {
  const parent = obj.parentElement;

  if (!parent) {
    console.error('Parent element not found');
    return false;
  }

  const hhInput = parent.previousElementSibling?.querySelector<HTMLInputElement | HTMLTextAreaElement>('input, textarea');
  const yhnInput = parent.nextElementSibling?.querySelector<HTMLInputElement | HTMLTextAreaElement>('input, textarea');

  if (!hhInput || !yhnInput) {
    console.error('Required input elements not found');
    return false;
  }

  // Copy the data from the YHN side
  hhInput.value = yhnInput.value;

  highlightDifferences();
  return false;
}

function link(obj: HTMLElement): void {
  const hhLinkElements = document.querySelectorAll<HTMLElement>('.hh-link, .yhn-link');
  const linkDeleteElements = document.querySelectorAll<HTMLElement>('.js-link-delete');
  const addProviderElements = document.querySelectorAll<HTMLElement>('.js-add-provider');

  hhLinkElements.forEach(element => element.classList.toggle('hidden'));
  linkDeleteElements.forEach(element => element.classList.toggle('hidden'));
  addProviderElements.forEach(element => element.classList.toggle('hidden'));

  if (obj.classList.contains('yhn-link')) {
    const closestTr = obj.closest('tr');
    if (closestTr) {
      closestTr.classList.add('js-linking');
    }
    obj.nextElementSibling?.classList.toggle('hidden');
  } else {
    const linkingRow = document.querySelector<HTMLElement>('.js-linking');

    if (!linkingRow) {
      console.error('Linking row not found');
      return;
    }

    const importDataInputs = linkingRow.querySelectorAll<HTMLInputElement>('input.import-data');

    importDataInputs.forEach(input => {
      const field = input.getAttribute('field');
      const fieldVal = input.value;

      if (!field) return;

      // Copy the value over
      const closestTr = obj.closest('tr');
      if (!closestTr) return;

      const toInput = closestTr.querySelector<HTMLInputElement>(`input.import-data[field='${field}']`);
      if (toInput) {
        toInput.value = fieldVal;
      }
    });

    // Remove the "linked" row
    linkingRow.remove();

    highlightDifferences();
  }
}

function linkCancel(obj: HTMLElement): void {
  const hhLinkElements = document.querySelectorAll<HTMLElement>('.hh-link, .yhn-link');
  const linkDeleteElements = document.querySelectorAll<HTMLElement>('.js-link-delete');
  const addProviderElements = document.querySelectorAll<HTMLElement>('.js-add-provider');

  hhLinkElements.forEach(element => element.classList.toggle('hidden'));
  linkDeleteElements.forEach(element => element.classList.toggle('hidden'));
  addProviderElements.forEach(element => element.classList.toggle('hidden'));

  obj.classList.toggle('hidden');

  const linkingElement = document.querySelector<HTMLElement>('.js-linking');
  if (linkingElement) {
    linkingElement.classList.remove('js-linking');
  }
}

function addAll(): void {
  const copyLeftButtons = document.querySelectorAll<HTMLElement>('.provider-table .js-copy-left');
  copyLeftButtons.forEach(button => button.click());
}

function highlightDifferences(): void {
  const rows = document.querySelectorAll<HTMLTableRowElement>('tr');
  rows.forEach(row => {
    const inputs = row.querySelectorAll<HTMLInputElement | HTMLTextAreaElement>('input, textarea');
    const input1 = inputs[0];
    const input2 = inputs[inputs.length - 1];

    if (input1 && input2) {
      if (input1.value === input2.value) {
        input2.classList.remove('different');
        input2.classList.add('match');
      } else {
        input2.classList.remove('match');
        input2.classList.add('different');
      }
    }
  });
}

function deleteProvider(obj: HTMLElement): void {
  const row = obj.closest<HTMLElement>('.provider-tr');

  if (!row) {
    console.error('Provider row not found');
    return;
  }

  const providerId = row.getAttribute('provider');
  const csrfTokenInput = document.querySelector<HTMLInputElement>('input[name="_csrfToken"]');

  if (!providerId || !csrfTokenInput) {
    console.error('Provider ID or CSRF token not found');
    return;
  }

  const csrfToken = csrfTokenInput.value;

  if (confirm('Are you sure you want to delete this provider?')) {
    fetch(`/admin/imports/ajax_delete_provider/${providerId}`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-type': 'application/json',
        "X-CSRF-Token": csrfToken
      },
    })
      .then(response => {
        if (response.ok) {
          row.remove();
        } else {
          throw new Error('Error deleting provider');
        }
      })
      .catch(error => {
        console.error(error);
      });
  }
}

function addProvider(obj: HTMLElement): void {
  const row = obj.closest('tr');

  if (!row) {
    console.error('Row not found');
    return;
  }

  const providerCount = row.getAttribute('providercount');

  if (!providerCount) {
    console.error('Provider count not found');
    return;
  }

  const copyLeftButtons = document.querySelectorAll<HTMLElement>(`[providercount='${providerCount}'] .js-copy-left`);
  copyLeftButtons.forEach(copyLeftButton => {
    copyLeftButton.click();
  });
}