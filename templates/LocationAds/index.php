<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationAd[]|\Cake\Collection\CollectionInterface $locationAds
 */
?>
<div class="locationAds index content">
    <?= $this->Html->link(__('New Location Ad'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Ads') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('photo_url') ?></th>
                    <th><?= $this->Paginator->sort('alt') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('border') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationAds as $locationAd): ?>
                <tr>
                    <td><?= $this->Number->format($locationAd->id) ?></td>
                    <td><?= $locationAd->has('location') ? $this->Html->link($locationAd->location->title, ['controller' => 'Locations', 'action' => 'view', $locationAd->location->id]) : '' ?></td>
                    <td><?= h($locationAd->photo_url) ?></td>
                    <td><?= h($locationAd->alt) ?></td>
                    <td><?= h($locationAd->title) ?></td>
                    <td><?= h($locationAd->description) ?></td>
                    <td><?= h($locationAd->border) ?></td>
                    <td><?= h($locationAd->created) ?></td>
                    <td><?= h($locationAd->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationAd->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationAd->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationAd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationAd->id)]) ?>
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
