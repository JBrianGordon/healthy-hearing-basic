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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $advertisementsClick->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $advertisementsClick->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Advertisements Clicks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="advertisementsClicks form content">
            <?= $this->Form->create($advertisementsClick) ?>
            <fieldset>
                <legend><?= __('Edit Advertisements Click') ?></legend>
                <?php
                    echo $this->Form->control('ad_id');
                    echo $this->Form->control('ref');
                    echo $this->Form->control('ip');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
