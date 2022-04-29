<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content[]|\Cake\Collection\CollectionInterface $content
 */
?>
<div class="content index">
    <?= $this->Html->link(__('New Content'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Content') ?></h3>

    <?php
        echo $this->Form->create(null, ['valueSources' => 'query']);
        echo $this->Form->control('id', ['label' => 'Content ID']);
        echo $this->Form->control('user_id', ['label' => 'Primary Author', 'empty' => '(select one)']);
        echo $this->Form->control('type', ['type' => 'select', 'options' => $typeOptions, 'empty' => '(select one)']);
        echo $this->Form->control('title');
        echo $this->Form->control('short');
        echo $this->Form->control('body');
        echo $this->Form->control('is_active', [
            'type' => 'select',
            'options' =>
                [1 => 'Yes', 0 => 'No'],
                'empty' => '(select one)'
            ]);
        echo $this->Form->control('is_library_item', [
            'type' => 'select',
            'options' =>
                [1 => 'Yes', 0 => 'No'],
                'empty' => '(select one)'
            ]);
        echo $this->Form->control('library_share_text');
        echo $this->Form->control('is_gone', [
            'type' => 'select',
            'options' =>
                [1 => 'Yes', 0 => 'No'],
                'empty' => '(select one)'
            ]);
        echo $this->Form->control('facebook_image', [
            'type' => 'select',
            'options' =>
                [1 => 'Yes', 0 => 'No'],
                'empty' => '(select one)'
            ]);
        echo $this->Form->control('facebook_image_width_override', [
            'type' => 'select',
            'options' =>
                [1 => 'Yes', 0 => 'No'],
                'empty' => '(select one)'
            ]);
        echo $this->Form->control('id_draft_parent', [
            'type' => 'select',
            'options' =>
                [1 => 'Yes', 0 => 'No'],
                'empty' => '(select one)'
            ]);
        echo $this->Form->control('q', ['label' => 'Query']);
        echo $this->Form->button('Filter', ['type' => 'submit']);
        echo $this->Html->link('Reset', ['action' => 'index']);
        echo $this->Form->end();
    ?>

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
