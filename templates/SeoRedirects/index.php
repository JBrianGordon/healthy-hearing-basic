<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoRedirect[]|\Cake\Collection\CollectionInterface $seoRedirects
 */
?>
<div class="seoRedirects index content">
    <?= $this->Html->link(__('New Seo Redirect'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Seo Redirects') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('seo_uri_id') ?></th>
                    <th><?= $this->Paginator->sort('redirect') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('callback') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_nocache') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seoRedirects as $seoRedirect): ?>
                <tr>
                    <td><?= $this->Number->format($seoRedirect->id) ?></td>
                    <td><?= $seoRedirect->has('seo_uri') ? $this->Html->link($seoRedirect->seo_uri->id, ['controller' => 'SeoUris', 'action' => 'view', $seoRedirect->seo_uri->id]) : '' ?></td>
                    <td><?= h($seoRedirect->redirect) ?></td>
                    <td><?= $this->Number->format($seoRedirect->priority) ?></td>
                    <td><?= h($seoRedirect->is_active) ?></td>
                    <td><?= h($seoRedirect->callback) ?></td>
                    <td><?= h($seoRedirect->created) ?></td>
                    <td><?= h($seoRedirect->modified) ?></td>
                    <td><?= h($seoRedirect->is_nocache) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $seoRedirect->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seoRedirect->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seoRedirect->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoRedirect->id)]) ?>
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
