<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoMetaTag $seoMetaTag
 * @var string[]|\Cake\Collection\CollectionInterface $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoMetaTag->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoMetaTag->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Meta Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoMetaTags form content">
            <?= $this->Form->create($seoMetaTag) ?>
            <fieldset>
                <legend><?= __('Edit Seo Meta Tag') ?></legend>
                <?php
                    echo $this->Form->control('seo_uri_id', ['options' => $seoUris]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('content');
                    echo $this->Form->control('is_http_equiv');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
