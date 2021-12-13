<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */
?>
<div class="csCalls index content">
    <?= $this->Html->link(__('New Cs Call'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cs Calls') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('call_id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('ad_source') ?></th>
                    <th><?= $this->Paginator->sort('start_time') ?></th>
                    <th><?= $this->Paginator->sort('result') ?></th>
                    <th><?= $this->Paginator->sort('duration') ?></th>
                    <th><?= $this->Paginator->sort('call_type') ?></th>
                    <th><?= $this->Paginator->sort('call_status') ?></th>
                    <th><?= $this->Paginator->sort('leadscore') ?></th>
                    <th><?= $this->Paginator->sort('recording_url') ?></th>
                    <th><?= $this->Paginator->sort('tracking_number') ?></th>
                    <th><?= $this->Paginator->sort('caller_phone') ?></th>
                    <th><?= $this->Paginator->sort('clinic_phone') ?></th>
                    <th><?= $this->Paginator->sort('caller_firstname') ?></th>
                    <th><?= $this->Paginator->sort('caller_lastname') ?></th>
                    <th><?= $this->Paginator->sort('prospect') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($csCalls as $csCall): ?>
                <tr>
                    <td><?= $this->Number->format($csCall->id) ?></td>
                    <td><?= $this->Number->format($csCall->call_id) ?></td>
                    <td><?= $csCall->has('location') ? $this->Html->link($csCall->location->title, ['controller' => 'Locations', 'action' => 'view', $csCall->location->id]) : '' ?></td>
                    <td><?= h($csCall->ad_source) ?></td>
                    <td><?= h($csCall->start_time) ?></td>
                    <td><?= h($csCall->result) ?></td>
                    <td><?= $this->Number->format($csCall->duration) ?></td>
                    <td><?= h($csCall->call_type) ?></td>
                    <td><?= h($csCall->call_status) ?></td>
                    <td><?= h($csCall->leadscore) ?></td>
                    <td><?= h($csCall->recording_url) ?></td>
                    <td><?= h($csCall->tracking_number) ?></td>
                    <td><?= h($csCall->caller_phone) ?></td>
                    <td><?= h($csCall->clinic_phone) ?></td>
                    <td><?= h($csCall->caller_firstname) ?></td>
                    <td><?= h($csCall->caller_lastname) ?></td>
                    <td><?= h($csCall->prospect) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $csCall->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $csCall->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $csCall->id], ['confirm' => __('Are you sure you want to delete # {0}?', $csCall->id)]) ?>
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
