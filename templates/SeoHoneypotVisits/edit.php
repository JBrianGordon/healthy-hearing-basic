<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoHoneypotVisit $seoHoneypotVisit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoHoneypotVisit->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoHoneypotVisit->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Honeypot Visits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoHoneypotVisits form content">
            <?= $this->Form->create($seoHoneypotVisit) ?>
            <fieldset>
                <legend><?= __('Edit Seo Honeypot Visit') ?></legend>
                <?php
                    echo $this->Form->control('ip');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
