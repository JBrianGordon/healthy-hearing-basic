<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoHoneypotVisit[]|\Cake\Collection\CollectionInterface $seoHoneypotVisits
 */
?>
<div class="seoHoneypotVisits index content">
    <?= $this->Html->link(__('New Seo Honeypot Visit'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Honeypot Visits') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoHoneypotVisits as $seoHoneypotVisit): ?>
                <tr>
                    <td><?= $this->Number->format($seoHoneypotVisit->id) ?></td>
                    <td><?= $this->Number->format($seoHoneypotVisit->ip) ?></td>
                    <td><?= h($seoHoneypotVisit->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoHoneypotVisit->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoHoneypotVisit->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoHoneypotVisit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoHoneypotVisit->id)]) ?>
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
