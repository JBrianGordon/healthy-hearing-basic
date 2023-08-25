<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $corps
 * @var string[]|\Cake\Collection\CollectionInterface $content
 * @var string[]|\Cake\Collection\CollectionInterface $wikis
 */
 
$this->Html->script('dist/admin_edit_user.min', ['block' => true]);
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
						<div class="panel-heading"><?= __('Users Actions') ?></div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
								<?= $this->Html->link(__(' Add'), ['action' => 'edit'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
								<?= $this->Form->postLink(
						            __('Delete'),
						            ['action' => 'delete', $user->id],
						            ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-danger bi bi-trash']
						        ) ?>
						        <?= $this->Html->link(__(' Change Password'), ['action' => 'change_password', $user->id], ['class' => 'btn btn-default bi bi-lock-fill']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
							    <div class="column-responsive column-80">
							        <div class="users form content">
							            <?= $this->Form->create($user) ?>
							            <fieldset>
							                <?= $this->Form->control('username', ['class'=>'form-group required']) ?>
							                <div class="col-md-offset-3 col-md-9 mb20">
							                	<?= $this->Form->control('active') ?>
							                </div>
							                <div class="clearfix"></div>
											<div class="tabbable">
												<ul class="nav nav-tabs">
													<li class="active"><a href="#Basic" data-toggle="tab" aria-expanded="true">Basic</a></li>
													<li class=""><a href="#Admin" data-toggle="tab" aria-expanded="false">Admin</a></li>
												</ul>
												<div class="tab-content mt20">
													<div class="tab-pane active" id="Basic">
														<div class="row">
															<div class="col-md-4"><?= $this->Form->control('first_name') ?></div>
															<div class="col-md-4"><?= $this->Form->control('middle_name', ['label' => 'Middle']) ?></div>
															<div class="col-md-4"><?= $this->Form->control('last_name', ['label' => 'Last']) ?></div>
														</div>
														<hr>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('degrees') ?></div>
															<div class="col-md-6"><?= $this->Form->control('honorific_prefix') ?></div>
														</div>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('title_dept_company') ?></div>
															<div class="col-md-6"><?= $this->Form->control('credentials') ?></div>
														</div>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('company') ?></div>
															<div class="col-md-6"><?= $this->Form->control('alumni_of_1') ?></div>
														</div>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('alumni_of_2') ?></div>
															<div class="col-md-6"><?= $this->Form->control('alumni_of_3') ?></div>
														</div>
														<hr>
														<?php
															echo $this->Form->control('url');
															echo $this->Form->control('image_url');
														?>
														<hr>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('email') ?></div>
															<div class="col-md-6"><?= $this->Form->control('recovery_email') ?></div>
														</div>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('phone') ?></div>
														</div>
														<hr>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('address') ?></div>
															<div class="col-md-6"><?= $this->Form->control('state') ?></div>
														</div>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('address_2') ?></div>
															<div class="col-md-6"><?= $this->Form->control('zip') ?></div>
														</div>
														<div class="row">
															<div class="col-md-6"><?= $this->Form->control('city') ?></div>
															<div class="col-md-6"><?= $this->Form->control('country') ?></div>
														</div>
														<hr>
														<?php
															echo $this->Form->control('bio');
															echo $this->Form->control('short_bio');
														?>
													</div>
													<div class="tab-pane" aria-expanded="false" id="Admin">
														<hr>
														<div class="row">
															<label class="col col-md-3 control-label">User Types<span class="red">*</span></label>
															<div class="col col-md-9">
																<div class="col-md-6"><?= $this->Form->control('is_admin', ['label' => 'Admin']) ?></div>
																<div class="col-md-6"><?= $this->Form->control('is_it_admin', ['label' => 'IT Admin']) ?></div>
																<div class="col-md-6"><?= $this->Form->control('is_agent', ['label' => 'Call Assist Agent']) ?></div>
																<div class="col-md-6"><?= $this->Form->control('is_call_supervisor', ['label' => 'Call Assist Supervisor']) ?></div>
																<div class="col-md-6"><?= $this->Form->control('is_csa', ['label' => 'Customer Support Assistant']) ?></div>
																<div class="col-md-6"><?= $this->Form->control('is_writer', ['label' => 'Content Writer']) ?></div>
																<div class="col-md-6"><?= $this->Form->control('is_author', ['label' => 'Author']) ?></div>
																<!-- *** TODO: check why Reviewer isn't a boolean ***-->
																<div class="col-md-6"><?= $this->Form->control('is_reviewer', ['label' => 'Reviewer']) ?></div>
															</div>
														</div>
														<hr>
														<div class="row">
															<?= $this->Form->control('notes') ?>
														</div>
														<div class="row">
															<?= $this->Form->control('corp_id') ?>
														</div>
														<div class="row">
															<?= $this->Form->control('timezone_offset') ?>
														</div>
														<div class="row">
															<?= $this->Form->control('timezone') ?>
														</div>
													</div>
												</div>
											</div>
							            </fieldset>
							            <div class="form-actions tar">
							            	<?= $this->Form->button(__('Save User'), ['class' => 'btn btn-primary btn-lg']) ?>
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
