<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationAd $locationAd
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Location Ads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationAds form content">
            <?= $this->Form->create($locationAd) ?>
            <fieldset>
                <legend><?= __('Add Location Ad') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('photo_url');
                    echo $this->Form->control('alt');
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('border');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
