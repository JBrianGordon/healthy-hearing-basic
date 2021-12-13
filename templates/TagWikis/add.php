<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagWiki $tagWiki
 * @var \Cake\Collection\CollectionInterface|string[] $wikis
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tag Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tagWikis form content">
            <?= $this->Form->create($tagWiki) ?>
            <fieldset>
                <legend><?= __('Add Tag Wiki') ?></legend>
                <?php
                    echo $this->Form->control('wiki_id', ['options' => $wikis]);
                    echo $this->Form->control('tag_id', ['options' => $tags]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
