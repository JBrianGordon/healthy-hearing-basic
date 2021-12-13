<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportStatus $importStatus
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Import Status'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importStatus form content">
            <?= $this->Form->create($importStatus) ?>
            <fieldset>
                <legend><?= __('Add Import Status') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('oticon_tier');
                    echo $this->Form->control('listing_type');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_show');
                    echo $this->Form->control('is_grace_period');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
