<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CrmSearch $crmSearch
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Crm Search'), ['action' => 'edit', $crmSearch->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Crm Search'), ['action' => 'delete', $crmSearch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearch->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Crm Searches'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Crm Search'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="crmSearches view content">
            <h3><?= h($crmSearch->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $crmSearch->has('user') ? $this->Html->link($crmSearch->user->id, ['controller' => 'Users', 'action' => 'view', $crmSearch->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($crmSearch->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($crmSearch->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($crmSearch->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $this->Number->format($crmSearch->order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($crmSearch->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($crmSearch->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Public') ?></th>
                    <td><?= $crmSearch->is_public ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Search') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($crmSearch->search)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
