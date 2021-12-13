<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountMetric[]|\Cake\Collection\CollectionInterface $countMetrics
 */
?>
<div class="countMetrics index content">
    <?= $this->Html->link(__('New Count Metric'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Count Metrics') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('metric') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('sub_name') ?></th>
                    <th><?= $this->Paginator->sort('count') ?></th>
                    <th><?= $this->Paginator->sort('updated') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($countMetrics as $countMetric): ?>
                <tr>
                    <td><?= h($countMetric->id) ?></td>
                    <td><?= h($countMetric->type) ?></td>
                    <td><?= h($countMetric->metric) ?></td>
                    <td><?= h($countMetric->name) ?></td>
                    <td><?= h($countMetric->sub_name) ?></td>
                    <td><?= $this->Number->format($countMetric->count) ?></td>
                    <td><?= h($countMetric->updated) ?></td>
                    <td><?= h($countMetric->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $countMetric->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $countMetric->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $countMetric->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countMetric->id)]) ?>
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
