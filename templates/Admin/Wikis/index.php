<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki[]|\Cake\Collection\CollectionInterface $wikis
 */

 use Cake\Routing\Router;
 use App\Model\Entity\Wiki;

$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);
// Advanced search details
$advancedSearchFields = [];
foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
    $placeholder = null;
    if (in_array($type, ['date', 'datetime'])) {
        $value['start'] = isset($queryParams[$field.'_start']) ? $queryParams[$field.'_start'] : null;
        $value['end'] = isset($queryParams[$field.'_end']) ? $queryParams[$field.'_end'] : null;
    }
    switch ($field) {
        case 'facebook_image':
            $type = 'boolean';
            break;
		case 'priority':
			$label = 'Order';
			break;
		case 'user_id':
			$label = 'Author';
			$type = 'select';
			$options = $authors;
			$empty = '(select one)';
			break;
    }
    $advancedSearchFields[] = [
        'field' => $field,
        'type' => $type,
        'label' => $label,
        'options' => $options,
        'empty' => $empty,
        'value' => $value,
        'placeholder' => $placeholder
    ];
}
 
$this->Vite->script('admin_common','admin-vite');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Help Pages Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(__(' Browse'), ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
				<?= $this->Html->link(__(' Add'), ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<div class="wikis index">
					<h2>Help Pages</h2>
				    <?= $this->element('pagination') ?>
					<?= $this->element('admin_filter', ['modelName' => 'helpPages']) ?>
				    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
					<div class="wikis index content">
					    <div class="table-responsive">
					        <table class="table table-striped table-bordered table-condensed mt20">
					            <thead>
					                <tr>
						                <th><?= $this->Paginator->sort('is_active', ['label' => 'Active']) ?></th>
					                    <th><?= $this->Paginator->sort('name') ?></th>
					                    <th><?= $this->Paginator->sort('slug') ?></th>
					                    <th><?= $this->Paginator->sort('short') ?></th>
					                    <th width="120"><?= $this->Paginator->sort('last_modified', ['label' => 'Last Mod']) ?><br><?= $this->Paginator->sort('modified', ['label' => 'Last Saved']) ?></th>
					                    <th class="actions">Actions</th>
					                </tr>
					            </thead>
					            <tbody>
					                <?php foreach ($wikis as $wiki): ?>
					                <tr>
						                <td><?= $wiki->is_active ? '<span class="badge bg-success bi bi-check-lg"> Yes</span>' : '<span class="badge bg-danger bi bi-x-lg"> No</span>' ?></td>
					                    <td><?= $this->Editorial->adminIndexDraft($wiki->id_draft_parent) . h($wiki->name) ?></td>
					                    <td><?= h($wiki->slug) ?></td>
					                    <td><?= h($wiki->short) ?></td>
					                    <td><?= date_format($wiki->last_modified, 'M j, o') ?><br><?= date_format($wiki->modified, 'M j, o') ?></td>
					                    <td class="actions">
						                    <div class="btn-group btn-group-vertical">
											<?php if ($wiki->id_draft_parent === 0 && $wiki->is_active === true): ?>
												<?=
													$this->Html->link(' View',
														$wiki->hh_url,
														[
															'class' => 'btn btn-default bi-eye-fill btn-xs',
															'target' => '_blank',
														]
													)
												?>
											<?php else: ?>
												<?=
													$this->Html->link(' Preview', [
															'action' => 'preview',
															$wiki->id
														], [
															'class' => 'btn btn-default bi-eye-fill btn-xs',
															'target'=>'_blank'
														]
													)
												?>
											<?php endif; ?>
												<?= $this->Html->link(__(' Edit'), ['action' => 'edit', $wiki->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
												<?= $this->Form->postLink(__(' Delete'), ['action' => 'delete', $wiki->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wiki->id), 'class' => 'btn btn-xs btn-danger mt0 bi bi-trash']) ?>
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
		</div>
	</section>
</div>