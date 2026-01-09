// Reusable function to initialize autoComplete
const initializeAutoComplete = (selector) => {
    new autoComplete({
        selector: `#${selector}`, // Use the id as the selector
        placeHolder: "Search for a city, state, or ZIP...",
        debounce: 300,
        data: {
            src: async (query) => {
                try {
                    const response = await fetch(`/locations/autocomplete?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    return await response.json();
                } catch (error) {
                    console.error('Autocomplete fetch error:', error);
                    return [];
                }
            },
            keys: ['name'],
            cache: false
        },
        resultItem: {
            highlight: true
        },
        events: {
            input: {
                selection: (event) => {
                    const selection = event.detail.selection.value;
                    document.querySelector(`#${selector}`).value = selection.name;

                    window.location.href = selection.url;
                }
            }
        }
    });
};

// Select all elements with the class 'autoCompleteJs'
const elements = Array.from(document.querySelectorAll('.autoCompleteJs'));

// Loop through each element, get its id, and initialize autoComplete (classes do not work as selectors)
elements.forEach((element) => {
    const elementId = element.id;
    if (elementId) {
        initializeAutoComplete(elementId);
    } else {
        console.error('Element with class "autoCompleteJs" is missing an id.');
    }
});