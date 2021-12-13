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
            <?= $this->Html->link(__('List Seo Blacklists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoBlacklists form content">
            <?= $this->Form->create($seoBlacklist) ?>
            <fieldset>
                <legend><?= __('Add Seo Blacklist') ?></legend>
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
