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
            <?= $this->Html->link(__('Edit Seo Url'), ['action' => 'edit', $seoUrl->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Url'), ['action' => 'delete', $seoUrl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoUrl->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Urls'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Url'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoUrls view content">
            <h3><?= h($seoUrl->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($seoUrl->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Redirect Url') ?></th>
                    <td><?= h($seoUrl->redirect_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Seo Title') ?></th>
                    <td><?= h($seoUrl->seo_title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Seo Meta Description') ?></th>
                    <td><?= h($seoUrl->seo_meta_description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoUrl->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Code') ?></th>
                    <td><?= $seoUrl->status_code === null ? '' : $this->Number->format($seoUrl->status_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Redirect Is Active') ?></th>
                    <td><?= $seoUrl->redirect_is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
