<script src="https://cdn.ckbox.io/CKBox/2.2.0/ckbox.js"></script>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
use App\Model\Entity\Content;
use Cake\Routing\Router;
 
$this->Html->script('dist/content_edit.min', ['block' => true]);

$author_default = false;
$isFrozen = !empty($content->is_frozen);
$isDraft = !empty($content->draft_parent_id);
if (empty($content->id)) {
	if (in_array($user->id, $authors)) {
		$author_default = $user->id;
	}
}
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
						<div class="panel-heading">Content Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link( 'Browse', ['action' => 'index'], ['class' => 'btn btn-default bi-search']) ?>
								<?php if (!empty($content->id)): ?>
									<?= $this->Html->link(' Add', ['action' => 'edit'], ['class' => 'btn btn-success bi-plus-lg']) ?>
									<?= $this->Form->postLink('Delete', ['action' => 'delete', $content->id], ['confirm' => __('Are you sure you want to delete # {0}?', $content->id), 'class' => 'btn btn-danger bi-trash-fill', 'id' => 'deleteBtn']) ?>
						            <!--*** TODO: Preview button not functioning correctly ***-->
									<?= $this->Html->link(' Preview', ['action' => 'preview', $content->id], ['class' => 'btn btn-default bi-eye-fill', 'target'=>'_blank']) ?>
									<?php if (!$isDraft): ?>
										<?= $this->Html->link(' View', $content->hh_url, ['class' => 'btn btn-default bi-eye-fill', 'target'=>'_blank']) ?>
										<?php if ($isFrozen): ?>
											<!-- This content is locked -->
											<?= $this->Html->link(' Update and republish', ['action' => 'draft', $content->id], ['class' => 'btn btn-default bi-arrow-repeat']) ?>
										<?php endif; ?>
									<?php endif; ?>
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
										This content is a draft copy of an existing article. <?= $this->Html->link('Click here to edit the original', ['action' => 'edit', 'prefix'=>'Admin', $content->draft_parent_id], ['target' => '_blank']) ?>.
									</div>
								<?php endif; ?>
								<div class="row">
								    <div class="column-responsive column-80">
								        <div class="content form">
								            <?= $this->Form->create($content, ['id' => 'contentForm']) ?>
								            <fieldset>
								                <?php
							                    echo $this->Form->hidden('is_frozen');
							                    echo $this->Form->hidden('id_draft_parent');
							                    echo $this->Form->control('title');
							                    echo $this->Form->control('subtitle');
							                    echo $this->Form->control('date', ['label' => 'Publication Date', 'empty' => true, 'disabled' => true]);
							                    echo $this->Form->control('last_modified', ['label' => 'Date for republication', 'empty' => true, 'type' => 'date', 'dateFormat' => 'MDY',]);
							                    echo $this->Form->control('type', ['options' => Content::$typeOptions]);
							                    echo $this->Form->control('user_id', ['label' => 'Primary Author', 'options' => $authors, 'default' => $author_default, 'empty' => true]);
												if (!$isDraft && isset($content->hh_url) && is_array($content->hh_url)) {
													echo $this->Form->control('current_url', ['value' => Router::url($content->hh_url, true), 'disabled' => false]);
												}
												?>
												<?php if (empty($content->is_active)): ?>
													<div class="form-group">
														<label class="col col-md-3 control-label">Redirects To:</label>
														<div class="col col-md-9" style="padding:8px 12px;">
															<?php if (!empty($seoRedirect)): ?>
																<?= Router::url($seoRedirect->redirect, true) ?>
															<?php else: ?>
																<?= $this->Html->link('Create Redirect', ['controller'=>'seo', 'admin' => true, 'action' => 'seo_redirects', 'edit']) ?>
															<?php endif; ?>
														</div>
													</div>
												<?php endif; ?>
												<?php
							                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
							                    echo $this->Form->control('is_active');
							                    echo '</div>';
							                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
							                    echo $this->Form->control('is_library_item');
							                    echo '</div>';
							                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
							                    echo $this->Form->control('is_gone', ['label' => '410 This Content']);
							                    echo '<span class="help-block"><strong>Note:</strong> If checked, this content will serve a 410 GONE instead of rendering the content.</span>';
							                    echo '</div>';
								                ?>
								                <ul class="nav nav-tabs mb-3 clearfix" role="tablist">
								                    <li class="nav-item" role="presentation">
								                        <button class="nav-link active" id="content-tab"
								                            data-bs-toggle="tab" data-bs-target="#content"
								                            type="button" role="tab"
								                            aria-controls="content" aria-selected="true">Content</button>
								                    </li>
								                    <li class="nav-item" role="presentation">
								                        <button class="nav-link" id="details-tab"
								                            data-bs-toggle="tab" data-bs-target="#details"
								                            type="button" role="tab"
								                            aria-controls="details" aria-selected="false">Details</button>
								                    </li>
								                    <li class="nav-item" role="presentation">
								                        <button class="nav-link" id="admin-tab"
								                            data-bs-toggle="tab" data-bs-target="#admin"
								                            type="button" role="tab"
								                            aria-controls="admin" aria-selected="false">Admin</button>
								                    </li>
								                </ul>
								                <div class="tab-content" id="myTabContent">
								                    <!-- Content Tab -->
								                    <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">
								                       <?php
								                            echo $this->Form->control('body', ['label' => false, 'class' => 'editor', 'required' => false]);
								                            echo $this->Form->control('short');
								                            echo $this->Form->control('library_share_text');
								                        ?>
								                    </div>
								                    <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
								                        <?php
								                            echo $this->Form->control('slug');
								                            echo $this->Form->control('alt_title', ['label' => 'Alt Headline (hidden)']);
								                            echo $this->Form->control('title_head', ['label' => 'Title Tag']);
								                            echo $this->Form->control('meta_description');
								                            echo $this->Form->control('facebook_title');
								                            echo $this->Form->control('facebook_description');
								                        ?>
								                        <div class="row">
    														<div class="col-sm-9 col-sm-offset-3">
									                        <?= $this->Form->control('facebook_image_width_override', ['type' => 'checkbox', 'label' => 'Bypass image selection, width and alt text errors'])?>
										                    </div>
										                </div>
										                <?php
										                	//*** TODO: change this to upload to CKBox: ***/
								                            echo $this->Form->control('facebook_image', ['label' => 'Schema/Facebook Image<br><a class="btn btn-xs btn-info ck-box">Select New Image</a>', 'escape' => false]);
								                            echo $this->Form->control('facebook_image_width', ['label' => 'Image Width']);
								                            echo $this->Form->control('facebook_image_height', ['label' => 'Image Height']);
								                            echo $this->Form->control('facebook_image_alt', ['label' => 'Image Alt Text', 'required' => false]);
							                        	?>
														<hr>
														<h3>Additional Authors</h3>
														<?= $this->Form->control('Contributor', ['label' => false,'options' => $authors,'multiple' => 'checkbox']) ?>
														<hr>
														<h3>Help Page Tags</h3>
														<?= $this->Form->control('Wikis.Tags', ['label' => false,'options' => $tags,'multiple' => 'checkbox','escape' => false]) ?>
								                    </div>
								                    <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
								                    	<div class="row">
								                    		<strong class="col-sm-3 tar">Date last saved</strong>
									                        <p class="col-sm-9"><?= date('F j, Y', strtotime($content->last_modified)) ?></p>
									                    </div>
									                    <div class="row">
									                    	<strong class="col-sm-3 tar">Date created</strong>
									                    	<p class="col-sm-9"><?= date('F j, Y', strtotime($content->created)) ?></p>
									                    </div>
								                    </div>
								                </div>
								
								            </fieldset>
								            <div class="form-actions tar">
								            <?= $this->Form->button('Save For Approval', ['id' => 'ApproveLink', 'class' => 'btn btn-lg btn-info']) ?>
								            <?= $this->Form->button('Save Content', ['class' => 'btn btn-primary btn-lg']) ?>
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
