<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoMetaTag[]|\Cake\Collection\CollectionInterface $seoMetaTags
 */
?>
<div class="seoMetaTags index content">
    <?= $this->Html->link(__('New Seo Meta Tag'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Meta Tags') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('seo_uri_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('is_http_equiv') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoMetaTags as $seoMetaTag): ?>
                <tr>
                    <td><?= $this->Number->format($seoMetaTag->id) ?></td>
                    <td><?= $seoMetaTag->has('seo_uri') ? $this->Html->link($seoMetaTag->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoMetaTag->seo_uri->id]) : '' ?></td>
                    <td><?= h($seoMetaTag->name) ?></td>
                    <td><?= h($seoMetaTag->is_http_equiv) ?></td>
                    <td><?= h($seoMetaTag->created) ?></td>
                    <td><?= h($seoMetaTag->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoMetaTag->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoMetaTag->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoMetaTag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoMetaTag->id)]) ?>
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
