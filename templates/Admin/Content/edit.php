<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $content->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $content->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Content'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="content form content">
            <?= $this->Form->create($content) ?>
            <fieldset>
                <legend><?= __('Edit Content') ?></legend>
                <?php
                    echo $this->Form->control('id_brafton');
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('type');
                    echo $this->Form->control('date', ['empty' => true]);
                    echo $this->Form->control('last_modified', ['empty' => true]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('alt_title');
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
                    echo $this->Form->control('comment_count');
                    echo $this->Form->control('like_count');
                    echo $this->Form->control('old_url');
                    echo $this->Form->control('id_draft_parent');
                    echo $this->Form->control('is_frozen');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
