<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUserLogin $locationUserLogin
 * @var string[]|\Cake\Collection\CollectionInterface $locationUsers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $locationUserLogin->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $locationUserLogin->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Location User Logins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationUserLogins form content">
            <?= $this->Form->create($locationUserLogin) ?>
            <fieldset>
                <legend><?= __('Edit Location User Login') ?></legend>
                <?php
                    echo $this->Form->control('location_user_id', ['options' => $locationUsers]);
                    echo $this->Form->control('login_date', ['empty' => true]);
                    echo $this->Form->control('ip');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
