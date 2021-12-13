<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationVideo $locationVideo
 * @var string[]|\Cake\Collection\CollectionInterface $locations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locationVideo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locationVideo->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Location Videos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationVideos form content">
            <?= $this->Form->create($locationVideo) ?>
            <fieldset>
                <legend><?= __('Edit Location Video') ?></legend>
                <?php
                    echo $this->Form->control('location_id', ['options' => $locations]);
                    echo $this->Form->control('video_url');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
