<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchemaMigration[]|\Cake\Collection\CollectionInterface $schemaMigrations
 */
?>
<div class="schemaMigrations index content">
    <?= $this->Html->link(__('New Schema Migration'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Schema Migrations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('class') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schemaMigrations as $schemaMigration): ?>
                <tr>
                    <td><?= $this->Number->format($schemaMigration->id) ?></td>
                    <td><?= h($schemaMigration->class) ?></td>
                    <td><?= h($schemaMigration->type) ?></td>
                    <td><?= h($schemaMigration->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $schemaMigration->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $schemaMigration->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $schemaMigration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schemaMigration->id)]) ?>
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
