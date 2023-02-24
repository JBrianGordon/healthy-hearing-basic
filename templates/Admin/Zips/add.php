<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Zip $zip
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
						<div class="panel-heading">Zips Actions</div>
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
							    <div class="column-responsive column-80">
							        <div class="zips form content">
							            <?= $this->Form->create($zip) ?>
							            <fieldset>
							                <?= $this->Form->control('zip', ['type'=>'text']) ?>
							            </fieldset>
							            <div class="form-actions tar">
							            	<?= $this->Form->button(__('Add ZIP'), ['class' => 'btn btn-primary btn-lg']) ?>
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
