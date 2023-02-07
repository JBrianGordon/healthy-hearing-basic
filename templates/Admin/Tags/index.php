<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag[]|\Cake\Collection\CollectionInterface $tags
 */
 
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
						<div class="panel-heading">Tags Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
								<?= $this->Html->link(__(' Add'), ['action' => 'edit'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<div class="tags index content">
									<?= $this->element('pagination') ?>
								    <div class="table-responsive mb20">
								        <table class="table table-striped table-bordered table-condensed mt20">
								            <thead>
								                <tr>
								                    <th><?= $this->Paginator->sort('id') ?></th>
								                    <th><?= $this->Paginator->sort('name') ?></th>
								                    <th><?= $this->Paginator->sort('is_category') ?></th>
								                    <th><?= $this->Paginator->sort('is_sub_category') ?></th>
								                    <th><?= $this->Paginator->sort('header') ?></th>
								                    <th style="width:25%"><?= $this->Paginator->sort('created') ?><br><?= $this->Paginator->sort('modified') ?></th>
								                    <th class="actions"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($tags as $tag): ?>
								                <tr>
								                    <td><?= $this->Number->format($tag->id) ?></td>
								                    <td><?= h($tag->name) ?></td>
								                    <td><?= $tag->is_category ? '<span class="label label-success bi bi-check-lg"> Yes</span>' : '<span class="label label-danger bi bi-x-lg"> No</span>' ?></td>
								                    <td><?= $tag->is_sub_category ? '<span class="label label-success bi bi-check-lg"> Yes</span>' : '<span class="label label-danger bi bi-x-lg"> No</span>' ?></td>
								                    <td><?= $this->Text->truncate($tag->header) ?></td>
								                    <td><?= date_format($tag->created, 'M jS o, G:i') ?><br><?= date_format($tag->modified, 'M jS o, G:i') ?></td>
								                    <td class="actions">
								                        <?= $this->Html->link(__(' Edit'), ['action' => 'edit', $tag->id], ['class' => 'btn btn-xs bi bi-pencil']) ?>
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
			</div>
		</div>
	</div>
</div>
