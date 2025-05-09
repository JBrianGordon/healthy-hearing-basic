import './admin_common';

document.addEventListener('DOMContentLoaded', () => {
  const searchBtn = document.getElementById('searchBtn');
  const importLocationSearch = document.getElementById('search');
  const searchResults = document.getElementById('searchResults');

  searchBtn.addEventListener('click', async function() {
    const button = this;
    const importType = button.dataset.importType;
    const search = importLocationSearch.value;
    const csrfToken = $('input[name="_csrfToken"]').val();
    button.disabled = true;

    try {
      const response = await fetch('/admin/imports/ajax_location_search', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/json',
          "X-CSRF-Token": csrfToken
        },
        body: JSON.stringify({search: search, importType: importType})
      });

      if (response.ok) {
        const data = await response.text();
        searchResults.innerHTML = data;
      } else {
        console.error('ajax_location_search failed');
        throw new Error('Request failed');
      }
    } catch (error) {
      console.error('ajax_location_search failed');
      console.error(error);
    }

    button.disabled = false;
  });

  importLocationSearch.addEventListener('keydown', function(e) {
    if (e.keyCode === 13) { // Enter key
      searchBtn.click();
      e.preventDefault();
    }
  });

  importLocationSearch.focus();
  searchBtn.click();
});