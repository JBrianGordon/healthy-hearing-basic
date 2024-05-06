<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportProvider[]|\Cake\Collection\CollectionInterface $importProviders
 */
?>
<div class="importProviders index content">
    <?= $this->Html->link(__('New Import Provider'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Import Providers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('import_id') ?></th>
                    <th><?= $this->Paginator->sort('id_external') ?></th>
                    <th><?= $this->Paginator->sort('provider_id') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('aud_or_his') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($importProviders as $importProvider): ?>
                <tr>
                    <td><?= $this->Number->format($importProvider->id) ?></td>
                    <td><?= $importProvider->has('import') ? $this->Html->link($importProvider->import->id, ['controller' => 'Imports', 'action' => 'view', $importProvider->import->id]) : '' ?></td>
                    <td><?= $this->Number->format($importProvider->id_external) ?></td>
                    <td><?= $importProvider->has('provider') ? $this->Html->link($importProvider->provider->title, ['controller' => 'Providers', 'action' => 'view', $importProvider->provider->id]) : '' ?></td>
                    <td><?= h($importProvider->first_name) ?></td>
                    <td><?= h($importProvider->last_name) ?></td>
                    <td><?= h($importProvider->email) ?></td>
                    <td><?= h($importProvider->aud_or_his) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $importProvider->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $importProvider->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $importProvider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importProvider->id)]) ?>
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
