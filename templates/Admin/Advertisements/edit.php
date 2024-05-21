<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Advertisement $advertisement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $advertisement->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $advertisement->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Advertisements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="advertisements form content">
            <?= $this->Form->create($advertisement) ?>
            <fieldset>
                <legend><?= __('Edit Advertisement') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('type');
                    echo $this->Form->control('src');
                    echo $this->Form->control('dest');
                    echo $this->Form->control('slot');
                    echo $this->Form->control('height');
                    echo $this->Form->control('width');
                    echo $this->Form->control('alt');
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
