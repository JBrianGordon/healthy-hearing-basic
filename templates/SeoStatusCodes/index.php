<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoStatusCode[]|\Cake\Collection\CollectionInterface $seoStatusCodes
 */
?>
<div class="seoStatusCodes index content">
    <?= $this->Html->link(__('New Seo Status Code'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Status Codes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('seo_uri_id') ?></th>
                    <th><?= $this->Paginator->sort('status_code') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoStatusCodes as $seoStatusCode): ?>
                <tr>
                    <td><?= $this->Number->format($seoStatusCode->id) ?></td>
                    <td><?= $seoStatusCode->has('seo_uri') ? $this->Html->link($seoStatusCode->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoStatusCode->seo_uri->id]) : '' ?></td>
                    <td><?= $this->Number->format($seoStatusCode->status_code) ?></td>
                    <td><?= $this->Number->format($seoStatusCode->priority) ?></td>
                    <td><?= h($seoStatusCode->is_active) ?></td>
                    <td><?= h($seoStatusCode->created) ?></td>
                    <td><?= h($seoStatusCode->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoStatusCode->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoStatusCode->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoStatusCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoStatusCode->id)]) ?>
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
