<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUserLogin[]|\Cake\Collection\CollectionInterface $locationUserLogins
 */
?>
<div class="locationUserLogins index content">
    <?= $this->Html->link(__('New Location User Login'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location User Logins') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_user_id') ?></th>
                    <th><?= $this->Paginator->sort('login_date') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationUserLogins as $locationUserLogin): ?>
                <tr>
                    <td><?= $this->Number->format($locationUserLogin->id) ?></td>
                    <td><?= $locationUserLogin->has('location_user') ? $this->Html->link($locationUserLogin->location_user->id, ['controller' => 'LocationUsers', 'action' => 'view', $locationUserLogin->location_user->id]) : '' ?></td>
                    <td><?= h($locationUserLogin->login_date) ?></td>
                    <td><?= h($locationUserLogin->ip) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationUserLogin->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationUserLogin->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationUserLogin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationUserLogin->id)]) ?>
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
