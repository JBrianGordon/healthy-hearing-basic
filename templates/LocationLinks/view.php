<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationLink $locationLink
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Link'), ['action' => 'edit', $locationLink->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Link'), ['action' => 'delete', $locationLink->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationLink->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Links'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Link'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationLinks view content">
            <h3><?= h($locationLink->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationLink->has('location') ? $this->Html->link($locationLink->location->title, ['controller' => 'Locations', 'action' => 'view', $locationLink->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationLink->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Linked Location') ?></th>
                    <td><?= $this->Number->format($locationLink->id_linked_location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Distance') ?></th>
                    <td><?= $this->Number->format($locationLink->distance) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
