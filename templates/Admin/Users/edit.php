<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $corps
 * @var string[]|\Cake\Collection\CollectionInterface $content
 * @var string[]|\Cake\Collection\CollectionInterface $wikis
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit User') ?></legend>
                <?php
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('level');
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('middle_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('degrees');
                    echo $this->Form->control('credentials');
                    echo $this->Form->control('title_dept_company');
                    echo $this->Form->control('company');
                    echo $this->Form->control('email');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('address');
                    echo $this->Form->control('address_2');
                    echo $this->Form->control('city');
                    echo $this->Form->control('state');
                    echo $this->Form->control('zip');
                    echo $this->Form->control('country');
                    echo $this->Form->control('url');
                    echo $this->Form->control('bio');
                    echo $this->Form->control('image_url');
                    echo $this->Form->control('thumb_url');
                    echo $this->Form->control('square_url');
                    echo $this->Form->control('micro_url');
                    echo $this->Form->control('modified_by');
                    echo $this->Form->control('last_login', ['empty' => true]);
                    echo $this->Form->control('active');
                    echo $this->Form->control('is_hardened_password');
                    echo $this->Form->control('is_admin');
                    echo $this->Form->control('is_it_admin');
                    echo $this->Form->control('is_agent');
                    echo $this->Form->control('is_call_supervisor');
                    echo $this->Form->control('is_author');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('corp_id');
                    echo $this->Form->control('is_deleted');
                    echo $this->Form->control('is_csa');
                    echo $this->Form->control('is_writer');
                    echo $this->Form->control('recovery_email');
                    echo $this->Form->control('clinic_password');
                    echo $this->Form->control('timezone_offset');
                    echo $this->Form->control('timezone');
                    echo $this->Form->control('token');
                    echo $this->Form->control('token_expires', ['empty' => true]);
                    echo $this->Form->control('api_token');
                    echo $this->Form->control('activation_date', ['empty' => true]);
                    echo $this->Form->control('secret');
                    echo $this->Form->control('secret_verified');
                    echo $this->Form->control('tos_date', ['empty' => true]);
                    echo $this->Form->control('is_superuser');
                    echo $this->Form->control('role');
                    echo $this->Form->control('additional_data');
                    echo $this->Form->control('corps._ids', ['options' => $corps]);
                    echo $this->Form->control('content._ids', ['options' => $content]);
                    echo $this->Form->control('wikis._ids', ['options' => $wikis]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
