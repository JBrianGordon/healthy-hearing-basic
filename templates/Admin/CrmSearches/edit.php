<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CrmSearch $crmSearch
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */

//Populate user dropdown with usernames rather than id's
$userOptions = [];
foreach ($users as $userId => $username) {
    $userOptions[$userId] = $username;
}
 
$this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Crm Searches Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link("<i class='bi bi-search'></i> Browse", ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
				<?= $this->Html->link("<i class='bi bi-trash'></i> Delete", ['action' => 'delete', $crmSearch->id], ['class' => 'btn btn-danger', 'escape' => false], ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearch->id)]) ?>
			</div>
		</div>
	</div>
</header>	
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
		        <div class="crmsearches form locations">
		            <?= $this->Form->create($crmSearch) ?>
		            <fieldset>
		                <?php
			                echo '<div class="mb-3 form-group text"><label class="form-label" for="id">ID</label><div class="form-control border-0 pl0">' . $crmSearch->id . '</div></div><div class="clearfix"></div>';
		                    echo $this->Form->control('model');
		                    echo $this->Form->control('priority', ['label' => 'Order']);
		                    echo $this->Form->control('title');
		                    echo $this->Form->control('search');
		                ?>
		                <div class="col-md-offset-3 pl0">
		                    <?= $this->Form->control('is_public') ?>
		                </div>
		                <?php
							echo $this->Form->control('user_id', ['options' => $userOptions]);
	                        echo $this->Form->control('created', ['disabled' => true]);
		                ?>
		            </fieldset>
                    <div class="form-actions tar clearfix">
                        <?= $this->Form->button('Save CRM search', ['class' => 'btn btn-primary btn-lg']) ?>
                     </div>
                    <?= $this->Form->end() ?>
		        </div>
			</div>
		</div>
	</section>
</div>