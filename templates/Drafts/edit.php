<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Draft $draft
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $draft->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $draft->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Drafts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="drafts form content">
            <?= $this->Form->create($draft) ?>
            <fieldset>
                <legend><?= __('Edit Draft') ?></legend>
                <?php
                    echo $this->Form->control('model_id');
                    echo $this->Form->control('model');
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('json');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
