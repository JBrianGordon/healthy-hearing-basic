<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Reviews'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reviews form content">
            <?= $this->Form->create($review) ?>
            <fieldset>
                <legend><?= __('Add Review') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('body');
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('zip');
                    echo $this->Form->control('rating');
                    echo $this->Form->control('is_spam');
                    echo $this->Form->control('status');
                    echo $this->Form->control('origin');
                    echo $this->Form->control('response');
                    echo $this->Form->control('response_status');
                    echo $this->Form->control('denied_date', ['empty' => true]);
                    echo $this->Form->control('ip');
                    echo $this->Form->control('character_count');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
