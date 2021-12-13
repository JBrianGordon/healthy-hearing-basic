<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationEmail $locationEmail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Email'), ['action' => 'edit', $locationEmail->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Email'), ['action' => 'delete', $locationEmail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationEmail->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Emails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Email'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationEmails view content">
            <h3><?= h($locationEmail->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationEmail->has('location') ? $this->Html->link($locationEmail->location->title, ['controller' => 'Locations', 'action' => 'view', $locationEmail->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($locationEmail->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($locationEmail->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($locationEmail->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationEmail->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($locationEmail->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($locationEmail->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
