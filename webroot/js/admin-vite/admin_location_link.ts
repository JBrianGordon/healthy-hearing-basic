import './admin_common';

document.addEventListener('DOMContentLoaded', () => {
  const searchBtn = document.getElementById('searchBtn') as HTMLButtonElement;
  const importLocationSearch = document.getElementById('search') as HTMLInputElement;
  const searchResults = document.getElementById('searchResults') as HTMLElement;
  const csrfTokenInput = document.querySelector<HTMLInputElement>('input[name="_csrfToken"]');

  if (!searchBtn || !importLocationSearch || !searchResults || !csrfTokenInput) {
    console.error('Required elements not found');
    return;
  }

  searchBtn.addEventListener('click', async function (this: HTMLButtonElement) {
    const button = this;
    const importType = button.dataset.importType;
    const search = importLocationSearch.value;
    const csrfToken = csrfTokenInput.value;
    button.disabled = true;

    try {
      const response = await fetch('/admin/imports/ajax_location_search', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/json',
          "X-CSRF-Token": csrfToken
        },
        body: JSON.stringify({ search: search, importType: importType })
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

  importLocationSearch.addEventListener('keydown', function (e: KeyboardEvent) {
    if (e.keyCode === 13) { // Enter key
      searchBtn.click();
      e.preventDefault();
    }
  });

  importLocationSearch.focus();
  searchBtn.click();
});