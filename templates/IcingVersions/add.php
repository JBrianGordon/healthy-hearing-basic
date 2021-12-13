<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IcingVersion $icingVersion
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Icing Versions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="icingVersions form content">
            <?= $this->Form->create($icingVersion) ?>
            <fieldset>
                <legend><?= __('Add Icing Version') ?></legend>
                <?php
                    echo $this->Form->control('model_id');
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('model');
                    echo $this->Form->control('json');
                    echo $this->Form->control('url');
                    echo $this->Form->control('ip');
                    echo $this->Form->control('is_delete');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
