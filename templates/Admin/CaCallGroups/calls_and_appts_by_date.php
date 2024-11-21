<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CsCall[]|\Cake\Collection\CollectionInterface $csCalls
 */
use Cake\Core\Configure;
$this->Html->script('dist/admin_common.min', ['block' => true]);

$startDate = isset($startDate) ? $startDate : null;
$endDate = isset($endDate) ? $endDate : null;
$caCallGroup = [];
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
                <h2>Calls and Appts By Date Range</h2>
                <p>A spreadsheet will be emailed to you with one of the following:</p>
                <?= $this->Form->create(null, ['type' => 'file']) ?>
                <div class="row mb20">
                    <div class="col col-md-12">
                        <div data-toggle="buttons">
                            <label class="btn btn-default active mb10">
                                <input type="radio" name="report_type" value="totals" checked>Clinic totals
                            </label>
                            Spreadsheet will contain: <?php echo Configure::read('siteNameAbbr'); ?> ID, title, total call groups, usable calls, prospects and appts set.<br>
                            <div class="clearfix"></div>
                            <label class="btn btn-default">
                                <input type="radio" name="report_type" value="calls">Prospect calls
                            </label>
                            Spreadsheet will contain: <?php echo Configure::read('siteNameAbbr'); ?> ID, title, call date, caller name/phone/email, patient name, score, and appt date.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column-responsive column-80">
                        <div class="csCalls form content col col-md-6">
                            <fieldset>
                                <?php
                                    echo $this->Form->control('csv_file', ['type' => 'file', 'required' => true, 'help_block' => 'List of clinics. Must have 2 columns (id, title).']);
                                    echo $this->Form->control('start_date', ['type' => 'date', 'required' => true]);
                                    echo $this->Form->control('end_date', ['type' => 'date', 'required' => true]);
                                ?>
                            </fieldset>
                            <div class="form-actions tar">
                                <?= $this->Form->button('Send Report', ['class' => 'btn btn-primary btn-lg']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </section>
</div>
