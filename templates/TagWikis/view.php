<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagWiki $tagWiki
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tag Wiki'), ['action' => 'edit', $tagWiki->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tag Wiki'), ['action' => 'delete', $tagWiki->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tagWiki->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tag Wikis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tag Wiki'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tagWikis view content">
            <h3><?= h($tagWiki->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Wiki') ?></th>
                    <td><?= $tagWiki->has('wiki') ? $this->Html->link($tagWiki->wiki->name, ['controller' => 'Wikis', 'action' => 'view', $tagWiki->wiki->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= $tagWiki->has('tag') ? $this->Html->link($tagWiki->tag->name, ['controller' => 'Tags', 'action' => 'view', $tagWiki->tag->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tagWiki->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
