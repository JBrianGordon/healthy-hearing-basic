<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Provider $provider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $provider->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $provider->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="providers form content">
            <?= $this->Form->create($provider) ?>
            <fieldset>
                <legend><?= __('Edit Provider') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('middle_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('credentials');
                    echo $this->Form->control('title');
                    echo $this->Form->control('email');
                    echo $this->Form->control('description');
                    echo $this->Form->control('micro_url');
                    echo $this->Form->control('square_url');
                    echo $this->Form->control('thumb_url');
                    echo $this->Form->control('image_url');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('priority');
                    echo $this->Form->control('aud_or_his');
                    echo $this->Form->control('is_ida_verified');
                    echo $this->Form->control('id_yhn_provider');
                ?>
            </fieldset>

            <!-- Associated Locations Section -->
            <fieldset>
                <legend><strong><?= __('Associated Locations') ?></strong></legend>
                <div id="location-association-list">
                    <?php foreach ($provider->locations as $key => $location): ?>
                        <div class=<?= "associated-location data-location-key={$key}" ?>>
                            <?php
                                echo $this->Form->control("locations.{$key}.id");
                                echo $this->Form->label("locations.{$key}.id", $location->title);
                            ?>
                            <?= $this->Form->button(
                                'Delete',
                                [
                                    'data-location-key' => $key,
                                    'class' => 'delete-location-association',
                                    'type' => 'button'
                                ]
                            ) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </fieldset>

            <?= $this->Form->text('locations-query', [
                    'id' => 'locations-query',
                    'placeholder' => 'Add an associated clinic'
                ])
            ?>
            <div id="query-results"></div>

            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const queryInput = document.getElementById('locations-query');
        const queryResults = document.getElementById('query-results');

        // Perform locations AJAX search on 'keyup' events
        queryInput.addEventListener('keyup', function () {
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

                    jsonArray = JSON.parse(data);

                    let list = '';
                    for (i=0; i < jsonArray.length; i++) {
                        list += '<li class="location-clickable" data-location-id="' + jsonArray[i].id + '" data-location-title="' + jsonArray[i].title + '">' + jsonArray[i].title + ' -- ' + jsonArray[i].id + '</li>';
                    }

                    queryResults.innerHTML = '<ul>' + list + '</ul>';
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });

        // 'click' listener for locations query results items
        queryResults.addEventListener('click', function (event) {
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
            newAssociatedLocation.classList.add('associated-location');
            newAssociatedLocation.setAttribute('data-location-key', newKey);

            // Create an input element for the hidden 'location.#.id' field
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `locations[${newKey}][id]`;
            idInput.id = `locations-${newKey}-id`;
            idInput.value = itemId;

            // Create a label element with location 'title'/name
            const label = document.createElement('label');
            label.textContent = `${itemTitle}`;
            label.htmlFor = `locations-${newKey}-id`;

            // Create a delete button
            const deleteButton = document.createElement('button');
            deleteButton.classList.add('delete-location-association', 'btn', 'btn-secondary');
            deleteButton.type = 'button';
            deleteButton.textContent = 'Delete';
            deleteButton.setAttribute('data-location-key', newKey);

            // Append the elements to the new associated location div
            newAssociatedLocation.appendChild(idInput);
            newAssociatedLocation.appendChild(label);
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
        locationAssociations.addEventListener('click', function (event) {
            if (event.target.classList.contains('delete-location-association')) {
                let locationItem = event.target.closest(".associated-location");

                if (locationItem) {
                    locationItem.parentNode.removeChild(locationItem);
                }
            }
        });


    });
</script>

<style type="text/css">
    #q {
        width: 500px;
    }
    #query-results {
      border: 1px dotted #ccc;
      padding: 3px;
      width: 500px;
    }

    #query-results ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    #query-results ul li {
      padding: 5px 0;
    }

    #query-results ul li:hover {
      background: #eee;
    }
</style>