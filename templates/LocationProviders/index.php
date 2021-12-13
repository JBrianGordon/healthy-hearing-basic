<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationProvider[]|\Cake\Collection\CollectionInterface $locationProviders
 */
?>
<div class="locationProviders index content">
    <?= $this->Html->link(__('New Location Provider'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Providers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('provider_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationProviders as $locationProvider): ?>
                <tr>
                    <td><?= $this->Number->format($locationProvider->id) ?></td>
                    <td><?= $locationProvider->has('location') ? $this->Html->link($locationProvider->location->title, ['controller' => 'Locations', 'action' => 'view', $locationProvider->location->id]) : '' ?></td>
                    <td><?= $locationProvider->has('provider') ? $this->Html->link($locationProvider->provider->title, ['controller' => 'Providers', 'action' => 'view', $locationProvider->provider->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationProvider->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationProvider->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationProvider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationProvider->id)]) ?>
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
