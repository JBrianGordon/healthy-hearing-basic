<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QueueTask $queueTask
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $queueTask->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $queueTask->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Queue Tasks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="queueTasks form content">
            <?= $this->Form->create($queueTask) ?>
            <fieldset>
                <legend><?= __('Edit Queue Task') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('executed', ['empty' => true]);
                    echo $this->Form->control('scheduled', ['empty' => true]);
                    echo $this->Form->control('scheduled_end', ['empty' => true]);
                    echo $this->Form->control('reschedule');
                    echo $this->Form->control('start_time');
                    echo $this->Form->control('end_time');
                    echo $this->Form->control('cpu_limit');
                    echo $this->Form->control('is_restricted');
                    echo $this->Form->control('priority');
                    echo $this->Form->control('status');
                    echo $this->Form->control('type');
                    echo $this->Form->control('command');
                    echo $this->Form->control('result');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
