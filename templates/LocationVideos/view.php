<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationVideo $locationVideo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Video'), ['action' => 'edit', $locationVideo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Video'), ['action' => 'delete', $locationVideo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationVideo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Videos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Video'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationVideos view content">
            <h3><?= h($locationVideo->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationVideo->has('location') ? $this->Html->link($locationVideo->location->title, ['controller' => 'Locations', 'action' => 'view', $locationVideo->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Video Url') ?></th>
                    <td><?= h($locationVideo->video_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationVideo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($locationVideo->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($locationVideo->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
