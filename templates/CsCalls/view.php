<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall $csCall
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cs Call'), ['action' => 'edit', $csCall->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cs Call'), ['action' => 'delete', $csCall->id], ['confirm' => __('Are you sure you want to delete # {0}?', $csCall->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cs Calls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cs Call'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="csCalls view content">
            <h3><?= h($csCall->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $csCall->has('location') ? $this->Html->link($csCall->location->title, ['controller' => 'Locations', 'action' => 'view', $csCall->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Ad Source') ?></th>
                    <td><?= h($csCall->ad_source) ?></td>
                </tr>
                <tr>
                    <th><?= __('Result') ?></th>
                    <td><?= h($csCall->result) ?></td>
                </tr>
                <tr>
                    <th><?= __('Call Type') ?></th>
                    <td><?= h($csCall->call_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Call Status') ?></th>
                    <td><?= h($csCall->call_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Leadscore') ?></th>
                    <td><?= h($csCall->leadscore) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recording Url') ?></th>
                    <td><?= h($csCall->recording_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tracking Number') ?></th>
                    <td><?= h($csCall->tracking_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Caller Phone') ?></th>
                    <td><?= h($csCall->caller_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinic Phone') ?></th>
                    <td><?= h($csCall->clinic_phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Caller Firstname') ?></th>
                    <td><?= h($csCall->caller_firstname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Caller Lastname') ?></th>
                    <td><?= h($csCall->caller_lastname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Prospect') ?></th>
                    <td><?= h($csCall->prospect) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($csCall->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Call Id') ?></th>
                    <td><?= $this->Number->format($csCall->call_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Duration') ?></th>
                    <td><?= $this->Number->format($csCall->duration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= h($csCall->start_time) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
