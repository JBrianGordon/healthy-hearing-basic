<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportLocationProvider $importLocationProvider
 * @var \Cake\Collection\CollectionInterface|string[] $imports
 * @var \Cake\Collection\CollectionInterface|string[] $importLocations
 * @var \Cake\Collection\CollectionInterface|string[] $importProviders
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Import Location Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importLocationProviders form content">
            <?= $this->Form->create($importLocationProvider) ?>
            <fieldset>
                <legend><?= __('Add Import Location Provider') ?></legend>
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
