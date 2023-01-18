<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Import[]|\Cake\Collection\CollectionInterface $imports
 */
$queryParams = $this->request->getQueryParams();

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="clear"></div>
				<header class="col-md-12 mt10">
					<div class="panel panel-light">
						<div class="panel-heading">Imports Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(" Dashboard", ['controller' => 'import_locations', 'action' => 'index'], ['class' => 'btn btn-default bi bi-speedometer', 'escape' => false]) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2>Import Stats</h2>
								<div class="imports index content">
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
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
