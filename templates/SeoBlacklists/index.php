<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoBlacklist[]|\Cake\Collection\CollectionInterface $seoBlacklists
 */
?>
<div class="seoBlacklists index content">
    <?= $this->Html->link(__('New Seo Blacklist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Blacklists') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('ip_range_start') ?></th>
                    <th><?= $this->Paginator->sort('ip_range_end') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoBlacklists as $seoBlacklist): ?>
                <tr>
                    <td><?= $this->Number->format($seoBlacklist->id) ?></td>
                    <td><?= $this->Number->format($seoBlacklist->ip_range_start) ?></td>
                    <td><?= $this->Number->format($seoBlacklist->ip_range_end) ?></td>
                    <td><?= h($seoBlacklist->created) ?></td>
                    <td><?= h($seoBlacklist->modified) ?></td>
                    <td><?= h($seoBlacklist->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoBlacklist->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoBlacklist->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoBlacklist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoBlacklist->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
