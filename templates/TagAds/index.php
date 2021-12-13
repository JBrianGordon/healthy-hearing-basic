<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagAd[]|\Cake\Collection\CollectionInterface $tagAds
 */
?>
<div class="tagAds index content">
    <?= $this->Html->link(__('New Tag Ad'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tag Ads') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('ad_id') ?></th>
                    <th><?= $this->Paginator->sort('tag_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tagAds as $tagAd): ?>
                <tr>
                    <td><?= $this->Number->format($tagAd->id) ?></td>
                    <td><?= $this->Number->format($tagAd->ad_id) ?></td>
                    <td><?= $tagAd->has('tag') ? $this->Html->link($tagAd->tag->name, ['controller' => 'Tags', 'action' => 'view', $tagAd->tag->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tagAd->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tagAd->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tagAd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tagAd->id)]) ?>
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
