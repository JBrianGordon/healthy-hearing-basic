<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationVidscrip $locationVidscrip
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Vidscrip'), ['action' => 'edit', $locationVidscrip->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Vidscrip'), ['action' => 'delete', $locationVidscrip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationVidscrip->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Vidscrips'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Vidscrip'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationVidscrips view content">
            <h3><?= h($locationVidscrip->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationVidscrip->has('location') ? $this->Html->link($locationVidscrip->location->title, ['controller' => 'Locations', 'action' => 'view', $locationVidscrip->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Vidscrip') ?></th>
                    <td><?= h($locationVidscrip->vidscrip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($locationVidscrip->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationVidscrip->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($locationVidscrip->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($locationVidscrip->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
