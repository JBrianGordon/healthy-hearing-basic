<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentUser $contentUser
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $content
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contentUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contentUser->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Content Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="contentUsers form content">
            <?= $this->Form->create($contentUser) ?>
            <fieldset>
                <legend><?= __('Edit Content User') ?></legend>
                <?php
                    echo $this->Form->control('content_id', ['options' => $content]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
