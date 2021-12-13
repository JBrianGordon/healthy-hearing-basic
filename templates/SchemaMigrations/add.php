<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchemaMigration $schemaMigration
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Schema Migrations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="schemaMigrations form content">
            <?= $this->Form->create($schemaMigration) ?>
            <fieldset>
                <legend><?= __('Add Schema Migration') ?></legend>
                <?php
                    echo $this->Form->control('class');
                    echo $this->Form->control('type');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
