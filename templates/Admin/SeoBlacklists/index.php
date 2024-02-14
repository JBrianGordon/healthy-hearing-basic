<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoBlacklist[]|\Cake\Collection\CollectionInterface $seoBlacklists
 */

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Blacklists Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
                <?= $this->Html->link(' Meta Tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
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
                <h2>Seo Blacklists</h2>
                <!-- ***TODO: add search feature*** -->
                <div class="seoBlacklists index content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('is_active') ?></th>
                                    <th><?= $this->Paginator->sort('ip_range_start') ?></th>
                                    <th><?= $this->Paginator->sort('ip_range_end') ?></th>
                                    <th><?= $this->Paginator->sort('modified') ?></th>
                                    <th><?= $this->Paginator->sort('note') ?></th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seoBlacklists as $seoBlacklist): ?>
                                <tr>
                                    <td>
                                        <?= $this->Html->badge(
                                                $seoBlacklist->is_active ? '<span class="bi-check-lg"></span> Yes' : '<span class="bi-x-lg"></span> No',
                                                [
                                                    'class' => $seoBlacklist->is_active ? 'success label' : 'danger label',
                                                ]
                                            );
                                        ?>
                                    </td>
                                    <td><?= $this->Number->format($seoBlacklist->ip_range_start) ?></td>
                                    <td><?= $this->Number->format($seoBlacklist->ip_range_end) ?></td>
                                    <td><?= h($seoBlacklist->modified) ?></td>
                                    <td><?= h($seoBlacklist->note) ?></td>
                                    <td class="actions">
                                        <div class="btn-group-vertical">
                                            <?= $this->Html->link('Edit', ['action' => 'edit', $seoBlacklist->id], ['class' => 'btn btn-default btn-xs bi bi-pencil-fill']) ?>
                                            <?= $this->Form->postLink('Delete', ['action' => 'delete', $seoBlacklist->id], ['class' => 'btn btn-danger btn-xs bi bi-trash-fill', 'confirm' => __('Are you sure you want to delete # {0}?', $seoBlacklist->id)]) ?>
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