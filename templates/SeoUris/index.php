<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUri[]|\Cake\Collection\CollectionInterface $seoUris
 */
?>
<div class="seoUris index content">
    <?= $this->Html->link(__('New Seo Uri'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Uris') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('uri') ?></th>
                    <th><?= $this->Paginator->sort('is_approved') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoUris as $seoUri): ?>
                <tr>
                    <td><?= $this->Number->format($seoUri->id) ?></td>
                    <td><?= h($seoUri->uri) ?></td>
                    <td><?= h($seoUri->is_approved) ?></td>
                    <td><?= h($seoUri->created) ?></td>
                    <td><?= h($seoUri->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoUri->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoUri->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoUri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoUri->id)]) ?>
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
