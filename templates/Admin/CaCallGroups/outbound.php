<?php
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\CaCall;
use Cake\Routing\Router;

echo $this->element('ca_calls/ca_call_js_variables');
$this->Html->script('dist/ca_outbound.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="clear"></div>
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
								<h2>Outbound Calls</h2>
								<div class="caCallGroups index content">
								    <?= $this->element('pagination') ?>
									<div class = "btn-toolbar">
										<?= $this->Form->create(null, [
										    'url' => [
										        'controller' => 'CaCallGroups',
										        'action' => 'outbound',
										    ],
										    'id' => 'OutboundCallsForm'
										]); ?>
											<?php echo $this->Form->hidden('status', ['id' => 'CaCallGroupStatus']); ?>
											<?php echo $this->Form->hidden('score', ['id' => 'CaCallGroupScore']); ?>
											<?php echo $this->Form->hidden('is_appt_request_form', ['id' => 'CaCallGroupIsApptRequestForm']); ?>
											<?php if ($isCallSupervisor): ?>
												<button type="submit" class="btn btn-default btn-xs" id="followupNoAnswerBtn"><i class="bi bi-circle-fill orange"></i> <?php echo 'Supervisor'; ?></button>
												<hr class='mt5 mb10'>
											<?php endif; ?>
											<button type="submit" class="btn btn-default btn-xs" id="vmCallbackBtn"><i class="bi bi-circle-fill pink"></i> <?php echo 'Voicemails'; ?></button>
											<button type="submit" class="btn btn-default btn-xs" id="followupApptRequestBtn"><i class="bi bi-circle-fill lavender"></i> <?php echo 'Followup - Appt Request Form'; ?></button>
											<button type="submit" class="btn btn-default btn-xs" id="clinicFollowupBtn"><i class="bi bi-circle-fill yellow"></i> <?php echo 'Followup - Set Appt'; ?></button>
											<button type="submit" class="btn btn-default btn-xs" id="followupTentativeBtn"><i class="bi bi-circle-fill ivory"></i> <?php echo 'Followup - Verify Tentative Appt'; ?></button>
											<div class="well admin-filter-well">
												<div class="row">
													<div class="col-md-12">
														<?php
														$timezones = ['Eastern', 'Central', 'Mountain', 'Pacific', 'Alaska', 'Hawaii'];
														$tzFilter = $this->request->getData('tzFilter');
														foreach ($timezones as $timezone) {
															$checked = isset($tzFilter[$timezone]) ? $tzFilter[$timezone] : false;
															echo $this->Form->control('tzFilter.'.$timezone, [
																'type' => 'checkbox',
																'inline' => true,
																'label' => $timezone,
																'checked' => $checked,
                                                                'allowEmpty' => true,
                                                                'required' => false,
																'class' => 'timezoneFilter'
															]);
														}
														?>
													</div>
												</div>
											</div>
                                            <?php if (!empty($this->request->getData())) : ?>
                                                <div class="col col-md-auto p-0">
                                                    Showing search results.
                                                    <?= $this->Html->link('Clear Search', ['?'=>''], ['role' => 'button']) ?>
                                                </div>
                                            <?php endif; ?>
										</form>
									</div>
								    <div class="table-responsive">
								        <table class="table table-bordered table-condensed mt20">
								            <thead>
								                <tr>
								                    <th><?= $this->Paginator->sort('id', 'Group ID') ?></th>
								                    <th><?= $this->Paginator->sort('status', 'Outbound call type') ?></th>
								                    <th><?php echo 'Initial call ('.getEasternTimezone().')'; ?></th>
								                    <th><?php echo $this->Paginator->sort('scheduled_call_date','Next call time ('.getEasternTimezone().')'); ?></th>
								                    <th>Clinic</th>
								                    <th nowrap>Caller Name/<br>Patient Name</th>
								                    <th>Actions</th>
								                </tr>
								            </thead>
								            <tbody>
								                <?php foreach ($caCallGroups as $caCallGroup): ?>
                                                    <?php
                                                    $class = '';
                                                    $supervisorCall = false;
                                                    $callType = $this->CaCallGroup->getCallTypeByStatus($caCallGroup->status, $caCallGroup->score, $caCallGroup->location->direct_book_type, $caCallGroup->wants_hearing_test);
                                                    $readableCallType = $this->CaCallGroup->getReadableCallType($callType, $caCallGroup->status);
                                                    switch ($callType) {
                                                        case null:
                                                            if (in_array($caCallGroup->status, [CaCallGroup::STATUS_VM_NEEDS_CALLBACK, CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED])) {
                                                                $class = 'red-bg';
                                                            }
                                                            break;
                                                        case CaCall::CALL_TYPE_FOLLOWUP_NO_ANSWER:
                                                            $class = 'orange-bg';
                                                            $supervisorCall = true;
                                                            break;
                                                        case CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST:
                                                        case CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT:
                                                            $class = 'lavender-bg';
                                                            break;
                                                        case CaCall::CALL_TYPE_FOLLOWUP_APPT:
                                                            $class = 'beige-bg';
                                                            break;
                                                        case CaCall::CALL_TYPE_FOLLOWUP_TENTATIVE_APPT:
                                                            $class = 'ivory-bg';
                                                            break;
                                                        case CaCall::CALL_TYPE_SURVEY_DIRECT:
                                                            $class = 'purple-bg';
                                                            break;
                                                        case CaCall::CALL_TYPE_OUTBOUND_CLINIC:
                                                            $class = 'lt-blue-bg';
                                                            break;
                                                        case CaCall::CALL_TYPE_OUTBOUND_CALLER:
                                                            $class = 'green-bg';
                                                            break;
                                                    }
                                                    ?>
								                    <tr class='<?= $class ?>'>
								                        <td><?= $caCallGroup->id ?></td>
								                        <td><?php echo $readableCallType; ?></td>
                                                        <td>
                                                            <?php echo date('M d,', strtotime($caCallGroup->ca_calls[0]->start_time)); ?><br>
                                                            <?php echo date('g:i a', strtotime($caCallGroup->ca_calls[0]->start_time)); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo date('M d,', strtotime($caCallGroup->scheduled_call_date)); ?><br>
                                                            <?php echo date('g:i a', strtotime($caCallGroup->scheduled_call_date)); ?>
                                                        </td>
								                        <td>
                                                            <?php
                                                            if (!empty($caCallGroup->location_id)) {
                                                                if (!empty($caCallGroup->location->title)) {
                                                                    echo $this->Html->link($caCallGroup->location->title, ['controller' => 'locations', 'action' => 'edit', $caCallGroup->location_id]).'<br>';
                                                                    echo $caCallGroup->location->city.', '.$caCallGroup->location->state.'<br>';
                                                                    echo '<span class="label label-default">'.$this->Clinic->getClinicTimezone($caCallGroup->location_id).'</span>';
                                                                } else {
                                                                    echo "<span class='error'>ERROR:</span> Location ".$caCallGroup->location_id." no longer exists. Please notify supervisor.";
                                                                }
                                                            }
                                                            ?>
								                        </td>
								                        <td>
                                                            <?php echo $caCallGroup->caller_first_name.' '.$caCallGroup->caller_last_name; ?><br>
                                                            <?php echo $caCallGroup->patient_first_name.' '.$caCallGroup->patient_last_name; ?>
                                                        </td>
								                        <td class="p5" nowrap>
                                                            <?php if ($caCallGroup->is_locked): ?>
                                                                <span class="glyphicon glyphicon-lock"></span> Locked by <?php echo $this->App->getUserFirstName($caCallGroup->locked_by_user_id); ?><br/>
                                                                <?php echo date('M d, g:i a', strtotime($caCallGroup->lock_time.' +1hour')); ?><br/>
                                                                <?php if ($caCallGroup->locked_by_user_id == $user->id): ?>
                                                                    <?php echo $this->Html->link('Call', ['controller'=>'ca_calls', 'action'=>'add_outbound', $caCallGroup->id], ['class' => 'btn btn-default btn-sm']); ?>
                                                                <?php endif; ?>
                                                                <?php if (($caCallGroup->locked_by_user_id == $user->id) || ($isAdmin || $isCallSupervisor)): ?>
                                                                    <?php echo $this->Html->link('Unlock', ['action' => 'unlock', $caCallGroup->id], ['class' => 'btn btn-default btn-sm', 'rel' => 'nofollow']); ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <?php $showCallBtn = true; ?>
                                                                <?php if ($supervisorCall): ?>
                                                                    <?php $showCallBtn = $isCallSupervisor; ?>
                                                                    <span class="glyphicon glyphicon-asterisk"></span> Supervisor call<br/>
                                                                <?php endif; ?>
                                                                <?php if ($showCallBtn): ?>
                                                                    <?php echo $this->Html->link('Lock and Call', ['controller'=>'ca_calls', 'action' => 'add_outbound', $caCallGroup->id], ['class' => 'btn btn-default']); ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
								                        </td>
								                    </tr>
								                <?php endforeach; ?>
								            </tbody>
								        </table>
								    </div>
								    <?= $this->element('pagination') ?>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
