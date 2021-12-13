<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationVidscrip[]|\Cake\Collection\CollectionInterface $locationVidscrips
 */
?>
<div class="locationVidscrips index content">
    <?= $this->Html->link(__('New Location Vidscrip'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Vidscrips') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('vidscrip') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationVidscrips as $locationVidscrip): ?>
                <tr>
                    <td><?= $this->Number->format($locationVidscrip->id) ?></td>
                    <td><?= $locationVidscrip->has('location') ? $this->Html->link($locationVidscrip->location->title, ['controller' => 'Locations', 'action' => 'view', $locationVidscrip->location->id]) : '' ?></td>
                    <td><?= h($locationVidscrip->vidscrip) ?></td>
                    <td><?= h($locationVidscrip->email) ?></td>
                    <td><?= h($locationVidscrip->created) ?></td>
                    <td><?= h($locationVidscrip->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationVidscrip->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationVidscrip->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationVidscrip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationVidscrip->id)]) ?>
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
