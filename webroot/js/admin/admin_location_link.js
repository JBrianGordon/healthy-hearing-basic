import './admin_common';

document.addEventListener('DOMContentLoaded', () => {
  const searchBtn = document.getElementById('searchBtn');
  const importLocationSearch = document.getElementById('ImportLocationSearch');
  const searchResults = document.getElementById('searchResults');

  searchBtn.addEventListener('click', async function() {
    const button = this;
    const importType = button.dataset.importType;
    const search = importLocationSearch.value;
    button.disabled = true;
    console.log(search);

    try {
      const response = await fetch('/admin/imports/location_search/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ search, importType })
      });

      if (response.ok) {
        const data = await response.text();
        searchResults.innerHTML = data;
      } else {
        throw new Error('Request failed');
      }
    } catch (error) {
      console.error(error);
    }

    button.disabled = false;
  });

  importLocationSearch.addEventListener('keydown', function(e) {
    if (e.keyCode === 13) {
      searchBtn.click();
      e.preventDefault();
    }
  });

  importLocationSearch.focus();
});