<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoCanonical $seoCanonical
 * @var string[]|\Cake\Collection\CollectionInterface $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoCanonical->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoCanonical->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Canonicals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoCanonicals form content">
            <?= $this->Form->create($seoCanonical) ?>
            <fieldset>
                <legend><?= __('Edit Seo Canonical') ?></legend>
                <?php
                    echo $this->Form->control('seo_uri_id', ['options' => $seoUris]);
                    echo $this->Form->control('canonical');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
