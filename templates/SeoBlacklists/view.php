<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoBlacklist $seoBlacklist
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Blacklist'), ['action' => 'edit', $seoBlacklist->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Blacklist'), ['action' => 'delete', $seoBlacklist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoBlacklist->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Blacklists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Blacklist'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoBlacklists view content">
            <h3><?= h($seoBlacklist->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoBlacklist->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip Range Start') ?></th>
                    <td><?= $this->Number->format($seoBlacklist->ip_range_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip Range End') ?></th>
                    <td><?= $this->Number->format($seoBlacklist->ip_range_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoBlacklist->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($seoBlacklist->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $seoBlacklist->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($seoBlacklist->note)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
