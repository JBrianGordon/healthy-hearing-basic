<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\City $city
 */
 
 $this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Cities Actions</div>
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
		        <div class="zips form p20">
		            <?= $this->Form->create($city) ?>
		            <fieldset>
		                <?php
		                    echo $this->Form->control('city', ['required' => false]);
		                    echo $this->Form->control('state', ['required' => false]);
		                ?>
		            </fieldset>
		            <div class="form-actions tar">
		            	<?= $this->Form->button(__('Add City'), ['class' => 'btn btn-primary btn-lg']) ?>
		            </div>
		            <?= $this->Form->end() ?>
		        </div>
			</div>
		</div>
	</section>
</div>