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
<!--*** TODO: This template still needs functionality ***-->
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="form">
                    <h2>Tier Status Change Report</h2>
                    <?= $this->Form->create() ?>
                    <fieldset>
                        <?= $this->Form->control('start_date', ['label' => ['text' => 'Start Date', 'class' => 'col-md-4'], 'class' => 'col-md-8', 'placeholder' => 'MM/DD/YYYY'])?>
                        <span class="help-block col-md-9 col-md-offset-3 p0">Leave blank for all</span>
                        <?= $this->Form->control('end_date', ['label' => ['text' => 'Start Date', 'class' => 'col-md-4'], 'class' => 'col-md-8','placeholder' => 'MM/DD/YYYY'])?>
                        <span class="help-block col-md-9 col-md-offset-3 p0">Leave blank for all<br>(Note: Locations that were first imported after this date will show zero imports in the report)</span>
                        <?= $this->Form->control('title', ['label' => ['class' => 'col-md-4'], 'class' => 'col-md-8']) ?>
                        <span class="help-block col-md-9 col-md-offset-3 p0">The report will be sent to this email when complete.</span>
                    </fieldset>
                    <div class="form-actions tar clearfix">
                        <?= $this->Form->button('Generate report', ['class' => 'btn btn-primary btn-lg']) ?>
                     </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>
</div>