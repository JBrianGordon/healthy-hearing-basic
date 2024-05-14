<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Provider> $providers
 */

use App\Model\Entity\Location;
use App\Enums\Model\Location\LocationListingType;

// Advanced search details
$advancedSearchFields = [];
$ignoreFields = [
    'micro_url',
    'square_url',
    'thumb_url',
    'image_url',
    'phone',
    'priority',
    'location_count',
    'id_yhn_provider',
    'is_ida_verified',
    'q',
];

$fields = array_diff_key($fields, array_flip($ignoreFields));
// Add additional fields
$fields['location_listing_type'] = 'select';

foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
    $placeholder = null;
    if (in_array($type, ['date', 'datetime'])) {
        $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
        $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
    }
    switch ($field) {
        case 'location_listing_type':
            // $type = 'select';
            $options = Location::$listingTypes;
            $empty = '(All listing types)';
            break;
    }
    $advancedSearchFields[] = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty,
        'value' => $value,
        'placeholder' => $placeholder
    ];
}

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Providers Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(" Browse", ['action' => 'index'], ['class' => 'btn btn-default bi bi-search', 'escape' => false]) ?>
                <?= $this->Html->link(" Add", ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg', 'escape' => false]) ?>
                <?= $this->Html->link(" Export Duplicate Emails", ['action' => 'duplicateEmailProvidersCsv'], ['class' => 'btn btn-default bi bi-download', 'escape' => false]) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2><?= __('Providers') ?></h2>
                <div class="users index content">
                    <?= $this->element('pagination') ?>
                        <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('id') ?></th>
                                    <th>
                                        <?= $this->Paginator->sort('first_name', 'First') ?> / <?= $this->Paginator->sort('last_name', 'Last') ?><br>
                                    </th>
                                    <th>
                                        <?= $this->Paginator->sort('email') ?>
                                    </th>
                                    <th><?= $this->Paginator->sort('location_id', 'Clinic') ?></th>
                                    <th><?= $this->Paginator->sort('location_count') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($providers as $provider): ?>
                                <tr>
                                    <td><?= $provider->id ?></td>
                                    <td>
                                        <strong><?= h($provider->first_name) ?> <?= h($provider->last_name) ?></strong><br>
                                    </td>
                                    <td>
                                        <?= h($provider->email) ?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach ($provider->locations as $location) {
                                            echo $this->Html->link(
                                                $location->id,
                                                [
                                                    'controller' => 'locations',
                                                    'action' => 'edit',
                                                    $location->id,
                                                ],
                                            );
                                            echo ' - '.$this->Clinic->badgeListingType($location->listing_type).'<br>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $provider->location_count ?>
                                    </td>
                                    <td class="actions">
                                        <?= $this->Html->link(__(' Edit'),
                                                ['action' => 'edit', $provider->id],
                                                ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']
                                            )
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $this->element('pagination') ?>
                </div>
            </div>
        </div>
    </section>
</div>