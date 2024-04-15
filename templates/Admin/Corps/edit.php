<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
use Cake\Core\Configure;

$author_default = false;
if (empty($content->id)) {
	if (in_array($user->id, $authors)) {
		$author_default = $user->id;
	}
}

Configure::read('country') == 'CA' ? $this->Html->script('dist/ca_corp_edit.min', ['block' => true]) : $this->Html->script('dist/corp_edit.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading"><?= __('Company Actions') ?></div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
				<?= $this->Form->postLink(__(' Delete'),['action' => 'delete', $corp->id],['confirm' => __('Are you sure you want to delete # {0}?', $corp->id), 'class' => 'btn btn-danger bi bi-trash-fill', 'id' => 'deleteBtn']) ?>
				<?= /*** TODO: add preview to controller ***/ $this->Html->link(__(' Preview'), ['action' => 'preview'], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
				<?= $this->Html->link(__(' View'), ['prefix' => false, 'controller' => 'corps', 'action' => 'view', $corp->slug], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
				<?= $this->Html->link(__(' Update and republish'), ['action' => 'draft'], ['class' => 'btn btn-default']) ?>
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
							<div class="logo-container">
								<img src="<?= $corp->thumb_url ?>" loading="lazy" class="pull-right" alt="<?= $corp->facebook_title ?>" width="150" height="60">
							</div>
							<div class="clearfix"></div>
				            <?= $this->Form->create($corp, ['id' => 'corpForm']) ?>
				            <fieldset>
				                <?php
					                echo $this->Form->control('title');
					                echo $this->Form->control('user_id', ['label' => 'Primary Author', 'options' => $authors, 'default' => $author_default, 'empty' => true]);
					                echo $this->Form->control('priority', ['label' => 'Order']);
					                echo $this->Form->control('last_modified', ['empty' => true, 'type' => 'date', 'dateFormat' => 'MDY']);
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
												//*** TODO: add upload file functionality ***
												echo $this->Form->control('facebook_title');
												echo $this->Form->control('facebook_description');
												echo $this->Form->control('facebook_image');
												echo $this->Form->control('date_approved', ['empty' => true, 'type' => 'date', 'dateFormat' => 'MDY']);
											?>
											<hr>
											<h3>Contributors</h3>
											<?= $this->Form->control('Contributor', ['label' => false,'options' => $authors,'multiple' => 'checkbox']) ?>
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