<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp[]|\Cake\Collection\CollectionInterface $corps
 */
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
						<div class="panel-heading">Company Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<a href="/admin/corps" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Browse</a>
								<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
							</div>
						</div>
					</div>
				</header>
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2><?= __('Companies') ?></h2>
								<!-- ***TODO*** add in search bar and admin search toggle -->
								<div class="corps index">
								    <div class="paginator">
								        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
								    </div>
								    <div class="table-responsive">
								        <table class="table table-bordered table-striped table-condensed mt20">
								            <thead>
								                <tr>
									                <th><?= $this->Paginator->sort('priority', __('Order')) ?></th>
								                    <th><?= $this->Paginator->sort('is_active', __('Active')) ?><br><?= $this->Paginator->sort('id') ?></th>
								                    <th><?= $this->Paginator->sort('title') ?><br><?= $this->Paginator->sort('slug') ?></th>
								                    <th><?= $this->Paginator->sort('short') ?></th>
								                    <th><?= $this->Paginator->sort('website_url') ?></th>
								                    <th width="120"><?= $this->Paginator->sort('last_modified', __('Last Mod')) ?><br><?= $this->Paginator->sort('modified', __('Last Saved')) ?></th>
								                    <th class="actions"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($corps as $corp): ?>
								                <tr>
									                <td><?= $this->Number->format($corp->priority) ?></td>
								                    <td><?= $corp->is_active ? '<span class="label label-success bi bi-check-lg"> Yes</span>' : '<span class="label label-danger bi bi-x-lg"> No</span>' ?><br><span class="label label-default"><?= h($corp->id) ?></span></td>
								                    <td><?= h($corp->title) ?><br><?= h($corp->slug) ?></td>
								                    <td><?= h($corp->short) ?></td>
								                    <td><?= h($corp->website_url) ?></td>
								                    <td><?= date_format($corp->last_modified, 'M j, Y') ?><br><?= date_format($corp->modified, 'M j, Y') ?></td>
								                    <td>
									                    <div class="btn-group btn-group-vertical">
									                        <?= $this->Html->link(__('View'), ['prefix' => false, 'controller' => 'corps', 'action' => 'view', $corp->slug], ['class'=>'btn btn-xs btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
									                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $corp->id], ['class'=>'btn btn-xs btn-default bi bi-pencil-fill']) ?>
									                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $corp->id], ['class'=>'btn btn-xs btn-danger bi bi-trash-fill', 'confirm' => __('Are you sure you want to delete # {0}?', $corp->id)]) ?>
									                    </div>
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
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
