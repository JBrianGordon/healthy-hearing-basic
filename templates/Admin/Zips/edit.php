<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zip $zip
 */
use Cake\Core\Configure;

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading"><?= ucfirst($zipShort) ?> Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
				<?= $this->Form->postLink(
	                __(' Delete'),
	                ['action' => 'delete', $zip->zip],
	                ['confirm' => __('Are you sure you want to delete # {0}?', $zip->zip), 'class' => 'btn btn-danger bi bi-trash']
	            ) ?>
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
			                <?php
				                echo $this->Form->control('zip', ['label' => ucfirst(Configure::read('zipLabel')), 'type' => 'string']);
			                    echo $this->Form->control('lat');
			                    echo $this->Form->control('lon');
			                    echo $this->Form->control('city');
			                    echo $this->Form->control('state', ['label' => ucfirst(Configure::read('stateLabel'))]);
			                    echo $this->Form->control('areacode');
			                    echo $this->Form->control('country_code');
			                ?>
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