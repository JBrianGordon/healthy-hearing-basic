<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IcingVersion $icingVersion
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $icingVersion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $icingVersion->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Icing Versions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="icingVersions form content">
            <?= $this->Form->create($icingVersion) ?>
            <fieldset>
                <legend><?= __('Edit Icing Version') ?></legend>
                <?php
                    echo $this->Form->control('id_model');
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
