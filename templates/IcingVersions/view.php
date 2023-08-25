<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IcingVersion $icingVersion
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Icing Version'), ['action' => 'edit', $icingVersion->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Icing Version'), ['action' => 'delete', $icingVersion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $icingVersion->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Icing Versions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Icing Version'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="icingVersions view content">
            <h3><?= h($icingVersion->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($icingVersion->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Model Id') ?></th>
                    <td><?= h($icingVersion->id_model) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $icingVersion->has('user') ? $this->Html->link($icingVersion->user->id, ['controller' => 'Users', 'action' => 'view', $icingVersion->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($icingVersion->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($icingVersion->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($icingVersion->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($icingVersion->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $icingVersion->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Json') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($icingVersion->json)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
