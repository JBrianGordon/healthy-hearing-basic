<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
$this->Html->script('dist/corp_edit.min', ['block' => true]);
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
						<div class="panel-heading"><?= __('Company Actions') ?></div>
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
								<div class="row">
								    <div class="column-responsive column-80">
								        <div class="corps form content">
								            <?= $this->Form->create($corp) ?>
								            <fieldset>
									            <div class="col-md-3 float-start"></div>
									            <strong class="col-md-9 mb20 float-end">Note: Creating a new company requires an update to the routes.php file.  Please contact a developer for assistance.</strong>
									            <div class="clearfix"></div>
								                <?php
									                echo $this->Form->control('title');
									                //*** TODO: Add primary authors ***
									                echo $this->Form->control('priority', ['label' => 'Order']);
									                echo $this->Form->control('last_modified', ['empty' => true]);
									                echo $this->Form->control('is_active');
								                ?>
												<div class="tabbable">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#Corp" data-toggle="tab" aria-expanded="true">Company</a></li>
														<li class=""><a href="#Admin" data-toggle="tab" aria-expanded="false">Admin</a></li>
													</ul>
													<div class="tab-content">
														<br>
														<div class="tab-pane active" id="Corp">
															<?php
																echo $this->Form->control('description');
																echo $this->Form->control('short');
															?>
														</div>
														<div class="tab-pane" id="Admin">
															<?php
																echo $this->Form->control('title_long');
																echo $this->Form->control('slug');
																echo $this->Form->control('thumb_url');
																//*** TODO: add upload file functionality ***
																echo $this->Form->control('facebook_title');
																echo $this->Form->control('facebook_description');
																echo $this->Form->control('facebook_image');
																echo $this->Form->control('date_approved', ['empty' => true]);
																//*** TODO: Add Contributors list ***
															?>
														</div>
													</div>
												</div>
								            </fieldset>
								            <div class="form-actions tar">
								            <?= $this->Form->button(__('Save company'), ['class' => 'btn btn-primary btn-lg']) ?>
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