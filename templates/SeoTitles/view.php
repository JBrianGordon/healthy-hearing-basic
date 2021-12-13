<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoTitle $seoTitle
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Title'), ['action' => 'edit', $seoTitle->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Title'), ['action' => 'delete', $seoTitle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoTitle->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Titles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Title'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoTitles view content">
            <h3><?= h($seoTitle->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Seo Uri') ?></th>
                    <td><?= $seoTitle->has('seo_uri') ? $this->Html->link($seoTitle->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoTitle->seo_uri->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($seoTitle->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoTitle->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoTitle->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($seoTitle->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
