<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportProvider $importProvider
 * @var \Cake\Collection\CollectionInterface|string[] $imports
 * @var \Cake\Collection\CollectionInterface|string[] $providers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Import Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importProviders form content">
            <?= $this->Form->create($importProvider) ?>
            <fieldset>
                <legend><?= __('Add Import Provider') ?></legend>
                <?php
                    echo $this->Form->control('import_id', ['options' => $imports, 'empty' => true]);
                    echo $this->Form->control('id_external');
                    echo $this->Form->control('provider_id', ['options' => $providers, 'empty' => true]);
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('aud_or_his');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
