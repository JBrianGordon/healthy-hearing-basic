<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentTag[]|\Cake\Collection\CollectionInterface $contentTags
 */
?>
<div class="contentTags index content">
    <?= $this->Html->link(__('New Content Tag'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Content Tags') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('content_id') ?></th>
                    <th><?= $this->Paginator->sort('tag_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contentTags as $contentTag): ?>
                <tr>
                    <td><?= $this->Number->format($contentTag->id) ?></td>
                    <td><?= $contentTag->has('content') ? $this->Html->link($contentTag->content->title, ['controller' => 'Content', 'action' => 'view', $contentTag->content->id]) : '' ?></td>
                    <td><?= $contentTag->has('tag') ? $this->Html->link($contentTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $contentTag->tag->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contentTag->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contentTag->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contentTag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentTag->id)]) ?>
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
