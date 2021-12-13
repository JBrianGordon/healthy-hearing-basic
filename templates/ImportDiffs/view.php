<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ImportDiff $importDiff
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Import Diff'), ['action' => 'edit', $importDiff->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Import Diff'), ['action' => 'delete', $importDiff->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importDiff->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Import Diffs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Import Diff'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="importDiffs view content">
            <h3><?= h($importDiff->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Import') ?></th>
                    <td><?= $importDiff->has('import') ? $this->Html->link($importDiff->import->id, ['controller' => 'Imports', 'action' => 'view', $importDiff->import->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($importDiff->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Model') ?></th>
                    <td><?= h($importDiff->id_model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Field') ?></th>
                    <td><?= h($importDiff->field) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($importDiff->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Review Needed') ?></th>
                    <td><?= $this->Number->format($importDiff->review_needed) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($importDiff->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Value') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($importDiff->value)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
