<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoStatusCode $seoStatusCode
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Status Code'), ['action' => 'edit', $seoStatusCode->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Status Code'), ['action' => 'delete', $seoStatusCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoStatusCode->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Status Codes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Status Code'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoStatusCodes view content">
            <h3><?= h($seoStatusCode->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Seo Uri') ?></th>
                    <td><?= $seoStatusCode->has('seo_uri') ? $this->Html->link($seoStatusCode->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoStatusCode->seo_uri->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoStatusCode->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Code') ?></th>
                    <td><?= $this->Number->format($seoStatusCode->status_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= $this->Number->format($seoStatusCode->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoStatusCode->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($seoStatusCode->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $seoStatusCode->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
