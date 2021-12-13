<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp[]|\Cake\Collection\CollectionInterface $corps
 */
?>
<div class="corps index content">
    <?= $this->Html->link(__('New Corp'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Corps') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('last_modified') ?></th>
                    <th><?= $this->Paginator->sort('modified_by') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('title_long') ?></th>
                    <th><?= $this->Paginator->sort('slug') ?></th>
                    <th><?= $this->Paginator->sort('abbr') ?></th>
                    <th><?= $this->Paginator->sort('notify_email') ?></th>
                    <th><?= $this->Paginator->sort('approval_email') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('website_url') ?></th>
                    <th><?= $this->Paginator->sort('website_url_description') ?></th>
                    <th><?= $this->Paginator->sort('pdf_all_url') ?></th>
                    <th><?= $this->Paginator->sort('favicon') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('thumb_url') ?></th>
                    <th><?= $this->Paginator->sort('facebook_title') ?></th>
                    <th><?= $this->Paginator->sort('facebook_description') ?></th>
                    <th><?= $this->Paginator->sort('facebook_image') ?></th>
                    <th><?= $this->Paginator->sort('date_approved') ?></th>
                    <th><?= $this->Paginator->sort('id_old') ?></th>
                    <th><?= $this->Paginator->sort('is_approvalrequired') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_featured') ?></th>
                    <th><?= $this->Paginator->sort('id_draft_parent') ?></th>
                    <th><?= $this->Paginator->sort('order') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($corps as $corp): ?>
                <tr>
                    <td><?= $this->Number->format($corp->id) ?></td>
                    <td><?= $this->Number->format($corp->user_id) ?></td>
                    <td><?= h($corp->type) ?></td>
                    <td><?= h($corp->created) ?></td>
                    <td><?= h($corp->modified) ?></td>
                    <td><?= h($corp->last_modified) ?></td>
                    <td><?= $this->Number->format($corp->modified_by) ?></td>
                    <td><?= h($corp->title) ?></td>
                    <td><?= h($corp->title_long) ?></td>
                    <td><?= h($corp->slug) ?></td>
                    <td><?= h($corp->abbr) ?></td>
                    <td><?= h($corp->notify_email) ?></td>
                    <td><?= h($corp->approval_email) ?></td>
                    <td><?= h($corp->phone) ?></td>
                    <td><?= h($corp->website_url) ?></td>
                    <td><?= h($corp->website_url_description) ?></td>
                    <td><?= h($corp->pdf_all_url) ?></td>
                    <td><?= h($corp->favicon) ?></td>
                    <td><?= h($corp->address) ?></td>
                    <td><?= h($corp->thumb_url) ?></td>
                    <td><?= h($corp->facebook_title) ?></td>
                    <td><?= h($corp->facebook_description) ?></td>
                    <td><?= h($corp->facebook_image) ?></td>
                    <td><?= h($corp->date_approved) ?></td>
                    <td><?= $this->Number->format($corp->id_old) ?></td>
                    <td><?= $this->Number->format($corp->is_approvalrequired) ?></td>
                    <td><?= h($corp->is_active) ?></td>
                    <td><?= h($corp->is_featured) ?></td>
                    <td><?= $this->Number->format($corp->id_draft_parent) ?></td>
                    <td><?= $this->Number->format($corp->order) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $corp->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $corp->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $corp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corp->id)]) ?>
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
