<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoRedirect $seoRedirect
 * @var string[]|\Cake\Collection\CollectionInterface $seoUris
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoRedirect->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoRedirect->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Redirects'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoRedirects form content">
            <?= $this->Form->create($seoRedirect) ?>
            <fieldset>
                <legend><?= __('Edit Seo Redirect') ?></legend>
                <?php
                    echo $this->Form->control('seo_uri_id', ['options' => $seoUris]);
                    echo $this->Form->control('redirect');
                    echo $this->Form->control('priority');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('callback');
                    echo $this->Form->control('is_nocache');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
