<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoSearchTerm[]|\Cake\Collection\CollectionInterface $seoSearchTerms
 */
?>
<div class="seoSearchTerms index content">
    <?= $this->Html->link(__('New Seo Search Term'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Search Terms') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('term') ?></th>
                    <th><?= $this->Paginator->sort('uri') ?></th>
                    <th><?= $this->Paginator->sort('count') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoSearchTerms as $seoSearchTerm): ?>
                <tr>
                    <td><?= $this->Number->format($seoSearchTerm->id) ?></td>
                    <td><?= h($seoSearchTerm->term) ?></td>
                    <td><?= h($seoSearchTerm->uri) ?></td>
                    <td><?= $this->Number->format($seoSearchTerm->count) ?></td>
                    <td><?= h($seoSearchTerm->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoSearchTerm->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoSearchTerm->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoSearchTerm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoSearchTerm->id)]) ?>
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
