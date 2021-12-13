<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AdvertisementsClick[]|\Cake\Collection\CollectionInterface $advertisementsClicks
 */
?>
<div class="advertisementsClicks index content">
    <?= $this->Html->link(__('New Advertisements Click'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Advertisements Clicks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('ad_id') ?></th>
                    <th><?= $this->Paginator->sort('ref') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($advertisementsClicks as $advertisementsClick): ?>
                <tr>
                    <td><?= $this->Number->format($advertisementsClick->id) ?></td>
                    <td><?= h($advertisementsClick->created) ?></td>
                    <td><?= $this->Number->format($advertisementsClick->ad_id) ?></td>
                    <td><?= h($advertisementsClick->ref) ?></td>
                    <td><?= h($advertisementsClick->ip) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $advertisementsClick->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $advertisementsClick->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $advertisementsClick->id], ['confirm' => __('Are you sure you want to delete # {0}?', $advertisementsClick->id)]) ?>
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
