<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki[]|\Cake\Collection\CollectionInterface $wikis
 */
?>
<div class="wikis index content">
    <?= $this->Html->link(__('New Wiki'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Wikis') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('id_draft_parent') ?></th>
                    <th><?= $this->Paginator->sort('order') ?></th>
                    <th><?= $this->Paginator->sort('title_head') ?></th>
                    <th><?= $this->Paginator->sort('title_h1') ?></th>
                    <th><?= $this->Paginator->sort('background_file') ?></th>
                    <th><?= $this->Paginator->sort('meta_description') ?></th>
                    <th><?= $this->Paginator->sort('facebook_title') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_bypass') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_width') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_height') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_alt') ?></th>
                    <th><?= $this->Paginator->sort('facebook_description') ?></th>
                    <th><?= $this->Paginator->sort('last_modified') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('background_alt') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wikis as $wiki): ?>
                <tr>
                    <td><?= $this->Number->format($wiki->id) ?></td>
                    <td><?= h($wiki->name) ?></td>
                    <td><?= h($wiki->slug) ?></td>
                    <td><?= $this->Number->format($wiki->user_id) ?></td>
                    <td><?= h($wiki->is_active) ?></td>
                    <td><?= $this->Number->format($wiki->id_draft_parent) ?></td>
                    <td><?= $this->Number->format($wiki->order) ?></td>
                    <td><?= h($wiki->title_head) ?></td>
                    <td><?= h($wiki->title_h1) ?></td>
                    <td><?= h($wiki->background_file) ?></td>
                    <td><?= h($wiki->meta_description) ?></td>
                    <td><?= h($wiki->facebook_title) ?></td>
                    <td><?= h($wiki->facebook_image) ?></td>
                    <td><?= h($wiki->facebook_image_bypass) ?></td>
                    <td><?= $this->Number->format($wiki->facebook_image_width) ?></td>
                    <td><?= $this->Number->format($wiki->facebook_image_height) ?></td>
                    <td><?= h($wiki->facebook_image_alt) ?></td>
                    <td><?= h($wiki->facebook_description) ?></td>
                    <td><?= h($wiki->last_modified) ?></td>
                    <td><?= h($wiki->modified) ?></td>
                    <td><?= h($wiki->created) ?></td>
                    <td><?= h($wiki->background_alt) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $wiki->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wiki->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wiki->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wiki->id)]) ?>
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
