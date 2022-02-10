<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content[]|\Cake\Collection\CollectionInterface $content
 */
?>
<div class="content index content">
    <?= $this->Html->link(__('New Content'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Content') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('id_brafton') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('last_modified') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('alt_title') ?></th>
                    <th><?= $this->Paginator->sort('title_head') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('meta_description') ?></th>
                    <th><?= $this->Paginator->sort('bodyclass') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_library_item') ?></th>
                    <th><?= $this->Paginator->sort('library_share_text') ?></th>
                    <th><?= $this->Paginator->sort('is_gone') ?></th>
                    <th><?= $this->Paginator->sort('facebook_title') ?></th>
                    <th><?= $this->Paginator->sort('facebook_description') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_width') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_width_override') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_height') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image_alt') ?></th>
                    <th><?= $this->Paginator->sort('comment_count') ?></th>
                    <th><?= $this->Paginator->sort('like_count') ?></th>
                    <th><?= $this->Paginator->sort('old_url') ?></th>
                    <th><?= $this->Paginator->sort('id_draft_parent') ?></th>
                    <th><?= $this->Paginator->sort('is_frozen') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($content as $content): ?>
                <tr>
                    <td><?= $this->Number->format($content->id) ?></td>
                    <td><?= $this->Number->format($content->id_brafton) ?></td>
                    <td><?= $this->Number->format($content->user_id) ?></td>
                    <td><?= h($content->type) ?></td>
                    <td><?= h($content->date) ?></td>
                    <td><?= h($content->created) ?></td>
                    <td><?= h($content->modified) ?></td>
                    <td><?= h($content->last_modified) ?></td>
                    <td><?= h($content->title) ?></td>
                    <td><?= h($content->alt_title) ?></td>
                    <td><?= h($content->title_head) ?></td>
                    <td><?= h($content->slug) ?></td>
                    <td><?= h($content->meta_description) ?></td>
                    <td><?= h($content->bodyclass) ?></td>
                    <td><?= h($content->is_active) ?></td>
                    <td><?= h($content->is_library_item) ?></td>
                    <td><?= h($content->library_share_text) ?></td>
                    <td><?= h($content->is_gone) ?></td>
                    <td><?= h($content->facebook_title) ?></td>
                    <td><?= h($content->facebook_description) ?></td>
                    <td><?= h($content->facebook_image) ?></td>
                    <td><?= $this->Number->format($content->facebook_image_width) ?></td>
                    <td><?= h($content->facebook_image_width_override) ?></td>
                    <td><?= $this->Number->format($content->facebook_image_height) ?></td>
                    <td><?= h($content->facebook_image_alt) ?></td>
                    <td><?= $this->Number->format($content->comment_count) ?></td>
                    <td><?= $this->Number->format($content->like_count) ?></td>
                    <td><?= h($content->old_url) ?></td>
                    <td><?= $this->Number->format($content->id_draft_parent) ?></td>
                    <td><?= h($content->is_frozen) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $content->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $content->id]) ?>
                        <?= $this->Form->postLink(__('Draft'), ['action' => 'draft', $content->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $content->id], ['confirm' => __('Are you sure you want to delete # {0}?', $content->id)]) ?>
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
