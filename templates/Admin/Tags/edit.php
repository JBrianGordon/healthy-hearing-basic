<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 * @var string[]|\Cake\Collection\CollectionInterface $content
 */
 
$this->Vite->script('admin_common','admin');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Tags Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
				<?= $this->Form->postLink(
	                __(' Delete'),
	                ['action' => 'delete', $tag->id],
	                ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'btn btn-danger bi bi-trash']
	            ) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
		        <div class="tags form content">
		            <?= $this->Form->create($tag) ?>
		            <fieldset>
		                <?php
		                    echo $this->Form->control('name');
		                    echo '<div class="col-md-9 col-md-offset-3 pl0 mb-3">';
		                    echo $this->Form->control('is_category', ['required' => true]);
		                    echo '</div>';
		                    echo '<div class="col-md-9 col-md-offset-3 pl0 mb-3">';
		                    echo $this->Form->control('is_sub_category', ['required' => true]);
		                    echo '</div>';
		                    echo $this->Form->control('header');
		                    echo $this->Form->control('display_header', ['required' => false]);
		                    echo $this->Form->control('ribbon_header', ['required' => false]);
		                ?>
		            </fieldset>
		            <div class="form-actions tar">
		            <?= $this->Form->button(__('Save Tag'), ['class' => 'btn btn-primary btn-lg']) ?>
		            </div>
		            <?= $this->Form->end() ?>
		        </div>
			</div>
		</div>
	</section>
</div>