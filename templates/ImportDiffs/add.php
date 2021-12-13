<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportDiff $importDiff
 * @var \Cake\Collection\CollectionInterface|string[] $imports
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Import Diffs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importDiffs form content">
            <?= $this->Form->create($importDiff) ?>
            <fieldset>
                <legend><?= __('Add Import Diff') ?></legend>
                <?php
                    echo $this->Form->control('import_id', ['options' => $imports, 'empty' => true]);
                    echo $this->Form->control('model');
                    echo $this->Form->control('id_model');
                    echo $this->Form->control('field');
                    echo $this->Form->control('value');
                    echo $this->Form->control('review_needed');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
