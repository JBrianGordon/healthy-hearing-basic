<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Page> $pages
 */
 
$this->Html->script('dist/common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Pages Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(" Browse", ['action' => 'index'], ['class' => 'btn btn-default bi bi-search', 'escape' => false]) ?>
				<?= $this->Html->link(" Add", ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg', 'escape' => false]) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2>Misc Pages</h2>
				<div class="content index">
				    <div class="col-12 table-responsive">
				        <table class="table table-striped table-bordered">
				            <thead>
				                <tr class="align-top">
				                    <th style="width:90%">Title</th>
				                    <th class="actions"><?= __('Action') ?></th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php foreach ($pages as $page) : ?>
				                <tr>
				                    <td><?= h($page->title) ?></td>
				                    <td class="actions">
				                        <div class="btn-group-vertical btn-group">
				                            <?=
				                                $this->Html->link(
				                                    __('Edit'),
				                                    ['action' => 'edit', $page->id],
				                                    ['class' => 'btn btn-default btn-xs']
				                                )
				                            ?>
				                        </div>
				                    </td>
				                </tr>
				                <?php endforeach; ?>
				            </tbody>
				        </table>
				    </div>
				</div>
			</div>
		</div>
	</section>
</div>