<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportLocation[]|\Cake\Collection\CollectionInterface $importLocations
 */
?>
<div class="importLocations index content">
    <?= $this->Html->link(__('New Import Location'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Import Locations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('import_id') ?></th>
                    <th><?= $this->Paginator->sort('id_external') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('id_oticon') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('subtitle') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('address_2') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('match_type') ?></th>
                    <th><?= $this->Paginator->sort('is_retail') ?></th>
                    <th><?= $this->Paginator->sort('is_new') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($importLocations as $importLocation): ?>
                <tr>
                    <td><?= $this->Number->format($importLocation->id) ?></td>
                    <td><?= $importLocation->has('import') ? $this->Html->link($importLocation->import->id, ['controller' => 'Imports', 'action' => 'view', $importLocation->import->id]) : '' ?></td>
                    <td><?= h($importLocation->id_external) ?></td>
                    <td><?= $importLocation->has('location') ? $this->Html->link($importLocation->location->title, ['controller' => 'Locations', 'action' => 'view', $importLocation->location->id]) : '' ?></td>
                    <td><?= h($importLocation->id_oticon) ?></td>
                    <td><?= h($importLocation->title) ?></td>
                    <td><?= h($importLocation->subtitle) ?></td>
                    <td><?= h($importLocation->email) ?></td>
                    <td><?= h($importLocation->address) ?></td>
                    <td><?= h($importLocation->address_2) ?></td>
                    <td><?= h($importLocation->city) ?></td>
                    <td><?= h($importLocation->state) ?></td>
                    <td><?= h($importLocation->zip) ?></td>
                    <td><?= h($importLocation->phone) ?></td>
                    <td><?= $this->Number->format($importLocation->match_type) ?></td>
                    <td><?= h($importLocation->is_retail) ?></td>
                    <td><?= h($importLocation->is_new) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $importLocation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $importLocation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $importLocation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importLocation->id)]) ?>
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
