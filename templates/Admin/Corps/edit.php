<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $corp->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $corp->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Corps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="corps form content">
            <?= $this->Form->create($corp) ?>
            <fieldset>
                <legend><?= __('Edit Corp') ?></legend>
                <?php
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('type');
                    echo $this->Form->control('last_modified', ['empty' => true]);
                    echo $this->Form->control('modified_by');
                    echo $this->Form->control('title');
                    echo $this->Form->control('title_long');
                    echo $this->Form->control('slug');
                    echo $this->Form->control('abbr');
                    echo $this->Form->control('short');
                    echo $this->Form->control('description');
                    echo $this->Form->control('notify_email');
                    echo $this->Form->control('approval_email');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('website_url');
                    echo $this->Form->control('website_url_description');
                    echo $this->Form->control('pdf_all_url');
                    echo $this->Form->control('favicon');
                    echo $this->Form->control('address');
                    echo $this->Form->control('thumb_url');
                    echo $this->Form->control('facebook_title');
                    echo $this->Form->control('facebook_description');
                    echo $this->Form->control('facebook_image');
                    echo $this->Form->control('date_approved', ['empty' => true]);
                    echo $this->Form->control('id_old');
                    echo $this->Form->control('is_approvalrequired');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_featured');
                    echo $this->Form->control('id_draft_parent');
                    echo $this->Form->control('wbc_config');
                    echo $this->Form->control('priority');
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
