<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagWiki[]|\Cake\Collection\CollectionInterface $tagWikis
 */
?>
<div class="tagWikis index content">
    <?= $this->Html->link(__('New Tag Wiki'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tag Wikis') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('wiki_id') ?></th>
                    <th><?= $this->Paginator->sort('tag_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tagWikis as $tagWiki): ?>
                <tr>
                    <td><?= $this->Number->format($tagWiki->id) ?></td>
                    <td><?= $tagWiki->has('wiki') ? $this->Html->link($tagWiki->wiki->name, ['controller' => 'Wikis', 'action' => 'view', $tagWiki->wiki->id]) : '' ?></td>
                    <td><?= $tagWiki->has('tag') ? $this->Html->link($tagWiki->tag->name, ['controller' => 'Tags', 'action' => 'view', $tagWiki->tag->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tagWiki->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tagWiki->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tagWiki->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tagWiki->id)]) ?>
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
