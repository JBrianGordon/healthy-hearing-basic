<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki[]|\Cake\Collection\CollectionInterface $wikis
 */
 
$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Help Pages Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<div class="wikis index">
					<h2>Help Pages</h2>
				    <?= $this->element('pagination') ?>
				    <!-- ***TODO*** : Populate fields for advanced search --> 
				    <?= $this->element('advanced_search') ?>
					<div class="wikis index content">
					    <div class="table-responsive">
					        <table class="table table-striped table-bordered table-condensed mt20">
					            <thead>
					                <tr>
						                <th><?= $this->Paginator->sort('is_active', ['label' => 'Active']) ?></th>
					                    <th><?= $this->Paginator->sort('name') ?></th>
					                    <th><?= $this->Paginator->sort('slug') ?></th>
					                    <th><?= $this->Paginator->sort('short') ?></th>
					                    <th width="120"><?= $this->Paginator->sort('last_modified', ['label' => 'Last Mod']) ?><br><?= $this->Paginator->sort('modified', ['label' => 'Last Saved']) ?></th>
					                    <th class="actions"><?= __('Actions') ?></th>
					                </tr>
					            </thead>
					            <tbody>
					                <?php foreach ($wikis as $wiki): ?>
					                <tr>
						                <td><?= $wiki->is_active ? '<span class="label label-success bi bi-check-lg"> Yes</span>' : '<span class="label label-danger bi bi-x-lg"> No</span>' ?></td>
					                    <td><?= h($wiki->name) ?></td>
					                    <td><?= h($wiki->slug) ?></td>
					                    <td><?= h($wiki->short) ?></td>
					                    <td><?= date_format($wiki->last_modified, 'M j, o') ?><br><?= date_format($wiki->modified, 'M j, o') ?></td>
					                    <td class="actions">
						                    <div class="btn-group btn-group-vertical">
					                        	<?= $this->Html->link(__(' View'), ['prefix' => false, 'controller' => 'wikis', 'action' => 'view', $wiki->slug], ['class' => 'btn btn-default btn-xs bi bi-eye-fill', 'target' => '_blank']) ?>
												<?= $this->Html->link(__(' Edit'), ['action' => 'edit', $wiki->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
												<?= $this->Form->postLink(__(' Delete'), ['action' => 'delete', $wiki->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wiki->id), 'class' => 'btn btn-xs btn-danger mt0 bi bi-trash']) ?>
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
		</div>
	</section>
</div>