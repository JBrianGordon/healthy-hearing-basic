<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $corps
 * @var string[]|\Cake\Collection\CollectionInterface $content
 * @var string[]|\Cake\Collection\CollectionInterface $wikis
 */
use App\Model\Entity\User;
 
$this->Html->script('dist/admin_edit_user.min', ['block' => true]);
?>
<header class="col-sm-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Users Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
				<?= $this->Form->postLink('Delete',
		            ['action' => 'delete', $user->id],
		            ['confirm' => 'Are you sure you want to delete # {0}?', $user->id, 'class' => 'btn btn-danger bi bi-trash']
		        ) ?>
				<?= $this->Html->link(' Send Default Email', ['action' => 'default_email/'.$user->id], ['class' => 'btn btn-default bi bi-envelope']) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-sm-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
			    <div class="column-responsive column-80">
			        <div class="users form content">
			            <?= $this->Form->create($user) ?>
			            <fieldset>
							<h2>Edit User</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<tr>
										<th class="col-md-3 tar">ID</th>
										<td class="col-md-9">
											<?= $user->id ?>
										</td>
									</tr>
									<?php if (!empty($user->locations)): ?>
										<tr>
											<th class="col-md-3 tar">Clinic</th>
											<td class="col-md-9" id="clinic-data">
												<?= $this->Html->link($user->locations[0]->title, ['controller' => 'locations', 'action' => 'edit', $user->locations[0]->id]) ?>
												<?= '<br>'.$user->locations[0]->city.', '.$user->locations[0]->state ?>
											</td>
										</tr>
									<?php endif; ?>
									<tr>
										<th class="col-md-3 tar">Created</th>
										<td class="col-md-9">
											<?= $user->created ?>
										</td>
									</tr>
									<tr>
										<th class="col-md-3 tar">Modified</th>
										<td class="col-md-9">
											<?= $user->modified ?>
										</td>
									</tr>
								</table>
							</div>
			                <?= $this->Form->control('username', ['class'=>'form-group required', 'required' => true]) ?>
			                <div class="col-sm-offset-3 col-sm-9 mb20">
			                	<?= $this->Form->control('active') ?>
			                </div>
			                <div class="clearfix"></div>
							<div class="tabbable">
								<ul class="nav nav-tabs flex">
									<li class="nav-item"><button type="button" class="nav-link active" data-bs-target="#Basic" data-bs-toggle="tab" aria-controls="Basic" aria-expanded="true" role="tab">Basic</button></li>
									<li class="nav-item"><button type="button" class="nav-link" data-bs-target="#Admin" data-bs-toggle="tab" aria-controls="Admin" aria-expanded="false" role="tab">Admin</button></li>
									<li class="nav-item"><button type="button" class="nav-link" data-bs-target="#LoginHistory" data-bs-toggle="tab" aria-controls="Admin" aria-expanded="false" role="tab">Login History</button></li>
								</ul>
								<div class="tab-content mt20">
									<div class="tab-pane show fade active" id="Basic" role="tabpanel">
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('first_name', ['required' => true]) ?></div>
											<div class="col-sm-6"><?= $this->Form->control('last_name', ['required' => true]) ?></div>
										</div>
										<hr>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('degrees') ?></div>
											<div class="col-sm-6"><?= $this->Form->control('honorific_prefix') ?></div>
										</div>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('title_dept_company', ['type' => 'text']) ?></div>
											<div class="col-sm-6"><?= $this->Form->control('credentials') ?></div>
										</div>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('company') ?></div>
											<div class="col-sm-6"><?= $this->Form->control('alumni_of_1') ?></div>
										</div>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('alumni_of_2') ?></div>
											<div class="col-sm-6"><?= $this->Form->control('alumni_of_3') ?></div>
										</div>
										<hr>
										<?php
											echo $this->Form->control('url');
											echo $this->Form->control('image_url');
										?>
										<hr>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('email') ?></div>
											<div class="col-sm-6"><?= $this->Form->control('recovery_email') ?></div>
										</div>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('phone') ?></div>
										</div>
										<hr>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('address') ?></div>
											<div class="col-sm-6"><?= $this->Form->control('state') ?></div>
										</div>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('address_2') ?></div>
											<div class="col-sm-6"><?= $this->Form->control('zip') ?></div>
										</div>
										<div class="row">
											<div class="col-sm-6"><?= $this->Form->control('city') ?></div>
											<div class="col-sm-6"><?= $this->Form->control('country') ?></div>
										</div>
										<hr>
										<?php
											echo $this->Form->control('bio', ['class' => 'editor']);
											echo $this->Form->control('short_bio');
										?>
									</div>
									<div class="tab-pane fade" aria-expanded="false" id="Admin" role="tabpanel">
										<div class="row">
											<?= $this->Form->control('role', ['type' => 'select', 'options' => User::$roles]) ?>
										</div>
										<div class="row">
											<label class="col col-sm-3 control-label">User Types<span class="red">*</span></label>
											<div class="col-sm-9">
												<div class="col-sm-6"><?= $this->Form->control('is_admin', ['label' => 'Admin']) ?></div>
												<div class="col-sm-6"><?= $this->Form->control('is_it_admin', ['label' => 'IT Admin']) ?></div>
												<div class="col-sm-6"><?= $this->Form->control('is_agent', ['label' => 'Call Assist Agent']) ?></div>
												<div class="col-sm-6"><?= $this->Form->control('is_call_supervisor', ['label' => 'Call Assist Supervisor']) ?></div>
												<div class="col-sm-6"><?= $this->Form->control('is_csa', ['label' => 'Customer Support Assistant']) ?></div>
												<div class="col-sm-6"><?= $this->Form->control('is_writer', ['label' => 'Content Writer']) ?></div>
												<div class="col-sm-6"><?= $this->Form->control('is_author', ['label' => 'Author']) ?></div>
												<div class="col-sm-6"><?= $this->Form->control('is_reviewer', ['label' => 'Reviewer']) ?></div>
											</div>
										</div>
										<hr>
										<div class="row">
											<?= $this->Form->control('notes') ?>
										</div>
										<div class="row">
											<?= $this->Form->control('corp_id', ['empty' => true]) ?>
										</div>
										<div class="row">
											<?= $this->Form->control('timezone_offset') ?>
										</div>
										<div class="row">
											<?= $this->Form->control('timezone') ?>
										</div>
									</div>
									<div class="tab-pane fade" aria-expanded="false" id="LoginHistory" role="tabpanel">
										<div class="table-responsive">
											<table class="table table-condensed table-striped table-bordered">
												<tr>
													<th>Login</th>
													<th>IP Address</th>
												</tr>

												<?php foreach ($user->login_ips as $locationUserLogin): ?>
													<tr>
														<td><?= $locationUserLogin['login_date'] ?></td>
														<td><?= $locationUserLogin['ip'] ?></td>
													</tr>
												<?php endforeach; ?>
											</table>
										</div>
									</div>
								</div>
							</div>
			            </fieldset>
			            <div class="form-actions tar">
			            	<?= $this->Form->button('Save User', ['class' => 'btn btn-primary btn-lg']) ?>
			            </div>
			            <?= $this->Form->end() ?>
			        </div>
			    </div>
			</div>
		</div>
	</section>
</div>