<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Provider $provider
 * @var string[]|\Cake\Collection\CollectionInterface $locations
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
                    echo $this->Form->control('locations._ids', ['options' => $locations]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- <div class="search-form">
    <?= $this->Form->input('search', [
        'id' => 'search-input',
        'label' => false,
        'placeholder' => 'Search Locations',
    ]) ?>
</div>
<div id="search-results"></div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Cache the search input field and results container
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');

        // Attach an event listener to the input field for input events
        searchInput.addEventListener('input', function () {
            // Get the current search query from the input field
            const query = searchInput.value;

            // Send a Fetch API request to the server to fetch search results
            fetch(`/admin/providers/search?providerLocation=${query}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/x-www-form-urlencoded'
                },
            })
                .then((response) => response.text())
                .then((data) => {
                    searchResults.replaceChildren();
                    // Update the search results container with the retrieved data
                    searchResults.innerHTML = data;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    });
</script> -->


<form autocomplete="off"><input type="text" name="q" id="q" />
<div id="result"></div>
</form>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Cache the search input field and results container
        const queryInput = document.getElementById('q');
        const queryResults = document.getElementById('result');

        // Attach an event listener to the input field for input events
        queryInput.addEventListener('keyup', function () {
            queryResults.innerHTML = '';

            // Get the current search query from the input field
            const query = queryInput.value;

            // Send a Fetch API request to the server to fetch search results
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
                        list += '<li>' + jsonArray[i].title + ' -- ' + jsonArray[i].id + '</li>';
                    }

                    queryResults.innerHTML = '<ul>' + list + '</ul>';
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    });
</script>

<style type="text/css">
    #q {
        width: 500px;
    }
    #result {
      border: 1px dotted #ccc;
      padding: 3px;
      width: 500px;
    }

    #result ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    #result ul li {
      padding: 5px 0;
    }

    #result ul li:hover {
      background: #eee;
    }
</style>