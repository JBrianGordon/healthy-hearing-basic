<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchemaMigration $schemaMigration
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Schema Migration'), ['action' => 'edit', $schemaMigration->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Schema Migration'), ['action' => 'delete', $schemaMigration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schemaMigration->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Schema Migrations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Schema Migration'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="schemaMigrations view content">
            <h3><?= h($schemaMigration->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Class') ?></th>
                    <td><?= h($schemaMigration->class) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($schemaMigration->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($schemaMigration->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($schemaMigration->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
