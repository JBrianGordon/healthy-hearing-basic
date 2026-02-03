<?php
use Cake\Core\Configure;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\Location;
//$this->Html->script('dist/clinic_report.min.js?v='.Configure::read("tagVersion"), ['defer' => 'defer', 'block' => true]);

$username ??= null;
$startDate ??= null;
$endDate ??= null;
if (!empty($locationId)) {
    $isCallAssist = isset($isCallAssist) ? $isCallAssist : false;
    $title = isset($title) ? $title : '';
    $showCallAssistReport = false;
    $showCallTrackingReport = false;
    if (!empty($calls)) {
        $showCallAssistReport = true;
    }
    if (!empty($csCalls)) {
        $showCallTrackingReport = true;
    }
    if ($isCallAssist) {
        // Call Assist clinics should show Call Assist report even if no data
        $showCallAssistReport = true;
    } else {
        $showCallTrackingReport = true;
    }
    $isLeadscoreEnabled = Configure::read('isLeadscoreEnabled');
}

$this->Html->script('dist/clinic_report.min', ['block' => true]);
?>
<?php if ($showProfileViews) : ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>
    <script>
        const timeSeriesData = <?php echo $profileViewsByMonths; ?>;
        const labelsForChart = <?php echo $labelsForChart; ?>;
        const locationURL = "<?php echo $locationURL; ?>";
    </script>
