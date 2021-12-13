<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersWiki $usersWiki
 * @var \Cake\Collection\CollectionInterface|string[] $wikis
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="usersWikis form content">
            <?= $this->Form->create($usersWiki) ?>
            <fieldset>
                <legend><?= __('Add Users Wiki') ?></legend>
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
