<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoBlacklist $seoBlacklist
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoBlacklist->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoBlacklist->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Blacklists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoBlacklists form content">
            <?= $this->Form->create($seoBlacklist) ?>
            <fieldset>
                <legend><?= __('Edit Seo Blacklist') ?></legend>
                <?php
                    echo $this->Form->control('ip_range_start');
                    echo $this->Form->control('ip_range_end');
                    echo $this->Form->control('note');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
