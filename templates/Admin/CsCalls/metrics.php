<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */

$this->Vite->script('admin-vite','admin_common');

$startDate = isset($startDate) ? $startDate : null;
$endDate = isset($endDate) ? $endDate : null;
// Readable report titles
$reportReadable = [
    'prospects_other' => 'Abandoned / Busy / No answer / Short',
    'non_prospects' => 'Non-prospects',
    'unknown' => 'Voicemails / Unknown'
];
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Cs Calls Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
            </div>
        </div>
    </div>
</header>                       
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Call Tracking Metrics <small>(from CallSource LeadScoring)</small></h2>
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
                    <h4>Report for <?php echo $startDate; ?> to <?php echo $endDate; ?></h4>
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
