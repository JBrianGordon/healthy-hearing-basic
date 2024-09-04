import '../common/common';


document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.js-copy-left').forEach(element => {
    element.addEventListener('click', function() {
      copyLeft(this);
      return false;
    });
  });

  document.querySelectorAll('.js-link').forEach(element => {
    element.addEventListener('click', function() {
      link(this);
      return false;
    });
  });

  document.querySelectorAll('.js-add-all').forEach(element => {
    element.addEventListener('click', function() {
      addAll();
      return false;
    });
  });

  document.querySelectorAll('.js-add-provider').forEach(element => {
    element.addEventListener('click', function() {
      addProvider(this);
      return false;
    });
  });

  document.querySelectorAll('.js-link-delete').forEach(element => {
    element.addEventListener('click', function() {
      deleteProvider(this);
      return false;
    });
  });

  document.querySelectorAll('.js-link-cancel').forEach(element => {
    element.addEventListener('click', function() {
      linkCancel(this);
      return false;
    });
  });

  highlightDifferences();
});

function copyLeft(obj) {
  const hhInput = obj.parentNode.previousElementSibling.querySelector('input, textarea');
  const yhnInput = obj.parentNode.nextElementSibling.querySelector('input, textarea');

  // Copy the data from the YHN side
  hhInput.value = yhnInput.value;

  highlightDifferences();
  return false;
}

function link(obj) {
  const hhLinkElements = document.querySelectorAll('.hh-link, .yhn-link');
  const linkDeleteElements = document.querySelectorAll('.js-link-delete');
  const addProviderElements = document.querySelectorAll('.js-add-provider');

  hhLinkElements.forEach(element => element.classList.toggle('hidden'));
  linkDeleteElements.forEach(element => element.classList.toggle('hidden'));
  addProviderElements.forEach(element => element.classList.toggle('hidden'));

  if (obj.classList.contains('yhn-link')) {
    obj.closest('tr').classList.add('js-linking');
    obj.nextElementSibling.classList.toggle('hidden');
  } else {
    const linkingRow = document.querySelector('.js-linking');
    const importDataInputs = linkingRow.querySelectorAll('input.import-data');

    importDataInputs.forEach(input => {
      const field = input.getAttribute('field');
      const fieldVal = input.value;
      
      // Copy the value over
      const toInput = obj.closest('tr').querySelector(`input.import-data[field='${field}']`);
      toInput.value = fieldVal;
    });

    // Remove the "linked" row
    linkingRow.remove();

    highlightDifferences();
  }
}

function linkCancel(obj) {
  const hhLinkElements = document.querySelectorAll('.hh-link, .yhn-link');
  const linkDeleteElements = document.querySelectorAll('.js-link-delete');
  const addProviderElements = document.querySelectorAll('.js-add-provider');

  hhLinkElements.forEach(element => element.classList.toggle('hidden'));
  linkDeleteElements.forEach(element => element.classList.toggle('hidden'));
  addProviderElements.forEach(element => element.classList.toggle('hidden'));

  obj.classList.toggle('hidden');
  document.querySelector('.js-linking').classList.remove('js-linking');
}

function addAll() {
  const copyLeftButtons = document.querySelectorAll('.provider-table .js-copy-left');
  copyLeftButtons.forEach(button => button.click());
}

function highlightDifferences() {
  const rows = document.querySelectorAll('tr');
  rows.forEach(row => {
    const inputs = row.querySelectorAll('input, textarea');
    const input1 = inputs[0];
    const input2 = inputs[inputs.length - 1];
    if (input1) {
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

function deleteProvider(obj) {
  const row = obj.closest('tr');
  const providerId = row.getAttribute('provider');
  
  if (confirm('Are you sure you want to delete this provider?')) {
    fetch(`/admin/imports/delete_provider/${providerId}`, {
      method: 'POST'
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

function addProvider(obj) {
  const row = obj.closest('tr');
  const providerCount = row.getAttribute('providercount');
  const copyLeftButton = document.querySelector(`[providercount='${providerCount}'] .js-copy-left`);
  if (copyLeftButton) {
    copyLeftButton.click();
  }
}

