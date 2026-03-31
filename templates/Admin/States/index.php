<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State[]|\Cake\Collection\CollectionInterface $states
 */
 
 $this->Vite->script('admin_common','admin');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading"><?= ucfirst($stateLabel) ?>s Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2><?= ucfirst($stateLabel) ?>s</h2>
				<div class="states index content">
				    <?= $this->element('pagination') ?>
				    <div class="table-responsive">
				        <table class="table table-striped table-bordered table-sm">
				            <thead>
				                <tr>
				                    <th class="p5"><?= $this->Paginator->sort('name') ?></th>
				                    <th class="p5"><?= $this->Paginator->sort('is_active', ['label' => 'Active']) ?></th>
				                    <th class="actions p5"><?= __('Actions') ?></th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php foreach ($states as $state): ?>
				                <tr>
				                    <td class="p5">
				                        <?= $this->Html->link(h($state->name), [
				                            'prefix' => false,
				                            'controller' => 'locations',
				                            'action' => 'viewState',
				                            'region' =>  $this->Clinic->stateSlug($state->name)
				                        ]) ?>
				                    </td>
				                    <td class="p5">
				                        <?= $this->Html->badge(
				                            $state->is_active ? '<i class="bi bi-check-lg"></i> Active' : '<i class="bi bi-x-lg"></i> Inactive',
				                            [
				                                'class' => $state->is_active ? 'success' : 'danger',
				                            ]
				                        ); ?>
				                    </td>
				                    <td class="actions p5">
				                        <div class="btn-group-vertical btn-group-sm">
				                            <?= $this->Html->link(__(' Edit'),
				                                ['action' => 'edit', $state->id],
				                                ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
				                            <?= $this->Html->link(__(' View'),
				                                [
				                                    'prefix' => false,
				                                    'controller' => 'locations',
				                                    'action' => 'viewState',
				                                    'region' =>  $this->Clinic->stateSlug($state->name)
				                                ],
				                                ['class' => 'btn btn-default btn-xs bi bi-eye-fill']) ?>
				                            <?= $user->is_it_admin ? $this->Form->postLink(__(' Delete'),
				                                ['action' => 'delete', $state->id],
				                                ['class' => 'btn btn-danger btn-xs bi bi-trash', 'confirm' => __('Are you sure you want to delete # {0}?', $state->id)]) : '' ?>
				                        </div>
				                    </td>
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