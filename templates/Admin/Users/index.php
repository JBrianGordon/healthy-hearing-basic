<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
use Cake\Core\Configure;
use App\Model\Entity\User;

$queryParams = $this->request->getQueryParams();
// Only include these fields in advanced search
$includeFields = ['id', 'username', 'first_name', 'last_name', 'email', 'recovery_email', 'active', 'role', 'created', 'modified', 'last_login', 'is_admin', 'is_it_admin', 'is_agent', 'is_call_supervisor', 'is_author', 'is_reviewer', 'is_csa', 'is_writer', 'is_superuser', 'Locations.id'];
// Advanced search details
$advancedSearchFields = [];
// Add additional fields
$fields['Locations.id'] = 'biginteger';
foreach ($fields as $field => $type) {
    if (in_array($field, $includeFields)) {
        $label = '';
        $options = false;
        $empty = false;
        $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
        if (in_array($type, ['date', 'datetime'])) {
            $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
            $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
        }
        switch ($field) {
            case 'role':
                $type = 'select';
                $options = User::$roles;
                $empty = '(All roles)';
                break;
            case 'Locations.id':
                $label = 'Location ID';
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
						<div class="panel-heading">Users Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi-search']) ?>
								<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi-plus-lg']) ?>
								<?= $this->Html->link('Clinic Users', ['action' => 'index', '?' => ['role'=>'clinic']], ['class' => 'btn btn-default']) ?>
								<?= $this->Html->link('Admin Users', ['action' => 'index', '?' => ['role'=>'admin']], ['class' => 'btn btn-default']) ?>
								<?= $this->Html->link('Other Users', ['action' => 'index', '?' => ['role'=>'user']], ['class' => 'btn btn-default']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<div class="users index content">
								    <h3>Users</h3>
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
								    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
								    <div class="table-responsive">
								        <table class="table table-striped table-bordered table-sm mb20">
								            <thead>
								                <tr>
								                    <th><?= $this->Paginator->sort('id') ?></th>
								                    <th>
														<?= $this->Paginator->sort('username') ?><br>
														<?= $this->Paginator->sort('first_name') ?> / <?= $this->Paginator->sort('last_name') ?><br>
														<?= $this->Paginator->sort('email') ?>
								                    </th>
								                    <th>
														<?= $this->Paginator->sort('role') ?><br>
														Clinic
								                    </th>
								                    <th><?= $this->Paginator->sort('active') ?></th>
								                    <th>
														<?= $this->Paginator->sort('created') ?><br>
														<?= $this->Paginator->sort('modified') ?><br>
														<?= $this->Paginator->sort('last_login') ?>
								                    </th>
								                    <th class="actions"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($users as $user): ?>
								                    <tr>
								                        <td><?= h($user->id) ?></td>
								                        <td>
															<span class="badge bg-default"><?= $user->username ?></span><br>
															<strong><?= $user->first_name.' '.$user->last_name ?></strong><br>
															<?= $user->email ?>
								                        </td>
								                        <td>
															<?= $this->Html->badge($user->role, ['class'=>'bg-default']) ?><br>
															<?php if (!empty($user->locations)): ?>
																<?=
																	$this->Html->link(
																		$user->locations[0]->title,
																		['controller' => 'Locations', 'action' => 'edit', $user->locations[0]->id]
																	)
																?><br>
																<?= $user->locations[0]->city.', '.$user->locations[0]->state ?>
															<?php endif; ?>
														</td>
														<td>
															<?= $this->Html->badge(
																$user->active ? '<i class="bi bi-check-lg"></i> Active' : '<i class="bi bi-x-lg"></i> Inactive',
																['class' => $user->active ? 'success' : 'danger']
															); ?>
														</td>
														<td nowrap>
															<?= empty($user->created) ? '' : date('Y-m-d', strtotime($user->created)) ?><br>
															<?= empty($user->modified) ? '' : date('Y-m-d', strtotime($user->modified)) ?><br>
															<?= empty($user->last_login) ? '' : date('Y-m-d', strtotime($user->last_login)) ?>
														</td>
								                        <td class="actions">
							                                <?= $this->Html->link(__(' Edit'),
							                                    ['action' => 'edit', $user->id],
							                                    ['class' => 'btn btn-default btn-xs bi-pencil-fill']) 
							                                ?>
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