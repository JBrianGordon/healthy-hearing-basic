<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroupNote $caCallGroupNote
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Ca Call Group Note'), ['action' => 'edit', $caCallGroupNote->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ca Call Group Note'), ['action' => 'delete', $caCallGroupNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroupNote->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Ca Call Group Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ca Call Group Note'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="caCallGroupNotes view content">
            <h3><?= h($caCallGroupNote->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Ca Call Group') ?></th>
                    <td><?= $caCallGroupNote->has('ca_call_group') ? $this->Html->link($caCallGroupNote->ca_call_group->id, ['controller' => 'CaCallGroups', 'action' => 'view', $caCallGroupNote->ca_call_group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($caCallGroupNote->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $caCallGroupNote->has('user') ? $this->Html->link($caCallGroupNote->user->id, ['controller' => 'Users', 'action' => 'view', $caCallGroupNote->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($caCallGroupNote->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($caCallGroupNote->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($caCallGroupNote->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($caCallGroupNote->body)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
