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
            <?= $this->Html->link(__('List Advertisements Clicks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="advertisementsClicks form content">
            <?= $this->Form->create($advertisementsClick) ?>
            <fieldset>
                <legend><?= __('Add Advertisements Click') ?></legend>
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
