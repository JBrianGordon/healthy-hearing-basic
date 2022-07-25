<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LocationUser $locationUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Location Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locationUsers form content">
            <?= $this->Form->create($locationUser) ?>
            <fieldset>
                <legend><?= __('Add Location User') ?></legend>
                <?php
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('lastlogin', ['empty' => true]);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('reset_url');
                    echo $this->Form->control('reset_expiration_date', ['empty' => true]);
                    echo $this->Form->control('clinic_password');
                    echo $this->Form->control('location_id', ['type' => 'text', 'default' => '']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
