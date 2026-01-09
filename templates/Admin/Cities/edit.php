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
				<?= $this->Form->postLink(
	                __('Delete'),
	                ['action' => 'delete', $city->id],
	                ['confirm' => __('Are you sure you want to delete # {0}?', $city->id), 'id' => 'deleteBtn', 'class' => 'btn btn-danger bi bi-trash']
	            ) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
		        <div class="zips form content">
		            <?= $this->Form->create($city) ?>
		            <fieldset>
		                <?php
		                    echo $this->Form->control('city', ['required' => false]);
		                    echo $this->Form->control('state', ['required' => false]);
		                    echo $this->Form->control('country', ['required' => false]);
		                    echo $this->Form->control('lat', ['required' => false]);
		                    echo $this->Form->control('lon', ['required' => false]);
		                    echo $this->Form->control('population', ['required' => false]);
		                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
		                    echo $this->Form->control('is_near_location');
		                    echo '</div>';
		                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
		                    echo $this->Form->control('is_featured', ['label' => ' Show on /hearing-aids']);
		                    echo '</div>';
		                ?>
		            </fieldset>
		            <div class="form-actions tar">
		            	<?= $this->Form->button(__('Save City'), ['class' => 'btn btn-primary btn-lg']) ?>
		            </div>
		            <?= $this->Form->end() ?>
		        </div>
			</div>
		</div>
	</section>
</div>