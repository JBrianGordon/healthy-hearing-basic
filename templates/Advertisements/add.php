<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Advertisement $advertisement
 * @var \Cake\Collection\CollectionInterface|string[] $corps
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Advertisements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="advertisements form content">
            <?= $this->Form->create($advertisement) ?>
            <fieldset>
                <legend><?= __('Add Advertisement') ?></legend>
                <?php
                    echo $this->Form->control('modified_by');
                    echo $this->Form->control('title');
                    echo $this->Form->control('slug');
                    echo $this->Form->control('corp_id', ['options' => $corps]);
                    echo $this->Form->control('type');
                    echo $this->Form->control('src');
                    echo $this->Form->control('dest');
                    echo $this->Form->control('slot');
                    echo $this->Form->control('height');
                    echo $this->Form->control('width');
                    echo $this->Form->control('alt');
                    echo $this->Form->control('class');
                    echo $this->Form->control('style');
                    echo $this->Form->control('onclick');
                    echo $this->Form->control('onmouseover');
                    echo $this->Form->control('weight');
                    echo $this->Form->control('active_expires', ['empty' => true]);
                    echo $this->Form->control('restrict_path');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('is_ao');
                    echo $this->Form->control('is_hh');
                    echo $this->Form->control('is_sp');
                    echo $this->Form->control('is_ei');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('tag_corps');
                    echo $this->Form->control('tag_basic');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
