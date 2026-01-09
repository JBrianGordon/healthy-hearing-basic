<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoTitle[]|\Cake\Collection\CollectionInterface $seoTitles
 */

$this->Vite->script('admin-vite','admin_common');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Status Codes Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Meta Tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Redirects', ['controller' => 'seoRedirects', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Status Codes', ['controller' => 'seoStatusCodes', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Uris', ['controller' => 'seoUris', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Seo Titles</h2>
                <div class="seoTitles index content">
                    <?= $this->element('pagination') ?>
                    <?= $this->element('admin_filter', ['modelName' => 'seoTitle']) ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('seo_uri_uri', ['label' => 'Seo Uri']) ?></th>
                                    <th><?= $this->Paginator->sort('title') ?></th>
                                    <th><?= $this->Paginator->sort('modified') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seoTitles as $seoTitle): ?>
                                <tr>
                                    <td><?= $seoTitle->has('seo_uri') ? $this->Html->link($seoTitle->seo_uri->uri, ['controller' => 'SeoUris', 'action' => 'view', $seoTitle->seo_uri->id]) : '' ?></td>
                                    <td><?= h($seoTitle->title) ?></td>
                                    <td><?= h($seoTitle->modified->format('M jS Y, H:i')) ?></td>
                                    <td class="actions">
                                        <div class="btn-group-vertical">
                                            <?= $this->Html->link('Edit', ['action' => 'edit', $seoTitle->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
                                            <?= $this->Form->postLink('Delete', ['action' => 'delete', $seoTitle->id], ['class' => 'btn btn-danger btn-xs bi bi-trash-fill', 'confirm' => __('Are you sure you want to delete # {0}?', $seoTitle->id)]) ?>
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