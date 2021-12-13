<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorpsUser $corpsUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Corps User'), ['action' => 'edit', $corpsUser->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Corps User'), ['action' => 'delete', $corpsUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corpsUser->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Corps Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Corps User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="corpsUsers view content">
            <h3><?= h($corpsUser->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Corp') ?></th>
                    <td><?= $corpsUser->has('corp') ? $this->Html->link($corpsUser->corp->title, ['controller' => 'Corps', 'action' => 'view', $corpsUser->corp->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $corpsUser->has('user') ? $this->Html->link($corpsUser->user->id, ['controller' => 'Users', 'action' => 'view', $corpsUser->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($corpsUser->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
