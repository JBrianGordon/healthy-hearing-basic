<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $locations
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Content'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="content form content">
            <?= $this->Form->create($content) ?>
            <fieldset>
                <legend><?= __('Add Content') ?></legend>
                <?php
                    echo $this->Form->control('id_brafton');
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('type');
                    echo $this->Form->control('date', ['empty' => true]);
                    echo $this->Form->control('last_modified', ['empty' => true]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('alt_title');
                    echo $this->Form->control('subtitle');
                    echo $this->Form->control('title_head');
                    echo $this->Form->control('slug');
                    echo $this->Form->control('short');
                    echo $this->Form->control('body');
                    echo $this->Form->control('meta_description');
                    echo $this->Form->control('bodyclass');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_library_item');
                    echo $this->Form->control('library_share_text');
                    echo $this->Form->control('is_gone');
                    echo $this->Form->control('facebook_title');
                    echo $this->Form->control('facebook_description');
                    echo $this->Form->control('facebook_image');
                    echo $this->Form->control('facebook_image_width');
                    echo $this->Form->control('facebook_image_width_override');
                    echo $this->Form->control('facebook_image_height');
                    echo $this->Form->control('facebook_image_alt');
                    echo $this->Form->control('old_url');
                    echo $this->Form->control('id_draft_parent');
                    echo $this->Form->control('is_frozen');
                    echo $this->Form->control('users._ids', ['options' => $users]);
                    echo $this->Form->control('locations._ids', ['options' => $locations]);
                    echo $this->Form->control('tags._ids', ['options' => $tags]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
