<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zip $zip
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
						<div class="panel-heading">Zips Actions</div>
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
								                /*** TODO: look into 'zip' validation error in debug ***/
								                echo $this->Form->control('zip', ['label' => 'ZIP', 'type' => 'number']);
							                    echo $this->Form->control('lat', ['required' => false]);
							                    echo $this->Form->control('lon', ['required' => false]);
							                    echo $this->Form->control('city', ['required' => false]);
							                    echo $this->Form->control('state', ['required' => false]);
							                    echo $this->Form->control('areacode', ['required' => false]);
							                    echo $this->Form->control('country_code');
							                ?>
							            </fieldset>
							            <div class="form-actions tar">
							            	<?= $this->Form->button(__('Save ZIP'), ['class' => 'btn btn-primary btn-lg']) ?>
							            </div>
							            <?= $this->Form->end() ?>
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
