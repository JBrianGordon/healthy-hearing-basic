<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationHour[]|\Cake\Collection\CollectionInterface $locationHours
 */
?>
<div class="locationHours index content">
    <?= $this->Html->link(__('New Location Hour'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Location Hours') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('location_id') ?></th>
                    <th><?= $this->Paginator->sort('sun_open') ?></th>
                    <th><?= $this->Paginator->sort('sun_close') ?></th>
                    <th><?= $this->Paginator->sort('sun_is_closed') ?></th>
                    <th><?= $this->Paginator->sort('sun_is_byappt') ?></th>
                    <th><?= $this->Paginator->sort('mon_open') ?></th>
                    <th><?= $this->Paginator->sort('mon_close') ?></th>
                    <th><?= $this->Paginator->sort('mon_is_closed') ?></th>
                    <th><?= $this->Paginator->sort('mon_is_byappt') ?></th>
                    <th><?= $this->Paginator->sort('tue_open') ?></th>
                    <th><?= $this->Paginator->sort('tue_close') ?></th>
                    <th><?= $this->Paginator->sort('tue_is_closed') ?></th>
                    <th><?= $this->Paginator->sort('tue_is_byappt') ?></th>
                    <th><?= $this->Paginator->sort('wed_open') ?></th>
                    <th><?= $this->Paginator->sort('wed_close') ?></th>
                    <th><?= $this->Paginator->sort('wed_is_closed') ?></th>
                    <th><?= $this->Paginator->sort('wed_is_byappt') ?></th>
                    <th><?= $this->Paginator->sort('thu_open') ?></th>
                    <th><?= $this->Paginator->sort('thu_close') ?></th>
                    <th><?= $this->Paginator->sort('thu_is_closed') ?></th>
                    <th><?= $this->Paginator->sort('thu_is_byappt') ?></th>
                    <th><?= $this->Paginator->sort('fri_open') ?></th>
                    <th><?= $this->Paginator->sort('fri_close') ?></th>
                    <th><?= $this->Paginator->sort('fri_is_closed') ?></th>
                    <th><?= $this->Paginator->sort('fri_is_byappt') ?></th>
                    <th><?= $this->Paginator->sort('sat_open') ?></th>
                    <th><?= $this->Paginator->sort('sat_close') ?></th>
                    <th><?= $this->Paginator->sort('sat_is_closed') ?></th>
                    <th><?= $this->Paginator->sort('sat_is_byappt') ?></th>
                    <th><?= $this->Paginator->sort('is_evening_weekend_hours') ?></th>
                    <th><?= $this->Paginator->sort('is_closed_lunch') ?></th>
                    <th><?= $this->Paginator->sort('lunch_start') ?></th>
                    <th><?= $this->Paginator->sort('lunch_end') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationHours as $locationHour): ?>
                <tr>
                    <td><?= $this->Number->format($locationHour->id) ?></td>
                    <td><?= $locationHour->has('location') ? $this->Html->link($locationHour->location->title, ['controller' => 'Locations', 'action' => 'view', $locationHour->location->id]) : '' ?></td>
                    <td><?= h($locationHour->sun_open) ?></td>
                    <td><?= h($locationHour->sun_close) ?></td>
                    <td><?= h($locationHour->sun_is_closed) ?></td>
                    <td><?= h($locationHour->sun_is_byappt) ?></td>
                    <td><?= h($locationHour->mon_open) ?></td>
                    <td><?= h($locationHour->mon_close) ?></td>
                    <td><?= h($locationHour->mon_is_closed) ?></td>
                    <td><?= h($locationHour->mon_is_byappt) ?></td>
                    <td><?= h($locationHour->tue_open) ?></td>
                    <td><?= h($locationHour->tue_close) ?></td>
                    <td><?= h($locationHour->tue_is_closed) ?></td>
                    <td><?= h($locationHour->tue_is_byappt) ?></td>
                    <td><?= h($locationHour->wed_open) ?></td>
                    <td><?= h($locationHour->wed_close) ?></td>
                    <td><?= h($locationHour->wed_is_closed) ?></td>
                    <td><?= h($locationHour->wed_is_byappt) ?></td>
                    <td><?= h($locationHour->thu_open) ?></td>
                    <td><?= h($locationHour->thu_close) ?></td>
                    <td><?= h($locationHour->thu_is_closed) ?></td>
                    <td><?= h($locationHour->thu_is_byappt) ?></td>
                    <td><?= h($locationHour->fri_open) ?></td>
                    <td><?= h($locationHour->fri_close) ?></td>
                    <td><?= h($locationHour->fri_is_closed) ?></td>
                    <td><?= h($locationHour->fri_is_byappt) ?></td>
                    <td><?= h($locationHour->sat_open) ?></td>
                    <td><?= h($locationHour->sat_close) ?></td>
                    <td><?= h($locationHour->sat_is_closed) ?></td>
                    <td><?= h($locationHour->sat_is_byappt) ?></td>
                    <td><?= h($locationHour->is_evening_weekend_hours) ?></td>
                    <td><?= h($locationHour->is_closed_lunch) ?></td>
                    <td><?= h($locationHour->lunch_start) ?></td>
                    <td><?= h($locationHour->lunch_end) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $locationHour->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $locationHour->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $locationHour->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationHour->id)]) ?>
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
