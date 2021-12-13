<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('middle_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('degrees') ?></th>
                    <th><?= $this->Paginator->sort('credentials') ?></th>
                    <th><?= $this->Paginator->sort('company') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('address_2') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('country') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('image_url') ?></th>
                    <th><?= $this->Paginator->sort('thumb_url') ?></th>
                    <th><?= $this->Paginator->sort('square_url') ?></th>
                    <th><?= $this->Paginator->sort('micro_url') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('modified_by') ?></th>
                    <th><?= $this->Paginator->sort('lastlogin') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_hardened_password') ?></th>
                    <th><?= $this->Paginator->sort('is_admin') ?></th>
                    <th><?= $this->Paginator->sort('is_it_admin') ?></th>
                    <th><?= $this->Paginator->sort('is_agent') ?></th>
                    <th><?= $this->Paginator->sort('is_call_supervisor') ?></th>
                    <th><?= $this->Paginator->sort('is_author') ?></th>
                    <th><?= $this->Paginator->sort('corp_id') ?></th>
                    <th><?= $this->Paginator->sort('is_deleted') ?></th>
                    <th><?= $this->Paginator->sort('is_csa') ?></th>
                    <th><?= $this->Paginator->sort('is_writer') ?></th>
                    <th><?= $this->Paginator->sort('recovery_email') ?></th>
                    <th><?= $this->Paginator->sort('clinic_password') ?></th>
                    <th><?= $this->Paginator->sort('timezone_offset') ?></th>
                    <th><?= $this->Paginator->sort('timezone') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= $this->Number->format($user->level) ?></td>
                    <td><?= h($user->first_name) ?></td>
                    <td><?= h($user->middle_name) ?></td>
                    <td><?= h($user->last_name) ?></td>
                    <td><?= h($user->degrees) ?></td>
                    <td><?= h($user->credentials) ?></td>
                    <td><?= h($user->company) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->phone) ?></td>
                    <td><?= h($user->address) ?></td>
                    <td><?= h($user->address_2) ?></td>
                    <td><?= h($user->city) ?></td>
                    <td><?= h($user->state) ?></td>
                    <td><?= h($user->zip) ?></td>
                    <td><?= h($user->country) ?></td>
                    <td><?= h($user->url) ?></td>
                    <td><?= h($user->image_url) ?></td>
                    <td><?= h($user->thumb_url) ?></td>
                    <td><?= h($user->square_url) ?></td>
                    <td><?= h($user->micro_url) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td><?= $this->Number->format($user->modified_by) ?></td>
                    <td><?= h($user->lastlogin) ?></td>
                    <td><?= h($user->is_active) ?></td>
                    <td><?= h($user->is_hardened_password) ?></td>
                    <td><?= h($user->is_admin) ?></td>
                    <td><?= h($user->is_it_admin) ?></td>
                    <td><?= h($user->is_agent) ?></td>
                    <td><?= h($user->is_call_supervisor) ?></td>
                    <td><?= h($user->is_author) ?></td>
                    <td><?= $this->Number->format($user->corp_id) ?></td>
                    <td><?= h($user->is_deleted) ?></td>
                    <td><?= h($user->is_csa) ?></td>
                    <td><?= h($user->is_writer) ?></td>
                    <td><?= h($user->recovery_email) ?></td>
                    <td><?= h($user->clinic_password) ?></td>
                    <td><?= $this->Number->format($user->timezone_offset) ?></td>
                    <td><?= h($user->timezone) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
