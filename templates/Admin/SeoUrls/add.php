<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUrl $seoUrl
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Seo Urls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoUrls form content">
            <?= $this->Form->create($seoUrl) ?>
            <fieldset>
                <legend><?= __('Add Seo Url') ?></legend>
                <?php
                    echo $this->Form->control('url');
                    echo $this->Form->control('redirect_url');
                    echo $this->Form->control('redirect_is_active');
                    echo $this->Form->control('seo_title');
                    echo $this->Form->control('seo_meta_description');
                    echo $this->Form->control('status_code');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
