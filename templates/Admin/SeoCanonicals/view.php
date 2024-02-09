<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoCanonical $seoCanonical
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Canonical'), ['action' => 'edit', $seoCanonical->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Canonical'), ['action' => 'delete', $seoCanonical->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoCanonical->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Canonicals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Canonical'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoCanonicals view content">
            <h3><?= h($seoCanonical->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Seo Uri') ?></th>
                    <td><?= $seoCanonical->has('seo_uri') ? $this->Html->link($seoCanonical->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoCanonical->seo_uri->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Canonical') ?></th>
                    <td><?= h($seoCanonical->canonical) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoCanonical->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoCanonical->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($seoCanonical->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $seoCanonical->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
