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
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr class="align-top">
                    <th>
                        <?= $this->Paginator->sort('is_active', 'Active') ?>
                        <?= $this->Paginator->sort('id') ?>
                    </th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'Author') ?></th>
                    <th><?= $this->Paginator->sort('short') ?></th>
                    <th>
                        <?= $this->Paginator->sort('last_modified', 'Last Mod') ?>
                        <?= $this->Paginator->sort('date', 'Pub Date') ?>
                    </th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($content as $content): ?>
                <tr>
                    <td>
                        <?= $this->Number->format($content->id) ?>
                        <?= $this->Html->badge(
                                $content->is_active ? 'Yes' : 'No', [
                                'class' => $content->is_active ? 'success' : 'danger',
                            ]);
                        ?>
                    </td>
                    <td><?= h($content->title) ?></td>
                    <td><?= h($content->type) ?></td>
                    <td>
                        <?php
                            if ($content->primary_author !== null) {
                                echo h($content->primary_author->username);
                            }
                        ?>
                    </td>
                    <td><?= h($content->short) ?></td>
                    <td><?= h($content->last_modified) ?></td>
                    <td><?= h($content->date) ?></td>
                    <td class="actions">
                        <div class="btn-group-vertical">
                            <?= $this->Html->link(
                                __('View'),
                                array_merge(['prefix' => false], $content->hh_url),
                                ['class' => 'btn btn-outline-secondary'])
                            ?>
                            <?= $this->Html->link(
                                __('Edit'),
                                ['action' => 'edit', $content->id],
                                ['class' => 'btn btn-outline-secondary'])
                            ?>
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
