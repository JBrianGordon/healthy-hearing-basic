<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */

$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
// Only include these fields in advanced search
$includeFields = ['id', 'username', 'first_name', 'last_name', 'email', 'company', 'active', 'role', 'created', 'modified', 'is_admin', 'is_it_admin', 'is_agent', 'is_call_supervisor', 'is_author', 'is_csa', 'is_writer', 'is_superuser'];
foreach ($fields as $field => $type) {
    if (!in_array($field, $includeFields)) {
        unset($fields[$field]);
    }
}
//pr($this->Search);
//pr($this->Search->isSearch());
//pr($this->request);
?>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <?= $this->element('pagination') ?>
    <div class="row justify-content-end">
        <?php if ($this->Search->isSearch()) : ?>
            <div class="col col-md-auto">
                <?= $this->Search->resetLink(__('Reset'), ['class' => 'btn btn-info text-light', 'role' => 'button']) ?>
            </div>
        <?php endif; ?>
        <div class="col col-md-auto">
            <button class="btn btn-primary mb-3" type="button"
                data-bs-toggle="collapse" data-bs-target="#advancedSearch"
                aria-expanded="false" aria-controls="advancedSearch"
            >
                + Advanced
            </button>
        </div>
    </div>
    <div class="collapse" id="advancedSearch">
        <?php
        echo $this->Form->create(null, [
            'class' => 'bg-light mb-3 p-5',
            'valueSources' => 'query',
        ]);
        ?>
        <?php $column = 1; ?>
        <?php foreach ($fields as $field => $type): ?>
            <?php if ($column == 1): ?>
                <div class="row" style="min-height: 74px;">
                    <div class="col-md-6">
                        <?php echo $this->Admin->formInput($field, $type); ?>
                        <?php $column = 2; ?>
                    </div> <!-- end col -->
            <?php else: // column 2 ?>
                    <div class="col-md-6">
                        <?php echo $this->Admin->formInput($field, $type); ?>
                        <?php $column = 1; ?>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($column==2): ?>
            </div> <!-- end row -->
        <?php endif; ?>
        <?php
        echo $this->Form->button('Filter', [
            'type' => 'submit',
            'class' => 'me-3',
        ]);
        echo $this->Form->end();
        ?>
    </div>
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
                            '<span class="badge bg-secondary">'.$user->username.'</span><br>'.
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
                                    ['class' => 'btn btn-outline-secondary']) ?>
                                <?= $this->Form->postLink(__('Delete'),
                                    ['action' => 'delete', $user->id],
                                    ['class' => 'btn btn-outline-secondary', 'confirm' => __('Are you sure you want to delete {0}?', $user->username)]) ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
