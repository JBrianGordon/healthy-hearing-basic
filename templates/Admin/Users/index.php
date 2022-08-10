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
?>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __(Configure::read('siteNameAbbr').' Users') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?> <?= $this->Paginator->sort('last_name') ?><br>
                        <?= $this->Paginator->sort('username') ?> <?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('company') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('created') ?><br><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= h($user->id) ?></td>
                        <td><?php echo '<strong>'.$user->first_name.' '.$user->last_name.'</strong><br>'.
                            '<span class="badge bg-info">'.$user->username.'</span><br>'.
                            $user->email; ?></td>
                        <td><?= h($user->company) ?></td>
                        <td><?= $this->Html->badge(
                                $user->active ? '<i class="bi bi-check-lg"></i> Active' : '<i class="bi bi-x-lg"></i> Inactive',
                                [
                                    'class' => $user->active ? 'success' : 'danger',
                                ]
                            ); ?>
                        </td>
                        <td><?= h($user->role) ?></td>
                        <td><?php echo date('m/d/Y', strtotime($user->created)).'<br>'.date('m/d/Y', strtotime($user->modified)); ?></td>
                        <td class="actions">
                            <div class="btn-group-vertical btn-group-sm">
                                <?= $this->Html->link(__('Edit'),
                                    ['action' => 'edit', $user->id],
                                    ['class' => 'btn btn-default']) ?>
                                <?= $this->Form->postLink(__('Delete'),
                                    ['action' => 'delete', $user->id],
                                    ['class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete {0}?', $user->username)]) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
