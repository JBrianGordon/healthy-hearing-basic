<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationAd $locationAd
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Ad'), ['action' => 'edit', $locationAd->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Ad'), ['action' => 'delete', $locationAd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationAd->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Ads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Ad'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationAds view content">
            <h3><?= h($locationAd->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationAd->has('location') ? $this->Html->link($locationAd->location->title, ['controller' => 'Locations', 'action' => 'view', $locationAd->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo Url') ?></th>
                    <td><?= h($locationAd->photo_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Alt') ?></th>
                    <td><?= h($locationAd->alt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($locationAd->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($locationAd->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Border') ?></th>
                    <td><?= h($locationAd->border) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationAd->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($locationAd->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($locationAd->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
