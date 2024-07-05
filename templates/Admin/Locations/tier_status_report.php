<?php
use Cake\Core\Configure;
$this->Html->script('dist/admin_common.min', ['block' => true]);
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Imports Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(" Dashboard", ['controller' => 'import-locations', 'action' => 'index'], ['class' => 'btn btn-default bi bi-speedometer', 'escape' => false]) ?>
                <?= $this->Html->link(" Stats", ['controller' => 'imports', 'action' => 'index'], ['class' => 'btn btn-default bi bi-bar-chart-fill', 'escape' => false]) ?>
                <?= $this->Html->link(" Tier Status Change", ['controller' => 'locations', 'action' => 'tier-status-report'], ['class' => 'btn btn-default bi bi-bar-chart-fill', 'escape' => false]) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <div class="form">
                    <h2>Tier Status Change Report</h2>
                    <?= $this->Form->create() ?>
                        <fieldset>
                            <?= $this->Form->control('start_date', [
                                'type' => 'date',
                                'min' => date("Y-m-d", strtotime('01/01/2011')),
                                'max' => date("Y-m-d", strtotime('today')),
                            ]); ?>
                            <?= $this->Form->control('end_date', [
                                'type' => 'date',
                                'min' => date("Y-m-d", strtotime('01/01/2011')),
                                'max' => date("Y-m-d", strtotime('today')),
                            ]); ?>
                            <span class="help-block col-md-9 col-md-offset-3 p0">Leave blank for all<br>(Note: Locations that were first imported after this date will show zero imports in the report)</span>
                            <?= $this->Form->control('email', ['label' => ['class' => 'col-md-4'], 'class' => 'col-md-8']) ?>
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
