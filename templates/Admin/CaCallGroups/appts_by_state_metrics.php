<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */
$this->Html->script('dist/admin_common.min', ['block' => true]);

$startDate = isset($startDate) ? $startDate : null;
$endDate = isset($endDate) ? $endDate : null;
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Ca Call Groups Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->element('ca_calls/action_bar') ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Appts By State Metrics</h2>
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="csCalls form content col col-md-6">
                            <?= $this->Form->create() ?>
                            <fieldset>
                                <?php
                                    echo $this->Form->control('start_date', ['type' => 'date', 'required' => true]);
                                    echo $this->Form->control('end_date', ['type' => 'date', 'required' => true]);
                                ?>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Send Report', ['class' => 'btn btn-primary btn-lg']) ?>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
