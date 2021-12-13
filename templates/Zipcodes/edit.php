<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zipcode $zipcode
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $zipcode->zip],
                ['confirm' => __('Are you sure you want to delete # {0}?', $zipcode->zip), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Zipcodes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="zipcodes form content">
            <?= $this->Form->create($zipcode) ?>
            <fieldset>
                <legend><?= __('Edit Zipcode') ?></legend>
                <?php
                    echo $this->Form->control('lat');
                    echo $this->Form->control('lon');
                    echo $this->Form->control('city');
                    echo $this->Form->control('state');
                    echo $this->Form->control('areacode');
                    echo $this->Form->control('country_code');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
