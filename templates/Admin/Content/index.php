<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content[]|\Cake\Collection\CollectionInterface $content
 */
use Cake\Routing\Router;
use App\Model\Entity\Content;
/* TODO - do I need this?
$this->loadHelper('Search.Search', [
    'additionalBlacklist' => [
        'created_start_date',
        'created_end_date',
        'last_mod_start_date',
        'last_mod_end_date',
        'saved_search',
    ],
]);*/
$queryParams = $this->request->getQueryParams();
$exportUrl = Router::url(['action' => 'export', '?' => $queryParams]);
// Advanced search details
$advancedSearchFields = [];
$ignoreFields = ['is_frozen', 'id_brafton', 'date', 'modified', 'alt_title', 'title_head', 'meta_description', 'bodyclass', 'facebook_title', 'facebook_image_width', 'facebook_image_height', 'facebook_image_alt', 'old_url', 'slug', 'facebook_description'];
$fields = array_diff_key($fields, array_flip($ignoreFields));
// Add additional fields
$fields['q'] = 'string';
foreach ($fields as $field => $type) {
    $label = '';
    $options = false;
    $empty = false;
    $value = isset($queryParams[$field]) ? $queryParams[$field] : null;
    switch ($field) {
        case 'user_id':
            $label = 'Primary Author';
            $type = 'select';
            $options = $users;
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
        'value' => $value
    ];
}
?>

<div class="content index">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->Html->link("+ Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
        <?= $this->Form->button("<i class='bi bi-download'></i> Export", ['type' => 'button', 'id' => 'exportBtn', 'class' => 'btn btn-default', 'escapeTitle' => false]) ?>
        <?= $this->Html->link("<i class='bi bi-arrow-repeat'></i> Sync photos", ['action' => 'rsync'], ['class' => 'btn btn-success', 'escape' => false]) ?>
    </div>
    <h3><?= __('Reports') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('advanced_search', ['fields' => $advancedSearchFields]) ?>
    <?= $this->element('crm_search', ['crmSearches' => $crmSearches]) ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
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
                        <?= $this->Number->format($content->id) ?>
                        <?=
                            $this->Html->badge(
                                $content->is_active ? 'Yes' : 'No',
                                [
                                    'class' => $content->is_active ? 'success' : 'danger',
                                ]
                            );
                        ?>
                    </td>
                    <td><?= h($content->title) ?></td>
                    <td><?= h($content->type) ?></td>
                    <td>
                        <?php
                        if ($content->primary_author !== null) {
                            echo h($content->primary_author->username);
                        }
                        ?>
                    </td>
                    <td><?= h($content->short) ?></td>
                    <td><?= h($content->last_modified) ?></td>
                    <td><?= h($content->date) ?></td>
                    <td class="actions">
                        <div class="btn-group-vertical btn-group-sm">
                            <?=
                                $this->Html->link(
                                    __('View'),
                                    array_merge(['prefix' => false], $content->hh_url),
                                    ['class' => 'btn btn-default']
                                )
                            ?>
                            <?=
                                $this->Html->link(
                                    __('Edit'),
                                    ['action' => 'edit', $content->id],
                                    ['class' => 'btn btn-default']
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
<?php
// TODO: This should be moved into a js file and simplified with jQuery once we have that working.
echo '<script type="text/javascript">
    function exportBtnClick() {
        var count = '.$count.';
        var readableCount = "'.number_format($count).'";
        var exportUrl = "'.$exportUrl.'";
        if (count < 100000) {
            // Small file. Download immediately.
            if (confirm("Downloading export file with "+readableCount+" entries. This may take up to 30 seconds. Stay on this page until download is complete.")) {
                window.location.replace(exportUrl);
            }
        } else {
            // Large file
            // TODO - Large files take over 30 seconds and page times out. Send to queue when queue is working.
            alert("Export is too large. Please narrow your results to 100,000 or less.");
        }
    }
    document.getElementById("exportBtn").addEventListener("click", exportBtnClick);
</script>';
?>
