<?php
/**
 * @var \App\View\AppView $this
 */

$this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Utils Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(' Browse', ['action' => 'cache'], ['class' => 'btn btn-default bi bi-search']) ?>
			</div>
		</div>
	</div>
</header>
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<div class="citys index p20">
					<pre>
						<?= var_export($cache_contents, true) ?>
					</pre>
					<div class="form-actions tar">
					</div>
				</div>
			</div>
		</div>
	</section>
</div>