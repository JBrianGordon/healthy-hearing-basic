<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CrmSearch[]|\Cake\Collection\CollectionInterface $crmSearches
 */
?>
<div class="crmSearches index content">
    <?= $this->Html->link(__('New Crm Search'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Crm Searches') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('is_public') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($crmSearches as $crmSearch): ?>
                <tr>
                    <td><?= $this->Number->format($crmSearch->id) ?></td>
                    <td><?= $crmSearch->has('user') ? $this->Html->link($crmSearch->user->id, ['controller' => 'Users', 'action' => 'view', $crmSearch->user->id]) : '' ?></td>
                    <td><?= h($crmSearch->model) ?></td>
                    <td><?= h($crmSearch->title) ?></td>
                    <td><?= h($crmSearch->is_public) ?></td>
                    <td><?= $this->Number->format($crmSearch->priority) ?></td>
                    <td><?= h($crmSearch->created) ?></td>
                    <td><?= h($crmSearch->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $crmSearch->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $crmSearch->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $crmSearch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearch->id)]) ?>
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
