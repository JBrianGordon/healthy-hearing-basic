<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportDiff $importDiff
 * @var string[]|\Cake\Collection\CollectionInterface $imports
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $importDiff->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $importDiff->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Import Diffs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importDiffs form content">
            <?= $this->Form->create($importDiff) ?>
            <fieldset>
                <legend><?= __('Edit Import Diff') ?></legend>
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
