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
            <?= $this->Html->link(__('Edit Sitemap Url'), ['action' => 'edit', $sitemapUrl->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sitemap Url'), ['action' => 'delete', $sitemapUrl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sitemapUrl->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sitemap Urls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sitemap Url'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sitemapUrls view content">
            <h3><?= h($sitemapUrl->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($sitemapUrl->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($sitemapUrl->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($sitemapUrl->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= $this->Number->format($sitemapUrl->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($sitemapUrl->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($sitemapUrl->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
