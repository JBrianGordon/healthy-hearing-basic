import './admin_common';

document.addEventListener('DOMContentLoaded', () => {
    const queryInput = document.getElementById('locations-query');
    const queryResults = document.getElementById('query-results');

    // Perform locations AJAX search on 'keyup' events
    queryInput.addEventListener('keyup', () => {
        queryResults.innerHTML = '';

        const query = queryInput.value;

        fetch(`/admin/providers/search?providerLocation=${query}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-type': 'application/x-www-form-urlencoded'
            },
        })
        .then((response) => response.text())
        .then((data) => {

            const jsonArray = JSON.parse(data);

            let list = '';
            jsonArray.forEach(item => {
              list += `<li class="location-clickable" data-location-id="${item.id}" data-location-title="${item.title}">${item.title} -- ${item.id}</li>`;
            });

            queryResults.innerHTML = `<ul>${list}</ul>`;
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });

    // 'click' listener for locations query results items
    queryResults.addEventListener('click', event => {
        if (event.target.classList.contains('location-clickable')) {
            const itemId = event.target.getAttribute('data-location-id');
            const itemTitle = event.target.getAttribute('data-location-title');
            handleItemClick(itemId, itemTitle);
        }
    });

    // Add location item to provider's associated locations list
    function handleItemClick(itemId, itemTitle) {
        const associationList = document.querySelector('#location-association-list');

        // Generate a new key that doesn't conflict with existing ones
        const newKey = generateNewKey();

        // Create a new associated location div element
        const newAssociatedLocation = document.createElement('div');
        newAssociatedLocation.classList.add('associated-location', 'col-sm-9', 'p0');
        newAssociatedLocation.setAttribute('data-location-key', newKey);

        // Create an input element for the hidden 'location.#.id' field
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = `locations[${newKey}][id]`;
        idInput.id = `locations-${newKey}-id`;
        idInput.value = itemId;

        // Create a text element with location 'title'/name
        const name = document.createElement('input');
        name.textContent = `${itemTitle}`;
        name.type = 'text';
        name.readOnly = 'readonly';
        name.name = itemTitle;
        name.value = itemTitle;
        name.classList.add('d-inline-block', 'form-control', 'mb10');

        // Create a delete button
        const deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-location-association', 'btn', 'btn-danger', 'ml20', 'mb10');
        deleteButton.type = 'button';
        deleteButton.textContent = 'Delete';
        deleteButton.setAttribute('data-location-key', newKey);

        // Append the elements to the new associated location div
        newAssociatedLocation.appendChild(idInput);
        newAssociatedLocation.appendChild(name);
        newAssociatedLocation.appendChild(deleteButton);

        // Append the new associated location div to the location-association-list
        associationList.appendChild(newAssociatedLocation);
    }

    function generateNewKey() {
        const associatedLocationElements = document.querySelectorAll('.associated-location');

        // Start with index = 0 if adding first associated location
        if (associatedLocationElements.length === 0) {
            return 0;
        }

        const locationKeys = Array.from(associatedLocationElements).map((element) => {
            return element.getAttribute('data-location-key');
        });

        // Make new location key 1 larger than highest value
        const newKey = Math.max(...locationKeys) + 1;

        return newKey;
    }

    // Delete button removes location from associated locations list
    const locationAssociations = document.getElementById('location-association-list');
    locationAssociations.addEventListener('click', event => {
        if (event.target.classList.contains('delete-location-association')) {
            let locationItem = event.target.closest(".associated-location");

            if (locationItem) {
                locationItem.parentNode.removeChild(locationItem);
            }
        }
    });


});