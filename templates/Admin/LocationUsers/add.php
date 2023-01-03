<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUser $locationUser
 */
 
$this->Html->script('dist/location_users.min', ['block' => true]);
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
						<div class="panel-heading"><?= __(' Clinic Users Actions') ?></div>
						<div class="panel-body p10">
							<div class="btn-group">
								<a href="/admin/location_users" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Browse</a>
								<a href="/admin/location_users/edit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add</a>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2>Add Clinic User</h2>
						        <div class="users form content">
						            <?= $this->Form->create($locationUser) ?>
						            <fieldset>
						                <?php
						                    echo $this->Form->control('username');
						                    echo $this->Form->control('first_name', ['required' => false]);
						                    echo $this->Form->control('last_name', ['required' => false]);
						                    echo $this->Form->control('email');
						                ?>
						            </fieldset>
						            <div class="form-actions tar">
						            	<?= $this->Form->button(__('Save Clinic User'), ['class' => 'btn btn-primary btn-lg']) ?>
						            </div>
						            <?= $this->Form->end() ?>
						        </div>
						    </div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
