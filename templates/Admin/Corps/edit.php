<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */

use Cake\I18n\FrozenTime;

$isDraft = !empty($corp->id_draft_parent);

$this->Html->script('dist/corp_edit.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading"><?= __('Company Actions') ?></div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
				<?= $this->Form->postLink(__(' Delete'),['action' => 'delete', $corp->id],['confirm' => __('Are you sure you want to delete # {0}?', $corp->id), 'class' => 'btn btn-danger bi bi-trash-fill', 'id' => 'deleteBtn']) ?>
				<?= $this->Html->link(__(' Preview'), ['action' => 'preview', $corp->id], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
				<?php if(!$isDraft): ?>
					<?= $this->Html->link(__(' View'), ['prefix' => false, 'controller' => 'corps', 'action' => 'view', $corp->slug], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
					<?= $this->Form->postLink(__(' Update and republish'), ['action' => 'draft', $corp->id], ['class' => 'btn btn-default bi-arrow-repeat']) ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<?php if($isDraft): ?>
					<div class="alert alert-warning" role="alert">
						This manufacturer is a draft copy of an existing one. <?= $this->Html->link('Click here to edit the original', ['action' => 'edit', 'prefix'=>'Admin', $corp->id_draft_parent], ['target' => '_blank']) ?>.
					</div>
				<?php endif; ?>
				<div class="row">
				    <div class="column-responsive column-80">
				        <div class="corps form content">
							<div class="logo-container">
								<img src="<?= $corp->thumb_url ?>" loading="lazy" class="pull-right" alt="<?= $corp->facebook_title ?>" width="150" height="60">
							</div>
							<div class="clearfix"></div>
				            <?= $this->Form->create($corp, ['type' => 'file', 'id' => 'corpForm']) ?>
				            <fieldset>
				                <?php
					                echo $this->Form->control('title');
					                echo $this->Form->control('user_id', ['label' => 'Primary Author', 'options' => $authors, 'empty' => true]);
					                echo $this->Form->control('priority', [
										'label' => 'Order',
										'min' => -20,
					                ]);
					                if ($corp->id_draft_parent > 0) {
										echo $this->Form->control('last_modified', [
											'type' => 'datetime',
											'dateFormat' => 'MDY',
											'min' => FrozenTime::now()
												->addDay()
												->startOfDay()
												->i18nFormat('yyyy-MM-dd HH:mm:ss'),
										]);
					                } else {
										echo $this->Form->control('last_modified', [
											'type' => 'datetime',
											'dateFormat' => 'MDY',
										]);
					                }

					                echo '<div class="col-md-9 col-md-offset-3 pl0 mb-3">';
					                echo $this->Form->control('is_active', ['label' => 'Active']);
					                echo '</div>';
				                ?>
								<div class="tabbable">
									<ul class="nav nav-tabs clearfix">
										<li class="nav-item"><a href="#Corp" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">Company</a></li>
										<li class="nav-item"><a href="#Admin" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Admin</a></li>
									</ul>
									<div class="tab-content">
										<br>
										<div class="tab-pane active" id="Corp">
											<?php
												echo $this->Form->control('description', ['class' => 'editor']);
												echo $this->Form->control('short');
											?>
										</div>
										<div class="tab-pane" id="Admin">
											<?php
												echo $this->Form->control('title_long');
												echo $this->Form->control('slug');
												echo $this->Form->control('thumb_url');
											?>
                                            <img id="logo-imagePreview0" src="<?= $corp->logo_url ?? '#' ?>" class="form-group col-md-offset-3 mt-3" alt="Logo Preview" style="<?= $corp->logo_url ? '' : "display:none; " ?>max-width: 100px; max-height: 100px;" />
                                            <?=
                                                $this->Form->control('logo_name', [
                                                    'id' => 'logo-imageUpload0',
                                                    'class' => 'mt-3',
                                                    'type' => 'file',
                                                    'required' => false,
                                                    'label' => ['text' => 'Update logo']
                                                ]);
                                            ?>
                                            <?php
												echo $this->Form->control('facebook_title');
												echo $this->Form->control('facebook_description');
											?>
                                            <img id="facebook-imagePreview0" src="<?= $corp->facebook_image_url ?? '#' ?>" class="form-group col-md-offset-3 mt-3" alt="Facebook Image Preview" style="<?= $corp->facebook_image_url ? '' : "display:none; " ?>max-width: 100px; max-height: 100px;" />
                                            <?=
                                                $this->Form->control('facebook_image_name', [
                                                    'id' => 'facebook-imageUpload0',
                                                    'class' => 'mt-3',
                                                    'type' => 'file',
                                                    'required' => false,
                                                    'label' => ['text' => 'Update Facebook Image']
                                                ]);
                                            ?>
											<?php
												echo $this->Form->control('facebook_image');
												echo $this->Form->control('date_approved', ['empty' => true, 'type' => 'date', 'dateFormat' => 'MDY']);
											?>
											<hr>
											<h3>Contributors</h3>
			                                <strong>
												<em class="text-secondary">Select multiple with the control key (PC) or command key (Mac)</em>
			                                </strong>
			                                <?=
												$this->Form->select('contributors._ids',
													$authors,
													[
														'empty' => "NO additional contributors",
														'multiple' => true,
														'size' => 14
													]
												)
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