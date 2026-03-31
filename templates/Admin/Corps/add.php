<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 */

 $this->Vite->script('corp_edit','admin');

$author_default = false;
?>
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
				            <?= $this->Form->create($corp, ['type' => 'file', 'id' => 'corpForm']) ?>
				            <fieldset>
					            <div class="col-md-3 float-start"></div>
					            <strong class="col-md-9 mb20 float-end">Note: Creating a new company requires an update to the routes.php file.  Please contact a developer for assistance.</strong>
					            <div class="clearfix"></div>
				                <?php
					                echo $this->Form->control('title');
									echo $this->Form->control('user_id', [
										'label' => 'Primary Author',
										'options' => $authors,
										'default' => $author_default,
										'empty' => 'Select an author',
									]);
					                echo $this->Form->control('priority', [
										'label' => 'Order',
										'min' => -20,
										'max' => 1000,
					                ]);
					                echo $this->Form->control(
										'last_modified', [
											'default' => date("Y-m-d H:i:s")
										]
					                );
					                echo $this->Form->control('is_active', ['class' => 'col-sm-offset-3', 'style' => 'left:0', 'label' => ['class' => 'pl0']]);
				                ?>
								<ul class="nav nav-tabs clearfix">
									<li class="nav-item"><a href="#Corp" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">Company</a></li>
									<li class="nav-item"><a href="#Admin" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Admin</a></li>
								</ul>
								<div class="tab-content">
									<br>
									<div class="tab-pane active" id="Corp">
										<?= $this->Form->control('description', ['class' => 'editor', 'label' => ['style' => 'word-break: auto-phrase;']]) ?>
										<div class="ck-word-count tar w-100 mb-3"></div>
										<?= $this->Form->control('short') ?>
									</div>
									<div class="tab-pane" id="Admin">
										<strong class="col-md-offset-3 mb-0">
											<em class="text-secondary">Manufacturer page URLs are hard-coded in our system. Reach out to a developer for changes.</em>
										</strong>
										<?php
											echo $this->Form->control('slug');
										?>
										<img id="logo-imagePreview0" src="<?= $corp->logo_url ?? '#' ?>" class="form-group col-md-offset-3 mt-3<?= $corp->logo_url ? '' : " d-none" ?>" alt="Logo Preview" style="max-width: 100px; max-height: 100px;" />
										<input type="hidden" id="logoUrl" name="logo_url" class="d-none" value="<?= $corp->logo_url ?>">
										<?=
											$this->Form->control('logo_name', [
												'id' => 'logo-imageUpload0',
												'class' => 'mt-3 btn w-50',
												'style' => 'background-color:#78afc9;color:#fff',
												'required' => false,
												'label' => ['text' => 'Update logo'],
												'placeholder' => 'Choose an image',
												'readonly' => true,
												'value' => $corp->logo_name ?? ''
											]);
										?>
                                        <?php
											echo $this->Form->control('facebook_title');
											echo $this->Form->control('facebook_description');
										?>
										<img id="facebook-imagePreview0" src="<?= $corp->facebook_image_url ?? '#' ?>" class="form-group col-md-offset-3 mt-3<?= $corp->facebook_image_url ? '' : " d-none" ?>" alt="Facebook Image Preview" style="max-width: 100px; max-height: 100px;" />
										<input type="hidden" id="facebookImageUrl" name="facebook_image_url" class="d-none">
										<?php
											$inputValue = $this->Form->getValue('facebook_image_name');
											$class = isset($inputValue) ? 'mt-3 btn w-25' : 'mt-3 btn';
										?>

										<?=
											$this->Form->control('facebook_image_name', [
												'id' => 'facebook-imageUpload0',
												'class' => $class,
												'style' => 'background-color:#78afc9;color:#fff',
												'required' => false,
												'label' => ['text' => 'Update Facebook Image'],
												'placeholder' => 'Choose an image',
												'readonly' => true
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