<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Page> $pages
 */
?>
<div class="content index">
    <div class="btn-group btn-group-sm pt-2 mb-3">
        <?= $this->Html->link("+ Add", ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
    </div>
    <h3><?= __('Misc Pages') ?></h3>
    <?= $this->element('pagination') ?>

    <div class="col-12 col-lg-6 table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="align-top">
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page) : ?>
                <tr>
                    <td><?= h($page->title) ?></td>
                    <td class="actions">
                        <div class="btn-group-vertical btn-group-sm">
                            <?=
                                $this->Html->link(
                                    __('Edit'),
                                    ['action' => 'edit', $page->id],
                                    ['class' => 'btn btn-default']
                                )
                            ?>
                            <?=
                                $this->Form->postLink(
                                    __('<i class="bi bi-trash"></i> ' . 'Delete'),
                                    ['action' => 'delete', $page->id],
                                    [
                                        'class' => 'btn btn-danger',
                                        'confirm' => __('Are you sure you want to delete: {0}?', $page->title),
                                        'escape' => false
                                    ],
                                )
                            ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
</div>
