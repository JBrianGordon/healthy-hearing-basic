<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $wiki->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $wiki->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="wikis form content">
            <?= $this->Form->create($wiki) ?>
            <fieldset>
                <legend><?= __('Edit Wiki') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('slug');
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('body');
                    echo $this->Form->control('short');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('id_draft_parent');
                    echo $this->Form->control('order');
                    echo $this->Form->control('title_head');
                    echo $this->Form->control('title_h1');
                    echo $this->Form->control('background_file');
                    echo $this->Form->control('meta_description');
                    echo $this->Form->control('facebook_title');
                    echo $this->Form->control('facebook_image');
                    echo $this->Form->control('facebook_image_bypass');
                    echo $this->Form->control('facebook_image_width');
                    echo $this->Form->control('facebook_image_height');
                    echo $this->Form->control('facebook_image_alt');
                    echo $this->Form->control('facebook_description');
                    echo $this->Form->control('last_modified', ['empty' => true]);
                    echo $this->Form->control('background_alt');
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
