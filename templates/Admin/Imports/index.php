<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Import[]|\Cake\Collection\CollectionInterface $imports
 */
$queryParams = $this->request->getQueryParams();
?>
<div class="imports index content">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->Html->link("<i class='bi bi-speedometer'></i> Import Dashboard", ['controller' => 'import-locations', 'action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-bar-chart-fill'></i> Tier Status", ['controller' => 'imports', 'action' => 'tier_status_report'], ['class' => 'btn btn-default', 'escape' => false]) ?>
    </div>
    <h3><?= __('Import Stats') ?></h3>
    <?= $this->element('pagination') ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('total_locations', 'Locations') ?></th>
                    <th><?= $this->Paginator->sort('new_locations', 'New') ?></th>
                    <th><?= $this->Paginator->sort('updated_locations', 'Updated') ?></th>
                    <th><?= $this->Paginator->sort('total_providers', 'Providers') ?></th>
                    <th><?= $this->Paginator->sort('new_providers', 'New') ?></th>
                    <th><?= $this->Paginator->sort('updated_providers', 'Updated') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Date') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imports as $import): ?>
                <tr>
                    <td><?= $this->Number->format($import->id) ?></td>
                    <td><?= h($import->type) ?></td>
                    <td><?= $import->total_locations === null ? '' : $this->Number->format($import->total_locations) ?></td>
                    <td><?= $import->new_locations === null ? '' : $this->Number->format($import->new_locations) ?></td>
                    <td><?= $import->updated_locations === null ? '' : $this->Number->format($import->updated_locations) ?></td>
                    <td><?= $import->total_providers === null ? '' : $this->Number->format($import->total_providers) ?></td>
                    <td><?= $import->new_providers === null ? '' : $this->Number->format($import->new_providers) ?></td>
                    <td><?= $import->updated_providers === null ? '' : $this->Number->format($import->updated_providers) ?></td>
                    <td><?= date("F d, Y", strtotime($import->created)) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
