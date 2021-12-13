<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoTitle $seoTitle
 * @var string[]|\Cake\Collection\CollectionInterface $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoTitle->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoTitle->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Titles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoTitles form content">
            <?= $this->Form->create($seoTitle) ?>
            <fieldset>
                <legend><?= __('Edit Seo Title') ?></legend>
                <?php
                    echo $this->Form->control('seo_uri_id', ['options' => $seoUris]);
                    echo $this->Form->control('title');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
