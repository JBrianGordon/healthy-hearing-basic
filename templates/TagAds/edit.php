<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagAd $tagAd
 * @var string[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tagAd->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tagAd->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tag Ads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tagAds form content">
            <?= $this->Form->create($tagAd) ?>
            <fieldset>
                <legend><?= __('Edit Tag Ad') ?></legend>
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
