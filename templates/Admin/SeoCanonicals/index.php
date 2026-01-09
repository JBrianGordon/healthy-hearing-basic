<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoCanonical[]|\Cake\Collection\CollectionInterface $seoCanonicals
 */

 $this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Canonicals Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Meta tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Redirects', ['controller' => 'seoRedirects', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Status codes', ['controller' => 'seoStatusCodes', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Titles', ['controller' => 'seoTitles', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Uris', ['controller' => 'seoUris', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Seo Canonicals</h2>
                <div class="seoCanonicals index content">
                    <?= $this->element('pagination') ?>
                    <?= $this->element('admin_filter', ['modelName' => 'seoCanonicals']) ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th class="p5"><?= $this->Paginator->sort('is_active') ?></th>
                                    <th class="p5"><?= $this->Paginator->sort('seo_uri_id') ?></th>
                                    <th class="p5"><?= $this->Paginator->sort('canonical') ?></th>
                                    <th class="p5"><?= $this->Paginator->sort('modified') ?></th>
                                    <th class="actions p5"><?= 'Actions' ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seoCanonicals as $seoCanonical): ?>
                                <tr>
                                    <td class="p5">
                                        <?= $this->Html->badge(
                                            $seoCanonical->is_active ? '<span class="bi-check-lg"></span> Yes' : '<span class="bi-x-lg"></span> No',
                                            [
                                                'class' => $seoCanonical->is_active ? 'success label' : 'danger label',
                                            ]
                                        );?>
                                    </td>
                                    <td class="p5"><?= $seoCanonical->has('seo_uri') ? $this->Html->link($seoCanonical->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoCanonical->seo_uri->id]) : '' ?></td>
                                    <td class="p5"><?= $seoCanonical->canonical ?></td>
                                    <td class="p5"><?= h($seoCanonical->modified->format('M jS Y, H:i')) ?></td>
                                    <td class="actions p5">
                                        <div class="btn-group-vertical btn-group-sm">
                                            <?= $this->Html->link(' Edit', ['action' => 'edit', $seoCanonical->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
                                            <?= $this->Form->postLink(' Delete', ['action' => 'delete', $seoCanonical->id], ['class' => 'btn btn-danger btn-xs bi bi-trash-fill'], ['confirm' => 'Are you sure you want to delete # {0}?', $seoCanonical->id]) ?>
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
                        <p><?= $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
