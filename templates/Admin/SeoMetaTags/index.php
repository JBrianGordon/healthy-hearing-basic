<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoMetaTag[]|\Cake\Collection\CollectionInterface $seoMetaTags
 */

$this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Meta Tags Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
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
                <h2>Seo Meta Tags</h2>
                <div class="seoMetaTags index content">
                    <?= $this->element('pagination') ?>
					<?= $this->element('admin_filter', ['modelName' => 'seoMetaTag']) ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('seo_uri_id') ?></th>
                                    <th><?= $this->Paginator->sort('name') ?></th>
                                    <th><?= $this->Paginator->sort('content') ?></th>
                                    <th><?= $this->Paginator->sort('is_http_equiv') ?></th>
                                    <th><?= $this->Paginator->sort('modified') ?></th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seoMetaTags as $seoMetaTag): ?>
                                <tr>
                                    <td><?= $seoMetaTag->has('seo_uri') ? $this->Html->link($seoMetaTag->seo_uri->uri, ['controller' => 'SeoUris', 'action' => 'view', $seoMetaTag->seo_uri->uri]) : '' ?></td>
                                    <td><?= $seoMetaTag->name ?></td>
                                    <td><?= $seoMetaTag->content ?></td>
                                    <td><?= $seoMetaTag->is_http_equiv ?></td>
                                    <td><?= h($seoMetaTag->modified->format('M jS Y, H:i')) ?></td>
                                    <td class="actions">
                                        <div class="btn-group-vertical">
                                            <?= $this->Html->link('Edit', ['action' => 'edit', $seoMetaTag->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoMetaTag->id], ['class' => 'btn btn-danger btn-xs bi bi-trash-fill', 'confirm' => __('Are you sure you want to delete # {0}?', $seoMetaTag->id)]) ?>
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