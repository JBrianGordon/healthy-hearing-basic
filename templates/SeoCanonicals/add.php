<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoCanonical $seoCanonical
 * @var \Cake\Collection\CollectionInterface|string[] $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Seo Canonicals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoCanonicals form content">
            <?= $this->Form->create($seoCanonical) ?>
            <fieldset>
                <legend><?= __('Add Seo Canonical') ?></legend>
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
