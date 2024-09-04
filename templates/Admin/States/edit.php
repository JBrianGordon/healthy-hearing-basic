<?= $this->element('ckbox_script') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 */
 
$this->Html->script('dist/admin_edit_state.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
<div class="panel panel-light">
	<div class="panel-heading"><?= ucfirst($stateLabel) ?>s Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Form->postLink(
	                __(' Delete'),
	                ['action' => 'delete', $state->id],
	                ['confirm' => __('Are you sure you want to delete # {0}?', $state->id), 'id' => 'deleteBtn', 'class' => 'btn btn-danger bi bi-trash']
	            ) ?>
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
				        <div class="states form content">
				            <?= $this->Form->create($state) ?>
				            <fieldset>
				                <?php
				                    echo $this->Form->control('name');
				                    echo $this->Form->control('body', ['class' => 'editor']);
				                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
				                    echo $this->Form->control('is_active');
				                    echo '</div>';
				                ?>
				            </fieldset>
				            <div class="form-actions tar">
				            	<?= $this->Form->button('Save '.$stateLabel.' Page', ['class' => 'btn btn-primary btn-lg']) ?>
				            </div>
				            <?= $this->Form->end() ?>
				        </div>
				    </div>
				</div>
			</div>
		</div>
	</section>
</div>