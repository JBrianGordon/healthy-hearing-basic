<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCall $caCall
 * @var \Cake\Collection\CollectionInterface|string[] $caCallGroups
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Ca Calls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="caCalls form content">
            <?= $this->Form->create($caCall) ?>
            <fieldset>
                <legend><?= __('Add Ca Call') ?></legend>
                <?php
                    echo $this->Form->control('ca_call_group_id', ['options' => $caCallGroups]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('start_time', ['empty' => true]);
                    echo $this->Form->control('duration');
                    echo $this->Form->control('call_type');
                    echo $this->Form->control('recording_url');
                    echo $this->Form->control('recording_duration');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
