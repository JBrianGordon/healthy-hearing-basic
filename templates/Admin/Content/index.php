<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content[]|\Cake\Collection\CollectionInterface $content
 */
use Cake\Routing\Router;
use App\Model\Entity\Content;
$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = ['is_frozen', 'id_brafton', 'date', 'modified', 'alt_title', 'title_head', 'meta_description', 'bodyclass', 'facebook_title', 'facebook_image_width', 'facebook_image_height', 'facebook_image_alt', 'old_url', 'slug', 'facebook_description'];
$fields = array_diff_key($fields, array_flip($ignoreFields));
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
		case 'user_id':
			$label = 'Author';
			$type = 'select';
			$options = $authors;
			$empty = '(select one)';
			break;
        case 'type':
            $type = 'select';
            $options = Content::$typeOptions;
            $empty = '(select one)';
            break;
        case 'facebook_image':
            $type = 'boolean';
            break;
        case 'id_draft_parent':
            $label = 'Is draft';
            $type = 'boolean';
            break;
        case 'q':
            $label = 'Query';
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

$this->Html->script('dist/admin_content_index.min', ['block' => true]);
?>
<span id="count" class="d-none"><?= $count ?></span>
<span id="exportUrl" class="d-none"><?= $exportUrl ?></span>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Content Actions</div>
		<div class="panel-body p10">
			<div class="btn-group btn-group-sm">
				<?= $this->Html->link("+ Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
				<?= $this->Form->button("<i class='bi bi-download'></i> Export", ['type' => 'button', 'id' => 'exportBtn', 'class' => 'btn btn-default', 'escapeTitle' => false]) ?>
			</div>
		</div>
	</div>
</header>
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2>Reports</h2>
				<?= $this->element('pagination') ?>
				<?= $this->element('admin_filter', ['modelName' => 'content']) ?>
				<?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
				<?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-sm mb20">
						<thead>
							<tr class="align-top">
								<th>
									<?= $this->Paginator->sort('is_active', 'Active') ?>
									<?= $this->Paginator->sort('id') ?>
								</th>
								<th><?= $this->Paginator->sort('title') ?></th>
								<th><?= $this->Paginator->sort('type') ?></th>
								<th><?= $this->Paginator->sort('user_id', 'Author') ?></th>
								<th><?= $this->Paginator->sort('short') ?></th>
								<th>
									<?= $this->Paginator->sort('last_modified', 'Last Mod') ?>
									<?= $this->Paginator->sort('date', 'Pub Date') ?>
								</th>
								<th><?= $this->Paginator->sort('date') ?></th>
								<th class="actions"><?= __('Actions') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($content as $content) : ?>
							<tr>
								<td>
									<?=
										$this->Html->badge(
											$content->is_active ? '<span class="bi-check-lg"></span> Yes' : '<span class="bi-x-lg"></span> No',
											[
												'class' => $content->is_active ? 'success label' : 'danger label',
											]
										);
									?>
									<?= $this->Html->badge($content->id, ['class' => 'light label']) ?>
								</td>
			                    <td><?= $this->Editorial->adminIndexDraft($content->id_draft_parent) . h($content->title) ?></td>
								<td><?= h($content->type) ?><?= $content->is_library_item ? '<span class="bi-book-fill"></span>' : ''?></td>
								<td>
									<?php
									if ($content->primary_author !== null) {
										echo $this->Html->link(
											__($content->primary_author->username),
											'/admin/users/edit/'.$content->user_id,
											['class' => 'btn btn-default rounded pl5 pr5']
										);
									}
									?>
								</td>
								<td><?= h($content->short) ?></td>
								<td><?= h($content->last_modified) ?></td>
								<td><?= h($content->date) ?></td>
								<td class="actions">
									<div class="btn-group-vertical btn-group-sm">
										<?=
											$this->Html->link(' View',
												array_merge(['prefix' => false], $content->hh_url),
												['class' => 'btn btn-default bi-eye-fill btn-xs']
											)
										?>
										<?=
											$this->Html->link(' Edit',
												['action' => 'edit', $content->id],
												['class' => 'btn btn-default bi-pencil-fill btn-xs']
											)
										?>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="paginator">
					<ul class="pagination">
						<?= $this->Paginator->first('<< ' . __('first')) ?>
						<?= $this->Paginator->prev('< ' . __('previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(__('next') . ' >') ?>
						<?= $this->Paginator->last(__('last') . ' >>') ?>
					</ul>
					<p>
						<?=
						$this->Paginator->counter(
							__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')
						)
						?>
					</p>
				</div>
			</div>
		</div>
	</section>
</div>