<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentLocation $contentLocation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Content Location'), ['action' => 'edit', $contentLocation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Content Location'), ['action' => 'delete', $contentLocation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentLocation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Content Locations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Content Location'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="contentLocations view content">
            <h3><?= h($contentLocation->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Content') ?></th>
                    <td><?= $contentLocation->has('content') ? $this->Html->link($contentLocation->content->title, ['controller' => 'Content', 'action' => 'view', $contentLocation->content->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $contentLocation->has('location') ? $this->Html->link($contentLocation->location->title, ['controller' => 'Locations', 'action' => 'view', $contentLocation->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contentLocation->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
