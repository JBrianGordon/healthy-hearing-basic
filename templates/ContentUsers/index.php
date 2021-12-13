<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentUser[]|\Cake\Collection\CollectionInterface $contentUsers
 */
?>
<div class="contentUsers index content">
    <?= $this->Html->link(__('New Content User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Content Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('content_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contentUsers as $contentUser): ?>
                <tr>
                    <td><?= $this->Number->format($contentUser->id) ?></td>
                    <td><?= $contentUser->has('content') ? $this->Html->link($contentUser->content->title, ['controller' => 'Content', 'action' => 'view', $contentUser->content->id]) : '' ?></td>
                    <td><?= $contentUser->has('user') ? $this->Html->link($contentUser->user->id, ['controller' => 'Users', 'action' => 'view', $contentUser->user->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contentUser->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contentUser->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contentUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentUser->id)]) ?>
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
