<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoStatusCode $seoStatusCode
 * @var string[]|\Cake\Collection\CollectionInterface $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoStatusCode->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoStatusCode->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Status Codes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoStatusCodes form content">
            <?= $this->Form->create($seoStatusCode) ?>
            <fieldset>
                <legend><?= __('Edit Seo Status Code') ?></legend>
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
