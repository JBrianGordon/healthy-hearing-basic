<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountMetric $countMetric
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Count Metrics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="countMetrics form content">
            <?= $this->Form->create($countMetric) ?>
            <fieldset>
                <legend><?= __('Add Count Metric') ?></legend>
                <?php
                    echo $this->Form->control('type');
                    echo $this->Form->control('metric');
                    echo $this->Form->control('name');
                    echo $this->Form->control('sub_name');
                    echo $this->Form->control('count');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
