<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentTag $contentTag
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 * @var \Cake\Collection\CollectionInterface|string[] $content
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Content Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="contentTags form content">
            <?= $this->Form->create($contentTag) ?>
            <fieldset>
                <legend><?= __('Add Content Tag') ?></legend>
                <?php
                    echo $this->Form->control('content_id', ['options' => $content]);
                    echo $this->Form->control('tag_id', ['options' => $tags]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
