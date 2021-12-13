<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorpsUser $corpsUser
 * @var \Cake\Collection\CollectionInterface|string[] $corps
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Corps Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="corpsUsers form content">
            <?= $this->Form->create($corpsUser) ?>
            <fieldset>
                <legend><?= __('Add Corps User') ?></legend>
                <?php
                    echo $this->Form->control('corp_id', ['options' => $corps]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
