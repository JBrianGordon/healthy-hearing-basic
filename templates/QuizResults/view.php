<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QuizResult $quizResult
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Quiz Result'), ['action' => 'edit', $quizResult->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Quiz Result'), ['action' => 'delete', $quizResult->id], ['confirm' => __('Are you sure you want to delete # {0}?', $quizResult->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Quiz Results'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Quiz Result'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="quizResults view content">
            <h3><?= h($quizResult->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($quizResult->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($quizResult->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Results') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($quizResult->results)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
