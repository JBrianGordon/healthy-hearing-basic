<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationNote $locationNote
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locationNote->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locationNote->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Location Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationNotes form content">
            <?= $this->Form->create($locationNote) ?>
            <fieldset>
                <legend><?= __('Edit Location Note') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
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
