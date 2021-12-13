<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QuizResult[]|\Cake\Collection\CollectionInterface $quizResults
 */
?>
<div class="quizResults index content">
    <?= $this->Html->link(__('New Quiz Result'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Quiz Results') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quizResults as $quizResult): ?>
                <tr>
                    <td><?= $this->Number->format($quizResult->id) ?></td>
                    <td><?= h($quizResult->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $quizResult->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $quizResult->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $quizResult->id], ['confirm' => __('Are you sure you want to delete # {0}?', $quizResult->id)]) ?>
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
