<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUser[]|\Cake\Collection\CollectionInterface $locationUsers
 */
use Cake\Core\Configure;
use App\Model\Entity\User;
$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'saved_search',
    ],
]);
$queryParams = $this->request->getQueryParams();
// Fields to ignore
$ignoreFields = [];
// Advanced search details
$advancedSearchFields = [];
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
						<div class="panel-heading">Clinic Users Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(" Browse", ['action' => 'index'], ['class' => 'btn btn-default bi bi-search', 'escape' => false]) ?>
								<?= $this->Html->link(" Add", ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg', 'escape' => false]) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">
								<h2><?= __('Clinic Users') ?></h2>
								<div class="users index content">
								    <?= $this->element('pagination') ?>
								    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
								    <div class="table-responsive">
								        <table class="table table-striped table-bordered table-sm">
								            <thead>
								                <tr>
								                    <th><?= $this->Paginator->sort('id') ?></th>
								                    <th>
								                        <?= $this->Paginator->sort('username') ?><br>
								                        <?= $this->Paginator->sort('first_name', 'First') ?> / <?= $this->Paginator->sort('last_name', 'Last') ?><br>
								                        <?= $this->Paginator->sort('email') ?>
								                    </th>
								                    <th><?= $this->Paginator->sort('location_id', 'Clinic') ?></th>
								                    <th><?= $this->Paginator->sort('is_active', 'Active') ?></th>
								                    <th>
								                        <?= $this->Paginator->sort('created') ?><br>
								                        <?= $this->Paginator->sort('modified') ?><br>
								                        <?= $this->Paginator->sort('lastlogin', __('Last Login')) ?>
								                    </th>
								                    <th class="actions"><?= __('Actions') ?></th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($locationUsers as $locationUser): ?>
								                <tr>
								                    <td><?= $locationUser->id ?></td>
								                    <td>
								                        <span class="label label-default"><?= h($locationUser->username) ?></span><br>
								                        <strong><?= h($locationUser->first_name) ?> <?= h($locationUser->last_name) ?></strong><br>
								                        <?= h($locationUser->email) ?>
								                    </td>
								                    <td>
								                        <?php
								                        if (!empty($locationUser->location->id)) {
								                            if (!empty($locationUser->location->title)) {
								                                echo $this->Html->link($locationUser->location->title, ['controller' => 'locations', 'action' => 'edit', $locationUser->location->id]);
								                                echo '<br>'.$locationUser->location->city.', '.$locationUser->location->state;
								                            } else {
								                                echo '<span class="red">Location id '.$locationUser->location->id.' no longer exists.</span>';
								                            }
								                        }
								                        ?>
								                    </td>
								                    <td><?php echo $this->Admin->yesNo($locationUser->is_active); ?></td>
								                    <td>
								                        <?php
								                            if (!empty($locationUser->created)) {
								                                echo date('Y-m-d', strtotime($locationUser->created));
								                            }
								                            echo '<br>';
								                            if (!empty($locationUser->modified)) {
								                                echo date('Y-m-d', strtotime($locationUser->modified));
								                            }
								                            echo '<br>';
								                            if (!empty($locationUser->lastlogin)) {
								                                echo date('Y-m-d', strtotime($locationUser->lastlogin));
								                            } else {
								                                echo '[Never logged in]';
								                            }
								                        ?>
								                    </td>
								                    <td class="actions">
							                            <?= $this->Html->link(__(' Edit'),
							                                ['action' => 'edit', $locationUser->id],
							                                ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) 
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
