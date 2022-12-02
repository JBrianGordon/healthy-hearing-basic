<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CrmSearch $crmSearch
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
 
$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
				<header class="col-md-12 mt10">
					<div class="panel panel-light">
						<div class="panel-heading">Crm Searches Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link("<i class='bi bi-search'></i> Browse", ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
								<?= $this->Html->link("<i class='bi bi-plus-lg'></i> Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
								<?= $this->Html->link("<i class='bi bi-trash'></i> Delete", ['action' => 'delete', $crmSearch->id], ['class' => 'btn btn-danger', 'escape' => false], ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearch->id)]) ?>
								<?= $this->Html->link("<i class='bi bi-person-fill'></i> CRM", ['action' => 'locations'], ['class' => 'btn btn-default', 'escape' => false]) ?>
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
						                    echo $this->Form->control('order');
						                    echo $this->Form->control('title');
						                    echo $this->Form->control('search');
						                    echo $this->Form->control('is_public');
						                    echo $this->Form->control('user_id', ['options' => $users]);
						                    echo $this->Form->control('created');
						                ?>
						            </fieldset>
						            <?= $this->Form->button(__('Submit')) ?>
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