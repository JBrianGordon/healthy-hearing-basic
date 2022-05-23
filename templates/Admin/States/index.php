<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State[]|\Cake\Collection\CollectionInterface $states
 */
?>
<div class="states index content">
    <?= $this->Html->link(__('New State'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('States') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($states as $state): ?>
                <tr>
                    <td><?= $this->Number->format($state->id) ?></td>
                    <td><?= h($state->name) ?></td>
                    <td>
                        <?= $this->Html->badge(
                            $state->is_active ? '<i class="bi bi-check-lg"></i> Active' : '<i class="bi bi-x-lg"></i> Inactive',
                            [
                                'class' => $state->is_active ? 'success' : 'danger',
                            ]
                        ); ?>
                    </td>
                    <td class="actions">
                        <div class="btn-group-vertical">
                            <?= $this->Html->link(__('View'),
                                [
                                    'prefix' => false,
                                    'controller' => 'locations',
                                    'action' => 'cities',
                                    'region' => $state->name,
                                    // TODO:
                                    //'region' =>  $this->Clinic->stateSlug($state->name)
                                ],
                                ['class' => 'btn btn-outline-secondary']) ?>
                            <?= $this->Html->link(__('Edit'),
                                ['action' => 'edit', $state->id],
                                ['class' => 'btn btn-outline-secondary']) ?>
                            <?= $this->Form->postLink(__('Delete'),
                                ['action' => 'delete', $state->id],
                                ['class' => 'btn btn-outline-secondary', 'confirm' => __('Are you sure you want to delete # {0}?', $state->id)]) ?>
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
