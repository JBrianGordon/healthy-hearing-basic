<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationNote $locationNote
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Note'), ['action' => 'edit', $locationNote->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Note'), ['action' => 'delete', $locationNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationNote->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Note'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationNotes view content">
            <h3><?= h($locationNote->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationNote->has('location') ? $this->Html->link($locationNote->location->title, ['controller' => 'Locations', 'action' => 'view', $locationNote->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $locationNote->has('user') ? $this->Html->link($locationNote->user->id, ['controller' => 'Users', 'action' => 'view', $locationNote->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationNote->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($locationNote->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($locationNote->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($locationNote->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($locationNote->body)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
