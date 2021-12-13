<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CrmSearch $crmSearch
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $crmSearch->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $crmSearch->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Crm Searches'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="crmSearches form content">
            <?= $this->Form->create($crmSearch) ?>
            <fieldset>
                <legend><?= __('Edit Crm Search') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('model');
                    echo $this->Form->control('title');
                    echo $this->Form->control('search');
                    echo $this->Form->control('is_public');
                    echo $this->Form->control('order');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
