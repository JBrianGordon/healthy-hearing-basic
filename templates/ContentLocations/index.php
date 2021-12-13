<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentLocation[]|\Cake\Collection\CollectionInterface $contentLocations
 */
?>
<div class="contentLocations index content">
    <?= $this->Html->link(__('New Content Location'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Content Locations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('content_id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contentLocations as $contentLocation): ?>
                <tr>
                    <td><?= $this->Number->format($contentLocation->id) ?></td>
                    <td><?= $contentLocation->has('content') ? $this->Html->link($contentLocation->content->title, ['controller' => 'Content', 'action' => 'view', $contentLocation->content->id]) : '' ?></td>
                    <td><?= $contentLocation->has('location') ? $this->Html->link($contentLocation->location->title, ['controller' => 'Locations', 'action' => 'view', $contentLocation->location->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contentLocation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contentLocation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contentLocation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentLocation->id)]) ?>
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
