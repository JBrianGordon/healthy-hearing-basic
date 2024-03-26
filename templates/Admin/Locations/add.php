<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 * @var \Cake\Collection\CollectionInterface|string[] $content
 */

use Cake\Core\Configure;

$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Locations Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link('Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="form">
                    <?= $this->Form->create($location) ?>
                    <fieldset>
                        <div class="col-md-12 row">
                            <?= $this->Form->control('title', ['label' => ['class' => 'col-md-2-override'], 'class' => 'col-md-10-override']) ?>
                        </div>
                        <div class="form-group row">
                            <div class="col col-md-10 col-md-offset-2 pl0">
                                <span class="badge bg-hh"><?= Configure::read('siteNameAbbr') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6 row">
                            <?php
                                echo $this->Form->control('address', ['label' => ['class' => 'col-md-4-override'], 'class' => 'col-md-8-override']);
                                echo $this->Form->control('city', ['label' => ['class' => 'col-md-4-override'], 'class' => 'col-md-8-override']);
                                echo $this->Form->control('zip', ['label' => ['class' => 'col-md-4-override'], 'class' => 'col-md-8-override']);
                            ?>
                        </div>
                        <div class="col-md-6 row">
                            <?php
                                echo $this->Form->control('address_2', ['label' => ['class' => 'col-md-4-override'], 'class' => 'col-md-8-override']);
                                echo $this->Form->control('state', ['label' => ['class' => 'col-md-4-override'], 'class' => 'col-md-8-override']);
                            ?>
                        </div>
                        <div class="col-md-12 row">
                            <?php
                                echo $this->Form->control('phone', ['label' => ['class' => 'col-md-2-override'], 'class' => 'col-md-10-override']);
                                echo $this->Form->control('email', ['label' => ['class' => 'col-md-2-override'], 'class' => 'col-md-10-override']);
                            ?>
                        </div>
                    </fieldset>
                    <div class="form-actions tar clearfix">
                        <?= $this->Form->button('Save and edit Location', ['class' => 'btn btn-primary btn-lg']) ?>
                     </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>
</div>