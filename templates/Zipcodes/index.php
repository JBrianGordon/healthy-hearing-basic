<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zipcode[]|\Cake\Collection\CollectionInterface $zipcodes
 */
?>
<div class="zipcodes index content">
    <?= $this->Html->link(__('New Zipcode'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Zipcodes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('lat') ?></th>
                    <th><?= $this->Paginator->sort('lon') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('areacode') ?></th>
                    <th><?= $this->Paginator->sort('country_code') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($zipcodes as $zipcode): ?>
                <tr>
                    <td><?= h($zipcode->zip) ?></td>
                    <td><?= $this->Number->format($zipcode->lat) ?></td>
                    <td><?= $this->Number->format($zipcode->lon) ?></td>
                    <td><?= h($zipcode->city) ?></td>
                    <td><?= h($zipcode->state) ?></td>
                    <td><?= h($zipcode->areacode) ?></td>
                    <td><?= h($zipcode->country_code) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $zipcode->zip]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $zipcode->zip]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $zipcode->zip], ['confirm' => __('Are you sure you want to delete # {0}?', $zipcode->zip)]) ?>
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
