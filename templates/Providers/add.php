<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Provider $provider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="providers form content">
            <?= $this->Form->create($provider) ?>
            <fieldset>
                <legend><?= __('Add Provider') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('middle_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('credentials');
                    echo $this->Form->control('title');
                    echo $this->Form->control('email');
                    echo $this->Form->control('description');
                    echo $this->Form->control('micro_url');
                    echo $this->Form->control('square_url');
                    echo $this->Form->control('thumb_url');
                    echo $this->Form->control('image_url');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('priority');
                    echo $this->Form->control('aud_or_his');
                    echo $this->Form->control('caqh_number');
                    echo $this->Form->control('npi_number');
                    echo $this->Form->control('show_npi');
                    echo $this->Form->control('is_ida_verified');
                    echo $this->Form->control('licenses');
                    echo $this->Form->control('show_license');
                    echo $this->Form->control('id_yhn_provider');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
