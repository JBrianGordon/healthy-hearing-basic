<script src="https://cdn.tiny.cloud/1/wu3a6uyrxdnngas65ywopa04fomzngbm8e16wmw21ffr4vua/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
 
$this->Html->script('dist/wiki_edit.min', ['block' => true]);
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
						<div class="panel-heading">Help Pages Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
								<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
								<?= $this->Html->link(__(' Preview'), ['action' => 'preview', $wiki->id], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
								<?= $this->Html->link(__(' View'), ['prefix' => false, 'action' => 'view', $wiki->slug], ['class' => 'btn btn-default bi bi-eye-fill', 'target' => '_blank']) ?>
								<?= $this->Html->link(__(' Update and republish'), ['action' => 'draft', $wiki->id], ['class' => 'btn btn-default bi bi-clipboard-check']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">									
						        <div class="wikis form content">
						            <?= $this->Form->create($wiki) ?>
						            <fieldset>
						                <?php
						                    echo $this->Form->control('name');
						                    echo $this->Form->control('slug');
						                    echo $this->Form->control('user_id', ['label' => 'Primary Author']);
						                    echo $this->Form->control('last_modified', ['empty' => true]);
						                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
						                    echo $this->Form->control('is_active', ['label' => ' Active', 'required' => true]);
						                    echo '</div>';
						                ?>
						                <div class="clearfix" role="tabpanel">
											<ul class="nav nav-tabs" role="tablist">
												<li class="active"><a href="#details" data-toggle="tab">Help</a></li>
												<li><a href="#admin" data-toggle="tab">Admin</a></li>
												<li><a href="#display" data-toggle="tab">Display</a></li>
												<li><a href="#tags" data-toggle="tab">Tags</a></li>
											</ul>
											<div class="tab-content mt20">
												<div class="tab-pane active" id="details">
													<?php
									                    echo $this->Form->control('body', ['required' => false]);
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
									                    echo $this->Form->control('users._ids', ['options' => $users]);
									                ?>
												</div>
												<div class="tab-pane" id="display">
													<?php
									                    echo $this->Form->control('background_file');
									                    echo $this->Form->control('background_alt');
													?>
												</div>
												<div class="tab-pane" id="tags">
													<?php
														
													?>
												</div>
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
			</div>
		</div>
	</div>
</div>
<script>
	tinymce.init({
	  selector: '#body',
	  plugins: 'tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker tinydrive autocorrect a11ychecker typography inlinecss',
	  tinydrive_token_provider: `${window.location.origin}/endpoints/tinymce_endpoint`,
	  toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | insertfile link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
	  tinycomments_mode: 'embedded',
	  tinycomments_author: 'Author name',
	  mergetags_list: [
	    { value: 'First.Name', title: 'First Name' },
	    { value: 'Email', title: 'Email' },
	  ]
	});
</script>