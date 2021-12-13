<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationProvider $locationProvider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Provider'), ['action' => 'edit', $locationProvider->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Provider'), ['action' => 'delete', $locationProvider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationProvider->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Provider'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationProviders view content">
            <h3><?= h($locationProvider->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationProvider->has('location') ? $this->Html->link($locationProvider->location->title, ['controller' => 'Locations', 'action' => 'view', $locationProvider->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Provider') ?></th>
                    <td><?= $locationProvider->has('provider') ? $this->Html->link($locationProvider->provider->title, ['controller' => 'Providers', 'action' => 'view', $locationProvider->provider->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationProvider->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
