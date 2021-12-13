<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zipcode $zipcode
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Zipcode'), ['action' => 'edit', $zipcode->zip], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Zipcode'), ['action' => 'delete', $zipcode->zip], ['confirm' => __('Are you sure you want to delete # {0}?', $zipcode->zip), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Zipcodes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Zipcode'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="zipcodes view content">
            <h3><?= h($zipcode->zip) ?></h3>
            <table>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($zipcode->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($zipcode->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($zipcode->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Areacode') ?></th>
                    <td><?= h($zipcode->areacode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country Code') ?></th>
                    <td><?= h($zipcode->country_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lat') ?></th>
                    <td><?= $this->Number->format($zipcode->lat) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lon') ?></th>
                    <td><?= $this->Number->format($zipcode->lon) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
