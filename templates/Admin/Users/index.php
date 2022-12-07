<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
use Cake\Core\Configure;
use App\Model\Entity\User;
$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
$queryParams = $this->request->getQueryParams();
// Only include these fields in advanced search
$includeFields = ['id', 'username', 'first_name', 'last_name', 'email', 'company', 'active', 'role', 'created', 'modified', 'is_admin', 'is_it_admin', 'is_agent', 'is_call_supervisor', 'is_author', 'is_csa', 'is_writer', 'is_superuser'];
// Advanced search details
$advancedSearchFields = [];
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
							<div class="btn-group"><a href="/admin/users" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Browse</a><a href="/admin/users/edit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add</a></div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<div class="users index content">
								    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
								    <h3><?= __(Configure::read('siteNameAbbr').' Users') ?></h3>
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
								    <div class="table-responsive">
								        <table class="table table-striped table-bordered table-sm mb20">
								            <thead>
								                <tr>
								                    <th><?= $this->Paginator->sort('id') ?></th>
								                    <th><?= $this->Paginator->sort('first_name') ?> / <?= $this->Paginator->sort('last_name') ?> / 
								                        <?= $this->Paginator->sort('username') ?> / <?= $this->Paginator->sort('email') ?></th>
								                    <th><?= $this->Paginator->sort('company') ?></th>
								                    <th><?= $this->Paginator->sort('active') ?></th>
								                    <th><?= $this->Paginator->sort('role') ?></th>
								                    <th><?= $this->Paginator->sort('created') ?> / <?= $this->Paginator->sort('modified') ?></th>
								                    <th class="actions"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($users as $user): ?>
								                    <tr>
								                        <td><?= h($user->id) ?></td>
								                        <td><?php echo '<strong>'.$user->first_name.' '.$user->last_name.'</strong><br>'.
								                            '<span class="badge bg-default">'.$user->username.'</span><br>'.
								                            $user->email; ?></td>
								                        <td><?= h($user->company) ?></td>
								                        <td><?= $this->Html->badge(
								                                $user->active ? '<i class="bi bi-check-lg"></i> Active' : '<i class="bi bi-x-lg"></i> Inactive',
								                                [
								                                    'class' => $user->active ? 'success' : 'danger',
								                                ]
								                            ); ?>
								                        </td>
								                        <td><?= $this->Html->badge($user->role, ['class'=>'bg-default']) ?></td>
								                        <td><?php echo date('M jS Y, H:i', strtotime($user->created)).'<br>'.date('M jS Y, H:i', strtotime($user->modified)); ?></td>
								                        <td class="actions">
								                            <div class="btn-group-vertical btn-group-sm">
								                                <?= $this->Html->link(__('Edit'),
								                                    ['action' => 'edit', $user->id],
								                                    ['class' => 'btn btn-default rounded bi-pencil-fill']) ?>
								                                <?= $this->Form->postLink(__('Delete'),
								                                    ['action' => 'delete', $user->id],
								                                    ['class' => 'btn btn-default rounded bi-trash-fill', 'confirm' => __('Are you sure you want to delete {0}?', $user->username)]) ?>
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