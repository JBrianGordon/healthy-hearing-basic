<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentLocation $contentLocation
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 * @var string[]|\Cake\Collection\CollectionInterface $content
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contentLocation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contentLocation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Content Locations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="contentLocations form content">
            <?= $this->Form->create($contentLocation) ?>
            <fieldset>
                <legend><?= __('Edit Content Location') ?></legend>
                <?php
                    echo $this->Form->control('content_id', ['options' => $content]);
                    echo $this->Form->control('location_id', ['options' => $locations]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
