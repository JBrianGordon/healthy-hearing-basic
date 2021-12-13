<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUser[]|\Cake\Collection\CollectionInterface $locationUsers
 */
?>
<div class="locationUsers index content">
    <?= $this->Html->link(__('New Location User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('lastlogin') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('reset_url') ?></th>
                    <th><?= $this->Paginator->sort('reset_expiration_date') ?></th>
                    <th><?= $this->Paginator->sort('clinic_password') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationUsers as $locationUser): ?>
                <tr>
                    <td><?= $this->Number->format($locationUser->id) ?></td>
                    <td><?= h($locationUser->username) ?></td>
                    <td><?= h($locationUser->first_name) ?></td>
                    <td><?= h($locationUser->last_name) ?></td>
                    <td><?= h($locationUser->email) ?></td>
                    <td><?= h($locationUser->created) ?></td>
                    <td><?= h($locationUser->modified) ?></td>
                    <td><?= h($locationUser->lastlogin) ?></td>
                    <td><?= h($locationUser->is_active) ?></td>
                    <td><?= h($locationUser->reset_url) ?></td>
                    <td><?= h($locationUser->reset_expiration_date) ?></td>
                    <td><?= h($locationUser->clinic_password) ?></td>
                    <td><?= $locationUser->has('location') ? $this->Html->link($locationUser->location->title, ['controller' => 'Locations', 'action' => 'view', $locationUser->location->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationUser->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationUser->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationUser->id)]) ?>
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
