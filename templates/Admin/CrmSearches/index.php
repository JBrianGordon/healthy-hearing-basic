<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CrmSearch[]|\Cake\Collection\CollectionInterface $allCrmSearches
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
<div class="crmSearches index content">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->Html->link("<i class='bi bi-plus-lg'></i> Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
    </div>
    <h3><?= __('Crm Searches') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields, 'additionalBlacklist' => $additionalBlacklist]) ?>
    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?><br><?= $this->Paginator->sort('order') ?></th>
                    <th><?= $this->Paginator->sort('is_public') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('title') ?><br><?= 'Search' ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'User') ?></th>
                    <th><?= $this->Paginator->sort('created') ?><br><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allCrmSearches as $crmSearch) : ?>
                <tr>
                    <td><span class="badge bg-info"><?= $crmSearch->id ?></span><br><?= $crmSearch->order ?></td>
                    <td><?= $this->Admin->yesNo($crmSearch->is_public) ?></td>
                    <td><?= h($crmSearch->model) ?></td>
                    <td style="word-wrap: break-word; max-width: 500px;"><?= h($crmSearch->title) ?><br><small><?= h($crmSearch->search) ?></small></td>
                    <td>
                        <?=
                            $crmSearch->has('user') ?
                            $this->Html->link($crmSearch->user->username, [
                                'controller' => 'Users',
                                'action' => 'view',
                                $crmSearch->user->id,
                            ]) : ''
                        ?>     
                    </td>
                    <td nowrap><?= date('Y-m-d, H:i', strtotime($crmSearch->created)) ?><br><?= date('Y-m-d, H:i', strtotime($crmSearch->modified))  ?></td>
                    <td class="actions">
                        <div class="btn-group-vertical btn-group-xs">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $crmSearch->id], ['class' => 'btn btn-default']) ?>
                            <?=
                                $this->Form->postLink(
                                    __('Delete'),
                                    ['action' => 'delete', $crmSearch->id],
                                    ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearch->id), 'class' => 'btn btn-danger']
                                )
                            ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
