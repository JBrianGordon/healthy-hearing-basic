<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationPhoto[]|\Cake\Collection\CollectionInterface $locationPhotos
 */
?>
<div class="locationPhotos index content">
    <?= $this->Html->link(__('New Location Photo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Photos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('photo_url') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('alt') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationPhotos as $locationPhoto): ?>
                <tr>
                    <td><?= $this->Number->format($locationPhoto->id) ?></td>
                    <td><?= $locationPhoto->has('location') ? $this->Html->link($locationPhoto->location->title, ['controller' => 'Locations', 'action' => 'view', $locationPhoto->location->id]) : '' ?></td>
                    <td><?= h($locationPhoto->photo_url) ?></td>
                    <td><?= h($locationPhoto->created) ?></td>
                    <td><?= h($locationPhoto->modified) ?></td>
                    <td><?= h($locationPhoto->alt) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationPhoto->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationPhoto->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationPhoto->id)]) ?>
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
