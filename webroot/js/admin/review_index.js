import '../common/common';
import './nav_tabs';

const reviewLocationSearch = document.querySelector('#ReviewLocationSearch');
const reviewLocationId = document.querySelector('#ReviewLocationId');
const clearClinic = document.querySelector('#ClearClinic');

reviewLocationSearch.addEventListener('input', async () => {
  const query = reviewLocationSearch.value;
  if (query.length >= 2) {
    const response = await fetch('/reviewautocomplete?query=' + query);
    const data = await response.json();
    initializeAutocomplete(data);
  }
});

function initializeAutocomplete(data) {
  new autoComplete({
    selector: '#ReviewLocationSearch',
    minChars: 2,
    cache: false,
    source: function (term, suggest) {
      term = term.toLowerCase();
      const matches = data.filter(function (entry) {
        return entry.value.toLowerCase().indexOf(term) !== -1;
      });
      suggest(matches);
    },
    onSelect: function (event, suggestion) {
      if (suggestion.data.id) {
        reviewLocationId.value = suggestion.data.id;
      }
    }
  });
}

clearClinic.addEventListener('click', function (event) {
  reviewLocationId.value = '';
  event.preventDefault();
});