<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoRedirect $seoRedirect
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Redirect'), ['action' => 'edit', $seoRedirect->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Redirect'), ['action' => 'delete', $seoRedirect->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoRedirect->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Redirects'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Redirect'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoRedirects view content">
            <h3><?= h($seoRedirect->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Seo Uri') ?></th>
                    <td><?= $seoRedirect->has('seo_uri') ? $this->Html->link($seoRedirect->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoRedirect->seo_uri->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Redirect') ?></th>
                    <td><?= h($seoRedirect->redirect) ?></td>
                </tr>
                <tr>
                    <th><?= __('Callback') ?></th>
                    <td><?= h($seoRedirect->callback) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoRedirect->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= $this->Number->format($seoRedirect->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoRedirect->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($seoRedirect->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $seoRedirect->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Nocache') ?></th>
                    <td><?= $seoRedirect->is_nocache ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
