<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoSearchTerm $seoSearchTerm
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Search Term'), ['action' => 'edit', $seoSearchTerm->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Search Term'), ['action' => 'delete', $seoSearchTerm->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoSearchTerm->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Search Terms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Search Term'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoSearchTerms view content">
            <h3><?= h($seoSearchTerm->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Term') ?></th>
                    <td><?= h($seoSearchTerm->term) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uri') ?></th>
                    <td><?= h($seoSearchTerm->uri) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoSearchTerm->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Count') ?></th>
                    <td><?= $this->Number->format($seoSearchTerm->count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoSearchTerm->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