<?php endif; ?>
<div class="container-fluid site-body">
  <div class="row">
    <div class="backdrop-container">
      <div class="backdrop backdrop-gradient backdrop-height"></div>
    </div>
    <div class="container">
      <div class="row pt20">
        	<div class="col-md-12">
        		<section class="panel">
        			<div class="panel-body">
          			<div class="panel-section expanded">

                        <h1>Reporting</h1>

                        <?= $this->Form->create() ?>
                            <div class="row">
                                <div class="col col-lg-6">
                                    <?php
                                    if ($isAdmin) {
                                        echo $this->Form->control('username', [
                                            'default' => $username,
                                            'type' => 'text',
                                            'label' => 'Username',
                                            'required' => true,
                                            'div' => 'form-group required',
                                        ]);
                                    }
                                    echo $this->Form->control('start_date', [
                                        'class' => 'form-control datepicker',
                                        'default' => $startDate
                                    ]);
                                    echo $this->Form->control('end_date', [
                                        'class' => 'form-control datepicker',
                                        'default' => $endDate
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-actions mt10">
                                <input type="submit" value="Find Report" class="btn btn-primary btn-lg">
                            </div>
                        <?= $this->Form->end() ?>
                        <hr />
                        <?php if (!empty($locationId)): ?>
                            <div class="mt20">
                                <!-- Tab Navigation -->
                                <ul class="nav nav-tabs clearfix mb20" id="myTab" role="tablist">
                                    <?php if ($isCallAssist): ?>
                                        <!-- Call Assist clinics should display the Call Concierge Report first -->
                                        <?php if ($showCallAssistReport): ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="call-concierge-tab" data-bs-toggle="tab" data-bs-target="#callConcierge" type="button" role="tab" aria-controls="Call Concierge Reports" aria-selected="true">Call Concierge Reports</button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($showCallTrackingReport): ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="call-tracking-tab" data-bs-toggle="tab" data-bs-target="#callTracking" type="button" role="tab" aria-controls="Call Tracking Reports" aria-selected="true">Call Tracking Reports</button>
                                            </li>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <!-- Non-Call Assist clinics should display Call Tracking Report first -->
                                        <?php if ($showCallTrackingReport): ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="call-tracking-tab" data-bs-toggle="tab" data-bs-target="#callTracking" type="button" role="tab" aria-controls="Call Tracking Reports" aria-selected="true">Call Tracking Reports</button>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($showCallAssistReport): ?>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="call-concierge-tab" data-bs-toggle="tab" data-bs-target="#callConcierge" type="button" role="tab" aria-controls="Call Concierge Reports" aria-selected="true">Call Concierge Reports</button>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($showProfileViews): ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-views-tab" data-bs-toggle="tab" data-bs-target="#profileViews" type="button" role="tab" aria-controls="Profile Views" aria-selected="true">Profile Views</button>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <!-- Call Assist Reports -->
                                    <?php if ($showCallAssistReport): ?>
                                        <div class="tab-pane fade show active" id="callConcierge" role="tabpanel" aria-labelledby="call-concierge-tab">
                                            <h2>Call Concierge - Call Summary Report</h2>
                                            <h3><?php echo $title; ?> (<?php echo $report['start_date']; ?> - <?php echo $report['end_date']; ?>)</h3>
                                            <?php
                                            /* TODO - SAVE AS PDF NOT WORKING YET 
                                            echo $this->Html->link('Save call report as PDF',
                                                array(
                                                    'action' => 'report',
                                                    'ext' => 'pdf',
                                                    '?' => array(
                                                        'username' => $locationId,
                                                        'start' => $startDate,
                                                        'end' => $endDate,
                                                        'callTracking' => false,
                                                    ),
                                                    'testvar' => 'testvarvalue'
                                                ),
                                                array(
                                                    'class' => 'btn btn-default mb10',
                                                    'target' => '_blank'
                                                )
                                            );
                                            */
                                            ?>
                                            <div class="row">
                                                <div class="col col-md-6">
                                                    <table class="table table-bordered table-striped call-report-table">
                                                        <tr>
                                                            <th colspan="2">
                                                                All calls tracked to your clinic &nbsp;
                                                                <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="This includes both connected and missed calls."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td><?php echo $report['all_calls']['total'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">
                                                                Non-prospect calls &nbsp;
                                                                <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Callers who did not indicate that they were potentially in the market to purchase a hearing aid and were passed to your clinic."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td><?php echo $report['non_prospect_calls']['total'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Percent of all calls</td>
                                                            <td><?php echo $report['non_prospect_calls']['percent'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">
                                                                Prospect calls &nbsp;
                                                                <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Callers who indicated that they were potentially in the market to purchase a hearing aid and were passed to your clinic."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td><?php echo $report['prospect_calls']['total'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Percent of all calls</td>
                                                            <td><?php echo $report['prospect_calls']['percent'] ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col col-md-6">
                                                    <table class="table table-bordered table-striped call-report-table">
                                                        <tr>
                                                            <th colspan="2">
                                                                Unknown outcome &nbsp;
                                                                <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Prospects whose calls were passed to your clinic but we do not know the final outcome."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td><?php echo $report['unknown_calls']['total'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">
                                                                Missed opportunities &nbsp;
                                                                <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Prospects who did not schedule an appointment during this call."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td><?php echo $report['missed_opportunity_calls']['total'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Percent of known prospect outcomes<br>
                                                                <small>(Your front office missed opportunity rate)</small>
                                                            </td>
                                                            <td><?php echo $report['missed_opportunity_calls']['percent'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">
                                                                Appointments set &nbsp;
                                                                <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Prospects who scheduled an appointment during this call."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td><?php echo $report['appointment_calls']['total'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Percent of known prospect outcomes<br>
                                                                <small>(Your front office close rate)</small>
                                                            </td>
                                                            <td><?php echo $report['appointment_calls']['percent'] ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php if (isset($calls)): ?>
                                                <hr />
                                                <h2>Call Concierge - <small>Calls</small></h2>
                                                <?php
                                                    $options = array(
                                                        'url' => array(
                                                            $locationId,
                                                            'start_date' => str_replace("/","|",$startDate),
                                                            'end_date' => str_replace("/","|",$endDate),
                                                        )
                                                    );
                                                    $this->Paginator->options($options);
                                                ?>
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <th><?php echo $this->Paginator->sort('create', 'Date') ?></th>
                                                        <th><?php echo $this->Paginator->sort('score', 'Call Result') ?></th>
                                                        <th><?php echo $this->Paginator->sort('caller_name', 'Caller Info') ?></th>
                                                    </tr>
                                                    <?php foreach($calls as $call): ?>
                                                        <tr>
                                                            <td class="center"><?php echo isset($call->ca_calls[0]->start_time) ? $this->Time->nice($call->ca_calls[0]->start_time) : ''; ?></td>
                                                            <td class="center">
                                                                <?php
                                                                $callResult = $this->CaCallGroup->getCallResult($call->id);
                                                                echo $callResult;
                                                                if ($callResult == CaCallGroup::$scores[CaCallGroup::SCORE_TENTATIVE_APPT]) {
                                                                    echo "<br><small>(Please call 732-412-1215 to let us know if this caller set an appointment)</small>";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center"><?php echo $this->CaCallGroup->getCallerInfo($call); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    <?php if(empty($calls)): ?>
                                                        <tr><td colspan="4" class="center">No calls found in this time period.</td></tr>
                                                    <?php endif; ?>
                                                </table>
                                                <?php echo $this->element('pagination', array('options' => $options)); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Call Tracking Reports -->
                                    <?php if ($showCallTrackingReport): ?>
                                        <div class="tab-pane fade" id="callTracking" role="tabpanel" aria-labelledby="call-tracking-tab">
                                            <?php if (isset($csReport)): ?>
                                                <h2>Call Tracking - Call Summary Report</h2>
                                                <h3><?php echo $title; ?> (<?php echo $report['start_date']; ?> - <?php echo $report['end_date']; ?>)</h3>
                                                <?php
                                                /* TODO - SAVE AS PDF NOT WORKING YET
                                                echo $this->Html->link('Save call report as PDF',
                                                    array(
                                                        'action' => 'report',
                                                        'ext' => 'pdf',
                                                        '?' => array(
                                                            'username' => $locationId,
                                                            'start' => $startDate,
                                                            'end' => $endDate,
                                                            'callTracking' => true,
                                                        )
                                                    ),
                                                    array(
                                                        'class' => 'btn btn-default mb10',
                                                        'target' => '_blank'
                                                    )
                                                );
                                                */
                                                ?>
                                                <div class="row">
                                                    <div class="col col-md-6">
                                                        <table class="table table-bordered table-striped call-report-table">
                                                            <tr>
                                                                <th colspan="2">
                                                                    All calls tracked to your clinic &nbsp;
                                                                    <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="This includes both connected and missed calls."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td>Total</td>
                                                                <td><?php echo $csReport['all_calls']['total'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2">
                                                                    Missed calls &nbsp;
                                                                    <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="These resulted in a busy signal, no answer, abandoned call, or very short call."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td>Total</td>
                                                                <td><?php echo $csReport['missed_calls']['total'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Percent of all calls</td>
                                                                <td><?php echo $csReport['missed_calls']['percent'] ?></td>
                                                            </tr>
                                                            <?php if ($isLeadscoreEnabled): ?>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Non-prospect calls &nbsp;
                                                                        <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Callers who did not indicate that they were potentially in the market to purchase a hearing aid and were passed to your clinic."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><?php echo $csReport['non_prospect_calls']['total'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Percent of all calls</td>
                                                                    <td><?php echo $csReport['non_prospect_calls']['percent'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Prospect calls &nbsp;
                                                                        <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Callers who indicated that they were potentially in the market to purchase a hearing aid and were passed to your clinic."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><?php echo $csReport['prospect_calls']['total'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Percent of all calls</td>
                                                                    <td><?php echo $csReport['prospect_calls']['percent'] ?></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </table>
                                                    </div>
                                                    <div class="col col-md-6">
                                                        <table class="table table-bordered table-striped call-report-table">
                                                            <?php if ($isLeadscoreEnabled): ?>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Voicemails and Unknown outcome &nbsp;
                                                                        <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Prospects whose calls were passed to your clinic but we do not know the final outcome."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><?php echo $csReport['unknown_calls']['total'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Missed opportunities &nbsp;
                                                                        <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Prospects who did not schedule an appointment during this call."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><?php echo $csReport['missed_opportunity_calls']['total'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Percent of known prospect outcomes<br>
                                                                        <small>(Your front office missed opportunity rate)</small>
                                                                    </td>
                                                                    <td><?php echo $csReport['missed_opportunity_calls']['percent'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Appointments set &nbsp;
                                                                        <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Prospects who scheduled an appointment during this call."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><?php echo $csReport['appointment_calls']['total'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Percent of known prospect outcomes<br>
                                                                        <small>(Your front office close rate)</small>
                                                                    </td>
                                                                    <td><?php echo $csReport['appointment_calls']['percent'] ?></td>
                                                                </tr>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Non-prospect calls &nbsp;
                                                                        <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Callers who did not indicate that they were potentially in the market to purchase a hearing aid and were passed to your clinic."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><?php echo $csReport['non_prospect_calls']['total'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Percent of all calls</td>
                                                                    <td><?php echo $csReport['non_prospect_calls']['percent'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Prospect calls &nbsp;
                                                                        <a data-toggle="popover" data-trigger="hover" data-container="body" data-placement="right" data-content="Callers who indicated that they were potentially in the market to purchase a hearing aid and were passed to your clinic."><span class="glyphicon glyphicon-question-sign"></span></a>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><?php echo $csReport['prospect_calls']['total'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Percent of all calls</td>
                                                                    <td><?php echo $csReport['prospect_calls']['percent'] ?></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <?php if (Configure::read('isTieringEnabled') && ($listingType == Location::LISTING_TYPE_BASIC)): ?>
                                                    <section class="panel p20">
                                                        Upgrade your profile to have our Call Concierge team connect callers with your front office, and track how many of your prospect calls resulted in appointments set vs missed opportunities.<br><br>
                                                        <a href="/clinic/pages/faq#upgrades" target="_blank" class="btn btn-light is-basic">Learn how to upgrade</a>
                                                    </section>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (isset($csCalls)): ?>
                                                <hr />
                                                <h2>Call Tracking - <small>Calls</small></h2>
                                                <?php
                                                    $options = array(
                                                        'url' => array(
                                                            $locationId,
                                                            'start_date' => str_replace("/","|",$startDate),
                                                            'end_date' => str_replace("/","|",$endDate),
                                                        )
                                                    );
                                                    $this->Paginator->options($options);
                                                ?>
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <th><?php echo $this->Paginator->sort('CsCall.start_time', 'Date') ?></th>
                                                        <th><?php echo $this->Paginator->sort('CsCall.prospect', 'Call Result') ?></th>
                                                        <th><?php echo $this->Paginator->sort('CsCall.caller_lastname', 'Caller Info') ?></th>
                                                    </tr>
                                                    <?php foreach($csCalls as $call):   ?>
                                                        <tr>
                                                            <td class="center"><?php echo $this->Time->nice($call['CsCall']['start_time']); ?></td>
                                                            <td class="center">
                                                                <?php
                                                                switch ($call['CsCall']['prospect']) {
                                                                    case CsCall::PROSPECT_UNKNOWN:
                                                                        echo "Missed call";
                                                                        break;
                                                                    case CsCall::PROSPECT_NO:
                                                                        echo "Non-prospect";
                                                                        break;
                                                                    case CsCall::PROSPECT_YES:
                                                                        if ($isLeadscoreEnabled) {
                                                                            switch ($call['CsCall']['leadscore']) {
                                                                                case CsCall::LEADSCORE_APPT_SET:
                                                                                    echo "Prospect - Appointment Set";
                                                                                    break;
                                                                                case CsCall::LEADSCORE_MISSED_OPPORTUNITY:
                                                                                    echo "Prospect - Missed Opportunity";
                                                                                    break;
                                                                                default:
                                                                                    echo "Prospect - unknown outcome";
                                                                                    break;
                                                                            }
                                                                        } else {
                                                                            echo "Prospect";
                                                                            break;
                                                                        }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php echo $call['CsCall']['caller_firstname'].' '.$call['CsCall']['caller_lastname'].'<br>'; ?>
                                                                <?php echo formatNumber($call['CsCall']['caller_phone']); ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    <?php if (empty($csCalls)): ?>
                                                        <tr><td colspan="4" class="center">No calls found in this time period.</td></tr>
                                                    <?php endif; ?>
                                                </table>
                                                <p class="text-primary text-small text-uppercase">
                                                    <strong>
                                                        <?php echo count($csCalls).' of '.count($csCalls).' Results'; ?>
                                                    </strong>
                                                    <?php if (count($csCalls) < count($csCalls)): ?>
                                                        <?php
                                                            echo ' - ';
                                                            $url = router::url([
                                                                'action' => 'legacy_report',
                                                                'clinic' => true,
                                                                '?' => [
                                                                    'start' => date('Y-m-d', strtotime($startDate)),
                                                                    'end' => date('Y-m-d', strtotime($endDate)),
                                                                    'id' => $locationId
                                                                ]
                                                            ]);
                                                        ?>
                                                        <a href=<?php echo $url; ?> target="_blank">View more results</a>
                                                    <?php endif; ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Profile views chart -->
                                    <?php if ($showProfileViews): ?>
                                        <div class="tab-pane fade" id="profileViews" role="tabpanel" aria-labelledby="profile-views-tab">
                                            <p class="ml40 mr40 p10 bg-info text-center text-primary">
                                                <strong>As of summer 2023, your Healthy Hearing profile's traffic data is being pulled from an updated version of Google Analytics (G4) and our site began allowing users to opt out of tracking. We can only collect and share page views from users who were opted in to tracking. These changes may affect your previous results.</strong>
                                            </p>
                                            <canvas id="profileViewsChart" width="400" height="200"></canvas>
                                            <script>
                                                var chartElement = document.getElementById('profileViewsChart');
                                                var profileViewsChart = new Chart(chartElement, {
                                                    type: 'bar',
                                                    data: {
                                                        datasets: [{
                                                            fill: false,
                                                            backgroundColor: "orange",
                                                            borderColor: "orange",
                                                            borderWidth: 5,
                                                            data: timeSeriesData
                                                        }]
                                                    },
                                                    options: {
                                                        plugins: {
                                                            title: {
                                                                display: true,
                                                                text: 'My Healthy Hearing profile views',
                                                                font: {
                                                                    size: 16,
                                                                    weight: "bold"
                                                                }
                                                            },
                                                            subtitle: {
                                                                display: true,
                                                                text: locationURL,
                                                                padding: {
                                                                    bottom: 10
                                                                }
                                                            },
                                                            legend: {
                                                                display: false
                                                            },
                                                            tooltip: {
                                                                displayColors: false,
                                                                backgroundColor: "gray",
                                                                callbacks: {
                                                                    label: tooltipItem => tooltipItem.formattedValue + " profile views"
                                                                }
                                                            }
                                                        },
                                                        scales: {
                                                            x: {
                                                                title: {
                                                                    display: true,
                                                                    text: "Month",
                                                                    font: {
                                                                        size: 14,
                                                                        weight: "bold"
                                                                    }
                                                                },
                                                                type: 'time',
                                                                time: {
                                                                    unit: 'month',
                                                                    tooltipFormat: 'MMMM YYYY'
                                                                },
                                                                grid: {
                                                                    color: "lightskyblue"
                                                                }
                                                            },
                                                            y: {
                                                                beginAtZero: true,
                                                                grace: '10%',
                                                                title: {
                                                                    display: true,
                                                                    text: "Profile Views",
                                                                    font: {
                                                                        size: 14,
                                                                        weight: "bold"
                                                                    }
                                                                },
                                                                grid: {
                                                                    color: "lightskyblue"
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                            </script>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
    </div>
</div>
