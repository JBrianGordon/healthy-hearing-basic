<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CallSource $callSource
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Call Source'), ['action' => 'edit', $callSource->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Call Source'), ['action' => 'delete', $callSource->id], ['confirm' => __('Are you sure you want to delete # {0}?', $callSource->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Call Sources'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Call Source'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="callSources view content">
            <h3><?= h($callSource->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Customer Name') ?></th>
                    <td><?= h($callSource->customer_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $callSource->has('location') ? $this->Html->link($callSource->location->title, ['controller' => 'Locations', 'action' => 'view', $callSource->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Number') ?></th>
                    <td><?= h($callSource->phone_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Target Number') ?></th>
                    <td><?= h($callSource->target_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clinic Number') ?></th>
                    <td><?= h($callSource->clinic_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($callSource->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($callSource->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($callSource->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($callSource->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $callSource->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Ivr Enabled') ?></th>
                    <td><?= $callSource->is_ivr_enabled ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($callSource->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
