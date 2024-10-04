<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */

$this->Html->script('dist/admin_common.min', ['block' => true]);

$startDate = isset($startDate) ? $startDate : null;
$endDate = isset($endDate) ? $endDate : null;
// Readable report titles
$reportReadable = [
    'column_label' => '',
    'all_inbound_calls' => 'Inbound Calls and VMs',
    'prospects_other' => 'Disconnected / Wrong Number / Unknown',
    'non_prospects' => 'Non-prospects',
    'by_clinic' => 'By Clinic (calls)',
    'by_clinic_form' => 'By Clinic (forms)',
    'by_direct' => 'Direct Book (calls)',
    'by_direct_form' => 'Direct Book (forms)',
    'by_direct_online' => 'Direct Book (online)'
];
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Ca Call Groups Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->element('ca_calls/action_bar', ['spamCount' => $spamCount]) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Call Concierge Metrics</h2>
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="csCalls form content col col-md-6">
                            <!--*** TODO: functionality needs to be built out in controller ***-->
                            <?= $this->Form->create() ?>
                            <fieldset>
                                <?php
                                    echo $this->Form->control('start_date', ['type' => 'date', 'required' => true]);
                                    echo $this->Form->control('end_date', ['type' => 'date', 'required' => true]);
                                ?>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Find Report', ['class' => 'btn btn-primary btn-lg']) ?>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
                <?php if (isset($report)): ?>
                    <hr>
                    <h4 class="mb0">Selected dates: <?php echo $startDate; ?> to <?php echo $endDate; ?></h4>
                    <p><span class="metric-reported">Red</span> = reported data</p>
                    <?php
                    foreach ($report as $title => $data) {
                        echo $this->element('call_metrics_report', ['title' => $title, 'data' => $data, 'reportReadable' => $reportReadable]);
                    }
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
