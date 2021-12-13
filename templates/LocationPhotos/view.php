<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationPhoto $locationPhoto
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Photo'), ['action' => 'edit', $locationPhoto->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Photo'), ['action' => 'delete', $locationPhoto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationPhoto->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Photo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationPhotos view content">
            <h3><?= h($locationPhoto->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationPhoto->has('location') ? $this->Html->link($locationPhoto->location->title, ['controller' => 'Locations', 'action' => 'view', $locationPhoto->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo Url') ?></th>
                    <td><?= h($locationPhoto->photo_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Alt') ?></th>
                    <td><?= h($locationPhoto->alt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationPhoto->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($locationPhoto->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($locationPhoto->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
