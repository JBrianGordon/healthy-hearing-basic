<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Import $import
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $import->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $import->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Imports'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="imports form content">
            <?= $this->Form->create($import) ?>
            <fieldset>
                <legend><?= __('Edit Import') ?></legend>
                <?php
                    echo $this->Form->control('type');
                    echo $this->Form->control('total_locations');
                    echo $this->Form->control('new_locations');
                    echo $this->Form->control('updated_locations');
                    echo $this->Form->control('total_providers');
                    echo $this->Form->control('new_providers');
                    echo $this->Form->control('updated_providers');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
