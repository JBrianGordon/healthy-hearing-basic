<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Import[]|\Cake\Collection\CollectionInterface $imports
 */
$queryParams = $this->request->getQueryParams();
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = [];
$additionalBlacklist = [];
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
        if (in_array($type, ['date', 'datetime'])) {
            $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
            $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
        }
        switch ($field) {
            case 'user_id':
                $label = 'User';
                $type = 'select';
                $options = $users;
                $empty = '(select one)';
                break;
        }
        $advancedSearchFields[] = [
            'field' => $field,
            'type' => $type,
            'label' => $label,
            'options' => $options,
            'empty' => $empty,
            'value' => $value
        ];
    }
}
?>
<div class="imports index content">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->Html->link("<i class='bi bi-bar-chart-fill'></i> Stats", ['action' => 'stats'], ['class' => 'btn btn-default', 'escape' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-bar-chart-fill'></i> Tier Status", ['action' => 'tier_status_report'], ['class' => 'btn btn-default', 'escape' => false]) ?>
    </div>
    <h3><?= __('Import Dashboard') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields, 'additionalBlacklist' => $additionalBlacklist]) ?>
    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('total_locations') ?></th>
                    <th><?= $this->Paginator->sort('new_locations') ?></th>
                    <th><?= $this->Paginator->sort('updated_locations') ?></th>
                    <th><?= $this->Paginator->sort('total_providers') ?></th>
                    <th><?= $this->Paginator->sort('new_providers') ?></th>
                    <th><?= $this->Paginator->sort('updated_providers') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imports as $import): ?>
                <tr>
                    <td><?= $this->Number->format($import->id) ?><?php pr($import); ?></td>
                    <td><?= h($import->type) ?></td>
                    <td><?= $import->total_locations === null ? '' : $this->Number->format($import->total_locations) ?></td>
                    <td><?= $import->new_locations === null ? '' : $this->Number->format($import->new_locations) ?></td>
                    <td><?= $import->updated_locations === null ? '' : $this->Number->format($import->updated_locations) ?></td>
                    <td><?= $import->total_providers === null ? '' : $this->Number->format($import->total_providers) ?></td>
                    <td><?= $import->new_providers === null ? '' : $this->Number->format($import->new_providers) ?></td>
                    <td><?= $import->updated_providers === null ? '' : $this->Number->format($import->updated_providers) ?></td>
                    <td><?= h($import->created) ?></td>
                    <td class="actions">
                        <div class="btn-group-vertical btn-group-xs">
                            <?= $this->Html->link('Review', ['action' => 'edit'], ['class' => 'btn btn-default']) ?>
                            <?= $this->Html->link('Unlink', ['action' => 'edit', $import->id], ['class' => 'btn btn-default']) ?>
                            <?= $this->Html->link('Junk', ['action' => 'edit', $import->id], ['class' => 'btn btn-default']) ?>
                            <a href="/admin/imports/location_add/<?php echo $importLocation['ImportLocation']['id']; ?>" class="btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-plus-sign"></span> Add
                            </a>
                            <a href="/admin/imports/location_link/<?php echo $importLocation['ImportLocation']['id']; ?>" class="btn btn-default btn-xs">
                                <span class="glyphicon glyphicon-link"></span> Link
                            </a>
                            <?php echo $this->Html->link(
                                '<span class="glyphicon glyphicon-ban-circle"></span> Junk',
                                ['admin' => true, 'controller' => 'imports', 'action' => 'location_add_junk', $importLocation['ImportLocation']['id']],
                                ['escape' => false, 'class' => 'btn btn-default btn-xs'],
                                'Are you sure you want to mark this location as junk?'
                            ); ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
