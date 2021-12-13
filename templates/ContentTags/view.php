<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentTag $contentTag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Content Tag'), ['action' => 'edit', $contentTag->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Content Tag'), ['action' => 'delete', $contentTag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentTag->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Content Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Content Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="contentTags view content">
            <h3><?= h($contentTag->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Content') ?></th>
                    <td><?= $contentTag->has('content') ? $this->Html->link($contentTag->content->title, ['controller' => 'Content', 'action' => 'view', $contentTag->content->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= $contentTag->has('tag') ? $this->Html->link($contentTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $contentTag->tag->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contentTag->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
