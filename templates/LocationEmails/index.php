<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationEmail[]|\Cake\Collection\CollectionInterface $locationEmails
 */
?>
<div class="locationEmails index content">
    <?= $this->Html->link(__('New Location Email'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Emails') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationEmails as $locationEmail): ?>
                <tr>
                    <td><?= $this->Number->format($locationEmail->id) ?></td>
                    <td><?= $locationEmail->has('location') ? $this->Html->link($locationEmail->location->title, ['controller' => 'Locations', 'action' => 'view', $locationEmail->location->id]) : '' ?></td>
                    <td><?= h($locationEmail->email) ?></td>
                    <td><?= h($locationEmail->first_name) ?></td>
                    <td><?= h($locationEmail->last_name) ?></td>
                    <td><?= h($locationEmail->created) ?></td>
                    <td><?= h($locationEmail->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationEmail->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationEmail->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationEmail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationEmail->id)]) ?>
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
