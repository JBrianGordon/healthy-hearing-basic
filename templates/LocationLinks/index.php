<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationLink[]|\Cake\Collection\CollectionInterface $locationLinks
 */
?>
<div class="locationLinks index content">
    <?= $this->Html->link(__('New Location Link'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Links') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('id_linked_location') ?></th>
                    <th><?= $this->Paginator->sort('distance') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationLinks as $locationLink): ?>
                <tr>
                    <td><?= $this->Number->format($locationLink->id) ?></td>
                    <td><?= $locationLink->has('location') ? $this->Html->link($locationLink->location->title, ['controller' => 'Locations', 'action' => 'view', $locationLink->location->id]) : '' ?></td>
                    <td><?= $this->Number->format($locationLink->id_linked_location) ?></td>
                    <td><?= $this->Number->format($locationLink->distance) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationLink->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationLink->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationLink->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationLink->id)]) ?>
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
