<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content[]|\Cake\Collection\CollectionInterface $content
 */

$this->loadHelper('Search.Search', [
    'additionalBlacklist'=> [
        'created_start_date',
        'created_end_date',
        'last_mod_start_date',
        'last_mod_end_date'
    ]
]);
?>

<div class="content index">
    <?= $this->Html->link(__('New Content'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Content') ?></h3>
    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
    <div class="row justify-content-end">
        <?php if ($this->Search->isSearch()): ?>
            <div class="col col-md-auto">
                <?= $this->Search->resetLink(__('Reset'), ['class' => 'btn btn-info text-light', 'role' => 'button']) ?>
            </div>
        <?php endif; ?>
        <div class="col col-md-auto">
            <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#advancedSearch" aria-expanded="false" aria-controls="advancedSearch">
                + Advanced
            </button>
        </div>

    </div>

    <div class="collapse" id="advancedSearch">
        <?php
            echo $this->Form->create(null, [
                'class' => 'bg-light mb-3 p-5',
                'valueSources' => 'query'
            ]);
            echo $this->Form->control('id', [
                'label' => [
                    'text' => 'Content ID',
                    'floating' => true
                ]
            ]);
            echo $this->Form->control('user_id', [
                'label' => [
                    'text' => 'Primary Author',
                    'floating' => true
                ],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('type', [
                'type' => 'select',
                'options' => $typeOptions,
                'label' => ['floating' => true],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('title', [
                'label' => ['floating' => true]
            ]);
            echo $this->Form->control('short', [
                'label' => ['floating' => true]
            ]);
            echo $this->Form->control('body', [
                'label' => ['floating' => true]
            ]);
            echo $this->Form->control('is_active', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('is_library_item', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('library_share_text', [
                'label' => ['floating' => true]
            ]);
            echo $this->Form->control('is_gone', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('facebook_image', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('facebook_image_width_override', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('id_draft_parent', [
                'type' => 'select',
                'options' => [1 => 'Yes', 0 => 'No'],
                'label' => ['floating' => true],
                'empty' => '(select one)'
            ]);
            echo $this->Form->control('q', ['label' => 'Query']);
            echo $this->Form->control('last_mod_start_date', ['type' => 'date','label' => 'Lastmod Start Date']);
            echo $this->Form->control('last_mod_end_date', ['type' => 'date','label' => 'Lastmod End Date']);
            echo $this->Form->control('created_start_date', ['type' => 'date','label' => 'Created Start Date']);
            echo $this->Form->control('created_end_date', ['type' => 'date','label' => 'Created End Date']);

            echo $this->Form->button('Filter', [
                'type' => 'submit',
                'class' => 'me-3'
            ]);
            // echo $this->Html->link('Reset', ['action' => 'index']);
            echo $this->Form->end();
        ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="align-top">
                    <th>
                        <?= $this->Paginator->sort('is_active', 'Active') ?>
                        <?= $this->Paginator->sort('id') ?>
                    </th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'Author') ?></th>
                    <th><?= $this->Paginator->sort('short') ?></th>
                    <th>
                        <?= $this->Paginator->sort('last_modified', 'Last Mod') ?>
                        <?= $this->Paginator->sort('date', 'Pub Date') ?>
                    </th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($content as $content): ?>
                <tr>
                    <td>
                        <?= $this->Number->format($content->id) ?>
                        <?= $this->Html->badge(
                                $content->is_active ? 'Yes' : 'No', [
                                'class' => $content->is_active ? 'success' : 'danger',
                            ]);
                        ?>
                    </td>
                    <td><?= h($content->title) ?></td>
                    <td><?= h($content->type) ?></td>
                    <td>
                        <?php
                            if ($content->primary_author !== null) {
                                echo h($content->primary_author->username);
                            }
                        ?>
                    </td>
                    <td><?= h($content->short) ?></td>
                    <td><?= h($content->last_modified) ?></td>
                    <td><?= h($content->date) ?></td>
                    <td class="actions">
                        <div class="btn-group-vertical">
                            <?= $this->Html->link(
                                __('View'),
                                array_merge(['prefix' => false], $content->hh_url),
                                ['class' => 'btn btn-outline-secondary'])
                            ?>
                            <?= $this->Html->link(
                                __('Edit'),
                                ['action' => 'edit', $content->id],
                                ['class' => 'btn btn-outline-secondary'])
                            ?>
                        </div>
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
