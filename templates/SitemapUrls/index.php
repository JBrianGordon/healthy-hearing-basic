<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SitemapUrl[]|\Cake\Collection\CollectionInterface $sitemapUrls
 */
?>
<div class="sitemapUrls index content">
    <?= $this->Html->link(__('New Sitemap Url'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sitemap Urls') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sitemapUrls as $sitemapUrl): ?>
                <tr>
                    <td><?= $this->Number->format($sitemapUrl->id) ?></td>
                    <td><?= h($sitemapUrl->model) ?></td>
                    <td><?= h($sitemapUrl->url) ?></td>
                    <td><?= $this->Number->format($sitemapUrl->priority) ?></td>
                    <td><?= h($sitemapUrl->created) ?></td>
                    <td><?= h($sitemapUrl->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $sitemapUrl->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sitemapUrl->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sitemapUrl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sitemapUrl->id)]) ?>
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
