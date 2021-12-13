<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoStatusCode $seoStatusCode
 * @var \Cake\Collection\CollectionInterface|string[] $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Seo Status Codes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoStatusCodes form content">
            <?= $this->Form->create($seoStatusCode) ?>
            <fieldset>
                <legend><?= __('Add Seo Status Code') ?></legend>
                <?php
                    echo $this->Form->control('seo_uri_id', ['options' => $seoUris]);
                    echo $this->Form->control('status_code');
                    echo $this->Form->control('priority');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
