<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportStatus $importStatus
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Import Status'), ['action' => 'edit', $importStatus->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Import Status'), ['action' => 'delete', $importStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importStatus->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Import Status'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Import Status'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importStatus view content">
            <h3><?= h($importStatus->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $importStatus->has('location') ? $this->Html->link($importStatus->location->title, ['controller' => 'Locations', 'action' => 'view', $importStatus->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Listing Type') ?></th>
                    <td><?= h($importStatus->listing_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($importStatus->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($importStatus->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Oticon Tier') ?></th>
                    <td><?= $this->Number->format($importStatus->oticon_tier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($importStatus->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $importStatus->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Show') ?></th>
                    <td><?= $importStatus->is_show ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Grace Period') ?></th>
                    <td><?= $importStatus->is_grace_period ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
