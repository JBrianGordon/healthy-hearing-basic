<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationVideo[]|\Cake\Collection\CollectionInterface $locationVideos
 */
?>
<div class="locationVideos index content">
    <?= $this->Html->link(__('New Location Video'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Videos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('video_url') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationVideos as $locationVideo): ?>
                <tr>
                    <td><?= $this->Number->format($locationVideo->id) ?></td>
                    <td><?= $locationVideo->has('location') ? $this->Html->link($locationVideo->location->title, ['controller' => 'Locations', 'action' => 'view', $locationVideo->location->id]) : '' ?></td>
                    <td><?= h($locationVideo->video_url) ?></td>
                    <td><?= h($locationVideo->created) ?></td>
                    <td><?= h($locationVideo->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationVideo->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationVideo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationVideo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationVideo->id)]) ?>
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
