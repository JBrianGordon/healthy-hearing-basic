<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagAd $tagAd
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tag Ads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tagAds form content">
            <?= $this->Form->create($tagAd) ?>
            <fieldset>
                <legend><?= __('Add Tag Ad') ?></legend>
                <?php
                    echo $this->Form->control('ad_id');
                    echo $this->Form->control('tag_id', ['options' => $tags]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
