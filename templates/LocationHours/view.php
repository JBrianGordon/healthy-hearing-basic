<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationHour $locationHour
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location Hour'), ['action' => 'edit', $locationHour->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location Hour'), ['action' => 'delete', $locationHour->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationHour->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Location Hours'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location Hour'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationHours view content">
            <h3><?= h($locationHour->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= $locationHour->has('location') ? $this->Html->link($locationHour->location->title, ['controller' => 'Locations', 'action' => 'view', $locationHour->location->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Sun Open') ?></th>
                    <td><?= h($locationHour->sun_open) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sun Close') ?></th>
                    <td><?= h($locationHour->sun_close) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mon Open') ?></th>
                    <td><?= h($locationHour->mon_open) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mon Close') ?></th>
                    <td><?= h($locationHour->mon_close) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tue Open') ?></th>
                    <td><?= h($locationHour->tue_open) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tue Close') ?></th>
                    <td><?= h($locationHour->tue_close) ?></td>
                </tr>
                <tr>
                    <th><?= __('Wed Open') ?></th>
                    <td><?= h($locationHour->wed_open) ?></td>
                </tr>
                <tr>
                    <th><?= __('Wed Close') ?></th>
                    <td><?= h($locationHour->wed_close) ?></td>
                </tr>
                <tr>
                    <th><?= __('Thu Open') ?></th>
                    <td><?= h($locationHour->thu_open) ?></td>
                </tr>
                <tr>
                    <th><?= __('Thu Close') ?></th>
                    <td><?= h($locationHour->thu_close) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fri Open') ?></th>
                    <td><?= h($locationHour->fri_open) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fri Close') ?></th>
                    <td><?= h($locationHour->fri_close) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sat Open') ?></th>
                    <td><?= h($locationHour->sat_open) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sat Close') ?></th>
                    <td><?= h($locationHour->sat_close) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lunch Start') ?></th>
                    <td><?= h($locationHour->lunch_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lunch End') ?></th>
                    <td><?= h($locationHour->lunch_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($locationHour->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sun Is Closed') ?></th>
                    <td><?= $locationHour->sun_is_closed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Sun Is Byappt') ?></th>
                    <td><?= $locationHour->sun_is_byappt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Mon Is Closed') ?></th>
                    <td><?= $locationHour->mon_is_closed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Mon Is Byappt') ?></th>
                    <td><?= $locationHour->mon_is_byappt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Tue Is Closed') ?></th>
                    <td><?= $locationHour->tue_is_closed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Tue Is Byappt') ?></th>
                    <td><?= $locationHour->tue_is_byappt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Wed Is Closed') ?></th>
                    <td><?= $locationHour->wed_is_closed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Wed Is Byappt') ?></th>
                    <td><?= $locationHour->wed_is_byappt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Thu Is Closed') ?></th>
                    <td><?= $locationHour->thu_is_closed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Thu Is Byappt') ?></th>
                    <td><?= $locationHour->thu_is_byappt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Fri Is Closed') ?></th>
                    <td><?= $locationHour->fri_is_closed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Fri Is Byappt') ?></th>
                    <td><?= $locationHour->fri_is_byappt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Sat Is Closed') ?></th>
                    <td><?= $locationHour->sat_is_closed ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Sat Is Byappt') ?></th>
                    <td><?= $locationHour->sat_is_byappt ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Evening Weekend Hours') ?></th>
                    <td><?= $locationHour->is_evening_weekend_hours ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Closed Lunch') ?></th>
                    <td><?= $locationHour->is_closed_lunch ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
