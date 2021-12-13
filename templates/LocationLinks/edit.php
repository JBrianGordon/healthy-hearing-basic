<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationLink $locationLink
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locationLink->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locationLink->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Location Links'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationLinks form content">
            <?= $this->Form->create($locationLink) ?>
            <fieldset>
                <legend><?= __('Edit Location Link') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('id_linked_location');
                    echo $this->Form->control('distance');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
