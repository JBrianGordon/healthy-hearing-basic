<?php
/**
 * @var \App\View\AppView $this
 */

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Utils Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
			</div>
		</div>
	</div>
</header>
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2>Caches</h2>
                <div class="utilities content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Cache</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($files as $file): ?>
									<tr>
										<td><?= $file ?></td>
										<td>
											<div class="btn-group-vertical">
												<?= $this->Html->link('<span class="bi bi-eye-fill"></span> View', ['action' => 'cache_view', $file], ['class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
												<?= $this->Html->link('<span class="bi bi-trash"></span> Delete', ['action' => 'cache_delete', $file], ['class' => 'btn btn-sm btn-danger', 'escape' => false], 'Are you sure you want to delete # '.$file.'?') ?>
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