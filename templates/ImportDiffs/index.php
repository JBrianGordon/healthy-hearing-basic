<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportDiff[]|\Cake\Collection\CollectionInterface $importDiffs
 */
?>
<div class="importDiffs index content">
    <?= $this->Html->link(__('New Import Diff'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Import Diffs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('import_id') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('id_model') ?></th>
                    <th><?= $this->Paginator->sort('field') ?></th>
                    <th><?= $this->Paginator->sort('review_needed') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($importDiffs as $importDiff): ?>
                <tr>
                    <td><?= $this->Number->format($importDiff->id) ?></td>
                    <td><?= $importDiff->has('import') ? $this->Html->link($importDiff->import->id, ['controller' => 'Imports', 'action' => 'view', $importDiff->import->id]) : '' ?></td>
                    <td><?= h($importDiff->model) ?></td>
                    <td><?= h($importDiff->id_model) ?></td>
                    <td><?= h($importDiff->field) ?></td>
                    <td><?= $this->Number->format($importDiff->review_needed) ?></td>
                    <td><?= h($importDiff->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $importDiff->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $importDiff->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $importDiff->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importDiff->id)]) ?>
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
