<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroupNote $caCallGroupNote
 * @var \Cake\Collection\CollectionInterface|string[] $caCallGroups
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Ca Call Group Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="caCallGroupNotes form content">
            <?= $this->Form->create($caCallGroupNote) ?>
            <fieldset>
                <legend><?= __('Add Ca Call Group Note') ?></legend>
                <?php
                    echo $this->Form->control('ca_call_group_id', ['options' => $caCallGroups]);
                    echo $this->Form->control('body');
                    echo $this->Form->control('status');
                    echo $this->Form->control('user_id', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
