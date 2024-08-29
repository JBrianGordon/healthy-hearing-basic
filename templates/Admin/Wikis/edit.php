<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
 
$this->Html->script('dist/wiki_edit.min', ['block' => true]);

$isDraft = !empty($wiki->id_draft_parent);
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Help Pages Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
				<?= $this->Html->link(__(' Preview'), ['action' => 'preview', $wiki->id], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
				<?= $this->Html->link(__(' View'), ['prefix' => false, 'action' => 'view', $wiki->slug], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
				<?php if(!$isDraft): ?>
					<?= $this->Form->postLink(__(' Update and republish'), ['action' => 'draft', $wiki->id], ['class' => 'btn btn-default bi bi-clipboard-check']) ?>
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
						This Help page is a draft copy of an existing one. <?= $this->Html->link('Click here to edit the original', ['action' => 'edit', 'prefix'=>'Admin', $wiki->id_draft_parent], ['target' => '_blank']) ?>.
					</div>
				<?php endif; ?>
		        <div class="wikis form content">
		            <?= $this->Form->create($wiki, ['id' => 'wikisForm']) ?>
		            <fieldset>
		                <?php
		                    echo $this->Form->control('name');
		                    echo $this->Form->control('slug');
		                    echo $this->Form->control('user_id', ['label' => 'Primary Author', 'options' => $authors, 'empty' => true]);
		                    echo $this->Form->control('last_modified', ['empty' => true]);
		                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
		                    echo $this->Form->control('is_active', ['label' => ' Active']);
		                    echo '</div>';
		                ?>
						<ul class="nav nav-tabs clearfix" role="tablist">
							<li class="nav-item" role="presentation"><button class="nav-link active" data-bs-target="#details" data-bs-toggle="tab" type="button">Help</button></li>
							<li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#admin" data-bs-toggle="tab" type="button">Admin</button></li>
							<li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#display" data-bs-toggle="tab" type="button">Display</button></li>
							<li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#tags" data-bs-toggle="tab" type="button">Tags</button></li>
						</ul>
						<div class="tab-content mt20">
							<div class="tab-pane active" id="details">
								<?php
				                    echo $this->Form->control('body', ['required' => false, 'class' => 'editor', 'label' => false]);
				                    echo $this->Form->control('short');
				                ?>
							</div>
							<div class="tab-pane" id="admin">
								<?php
				                    echo $this->Form->control('priority', ['required' => true]);
				                    echo $this->Form->control('title_head');
				                    echo $this->Form->control('title_h1');
				                    echo $this->Form->control('meta_description');
				                    echo $this->Form->control('facebook_title');
				                    echo $this->Form->control('facebook_description');
				                    echo '<div class="col-md-9 col-md-offset-3 pl0 mb-3">';
				                    echo $this->Form->control('facebook_image_bypass', ['label' => 'Bypass image selection, width and alt text errors', 'class' => 'mb20']);
				                    echo '</div>';
				                    echo $this->Form->control('facebook_image');
				                    echo $this->Form->control('facebook_image_width', ['label' => 'Image Width (min 800px)', 'required' => false]);
				                    echo $this->Form->control('facebook_image_height', ['label' => 'Image Height']);
				                    echo $this->Form->control('facebook_image_alt', ['label' => 'Image Alt Text', 'required' => false]);
				                ?>
                                <hr>
                                <h3>Additional Authors</h3>
                                <?= $this->Form->control('contributors._ids', ['label' => false,'options' => $authors,'multiple' => 'checkbox']) ?>
                                <h3>Reviewers</h3>
                                <!--*** TODO: add reviewers ***-->
							</div>
							<div class="tab-pane" id="display">
								<?php
									//*** TODO: may want to have this upload to CKBox: ***/
				                    echo $this->Form->control('background_file');
				                    echo $this->Form->control('background_alt');
								?>
							</div>
							<div class="tab-pane" id="tags">
                                <h3>Tags</h3>
                                <?= $this->Form->control('tags._ids', [
										'label' => false,
										'options' => $tags,
										'multiple' => 'checkbox',
										'escape' => false,
										'value' => $selectedTags,
									])
								?>
							</div>
						</div>
		            </fieldset>
		            <div class="form-actions tar">
		            	<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-lg']) ?>
		            </div>
		            <?= $this->Form->end() ?>
		        </div>
			</div>
		</div>
	</section>
</div>