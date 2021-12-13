<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CallSource $callSource
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $callSource->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $callSource->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Call Sources'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="callSources form content">
            <?= $this->Form->create($callSource) ?>
            <fieldset>
                <legend><?= __('Edit Call Source') ?></legend>
                <?php
                    echo $this->Form->control('customer_name');
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('phone_number');
                    echo $this->Form->control('target_number');
                    echo $this->Form->control('clinic_number');
                    echo $this->Form->control('start_date');
                    echo $this->Form->control('end_date');
                    echo $this->Form->control('is_ivr_enabled');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
