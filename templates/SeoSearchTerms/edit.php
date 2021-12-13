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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seoSearchTerm->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seoSearchTerm->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Seo Search Terms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoSearchTerms form content">
            <?= $this->Form->create($seoSearchTerm) ?>
            <fieldset>
                <legend><?= __('Edit Seo Search Term') ?></legend>
                <?php
                    echo $this->Form->control('term');
                    echo $this->Form->control('uri');
                    echo $this->Form->control('count');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
