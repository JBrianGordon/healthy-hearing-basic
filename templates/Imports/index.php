<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Import[]|\Cake\Collection\CollectionInterface $imports
 */
?>
<div class="imports index content">
    <?= $this->Html->link(__('New Import'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Imports') ?></h3>
    <div class="table-responsive">
        <table>
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
                    <td><?= $this->Number->format($import->id) ?></td>
                    <td><?= h($import->type) ?></td>
                    <td><?= $this->Number->format($import->total_locations) ?></td>
                    <td><?= $this->Number->format($import->new_locations) ?></td>
                    <td><?= $this->Number->format($import->updated_locations) ?></td>
                    <td><?= $this->Number->format($import->total_providers) ?></td>
                    <td><?= $this->Number->format($import->new_providers) ?></td>
                    <td><?= $this->Number->format($import->updated_providers) ?></td>
                    <td><?= h($import->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $import->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $import->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $import->id], ['confirm' => __('Are you sure you want to delete # {0}?', $import->id)]) ?>
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
