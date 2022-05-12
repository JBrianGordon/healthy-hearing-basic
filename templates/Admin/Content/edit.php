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
        <div class="content form">
            <?= $this->Form->create($content) ?>
            <fieldset>
                <?php
                    echo $this->Form->hidden('is_frozen');
                    echo $this->Form->hidden('id_draft_parent');
                    echo $this->Form->control('title');
                    echo $this->Form->control('date', ['empty' => true]);
                    echo $this->Form->control('last_modified', ['empty' => true]);
                    echo $this->Form->control('type');
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('hh_url');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_library_item');
                    echo $this->Form->control('is_gone');
                ?>
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="content-tab"
                            data-bs-toggle="tab" data-bs-target="#content"
                            type="button" role="tab"
                            aria-controls="content" aria-selected="true">Content</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="details-tab"
                            data-bs-toggle="tab" data-bs-target="#details"
                            type="button" role="tab"
                            aria-controls="details" aria-selected="false">Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="admin-tab"
                            data-bs-toggle="tab" data-bs-target="#admin"
                            type="button" role="tab"
                            aria-controls="admin" aria-selected="false">Admin</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Content Tab -->
                    <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">
                       <?php
                            echo $this->Form->control('body');
                            echo $this->Form->control('short');
                            echo $this->Form->control('library_share_text');
                        ?>
                    </div>
                    <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <?php
                            echo $this->Form->control('slug');
                            echo $this->Form->control('alt_title');
                            echo $this->Form->control('title_head');
                            echo $this->Form->control('meta_description');
                            echo $this->Form->control('facebook_title');
                            echo $this->Form->control('facebook_description');
                            echo $this->Form->control('facebook_image_width_override');
                            echo $this->Form->control('facebook_image');
                            echo $this->Form->control('facebook_image_width');
                            echo $this->Form->control('facebook_image_height');
                            echo $this->Form->control('facebook_image_alt');
                        ?>
                    </div>
                    <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                        <?php
                            echo $this->Form->control('id_brafton');
                        ?>
                    </div>
                </div>

            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
