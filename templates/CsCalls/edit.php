<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall $csCall
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $csCall->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $csCall->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cs Calls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="csCalls form content">
            <?= $this->Form->create($csCall) ?>
            <fieldset>
                <legend><?= __('Edit Cs Call') ?></legend>
                <?php
                    echo $this->Form->control('call_id');
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('ad_source');
                    echo $this->Form->control('start_time', ['empty' => true]);
                    echo $this->Form->control('result');
                    echo $this->Form->control('duration');
                    echo $this->Form->control('call_type');
                    echo $this->Form->control('call_status');
                    echo $this->Form->control('leadscore');
                    echo $this->Form->control('recording_url');
                    echo $this->Form->control('tracking_number');
                    echo $this->Form->control('caller_phone');
                    echo $this->Form->control('clinic_phone');
                    echo $this->Form->control('caller_firstname');
                    echo $this->Form->control('caller_lastname');
                    echo $this->Form->control('prospect');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
