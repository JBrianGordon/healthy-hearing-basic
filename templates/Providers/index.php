<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Provider[]|\Cake\Collection\CollectionInterface $providers
 */
?>
<div class="providers index content">
    <?= $this->Html->link(__('New Provider'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Providers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('middle_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('credentials') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('micro_url') ?></th>
                    <th><?= $this->Paginator->sort('square_url') ?></th>
                    <th><?= $this->Paginator->sort('thumb_url') ?></th>
                    <th><?= $this->Paginator->sort('image_url') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('aud_or_his') ?></th>
                    <th><?= $this->Paginator->sort('caqh_number') ?></th>
                    <th><?= $this->Paginator->sort('npi_number') ?></th>
                    <th><?= $this->Paginator->sort('show_npi') ?></th>
                    <th><?= $this->Paginator->sort('is_ida_verified') ?></th>
                    <th><?= $this->Paginator->sort('show_license') ?></th>
                    <th><?= $this->Paginator->sort('id_yhn_provider') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($providers as $provider): ?>
                <tr>
                    <td><?= $this->Number->format($provider->id) ?></td>
                    <td><?= h($provider->first_name) ?></td>
                    <td><?= h($provider->middle_name) ?></td>
                    <td><?= h($provider->last_name) ?></td>
                    <td><?= h($provider->credentials) ?></td>
                    <td><?= h($provider->title) ?></td>
                    <td><?= h($provider->email) ?></td>
                    <td><?= h($provider->micro_url) ?></td>
                    <td><?= h($provider->square_url) ?></td>
                    <td><?= h($provider->thumb_url) ?></td>
                    <td><?= h($provider->image_url) ?></td>
                    <td><?= h($provider->is_active) ?></td>
                    <td><?= h($provider->created) ?></td>
                    <td><?= h($provider->modified) ?></td>
                    <td><?= h($provider->phone) ?></td>
                    <td><?= $this->Number->format($provider->priority) ?></td>
                    <td><?= h($provider->aud_or_his) ?></td>
                    <td><?= h($provider->caqh_number) ?></td>
                    <td><?= h($provider->npi_number) ?></td>
                    <td><?= h($provider->show_npi) ?></td>
                    <td><?= h($provider->is_ida_verified) ?></td>
                    <td><?= h($provider->show_license) ?></td>
                    <td><?= $this->Number->format($provider->id_yhn_provider) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $provider->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $provider->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $provider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $provider->id)]) ?>
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
