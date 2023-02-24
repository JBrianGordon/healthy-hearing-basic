<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
 
$this->Html->script('dist/content_edit.min', ['block' => true]);
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
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi-search']) ?>
								<!-- ***TODO: set up add when ready**-->
								<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi-plus-lg']) ?>
								<?= $this->Form->postLink(
					                __('Delete'),
					                ['action' => 'delete', $content->id],
					                ['confirm' => __('Are you sure you want to delete # {0}?', $content->id), 'class' => 'btn btn-danger bi-trash-fill', 'id' => 'deleteBtn']
					            ) ?>
								<?= $this->Html->link(__(' Preview'), ['action' => 'preview', $content->id], ['class' => 'btn btn-default bi-eye', 'target'=>'_blank']) ?>
								<?= $this->Html->link(__(' View'), ['prefix' => false, 'controller' => 'report', 'action' => $content->id . '-' . $content->hh_url['slug']], ['class' => 'btn btn-default bi-eye', 'target'=>'_blank']) ?>
								<?= $this->Html->link(__(' Update and republish'), ['action' => 'draft', $content->id], ['class' => 'btn btn-default bi-clipboard-check']) ?>
								<?= $this->Html->link(__(' Sync Photos'), ['action' => 'rsync'], ['class' => 'btn btn-default bi-arrow-repeat']) ?>
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
								        <div class="content form">
								            <?= $this->Form->create($content) ?>
								            <fieldset>
								                <?php
								                    echo $this->Form->hidden('is_frozen');
								                    echo $this->Form->hidden('id_draft_parent');
								                    echo $this->Form->control('title');
								                    echo $this->Form->control('subtitle');
								                    echo $this->Form->control('date', ['empty' => true]);
								                    echo $this->Form->control('last_modified', ['empty' => true]);
								                    echo $this->Form->control('type');
								                    echo $this->Form->control('primary_author');
								                    echo $this->Form->control('hh_url');
								                    //*** TODO: Fix checkbox layout ***
								                    echo $this->Form->control('is_active');
								                    echo $this->Form->control('is_library_item');
								                    echo $this->Form->control('is_gone');
								                ?>
								                <ul class="nav nav-tabs mb-3" role="tablist">
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
									                       /*** TODO: Add CKEditor when ready ***/
								                            echo $this->Form->control('body');
								                            echo $this->Form->control('short');
								                            echo $this->Form->control('library_share_text');
								                        ?>
								                    </div>
								                    <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
								                        <?php
								                            echo $this->Form->control('slug');
								                            echo $this->Form->control('alt_title');
								                            echo $this->Form->control('title_head');
								                            echo $this->Form->control('meta_description');
								                            echo $this->Form->control('facebook_title');
								                            echo $this->Form->control('facebook_description');
								                            echo $this->Form->control('facebook_image');
								                            echo $this->Form->control('facebook_image_width');
								                            echo $this->Form->control('facebook_image_height');
								                            echo $this->Form->control('facebook_image_alt');
								                        ?>
								                    </div>
								                    <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
								                        <?php
								                            echo $this->Form->control('last_modified', ['empty' => true]);
								                            echo $this->Form->control('created');
								                        ?>
								                    </div>
								                </div>
								
								            </fieldset>
								            <?= $this->Form->button(__('Submit')) ?>
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
