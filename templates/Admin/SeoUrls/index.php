<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SeoUrl> $seoUrls
 */

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

$this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Urls Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Seo Urls</h2>
                <?= $this->element('pagination') ?>
                <?= $this->element('admin_filter', ['modelName' => 'seoUrl']) ?>
                <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
                <div class="seoUrls index content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('url', 'URL') ?></th>
                                    <th><?= $this->Paginator->sort('redirect_is_active', 'Active redirect') ?></th>
                                    <th><?= $this->Paginator->sort('is_410', '410') ?></th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seoUrls as $seoUrl): ?>
                                <tr>
                                    <td><?= h($seoUrl->url) ?></td>
                                    <td><?=
                                            $this->Html->badge(
                                                $seoUrl->redirect_is_active ? '<span class="bi-check-lg"></span> Yes' : '<span class="bi-x-lg"></span> No',
                                                [
                                                    'class' => $seoUrl->redirect_is_active ? 'success label' : 'danger label',
                                                ]
                                            );
                                        ?>
                                    </td>
                                    <td><?=
                                            $this->Html->badge(
                                                $seoUrl->is_410 ? '<span class="bi-check-lg"></span> Yes' : '<span class="bi-x-lg"></span> No',
                                                [
                                                    'class' => $seoUrl->is_410 ? 'success label' : 'danger label',
                                                ]
                                            );
                                        ?>
                                    </td>
                                    <td class="actions">
                                        <div class="btn-group-vertical btn-group-sm">
                                            <?=
                                                $this->Html->link(' Edit',
                                                    ['action' => 'edit', $seoUrl->id],
                                                    ['class' => 'btn btn-default bi-pencil-fill btn-xs']
                                                )
                                            ?>
                                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoUrl->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoUrl->id), 'class' => 'btn btn-xs btn-danger mt0 bi bi-trash']) ?>
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
                        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
