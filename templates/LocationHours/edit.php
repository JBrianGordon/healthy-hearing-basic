<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationHour $locationHour
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locationHour->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locationHour->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Location Hours'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationHours form content">
            <?= $this->Form->create($locationHour) ?>
            <fieldset>
                <legend><?= __('Edit Location Hour') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('sun_open');
                    echo $this->Form->control('sun_close');
                    echo $this->Form->control('sun_is_closed');
                    echo $this->Form->control('sun_is_byappt');
                    echo $this->Form->control('mon_open');
                    echo $this->Form->control('mon_close');
                    echo $this->Form->control('mon_is_closed');
                    echo $this->Form->control('mon_is_byappt');
                    echo $this->Form->control('tue_open');
                    echo $this->Form->control('tue_close');
                    echo $this->Form->control('tue_is_closed');
                    echo $this->Form->control('tue_is_byappt');
                    echo $this->Form->control('wed_open');
                    echo $this->Form->control('wed_close');
                    echo $this->Form->control('wed_is_closed');
                    echo $this->Form->control('wed_is_byappt');
                    echo $this->Form->control('thu_open');
                    echo $this->Form->control('thu_close');
                    echo $this->Form->control('thu_is_closed');
                    echo $this->Form->control('thu_is_byappt');
                    echo $this->Form->control('fri_open');
                    echo $this->Form->control('fri_close');
                    echo $this->Form->control('fri_is_closed');
                    echo $this->Form->control('fri_is_byappt');
                    echo $this->Form->control('sat_open');
                    echo $this->Form->control('sat_close');
                    echo $this->Form->control('sat_is_closed');
                    echo $this->Form->control('sat_is_byappt');
                    echo $this->Form->control('is_evening_weekend_hours');
                    echo $this->Form->control('is_closed_lunch');
                    echo $this->Form->control('lunch_start');
                    echo $this->Form->control('lunch_end');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
