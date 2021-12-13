<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TagAd $tagAd
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tag Ad'), ['action' => 'edit', $tagAd->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tag Ad'), ['action' => 'delete', $tagAd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tagAd->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tag Ads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tag Ad'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tagAds view content">
            <h3><?= h($tagAd->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= $tagAd->has('tag') ? $this->Html->link($tagAd->tag->name, ['controller' => 'Tags', 'action' => 'view', $tagAd->tag->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tagAd->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ad Id') ?></th>
                    <td><?= $this->Number->format($tagAd->ad_id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
