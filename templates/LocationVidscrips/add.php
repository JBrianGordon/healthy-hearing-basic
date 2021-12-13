<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationVidscrip $locationVidscrip
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Location Vidscrips'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationVidscrips form content">
            <?= $this->Form->create($locationVidscrip) ?>
            <fieldset>
                <legend><?= __('Add Location Vidscrip') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('vidscrip');
                    echo $this->Form->control('email');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
