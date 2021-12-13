<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AdvertisementsClick $advertisementsClick
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Advertisements Click'), ['action' => 'edit', $advertisementsClick->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Advertisements Click'), ['action' => 'delete', $advertisementsClick->id], ['confirm' => __('Are you sure you want to delete # {0}?', $advertisementsClick->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Advertisements Clicks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Advertisements Click'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="advertisementsClicks view content">
            <h3><?= h($advertisementsClick->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Ref') ?></th>
                    <td><?= h($advertisementsClick->ref) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($advertisementsClick->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($advertisementsClick->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ad Id') ?></th>
                    <td><?= $this->Number->format($advertisementsClick->ad_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($advertisementsClick->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
