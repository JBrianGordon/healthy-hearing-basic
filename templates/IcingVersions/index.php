<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IcingVersion[]|\Cake\Collection\CollectionInterface $icingVersions
 */
?>
<div class="icingVersions index content">
    <?= $this->Html->link(__('New Icing Version'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Icing Versions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_model') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($icingVersions as $icingVersion): ?>
                <tr>
                    <td><?= h($icingVersion->id) ?></td>
                    <td><?= h($icingVersion->id_model) ?></td>
                    <td><?= $icingVersion->has('user') ? $this->Html->link($icingVersion->user->id, ['controller' => 'Users', 'action' => 'view', $icingVersion->user->id]) : '' ?></td>
                    <td><?= h($icingVersion->model) ?></td>
                    <td><?= h($icingVersion->created) ?></td>
                    <td><?= h($icingVersion->url) ?></td>
                    <td><?= h($icingVersion->ip) ?></td>
                    <td><?= h($icingVersion->is_delete) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $icingVersion->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $icingVersion->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $icingVersion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $icingVersion->id)]) ?>
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
