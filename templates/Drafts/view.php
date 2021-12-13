<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Draft $draft
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Draft'), ['action' => 'edit', $draft->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Draft'), ['action' => 'delete', $draft->id], ['confirm' => __('Are you sure you want to delete # {0}?', $draft->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Drafts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Draft'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="drafts view content">
            <h3><?= h($draft->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($draft->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Model Id') ?></th>
                    <td><?= h($draft->model_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($draft->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $draft->has('user') ? $this->Html->link($draft->user->id, ['controller' => 'Users', 'action' => 'view', $draft->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($draft->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($draft->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Json') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($draft->json)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
