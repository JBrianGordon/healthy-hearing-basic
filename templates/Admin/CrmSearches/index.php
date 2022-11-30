<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CrmSearch[]|\Cake\Collection\CollectionInterface $allCrmSearches
 */
$queryParams = $this->request->getQueryParams();
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = [];
$additionalBlacklist = [];
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
        if (in_array($type, ['date', 'datetime'])) {
            $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
            $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
        }
        switch ($field) {
            case 'user_id':
                $label = 'User';
                $type = 'select';
                $options = $users;
                $empty = '(select one)';
                break;
        }
        $advancedSearchFields[] = [
            'field' => $field,
            'type' => $type,
            'label' => $label,
            'options' => $options,
            'empty' => $empty,
            'value' => $value
        ];
    }
}

$this->Html->script('dist/admin_common.min', ['block' => true]);
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
						<div class="panel-heading">Crm Searches Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link("<i class='bi bi-search'></i> Browse", ['action' => '#'], ['class' => 'btn btn-default', 'escape' => false]) ?>
								<?= $this->Html->link("<i class='bi bi-plus-lg'></i> Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
								<?= $this->Html->link("<i class='bi bi-person-fill'></i> CRM", ['action' => 'locations'], ['class' => 'btn btn-default', 'escape' => false]) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<?php
								//$this->Admin->add(
									//$this->Html->link('<span class="glyphicon glyphicon-user"></span> CRM', array('admin' => true, 'controller' => 'locations', 'action' => 'index'), array('escape' => false, 'class' => 'sprint-find btn btn-default'))
								//);
								?>
								<h2><?= __('Crm Searches') ?></h2>
								<div class="locations index">
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields, 'additionalBlacklist' => $additionalBlacklist]) ?>
								    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-condensed" cellpadding="0" cellspacing="0">
											<thead>
												<tr>
									                <th class="actions"><?= __('Actions') ?></th>
												</tr>
											</thead>
											<tbody>
								                <?php foreach ($allCrmSearches as $crmSearch) : ?>
									                <tr>
									                    <td><span class="badge bg-info"><?= $crmSearch->id ?></span><br><?= $crmSearch->order ?></td>
									                    <td><?= $this->Admin->yesNo($crmSearch->is_public) ?></td>
									                    <td><?= h($crmSearch->model) ?></td>
									                    <td style="word-wrap: break-word; max-width: 350px;"><?= h($crmSearch->title) ?><br><small><?= h($crmSearch->search) ?></small></td>
									                    <td>
									                        <?=
									                            $crmSearch->has('user') ?
									                            $this->Html->link($crmSearch->user->username, [
									                                'controller' => 'Users',
									                                'action' => 'view',
									                                $crmSearch->user->id,
									                            ]) : ''
									                        ?>     
									                    </td>
									                    <td nowrap><?= date('M jS Y, H:i', strtotime($crmSearch->created)) ?><br><?= date('M jS Y, H:i', strtotime($crmSearch->modified))  ?></td>
									                    <td class="actions">
									                        <div class="btn-group-vertical btn-group">
									                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $crmSearch->id], ['class' => 'btn btn-xs btn-default']) ?>
									                            <?=
									                                $this->Form->postLink(
									                                    __('Delete'),
									                                    ['action' => 'delete', $crmSearch->id],
									                                    ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearch->id), 'class' => 'btn btn-xs btn-danger']
									                                )
									                            ?>
									                        </div>
									                    </td>
									                </tr>
								                <?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<?= $this->element('pagination') ?>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>