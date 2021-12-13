<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagWiki $tagWiki
 * @var string[]|\Cake\Collection\CollectionInterface $wikis
 * @var string[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tagWiki->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tagWiki->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tag Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tagWikis form content">
            <?= $this->Form->create($tagWiki) ?>
            <fieldset>
                <legend><?= __('Edit Tag Wiki') ?></legend>
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
