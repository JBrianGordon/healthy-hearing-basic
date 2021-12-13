<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorpsUser[]|\Cake\Collection\CollectionInterface $corpsUsers
 */
?>
<div class="corpsUsers index content">
    <?= $this->Html->link(__('New Corps User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Corps Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('corp_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($corpsUsers as $corpsUser): ?>
                <tr>
                    <td><?= $this->Number->format($corpsUser->id) ?></td>
                    <td><?= $corpsUser->has('corp') ? $this->Html->link($corpsUser->corp->title, ['controller' => 'Corps', 'action' => 'view', $corpsUser->corp->id]) : '' ?></td>
                    <td><?= $corpsUser->has('user') ? $this->Html->link($corpsUser->user->id, ['controller' => 'Users', 'action' => 'view', $corpsUser->user->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $corpsUser->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $corpsUser->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $corpsUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corpsUser->id)]) ?>
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
