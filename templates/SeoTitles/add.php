<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoTitle $seoTitle
 * @var \Cake\Collection\CollectionInterface|string[] $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Seo Titles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoTitles form content">
            <?= $this->Form->create($seoTitle) ?>
            <fieldset>
                <legend><?= __('Add Seo Title') ?></legend>
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
