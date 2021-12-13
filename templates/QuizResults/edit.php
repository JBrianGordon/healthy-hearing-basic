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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $quizResult->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $quizResult->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Quiz Results'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="quizResults form content">
            <?= $this->Form->create($quizResult) ?>
            <fieldset>
                <legend><?= __('Edit Quiz Result') ?></legend>
                <?php
                    echo $this->Form->control('results');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
