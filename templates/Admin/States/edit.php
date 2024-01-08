<script src="https://cdn.ckbox.io/CKBox/2.2.0/ckbox.js"></script>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\State $state
 */
 
$this->Html->script('dist/admin_edit_state.min', ['block' => true]);
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
					<div class="panel-heading">States Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
								<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
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
								                    /*** TODO: replace body with CKEditor when possible ***/
								                    echo $this->Form->control('body', ['class' => 'editor']);
								                    echo '<div class="col-md-9 col-md-offset-3 pl0">';
								                    echo $this->Form->control('is_active');
								                    echo '</div>';
								                ?>
								            </fieldset>
								            <div class="form-actions tar">
								            	<?= $this->Form->button(__('Save State Page'), ['class' => 'btn btn-primary btn-lg']) ?>
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
