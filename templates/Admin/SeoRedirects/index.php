<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoRedirect[]|\Cake\Collection\CollectionInterface $seoRedirects
 */

$this->Vite->script('admin_common','admin');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Redirects Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Meta Tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
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
                <h2>Seo Redirects</h2>
                <?= $this->element('pagination') ?>
				<?= $this->element('admin_filter', ['modelName' => 'seoRedirects']) ?>
                <div class="seoRedirects index content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('is_active') ?></th>
                                    <th><?= $this->Paginator->sort('seo_uri_id') ?></th>
                                    <th><?= $this->Paginator->sort('redirect') ?></th>
                                    <th><?= $this->Paginator->sort('priority') ?></th>
                                    <th><?= $this->Paginator->sort('callback') ?></th>
                                    <th style="min-width:110px"><?= $this->Paginator->sort('created') ?><br><?= $this->Paginator->sort('modified') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seoRedirects as $seoRedirect): ?>
                                <tr>
                                    <td><?=
                                            $this->Html->badge(
                                                $seoRedirect->is_active ? '<span class="bi-check-lg"></span> Yes' : '<span class="bi-x-lg"></span> No',
                                                [
                                                    'class' => $seoRedirect->is_active ? 'success label' : 'danger label',
                                                ]
                                            );
                                        ?>
                                    </td>
                                    <td><?= $seoRedirect->has('seo_uri') ? $this->Html->link($seoRedirect->seo_uri->uri, ['controller' => 'SeoUris', 'action' => 'view', $seoRedirect->seo_uri->uri]) : '' ?></td>
                                    <td><?= h($seoRedirect->redirect) ?></td>
                                    <td><?= $this->Number->format($seoRedirect->priority) ?></td>
                                    <td><?= h($seoRedirect->callback) ?></td>
                                    <td><?= h($seoRedirect->created->format('M jS Y')) ?><br><?= h($seoRedirect->modified->format('M jS Y')) ?></td>
                                    <td class="actions">
                                        <div class="btn-group-vertical">
                                            <?= $this->Html->link(' Edit', ['action' => 'edit', $seoRedirect->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
                                            <?= $this->Form->postLink('Delete', ['action' => 'delete', $seoRedirect->id], ['class' => 'btn btn-danger btn-xs bi bi-trash-fill', 'confirm' => __('Are you sure you want to delete # {0}?', $seoRedirect->id)]) ?>
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