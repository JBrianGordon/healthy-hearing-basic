<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUser $locationUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location User'), ['action' => 'edit', $locationUser->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location User'), ['action' => 'delete', $locationUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationUser->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationUsers view content">
            <h3><?= h($locationUser->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($locationUser->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($locationUser->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($locationUser->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($locationUser->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reset Url') ?></th>
                    <td><?= h($locationUser->reset_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinic Password') ?></th>
                    <td><?= h($locationUser->clinic_password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationUser->has('location') ? $this->Html->link($locationUser->location->title, ['controller' => 'Locations', 'action' => 'view', $locationUser->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationUser->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($locationUser->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($locationUser->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lastlogin') ?></th>
                    <td><?= h($locationUser->lastlogin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reset Expiration Date') ?></th>
                    <td><?= h($locationUser->reset_expiration_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $locationUser->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Location User Logins') ?></h4>
                <?php if (!empty($locationUser->location_user_logins)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location User Id') ?></th>
                            <th><?= __('Login Date') ?></th>
                            <th><?= __('Ip') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($locationUser->location_user_logins as $locationUserLogins) : ?>
                        <tr>
                            <td><?= h($locationUserLogins->id) ?></td>
                            <td><?= h($locationUserLogins->location_user_id) ?></td>
                            <td><?= h($locationUserLogins->login_date) ?></td>
                            <td><?= h($locationUserLogins->ip) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationUserLogins', 'action' => 'view', $locationUserLogins->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationUserLogins', 'action' => 'edit', $locationUserLogins->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationUserLogins', 'action' => 'delete', $locationUserLogins->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationUserLogins->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
