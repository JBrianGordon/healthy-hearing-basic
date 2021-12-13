<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoCanonical[]|\Cake\Collection\CollectionInterface $seoCanonicals
 */
?>
<div class="seoCanonicals index content">
    <?= $this->Html->link(__('New Seo Canonical'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Canonicals') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('seo_uri_id') ?></th>
                    <th><?= $this->Paginator->sort('canonical') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoCanonicals as $seoCanonical): ?>
                <tr>
                    <td><?= $this->Number->format($seoCanonical->id) ?></td>
                    <td><?= $seoCanonical->has('seo_uri') ? $this->Html->link($seoCanonical->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoCanonical->seo_uri->id]) : '' ?></td>
                    <td><?= h($seoCanonical->canonical) ?></td>
                    <td><?= h($seoCanonical->is_active) ?></td>
                    <td><?= h($seoCanonical->created) ?></td>
                    <td><?= h($seoCanonical->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoCanonical->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoCanonical->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoCanonical->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoCanonical->id)]) ?>
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
