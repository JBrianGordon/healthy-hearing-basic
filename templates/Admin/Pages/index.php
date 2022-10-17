<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Page> $pages
 */
?>
<div class="pages index content">
    <?= $this->Html->link(__('New Page'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pages') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page): ?>
                <tr>
                    <td><?= $this->Number->format($page->id) ?></td>
                    <td><?= h($page->title) ?></td>
                    <td><?= h($page->created) ?></td>
                    <td><?= h($page->modified) ?></td>
                    <td><?= $page->has('user') ? $this->Html->link($page->user->id, ['controller' => 'Users', 'action' => 'view', $page->user->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $page->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $page->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $page->id], ['confirm' => __('Are you sure you want to delete # {0}?', $page->id)]) ?>
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
