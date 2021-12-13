<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCall $caCall
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Ca Call'), ['action' => 'edit', $caCall->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ca Call'), ['action' => 'delete', $caCall->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCall->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Ca Calls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ca Call'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="caCalls view content">
            <h3><?= h($caCall->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Ca Call Group') ?></th>
                    <td><?= $caCall->has('ca_call_group') ? $this->Html->link($caCall->ca_call_group->id, ['controller' => 'CaCallGroups', 'action' => 'view', $caCall->ca_call_group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $caCall->has('user') ? $this->Html->link($caCall->user->id, ['controller' => 'Users', 'action' => 'view', $caCall->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Call Type') ?></th>
                    <td><?= h($caCall->call_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recording Url') ?></th>
                    <td><?= h($caCall->recording_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($caCall->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Duration') ?></th>
                    <td><?= $this->Number->format($caCall->duration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recording Duration') ?></th>
                    <td><?= $this->Number->format($caCall->recording_duration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= h($caCall->start_time) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
