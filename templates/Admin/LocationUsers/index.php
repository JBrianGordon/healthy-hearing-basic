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
// Fields to ignore
$ignoreFields = [];
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    if (!in_array($field, $ignoreFields)) {
        $label = '';
        $options = false;
        $empty = false;
        switch ($field) {
        }
        $advancedSearchFields[] = [
            'field' => $field,
            'type' => $type,
            'label' => $label,
            'options' => $options,
            'empty' => $empty
        ];
    }
}
?>
<div class="locationUsers index content">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->Html->link("<i class='bi bi-plus-lg'></i> Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
    </div>
    <h3><?= __('Clinic Users') ?></h3>
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
                        <?= $this->Paginator->sort('lastlogin') ?>
                    </th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locationUsers as $locationUser): ?>
                <tr>
                    <td><?= $locationUser->id ?></td>
                    <td>
                        <?= h($locationUser->username) ?><br>
                        <?= h($locationUser->first_name) ?> <?= h($locationUser->last_name) ?><br>
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
                        <div class="btn-group-vertical btn-group-sm">
                            <?= $this->Html->link(__('Edit'),
                                ['action' => 'edit', $locationUser->id],
                                ['class' => 'btn btn-default']) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
