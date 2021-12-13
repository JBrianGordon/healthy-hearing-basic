<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountMetric $countMetric
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Count Metric'), ['action' => 'edit', $countMetric->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Count Metric'), ['action' => 'delete', $countMetric->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countMetric->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Count Metrics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Count Metric'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="countMetrics view content">
            <h3><?= h($countMetric->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($countMetric->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($countMetric->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Metric') ?></th>
                    <td><?= h($countMetric->metric) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($countMetric->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sub Name') ?></th>
                    <td><?= h($countMetric->sub_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Count') ?></th>
                    <td><?= $this->Number->format($countMetric->count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated') ?></th>
                    <td><?= h($countMetric->updated) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($countMetric->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
