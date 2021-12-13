<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationProvider $locationProvider
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 * @var string[]|\Cake\Collection\CollectionInterface $providers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locationProvider->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locationProvider->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Location Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationProviders form content">
            <?= $this->Form->create($locationProvider) ?>
            <fieldset>
                <legend><?= __('Edit Location Provider') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations, 'empty' => true]);
                    echo $this->Form->control('provider_id', ['options' => $providers, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
