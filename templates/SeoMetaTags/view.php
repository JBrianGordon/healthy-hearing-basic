<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoMetaTag $seoMetaTag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Meta Tag'), ['action' => 'edit', $seoMetaTag->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Meta Tag'), ['action' => 'delete', $seoMetaTag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoMetaTag->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Meta Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Meta Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoMetaTags view content">
            <h3><?= h($seoMetaTag->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Seo Uri') ?></th>
                    <td><?= $seoMetaTag->has('seo_uri') ? $this->Html->link($seoMetaTag->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoMetaTag->seo_uri->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($seoMetaTag->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoMetaTag->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoMetaTag->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($seoMetaTag->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Http Equiv') ?></th>
                    <td><?= $seoMetaTag->is_http_equiv ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Content') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($seoMetaTag->content)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
