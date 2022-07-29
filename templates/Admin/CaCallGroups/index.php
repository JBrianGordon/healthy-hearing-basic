<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup[]|\Cake\Collection\CollectionInterface $caCallGroups
 */
use App\Model\Entity\CaCallGroup;
$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
$topics = array_merge(CaCallGroup::$col1Topics, CaCallGroup::$col2Topics);
// Fields to ignore
$ignoreFields = array_keys($topics);
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        switch ($field) {
            case 'score':
                $type = 'multiCheckbox';
                $options = CaCallGroup::$scores;
                break;
            case 'status':
                $type = 'multiCheckbox';
                $options = CaCallGroup::$statuses;
                break;
        }
        $advancedSearchFields[] = [
            'field' => $field,
            'type' => $type,
            'label' => $label,
            'options' => $options,
            'empty' => $empty
        ];
    }
}
// Add 'Topics' as a group of checkboxes
$topicFields = [];
foreach ($topics as $field => $label) {
    $topicFields[] = [
        'field' => $field,
        'type' => 'checkbox',
        'label' => $label,
        'options' => false,
        'empty' => false
    ];
}
$advancedSearchFields[] = [
    'checkboxGroupName' => 'Topics',
    'checkboxFields' => $topics
];
?>
<div class="caCallGroups index content">
    <?= $this->Html->link(__('New Ca Call Group'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Call Groups') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'Group ID') ?></th>
                    <th><?= $this->Paginator->sort('location_id', 'Clinic') ?></th>
                    <th><?= $this->Paginator->sort('caller_phone') ?></th>
                    <th><?= $this->Paginator->sort('caller_last_name', 'Caller name') ?><br><?= $this->Paginator->sort('patient_last_name', 'Patient name') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Initial call time') ?></th>
                    <th><?= $this->Paginator->sort('score') ?></th>
                    <th><?= $this->Paginator->sort('prospect') ?><br><?= $this->Paginator->sort('status') ?></th>
                    <th>Flags: <?= $this->Paginator->sort('is_review_needed', 'RN') ?>/<?= $this->Paginator->sort('is_prospect_override', 'PO') ?>/<br>
                        <?= $this->Paginator->sort('is_spam', 'Spam') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($caCallGroups as $caCallGroup): ?>
                <tr>
                    <td><?= $caCallGroup->id ?></td>
                    <td><?= $caCallGroup->has('location') ? $this->Html->link($caCallGroup->location->title, ['controller' => 'Locations', 'action' => 'view', $caCallGroup->location->id]) : '' ?></td>
                    <td><?= h($caCallGroup->caller_phone) ?></td>
                    <td><?= h($caCallGroup->caller_first_name) ?> <?= h($caCallGroup->caller_last_name) ?><br>
                        <?= h($caCallGroup->patient_first_name) ?> <?= h($caCallGroup->patient_last_name) ?></td>
                    <td><?= h($caCallGroup->prospect) ?></td>
                    <td><?= h($caCallGroup->is_prospect_override) ?></td>
                    <td><?= h($caCallGroup->score) ?></td>
                    <td><?= h($caCallGroup->status) ?></td>
                    <td><?= h($caCallGroup->is_review_needed) ?></td>
                    <td><?= h($caCallGroup->created) ?></td>
                    <td><?= h($caCallGroup->is_spam) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $caCallGroup->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $caCallGroup->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $caCallGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroup->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
