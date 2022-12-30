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
						<div class="panel-heading">Clinic Users Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'side-nav-item btn btn-default']) ?>
								<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'side-nav-item btn btn-success bi bi-plus-lg']) ?>
								<?= $this->Form->postLink(
					                __(' Delete'),
					                ['action' => 'delete', $locationUser->id],
					                ['confirm' => __('Are you sure you want to delete # {0}?', $locationUser->id), 'class' => 'btn btn-danger bi bi-trash']
					            ) ?>
					            <!-- *** TODO: check default email and password change links when functionality is built *** -->
								<?= $this->Html->link(__(' Send Default Email'), ['action' => 'default_email', $locationUser->id], ['class' => 'btn btn-primary bi bi-envelope-fill']) ?>
								<?= $this->Html->link(__(' Change Password'), ['action' => 'change_password', $locationUser->id], ['class' => 'btn btn-success bi bi-lock-fill']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2><?= __('Edit Clinic User') ?></h2>
								<div class="row">
								    <div class="column-responsive column-80">
								        <div class="users form content">
								            <?= $this->Form->create($locationUser) ?>
								            <fieldset>
												<?php
													echo $this->Form->control('id', ['type' => 'text', 'required' => false, 'disabled' => true]);
													/*** TODO: pull in location title instead of ID ***/
													echo $this->Form->control('location_id', ['type' => 'text']);
													echo $this->Form->control('created', ['type' => 'text', 'disabled' => true]);
													echo $this->Form->control('modified', ['type' => 'text', 'disabled' => true]);
												?>
								                <div class="tabbable">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#Basic" data-toggle="tab">Basic</a></li>
														<li><a href="#LoginHistory" data-toggle="tab">Login History</a></li>
													</ul>
													<div class="tab-content">
														<div class="tab-pane active mt20" id="Basic">
											                <?php
											                    echo $this->Form->control('username');
											                    echo $this->Form->control('first_name', ['required' => false]);
											                    echo $this->Form->control('last_name', ['required' => false]);
											                    echo $this->Form->control('email');
											                ?>
														</div>
														<div class="tab-pane mt20" id="LoginHistory">
															<?= $this->Form->control('lastlogin', ['label' => 'Login', 'empty' => true, 'disabled' => true]) ?>
															<!-- *** TODO: pull in location_user_logins ip *** -->
														</div>
													</div>
								                </div>
								            </fieldset>
								            <div class="form-actions tar">
								            	<?= $this->Form->button(__('Save Clinic User'), ['class' => 'btn btn-primary btn-lg']) ?>
								            </div>
								            <?= $this->Form->end() ?>
								        </div>
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