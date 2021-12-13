<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersWiki $usersWiki
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Users Wiki'), ['action' => 'edit', $usersWiki->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Users Wiki'), ['action' => 'delete', $usersWiki->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersWiki->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Users Wiki'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usersWikis view content">
            <h3><?= h($usersWiki->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Wiki') ?></th>
                    <td><?= $usersWiki->has('wiki') ? $this->Html->link($usersWiki->wiki->name, ['controller' => 'Wikis', 'action' => 'view', $usersWiki->wiki->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $usersWiki->has('user') ? $this->Html->link($usersWiki->user->id, ['controller' => 'Users', 'action' => 'view', $usersWiki->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($usersWiki->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
