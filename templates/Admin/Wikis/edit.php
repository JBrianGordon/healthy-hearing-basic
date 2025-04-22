<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */

use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
 
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
				<?php if(!$isDraft && $wiki->is_active): ?>
					<?= $this->Html->link(__(' View'), ['prefix' => false, 'action' => 'view', $wiki->slug], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
					<?= $this->Form->postLink(__(' Update and republish'), ['action' => 'draft', $wiki->id], ['class' => 'btn btn-default bi-arrow-repeat']) ?>
				<?php else: ?>
					<?= $this->Html->link(__(' Preview'), ['action' => 'preview', $wiki->id], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
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
					<div class="alert alert-warning mb-3" role="alert">
						This Help page is a draft copy of an existing one. <?= $this->Html->link('Click here to edit the original', ['action' => 'edit', 'prefix'=>'Admin', $wiki->id_draft_parent], ['target' => '_blank']) ?>.
					</div>
				<?php endif; ?>
		        <div class="wikis form content">
		            <?= $this->Form->create($wiki, ['type' => 'file', 'id' => 'wikisForm']) ?>
		            <fieldset>
		                <?php
		                    echo $this->Form->control('name', ['label' => 'Menu Name']);
		                ?>
						<span class="col-md-9 col-md-offset-3 ps-0 mt-n4 alert alert-info"><strong class="ps-3">URL:</strong> <?= Router::url($wiki->hh_url, true) ?></span>
		                <?php
		                    echo $this->Form->control('slug');
		                    echo $this->Form->control('user_id', ['label' => 'Primary Author', 'options' => $authors, 'empty' => true]);
							if ($wiki->id_draft_parent > 0) {
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
		                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
		                    echo $this->Form->control('is_active', ['label' => ' Active']);
		                    echo '</div>';
		                ?>
						<ul class="nav nav-tabs clearfix" role="tablist">
							<li class="nav-item" role="presentation"><button class="nav-link active" data-bs-target="#details" data-bs-toggle="tab" type="button">Help</button></li>
							<li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#admin" data-bs-toggle="tab" type="button">Admin</button></li>
							<li class="nav-item" role="presentation"><button class="nav-link" data-bs-target="#tags" data-bs-toggle="tab" type="button">Tag</button></li>
						</ul>
						<div class="tab-content mt20">
							<div class="tab-pane active content-body" id="details">
								<?php
				                    echo $this->Form->control('body', ['required' => false, 'class' => 'editor', 'label' => false]);
				                    echo $this->Form->control('short');
				                ?>
							</div>
							<div class="tab-pane" id="admin">
								<?php
									echo $this->Form->control('priority', [
										'required' => true,
										'label' => 'Order',
										'min' => -20,
										'max' => 1000,
									]);
									echo $this->Form->control('title_head', ['label' => 'Search title tag']);
									echo $this->Form->control('title_h1', ['label' => 'title/h1']);
									echo $this->Form->control('meta_description');
									echo $this->Form->control('facebook_title');
									echo $this->Form->control('facebook_description');
								?>
                                    <img id="facebook-imagePreview0" src="<?= $wiki->facebook_image_url ?? '#' ?>" class="form-group col-md-offset-3 mt-3" alt="Facebook Image Preview" style="<?= $wiki->facebook_image_url ? '' : "display:none; " ?>max-width: 100px; max-height: 100px;" />
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
									echo $this->Form->control('facebook_image_width', [
										'label' => 'Image Width (min 800px)',
										'readonly' => true,
									]);
									echo $this->Form->control('facebook_image_height', [
										'label' => 'Image Height',
										'readonly' => true,
									]);
				                    echo $this->Form->control('facebook_image_alt', ['label' => 'Image Alt Text', 'required' => false]);
				                ?>
                                <hr>
                                <h3>Additional Authors</h3>
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

                                <h3 class="mt-5">Reviewers</h3>
                                <?= $this->Form->control('reviewers._ids', ['label' => false,'options' => $reviewers,'multiple' => 'checkbox']) ?>
							</div>
							<div class="tab-pane" id="tags">
								<strong>A help/wiki page should only be associated with one tag. For now, repeated use of a tag is possible, so be aware of any conflicts. Before a tag can appear in the list below, it must be created in the <?= $this->Html->link('Tag admin panel', ['controller' => 'tags', 'action' => 'index'], ['target' => '_blank']) ?>.</strong>
								<br>
                                <em>Select one tag</em>
                                <?= $this->Form->select('tags._ids', $tags) ?>
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