<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportLocationProvider $importLocationProvider
 * @var string[]|\Cake\Collection\CollectionInterface $imports
 * @var string[]|\Cake\Collection\CollectionInterface $importLocations
 * @var string[]|\Cake\Collection\CollectionInterface $importProviders
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $importLocationProvider->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $importLocationProvider->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Import Location Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importLocationProviders form content">
            <?= $this->Form->create($importLocationProvider) ?>
            <fieldset>
                <legend><?= __('Edit Import Location Provider') ?></legend>
                <?php
                    echo $this->Form->control('import_id', ['options' => $imports, 'empty' => true]);
                    echo $this->Form->control('import_location_id', ['options' => $importLocations, 'empty' => true]);
                    echo $this->Form->control('import_provider_id', ['options' => $importProviders, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
