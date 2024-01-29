<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 */
 
$this->Html->script('dist/admin_edit_pages.min', ['block' => true]);
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
						<div class="panel-heading">Pages Actions</div>
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
						        <div class="pages form content">
						            <?= $this->Form->create($page) ?>
						            <fieldset>
						                <?php
							                echo '<span id="titleUnlock" class="btn btn-default btn-sm col-md-2 mt10">Unlock title field</span>';
						                    echo $this->Form->control('title', ['label' => ['class' => 'col col-md-3 control-label'], 'style' => 'width:50%', 'disabled' => true, 'id' => 'PageTitle']);
						                    echo '<small class="col-md-9 col-md-offset-3 red mb10">Warning: Changing the page title will affect whether or not the page displays correctly. Contact a developer if you would like a page title updated before saving any changes.</small>';
						                    echo $this->Form->control('content', ['class' => 'editor']);
						                ?>
						            </fieldset>
						            <div class="form-actions tar">
						            	<?= $this->Form->button(__('Save Page'), ['class' => 'btn btn-primary btn-lg']) ?>
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
