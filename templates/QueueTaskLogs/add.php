<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QueueTaskLog $queueTaskLog
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Queue Task Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="queueTaskLogs form content">
            <?= $this->Form->create($queueTaskLog) ?>
            <fieldset>
                <legend><?= __('Add Queue Task Log') ?></legend>
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
