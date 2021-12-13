<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentUser $contentUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Content User'), ['action' => 'edit', $contentUser->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Content User'), ['action' => 'delete', $contentUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentUser->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Content Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Content User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="contentUsers view content">
            <h3><?= h($contentUser->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Content') ?></th>
                    <td><?= $contentUser->has('content') ? $this->Html->link($contentUser->content->title, ['controller' => 'Content', 'action' => 'view', $contentUser->content->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $contentUser->has('user') ? $this->Html->link($contentUser->user->id, ['controller' => 'Users', 'action' => 'view', $contentUser->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contentUser->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
