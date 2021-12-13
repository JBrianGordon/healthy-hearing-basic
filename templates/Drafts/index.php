<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Draft[]|\Cake\Collection\CollectionInterface $drafts
 */
?>
<div class="drafts index content">
    <?= $this->Html->link(__('New Draft'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Drafts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('model_id') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($drafts as $draft): ?>
                <tr>
                    <td><?= h($draft->id) ?></td>
                    <td><?= h($draft->model_id) ?></td>
                    <td><?= h($draft->model) ?></td>
                    <td><?= $draft->has('user') ? $this->Html->link($draft->user->id, ['controller' => 'Users', 'action' => 'view', $draft->user->id]) : '' ?></td>
                    <td><?= h($draft->created) ?></td>
                    <td><?= h($draft->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $draft->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $draft->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $draft->id], ['confirm' => __('Are you sure you want to delete # {0}?', $draft->id)]) ?>
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
