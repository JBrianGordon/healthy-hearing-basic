<?php
use Cake\Core\Configure;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zip $zip
 */
 
$this->Vite->script('admin_common','admin');
$zip = $zip ?? null;
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading"><?= ucfirst($zipShort) ?> Actions</div>
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
			    <div class="column-responsive column-80">
			        <div class="zips form content">
			            <?= $this->Form->create($zip) ?>
			            <fieldset>
			                <?= $this->Form->control('zip', ['label' => ucfirst(Configure::read('zipLabel')), 'type'=>'string']) ?>
			            </fieldset>
			            <div class="form-actions tar">
			            	<?= $this->Form->button(__('Add ' . Configure::read('zipLabel')), ['class' => 'btn btn-primary btn-lg']) ?>
			            </div>
			            <?= $this->Form->end() ?>
			        </div>
			    </div>
			</div>
		</div>
	</section>
</div>