<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Advertisement> $advertisements
 */
?>
<div class="advertisements index content">
    <?= $this->Html->link(__('New Advertisement'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Advertisements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('src') ?></th>
                    <th><?= $this->Paginator->sort('dest') ?></th>
                    <th><?= $this->Paginator->sort('slot') ?></th>
                    <th><?= $this->Paginator->sort('height') ?></th>
                    <th><?= $this->Paginator->sort('width') ?></th>
                    <th><?= $this->Paginator->sort('alt') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('tag_corps') ?></th>
                    <th><?= $this->Paginator->sort('tag_basic') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($advertisements as $advertisement): ?>
                <tr>
                    <td><?= $this->Number->format($advertisement->id) ?></td>
                    <td><?= h($advertisement->created) ?></td>
                    <td><?= h($advertisement->modified) ?></td>
                    <td><?= h($advertisement->title) ?></td>
                    <td><?= h($advertisement->type) ?></td>
                    <td><?= h($advertisement->src) ?></td>
                    <td><?= h($advertisement->dest) ?></td>
                    <td><?= h($advertisement->slot) ?></td>
                    <td><?= h($advertisement->height) ?></td>
                    <td><?= h($advertisement->width) ?></td>
                    <td><?= h($advertisement->alt) ?></td>
                    <td><?= h($advertisement->is_active) ?></td>
                    <td><?= h($advertisement->tag_corps) ?></td>
                    <td><?= h($advertisement->tag_basic) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $advertisement->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $advertisement->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $advertisement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $advertisement->id)]) ?>
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
