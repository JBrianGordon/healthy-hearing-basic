<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SitemapUrl $sitemapUrl
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sitemapUrl->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sitemapUrl->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Sitemap Urls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sitemapUrls form content">
            <?= $this->Form->create($sitemapUrl) ?>
            <fieldset>
                <legend><?= __('Edit Sitemap Url') ?></legend>
                <?php
                    echo $this->Form->control('model');
                    echo $this->Form->control('url');
                    echo $this->Form->control('priority');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
