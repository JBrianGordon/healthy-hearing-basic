<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersWiki $usersWiki
 * @var string[]|\Cake\Collection\CollectionInterface $wikis
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $usersWiki->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $usersWiki->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Users Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usersWikis form content">
            <?= $this->Form->create($usersWiki) ?>
            <fieldset>
                <legend><?= __('Edit Users Wiki') ?></legend>
                <?php
                    echo $this->Form->control('wiki_id', ['options' => $wikis]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
