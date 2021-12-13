<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUri $seoUri
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Seo Uris'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoUris form content">
            <?= $this->Form->create($seoUri) ?>
            <fieldset>
                <legend><?= __('Add Seo Uri') ?></legend>
                <?php
                    echo $this->Form->control('uri');
                    echo $this->Form->control('is_approved');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
