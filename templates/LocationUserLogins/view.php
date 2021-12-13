<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUserLogin $locationUserLogin
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location User Login'), ['action' => 'edit', $locationUserLogin->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location User Login'), ['action' => 'delete', $locationUserLogin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationUserLogin->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location User Logins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location User Login'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationUserLogins view content">
            <h3><?= h($locationUserLogin->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location User') ?></th>
                    <td><?= $locationUserLogin->has('location_user') ? $this->Html->link($locationUserLogin->location_user->id, ['controller' => 'LocationUsers', 'action' => 'view', $locationUserLogin->location_user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($locationUserLogin->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationUserLogin->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Login Date') ?></th>
                    <td><?= h($locationUserLogin->login_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
