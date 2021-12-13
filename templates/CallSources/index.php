<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CallSource[]|\Cake\Collection\CollectionInterface $callSources
 */
?>
<div class="callSources index content">
    <?= $this->Html->link(__('New Call Source'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Call Sources') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('customer_name') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('phone_number') ?></th>
                    <th><?= $this->Paginator->sort('target_number') ?></th>
                    <th><?= $this->Paginator->sort('clinic_number') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_ivr_enabled') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($callSources as $callSource): ?>
                <tr>
                    <td><?= $this->Number->format($callSource->id) ?></td>
                    <td><?= h($callSource->customer_name) ?></td>
                    <td><?= $callSource->has('location') ? $this->Html->link($callSource->location->title, ['controller' => 'Locations', 'action' => 'view', $callSource->location->id]) : '' ?></td>
                    <td><?= h($callSource->is_active) ?></td>
                    <td><?= h($callSource->phone_number) ?></td>
                    <td><?= h($callSource->target_number) ?></td>
                    <td><?= h($callSource->clinic_number) ?></td>
                    <td><?= h($callSource->start_date) ?></td>
                    <td><?= h($callSource->end_date) ?></td>
                    <td><?= h($callSource->created) ?></td>
                    <td><?= h($callSource->is_ivr_enabled) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $callSource->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $callSource->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $callSource->id], ['confirm' => __('Are you sure you want to delete # {0}?', $callSource->id)]) ?>
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
