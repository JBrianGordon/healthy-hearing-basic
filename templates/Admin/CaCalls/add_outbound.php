<?php
use App\Model\Entity\CaCall;
use App\Model\Entity\CaCallGroup;
use App\Model\Entity\Location;
use Cake\Core\Configure;
echo $this->element('ca_calls/ca_call_js_variables');
$this->Vite->script('admin_add_outbound','admin-vite');
?>
<style>
	.popover {
		max-width: 80%;
	}
</style>
<?php
if (isset($caCall->user_id)) {
	$agentName = $this->App->getUserName($caCall->user_id);
}
$previousCalls = empty($previousCalls) ? [] : $previousCalls;
$id = empty($caCall->id) ? "" : $caCall->id;
$groupId = empty($caCall->ca_call_group_id) ? "" : $caCall->ca_call_group_id;
$caCallGroup = $caCall->ca_call_group;
$directBookType = isset($directBookType) ? $directBookType : Location::DIRECT_BOOK_NONE;
$status = empty($caCallGroup->status) ? CaCallGroup::STATUS_NEW : $caCallGroup->status;
$isVoicemailCallback = in_array($status, [CaCallGroup::STATUS_VM_NEEDS_CALLBACK, CaCallGroup::STATUS_VM_CALLBACK_ATTEMPTED]);
$callType = isset($caCall->call_type) ? $caCall->call_type : '';
$isProspect = isset($caCallGroup->prospect) ? ($caCallGroup->prospect == CaCallGroup::PROSPECT_YES) : true;
$callerName = trim($caCallGroup->caller_first_name).' '.trim($caCallGroup->caller_last_name);
if (!empty($caCallGroup->is_patient)) {
	$isPatient = true;
	$patientName = $callerName;
} else {
	$isPatient = false;
	$patientName = trim($caCallGroup->patient_first_name).' '.trim($caCallGroup->patient_last_name);
}
$noteCount = isset($caCallGroup->ca_call_group_notes) ? count($caCallGroup->ca_call_group_notes) : 0;
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Ca Calls Actions</div>
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
				<h2>New Outbound Call</h2>
				<div class="caCallGroups index content">
					<div class = "btn-toolbar">
						<?= $this->Form->create($caCall, ['id' => 'CaCallForm', 'class' => 'w-100']) ?>
							<?php
							echo $this->Form->hidden('id', ['id' => true]);
							echo $this->Form->hidden('ca_call_group_id', ['id' => true]);
							echo $this->Form->hidden('start_time', ['id' => true]);
							echo $this->Form->hidden('user_id', ['id' => true]);
							echo $this->Form->hidden('call_type', ['id' => true]);
							echo $this->Form->hidden('ca_call_group.id', ['id' => true]);
							echo $this->Form->hidden('ca_call_group.location_id', ['id' => true]);
							echo $this->Form->hidden('ca_call_group.status', ['id' => true]);
							echo $this->Form->hidden('ca_call_group.clinic_followup_count', ['id' => true]);
							echo $this->Form->hidden('ca_call_group.patient_followup_count', ['id' => true]);
							echo $this->Form->hidden('ca_call_group.vm_outbound_count', ['id' => true]);
							echo $this->Form->hidden('ca_call_group.original_group_id', ['value'=>$groupId]);
							echo $this->Form->hidden('ca_call_group.directBookType', ['value'=>$directBookType]);
							echo $this->Form->hidden('ca_call_group.is_spam', ['id' => true]);
							if (!$isVoicemailCallback && !in_array($callType, [CaCall::CALL_TYPE_FOLLOWUP_APPT, CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST, CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT, CaCall::CALL_TYPE_FOLLOWUP_TENTATIVE_APPT])) {
								echo $this->Form->hidden('CaCallGroup.prospect');
							}
							?>
							<table class="table table-striped table-bordered">
								<tr><th class="w-100 tar">Call ID</th>
									<td class="w-100">
										<?= $id ?>
									</td>
								</tr>
								<tr><th class="w-100 tar">Group ID</th>
									<td class="w-100">
										<span class="callGroupId"><?= $this->Html->link($groupId, ['controller' => 'ca_call_groups', 'action' => 'edit', $groupId]) ?></span>
									</td>
								</tr>
								<tr><th class="w-100 tar">Status</th>
									<td class="w-100">
										<span class="status"><?= CaCallGroup::$statuses[$status] ?></span>
									</td>
								</tr>
								<tr><th class="w-100 tar">Call Type</th>
									<td class="w-100">
										<span class="callType"><?= empty($callType) ? '' : CaCall::$callTypes[$callType] ?></span>
									</td>
								</tr>
								<?php if (isset($caCall->start_time)): ?>
									<tr><th class="w-100 tar">Start Time</th>
										<td class="w-100">
											<?= dateTimeEastern($caCall->start_time) ?>
										</td>
									</tr>
								<?php endif; ?>
								<?php if (!empty($caCall->duration)): ?>
									<tr><th class="w-100 tar">Duration</th>
										<td class="w-100">
											<?= gmdate('H:i:s', $caCall->duration) ?>
										</td>
									</tr>
								<?php endif; ?>
								<?php if (!empty($agentName)): ?>
									<tr><th class="w-100 tar">Agent</th>
										<td class="w-100">
											<?= $agentName ?>
										</td>
									</tr>
								<?php endif; ?>
								<tr><th class="tar">Calls</th>
									<td>
										<table class="table table-bordered table-condensed">
											<tr>
												<th class="p5">ID</th>
												<th class="p5">Call time</th>
												<th class="p5">Duration</th>
												<th class="p5">Agent</th>
												<th class="p5">Call type</th>
											</tr>
											<?php foreach ($previousCalls as $call): ?>
												<tr>
													<td class="p5"><?= $call->id ?></td>
													<td class="p5" style="min-width:220px"><?= dateTimeEastern($call->start_time) ?></td>
													<td class="p5"><?= gmdate("H:i:s", $call->duration) ?></td>
													<td class="p5" style="min-width:190px"><?= $this->App->getUserName($call->user_id) ?></td>
													<td class="p5" style="min-width:190px">
														<?php
														if (isset($call->call_type)) {
															echo empty($call->call_type) ? "" : CaCall::$callTypes[$call->call_type];
														}
														?>
													</td>
												</tr>
											<?php endforeach; ?>
										</table>
									</td>
								</tr>
								<tr><th class="tar">Notes</th>
									<td>
										<div class="notes border-0">
											<?php
											for ($i = 0; $i < $noteCount; $i++) {
												echo $this->element('ca_calls/note', ['note' => $caCallGroup->ca_call_group_notes[$i]]);
											}
											?>
										</div>
									</td>
								</tr>
								<tr><th class="w-100 tar">Clinic</th>
									<td class="w-100" id="clinic-data">
										<div class="row">
											<div class="col-md-8">
												<span class="locationLink"></span><br>
												<span class="locationAddress"></span><br>
												<span class="locationPhone"></span><br>
												<span class="locationMessage"></span><br>
												<strong><span class="locationLandmarks"></span></strong>
											</div>
											<div class="col-md-4">
												<span class="locationHours small"></span>
											</div>
										</div>
									</td>
								</tr>
							</table>

							<div class="form_fields">
								<?php if ($isVoicemailCallback): ?>
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											Voicemail from <strong><?= formatPhoneNumber($caCallGroup->caller_phone) ?></strong> at <strong><?= $this->Clinic->getClinicDateTime($caCallGroup->location_id, $voicemailTime) ?></strong><br>
											Listen carefully to the <strong>entire</strong> recording.
										</div>
									</div>
									<?php if (strpos($_SERVER["HTTP_USER_AGENT"], 'Trident') !== false): ?>
										<div class="alert alert-danger">
											Wav file playback not supported in IE. Please open this page in a different browser.
										</div>
									<?php endif; ?>
									<div class="form-group">
										<label class="col col-md-3 control-label">Play voicemail</label>
										<div class="col-md-9 pt10">
											<div class="player">
												<?php
												if ($recordingUrl != 'Expired' && $recordingUrl != 'N/A') {
													echo $this->element('play_media', ['media' => [
														'url' => $recordingUrl,
														'id' => $id,
														'duration' => $recordingDuration
													]]);
												} else {
													echo $recordingUrl;
												}
												?>
											</div>
										</div>
									</div>
									<?php
									// Call Type will be determined based on who the voicemail was from
									$vmFromOptions = [
										CaCall::CALL_TYPE_VM_CALLBACK_CONSUMER => 'Consumer',
										CaCall::CALL_TYPE_VM_CALLBACK_CLINIC   => 'Clinic',
										CaCall::CALL_TYPE_VM_CALLBACK_INVALID  => 'N/A'
									];
									echo $this->Form->control('ca_call_group.voicemail_from', [
										'label' => 'Call is from?',
										'type' => 'select',
										'options' => $vmFromOptions,
										'empty' => 'Select One',
										'required' => true
									]);
									?>
									<div id="return_vm_ajax_form hidden">

									</div>
									<div id="return_vm_from_invalid hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												No outbound call needed. Please add a note and save.
											</div>
										</div>
										<?php
										echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
											'label' => 'Add a note',
											'rows' => 3,
											'required' => false,
										]);
										?>
									</div>
								<?php endif; ?>
								<?php if (in_array($callType, [CaCall::CALL_TYPE_FOLLOWUP_APPT, CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST])): ?>
									<?php $isFollowupApptRequest = ($callType == CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST); ?>
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<div class="well blue-well">
												<i class="text-muted">
													Appointment requested by <strong><?= $callerName ?></strong>
													<?php if (!$isPatient): ?>
														on behalf of <strong><?= $patientName ?></strong>
													<?php endif; ?>
													<br>
													Caller phone: <?= formatPhoneNumber($caCallGroup->caller_phone) ?><br>
													Topic: <span class='callerTopics'></span>
												</i><br><br>
												<i class="text-muted bold-number">[Call clinic: <span class="locationPhone"></span>]</i>
											</div>
										</div>
									</div>
									<?php
									echo $this->Form->control('ca_call_group.did_they_answer_followup', [
										'options' => ['yes'=>'Yes', 'no'=>'No', 'vm'=>'No, but leave voicemail'],
										'empty' => 'Select One',
										'label' => 'Did clinic answer?',
										'required' => true
									]);
									?>
									<div class="didTheyAnswerFollowupYes hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													Hello, this is <?= $user['first_name'] ?> from Healthy Hearing. This call is being recorded for quality assurance. I'm calling because we received a
													<?php if ($isFollowupApptRequest): ?>
														request form
													<?php else: ?>
														call
													<?php endif; ?>
													from a prospective patient who asked for an appointment with your clinic.<br>
													First, can I get your name?
												</div>
											</div>
										</div>
										<?= $this->Form->control('ca_call_group.front_desk_name', ['autocomplete' => 'off']) ?>
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													Thanks <strong><span class="frontDeskName"></span></strong>. Are you ready to take their information?<br>
													<i class="text-muted">[when yes]</i><br>
													<?php if ($isFollowupApptRequest): ?>
														This is the information they submitted to us:
													<?php endif; ?>
													Their name is <strong><span class="callerFirstName"></span> <span class="callerLastName"></span></strong>.
													<span class="isNotPatient hidden">
														They are requesting an appointment on behalf of <strong><span class="patientName"></span></strong>.
													</span>
													<?php if ($isFollowupApptRequest): ?>
														The number they gave us is
													<?php else: ?>
														Their number is
													<?php endif; ?>
													<strong><span class="callerPhone"><?= formatPhoneNumber($caCallGroup->caller_phone) ?></span></strong> and their main reason for calling is <strong><span class="callerTopics"></span></strong>.<br>
													Okay, thank you. I will see if I can reach them to conference them in with us in a minute. Before I do that,
													can you please note in your system that this referral is from Healthy Hearing, as part of your paid membership.<br>
													Okay, I'll try to add <strong><span class="callerFirstName"></span></strong> to the line now.<br><br>
													<i class="text-muted bold-number">[Call consumer: <span class="callerPhone"><?= formatPhoneNumber($caCallGroup->caller_phone) ?></span>]</i><br>
													Hi. May I speak with <strong><span class="callerFirstName"></span></strong>?<br>
													<i class="text-muted">[wait for consumer]</i><br>
												</div>
											</div>
										</div>
										<?= $this->Form->control('ca_call_group.did_consumer_answer', [
											'options' => ['yes'=>'Yes', 'no'=>'No', 'invalid'=>'Invalid/disconnected phone number'],
											'empty' => 'Select One',
											'label' => 'Did consumer answer?',
											'required' => true
										]) ?>
										<div class="didConsumerAnswerYes hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														<i class="text-muted">[Conference in consumer and clinic]</i><br>
														Hi <strong><span class="callerFirstName"></span></strong>. This is <?= $user['first_name'] ?> from Healthy Hearing. This call is being recorded for quality assurance.
														<?php if ($isFollowupApptRequest): ?>
															You filled out an appointment request form
														<?php else: ?>
															You called
														<?php endif; ?>
														for an appointment with <strong><span class="locationTitle"></span></strong>. I have <strong><span class="frontDeskName"></span></strong> from that clinic on the line to assist you with your request.
														You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br><br>
														<i class="text-muted">[Mute and listen to appointment info. Update score below.]</i>
													</div>
												</div>
											</div>
										</div>
										<div class="didConsumerAnswerNo hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well mb0">
														<i class="text-muted">[Leave a voicemail for consumer (if possible)]</i><br>
														Hi <strong><span class="callerFirstName"></span></strong>. This is <?= $user['first_name'] ?> from Healthy Hearing.
														<?php if ($isFollowupApptRequest): ?>
															You filled out an appointment request form
														<?php else: ?>
															You called
														<?php endif; ?>
														for an appointment with <strong><span class="locationTitle"></span></strong>. I tried calling you today, <?= date('F d') ?>, to connect you with them to set an appointment. Please call them back at <strong><span class="locationPhone"></span></strong>. Thank you.<br><br>
														<i class="text-muted">[Return to clinic]</i><br />
														Thank you for holding, I was unable to reach <strong><span class="callerFirstName"></span></strong> at the number they left us. Please call <strong><span class="callerFirstName"></span></strong> directly to set up an appointment as soon as you can.<br>
														<i class="text-muted">[Give patient info again if needed.]</i><br>
														<?php if ($isProspect): ?>
															Please call us back at 732-412-1215 to verify that you've reached this prospective patient. Thank you.<br><br>
															<i class="text-muted">[Score as 'Tentative appointment'.]</i>
														<?php else: ?>
															Have a great day.
														<?php endif; ?>
													</div>
												</div>
											</div>
											<?= $this->Form->control('ca_call_group.didClinicRefuse', [
												'type' => 'checkbox',
												'label' => 'Clinic refused to take patient data',
												'style' => 'margin-left:23%;'
											]) ?>
											<div class="didClinicRefuseYes hidden">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<div class="well blue-well">
															Ok, we have given the prospective patient your number and we hope that they call you directly. Thank you.<br><br>
															<i class="text-muted">[Score as 'Clinic missed opportunity' and 'Needs supervisor review'.]</i><br>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="didConsumerAnswerInvalid hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														<i class="text-muted">[Return to clinic]</i><br />
														Thank you for holding. The phone number provided by <strong><span class="callerFirstName"></span></strong> appears to be out of order. I'm sorry for the inconvenience. Have a great day!<br><br>
														<i class="text-muted">[Score as 'Caller disconnected'.]</i><br>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="didTheyAnswerFollowupVm hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													<i class="text-muted">[Leave a voicemail]</i><br />
													<?php if ($isProspect): ?>
														This is <?= $user['first_name'] ?> with Healthy Hearing. We tried to reach you today, <?= date('F d'); ?> at <span class="locationCurrentTime"></span> because we had a consumer trying to reach you to set an appointment.
														Their name is <strong><span class="callerFirstName"></span></strong> <strong><span class="callerLastName"></span></strong>. That spelling is <i class="text-muted">[spell caller first name, caller last name]</i>.
														Their phone number is <strong><span class="callerPhone"></span></strong> and their main reason for calling is <strong><span class="callerTopics"></span></strong>.
														Please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Please call us back at 732-412-1215 to verify that you've reached the consumer. Thank you.<br><br>
														<i class="text-muted">[Score as 'Tentative appointment'.]</i>
													<?php else: ?>
														This is <?= $user['first_name'] ?> from Healthy Hearing. We got a request for an appointment from <strong><span class="callerFirstName"></span></strong> <strong><span class="callerLastName"></span></strong>. They wanted an appointment for <strong><span class="callerTopics"></span></strong>. Please call them back directly at <strong><span class="callerPhone"></span></strong>. Thank you.
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="followupForm hidden">
										<?= $this->element('ca_calls/outbound_followup_script') ?>
									</div>
									<div class="scheduled_call_date hidden">
										<?= $this->Form->control('ca_call_group.scheduled_call_date', [
											'class' => 'form-control datepicker inline-date',
											'label' => 'Next attempt to reach clinic ('.getEasternTimezone().')',
											'interval' => 15,
											'minYear' => '2016',
											'maxYear' => date("Y", strtotime('+2 years')),
										]) ?>
									</div>
									<?php
									echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
										'label' => 'Add a note',
										'rows' => 3,
										'required' => false,
									]);
									echo $this->Form->control('ca_call_group.is_review_needed', [
										'label' => [
											'class' => 'control-label',
											'text' => 'Needs supervisor review'],
											'style' => 'margin-left:23%;'
									]);
									?>
								<?php endif; ?>
								<?php if ($callType == CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST_DIRECT): ?>
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<div class="well green-well">
												<i class="text-muted">Login to direct booking system to set an appointment for this consumer.<br>
												Name: <strong><?= $callerName ?></strong><br>
												<?php if (!$isPatient): ?>
													Patient name: <strong><?= $patientName ?></strong><br>
												<?php endif; ?>
												Phone: <strong><?= formatPhoneNumber($caCallGroup->caller_phone) ?></strong><br>
												Email: <strong><?= $caCallGroup->email ?></strong><br>
												<br>
												<a href="http://dm.us.atlas.demant.com/usretail/contact" target="_blank" rel="noopener">http://dm.us.atlas.demant.com/usretail/contact</a>
												</i><br><br>
												<i class="text-muted bold-number">[Call consumer: <span class="callerPhone"><?= formatPhoneNumber($caCallGroup->caller_phone) ?></span>]</i><br>
												Hi. May I speak with <strong><span class="callerFirstName"></span></strong>?<br>
												<i class="text-muted">[wait for consumer]</i><br>
											</div>
										</div>
									</div>
									<?= $this->Form->control('ca_call_group.did_consumer_answer', [
										'options' => ['yes'=>'Yes', 'no'=>'No', 'invalid'=>'Invalid/disconnected phone number'],
										'empty' => 'Select One',
										'label' => 'Did consumer answer?',
										'required' => true
									]) ?>
									<div class="didConsumerAnswerYes hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well green-well">
													Hi <strong><span class="callerFirstName"></span></strong>. This is <?= $user['first_name'] ?> from Healthy Hearing. This call is being recorded for quality assurance. You filled out an appointment request form for an appointment with <strong><span class="locationTitle"></span></strong>. I would be happy to help you set that appointment.<br><br>
													This appointment is for a hearing test, correct?
												</div>
											</div>
										</div>
										<?php
										echo $this->Form->control('ca_call_group.wants_hearing_test', [
											'label' => 'Hearing test?',
											'type' => 'select',
											'options' => [
												0 => 'No',
												1 => 'Yes',
											],
											'default' => 1
										]);
										?>
										<div class="directBook hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well green-well">
														<i class="text-muted">[Schedule appointment and update score below.]</i>
													</div>
												</div>
											</div>
										</div>
										<div class="nonDirectBook hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Okay. Please hold briefly while I get the appointment desk on the phone.<br><br>
														<i class="text-muted bold-number">[Call clinic at <span class="locationPhone"></span>]</i>
													</div>
												</div>
												<?php
												echo $this->Form->control('ca_call_group.did_they_answer_followup', [
													'options' => ['yes'=>'Yes', 'no'=>'No', 'vm'=>'No, but leave voicemail'],
													'empty' => 'Select One',
													'label' => 'Did clinic answer?',
													'required' => true
												]);
												?>
												<div class="didTheyAnswerFollowupYes hidden">
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<div class="well blue-well">
																Hello, this is <?= $user['first_name'] ?> from Healthy Hearing. This call is being recorded for quality assurance. I'm calling because I have a prospective patient who is trying to reach your clinic to make an appointment. First, can I get your name?
															</div>
														</div>
													</div>
													<?= $this->Form->control('ca_call_group.front_desk_name', ['autocomplete' => 'off']) ?>
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<div class="well blue-well">
																Thanks <strong><span class="frontDeskName"></span></strong>. Are you ready to take their information?<br>
																<i class="text-muted">[when yes]</i><br>
																Their name is <strong><span class="callerFirstName"></span> <span class="callerLastName"></span></strong>.
																<span class="isNotPatient hidden">
																	They are calling on behalf of <strong><span class="patientName"></span></strong>.
																</span>
																Their number is <strong><span class="callerPhone"><?= formatPhoneNumber($caCallGroup->caller_phone) ?></span></strong> and their main reason for calling is <strong><span class="callerTopics"></span></strong>.<br>
																Okay, thank you. I will conference them in with us in a minute. Before I bring them in, can you please note in your system that this referral is from Healthy Hearing, as part of your paid membership.<br>
																Okay, I'll add <strong><span class="callerFirstName"></span></strong> to the line now.<br><br>
																<i class="text-muted">[Conference in consumer and clinic]</i>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<div class="well blue-well">
																Okay <strong><span class="callerFirstName"></span></strong>. I have <strong><span class="frontDeskName"></span></strong> on the line from <strong><span class="locationTitle"></span></strong>.
																You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br><br>
																<i class="text-muted">[Mute and listen to appointment info. Update score below.]</i>
															</div>
														</div>
													</div>
												</div>
												<div class="didTheyAnswerFollowupNo hidden">
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<div class="well blue-well">
																<i class="text-muted">[Return to caller]</i><br />
																Thank you for waiting, <strong><span class="callerFirstName"></span></strong>. I wasn’t able to reach anyone at the <strong><span class="locationTitle"></span></strong> appointment desk right now, but I know that they will want to speak with you right away. We will try calling them back until we reach them so they can get you scheduled. I will take care of this from here so you don’t have to do anything else; someone will get back to you as soon as possible. Thank you for contacting us today. I’m looking forward to assisting you with this process.
															</div>
														</div>
													</div>
												</div>
												<div class="didTheyAnswerFollowupVm hidden">
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<div class="well blue-well">
																<i class="text-muted">[Leave a voicemail]</i><br />
																This is <?= $user['first_name'] ?>  with Healthy Hearing. We tried to reach you today, <?= date('F d') ?> at <span class="locationCurrentTime"></span> because we had a consumer trying to reach you to set an appointment for a hearing test.
																Their name is <strong><span class="callerFirstName"></span></strong> <strong><span class="callerLastName"></span></strong>. That spelling is <i class="text-muted">[spell caller first name, caller last name]</i>.
																Their phone number is <strong><span class="callerPhone"></span></strong> and their main reason for calling is <strong><span class="callerTopics"></span></strong>. Please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Please call us back at 732-412-1215 to verify that you've reached the consumer. Thank you.
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-offset-3 col-md-9">
															<div class="well blue-well">
																<i class="text-muted">[Return to consumer]</i><br />
																Thank you for waiting, <strong><span class="callerFirstName"></span></strong>. I wasn’t able to reach anyone at the <strong><span class="locationTitle"></span></strong> appointment desk right now, but I know that they will want to speak with you right away. I was able to leave them a detailed voicemail, so they will be calling you back as soon as possible to get you scheduled. Have a great day.<br><br>
																<i class="text-muted">[Score as 'Tentative appointment'.]</i><br />
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="didConsumerAnswerNo hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													<i class="text-muted bold-number">[Call clinic: <span class="locationPhone"></span>]</i>
												</div>
											</div>
										</div>
										<?php
										echo $this->Form->control('ca_call_group.did_they_answer_followup2', [
											'options' => ['yes'=>'Yes', 'no'=>'No', 'vm'=>'No, but leave voicemail'],
											'empty' => 'Select One',
											'label' => 'Did clinic answer?',
											'required' => true
										]);
										?>
										<div class="didTheyAnswerFollowupYes hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Hello, this is <?= $user['first_name'] ?> from Healthy Hearing. This call is being recorded for quality assurance. I'm calling because I have a prospective patient who is trying to reach your clinic to make an appointment. First, can I get your name?
													</div>
												</div>
											</div>
											<?= $this->Form->control('ca_call_group.front_desk_name', ['autocomplete' => 'off']) ?>
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Thanks <strong><span class="frontDeskName"></span></strong>. Are you ready to take their information?<br>
														<i class="text-muted">[when yes]</i><br>
														Their name is <strong><span class="callerFirstName"></span> <span class="callerLastName"></span></strong>.
														<span class="isNotPatient hidden">
															They are calling on behalf of <strong><span class="patientName"></span></strong>.
														</span>
														Their number is <strong><span class="callerPhone"><?= formatPhoneNumber($caCallGroup->caller_phone) ?></span></strong> and their main reason for calling is <strong><span class="callerTopics"></span></strong>.<br>
														Okay, thank you. I will conference them in with us in a minute. Before I bring them in, can you please note in your system that this referral is from Healthy Hearing, as part of your paid membership.<br>
														Okay, I'll add <strong><span class="callerFirstName"></span></strong> to the line now.<br><br>
														<i class="text-muted bold-number">[Call consumer: <span class="callerPhone"><?= formatPhoneNumber($caCallGroup->caller_phone) ?></span>]</i><br>
														Hi. May I speak with <strong><span class="callerFirstName"></span></strong>?<br>
														<i class="text-muted">[wait for consumer]</i><br>
													</div>
												</div>
											</div>
											<?= $this->Form->control('ca_call_group.did_consumer_answer2', [
												'options' => ['yes'=>'Yes', 'no'=>'No'],
												'empty' => 'Select One',
												'label' => 'Did consumer answer?',
												'required' => true
											]) ?>
											<div class="didConsumerAnswer2Yes hidden">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<div class="well blue-well">
															<i class="text-muted">[Conference in consumer and clinic]</i><br>
															Hi <strong><span class="callerFirstName"></span></strong>. This is <?= $user['first_name'] ?> from Healthy Hearing. This call is being recorded for quality assurance.
															<?php if ($callType == CaCall::CALL_TYPE_FOLLOWUP_APPT_REQUEST): ?>
																You filled out an appointment request form for an appointment with <strong><span class="locationTitle"></span></strong>. I have <strong><span class="frontDeskName"></span></strong> from that clinic on the line to assist you with your request. You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br><br>
															<?php else: ?>
																I have <strong><span class="frontDeskName"></span></strong> on the line from <strong><span class="locationTitle"></span></strong>.
																You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br><br>
															<?php endif; ?>
															<i class="text-muted">[Mute and listen to appointment info. Update score below.]</i>
														</div>
													</div>
												</div>
											</div>
											<div class="didConsumerAnswer2No hidden">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<div class="well blue-well">
															<i class="text-muted">[Return to clinic]</i><br />
															Thank you for holding, I was unable to reach <strong><span class="callerFirstName"></span></strong>. Please call <strong><span class="callerFirstName"></span></strong> directly to set up an appointment as soon as you can. Please call us back at 732-412-1215 to verify that you've reached the consumer. Thank you.<br><br>
															<i class="text-muted">[Score as 'Tentative appointment'.]</i><br>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="didTheyAnswerFollowupVm hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														<i class="text-muted">[Leave a voicemail]</i><br />
														This is <?= $user['first_name'] ?>  with Healthy Hearing. We tried to reach you today, <?= date('F d') ?> at <span class="locationCurrentTime"></span> because we had a consumer trying to reach you to set an appointment for a hearing test.
														Their name is <strong><span class="callerFirstName"></span></strong> <strong><span class="callerLastName"></span></strong>. That spelling is <i class="text-muted">[spell caller first name, caller last name]</i>.
														Their phone number is <strong><span class="callerPhone"></span></strong> and their main reason for calling is <strong><span class="callerTopics"></span></strong>. Please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Please call us back at 732-412-1215 to verify that you've reached the consumer. Thank you.<br><br>
														<i class="text-muted">[Score as 'Tentative appointment'.]</i><br>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="didConsumerAnswerInvalid hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													<i class="text-muted">[Score as 'Caller disconnected'.]</i><br>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="followupForm hidden">
										<?= $this->element('ca_calls/outbound_followup_script') ?>
									</div>
									<div class="scheduled_call_date hidden">
										<?= $this->Form->control('ca_call_group.scheduled_call_date', [
											'class' => 'form-control datepicker inline-date',
											'label' => 'Next attempt to reach consumer ('.getEasternTimezone().')',
											'interval' => 15,
											'minYear' => '2016',
											'maxYear' => date("Y", strtotime('+2 years')),
										]) ?>
									</div>
									<?php
									echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
										'label' => 'Add a note',
										'rows' => 3,
										'required' => false,
									]);
									echo $this->Form->control('ca_call_group.is_review_needed', [
										'label' => [
											'class' => 'control-label',
											'text' => 'Needs supervisor review'],
											'style' => 'margin-left:23%;',
											'div' => 'form-group pt0',
											'class' => false,
									]);
									?>
								<?php endif; ?>
								<?php if ($callType == CaCall::CALL_TYPE_FOLLOWUP_TENTATIVE_APPT): ?>
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<div class="well blue-well">
												<i class="text-muted bold-number">[Call clinic: <span class="locationPhone"></span>]</i>
											</div>
										</div>
									</div>
									<?= $this->Form->control('ca_call_group.did_they_answer_followup', [
										'options' => ['yes'=>'Yes', 'no'=>'No'],
										'empty' => 'Select One',
										'label' => 'Did clinic answer?',
										'required' => true
									]) ?>
									<div class="didTheyAnswerFollowupYes hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													Hello, this is <?= $user['first_name'] ?> from Healthy Hearing. I'm calling to followup about a prospective patient. This call is being recorded for quality assurance. We called you on <strong><?= date('M d', strtotime($caCallGroup->created)) ?></strong> with a caller named <strong><span class="callerFirstName"></span> <span class="callerLastName"></span></strong> who wanted to set an appointment<span class="isNotPatient hidden">for <strong><span class="patientName"></span></strong></span>, and we left you their contact information. Were you able to reach that caller?
												</div>
												<div class="text-right">
													<small>
														<a data-toggle="popover" data-html="true" data-trigger="hover" data-container="body" data-placement="bottom" data-content="If the clinic doesn't want to give the follow-up information, say this:<br />
														As you know, Healthy Hearing has a partnership with Oticon that enables your clinic to be listed on our website. As a part of this partnership, Healthy Hearing is a covered entity under Oticon's HIPAA business associate agreement or BAA.<br />
														<br />
														You should have already signed a BAA as a part of doing business with Oticon because this allows you to legally share patient data with Oticon as a part of your regular business transactions. Because Healthy Hearing is also covered under this same agreement, it allows you to legally share with us the patient outcome data from the referral that we sent you.">
															<span class="glyphicon glyphicon-question-sign"></span> What if they don't want to give the info?
														</a>
													</small>
													<br />
													<br />
												</div>
											</div>
										</div>
										<?= $this->Form->control('ca_call_group.didClinicContactConsumer', [
											'options' => ['1'=>'Yes', '0'=>'No'],
											'empty' => 'Select One',
											'label' => 'Did they contact the caller?',
											'required' => true
										]) ?>
										<div class="didClinicContactConsumerYes hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Was an appointment set?<br><br>
														<i class="text-muted">[Update score below. If an appointment was set, get date/time.]</i><br>
													</div>
												</div>
											</div>
										</div>
										<div class="didClinicContactConsumerNo hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Okay, thanks. Have a great day.<br><br>
														<i class="text-muted">[Score as 'Clinic missed opportunity'.]</i><br>
													</div>
												</div>
											</div>
										</div>
										<hr>
										<?= $this->element('ca_calls/outbound_followup_script') ?>
									</div>
									<div class="scheduled_call_date hidden">
										<?= $this->Form->control('ca_call_group.scheduled_call_date', [
											'class' => 'form-control datepicker inline-date',
											'interval' => 15,
											'minYear' => '2016',
											'maxYear' => date("Y", strtotime('+2 years')),
										]) ?>
									</div>
									<?php
									echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
										'label' => 'Add a note',
										'rows' => 3,
										'required' => false,
									]);
									echo $this->Form->control('ca_call_group.is_review_needed', [
										'label' => [
											'class' => 'control-label',
											'text' => 'Needs supervisor review'],
											'style' => 'margin-left:23%;'
									]);
									?>
									<!-- If clinic already contacted caller and an appointment was set: -->
									<div class="didClinicContactConsumerYes hidden">
										<div class="appt_date hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Thank you, have a great day. Goodbye.
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<?php if ($callType == CaCall::CALL_TYPE_FOLLOWUP_NO_ANSWER): ?>
									<?php $name = $isPatient ? 'you' : $caCallGroup->patient_first_name; ?>
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<div class="well blue-well">
												<i class="text-muted bold-number">[Call patient: <?= formatPhoneNumber($caCallGroup->caller_phone) ?>]</i><br>
											</div>
										</div>
									</div>
									<?= $this->Form->control('ca_call_group.did_they_answer_followup', [
										'options' => ['yes'=>'Yes', 'no'=>'No', 'vm'=>'No, but leave voicemail'],
										'empty' => 'Select One',
										'label' => 'Did patient answer?',
										'required' => true
									]) ?>
									<div class="didTheyAnswerFollowupYes hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													Hello, may I please speak with <strong><?= $callerName ?></strong>?<br>
													Hello, this is <?= $user['first_name'] ?> with Healthy Hearing on behalf of <strong><span class="locationTitle"></span></strong>. This call may be recorded. You contacted us on <strong><?= date('M d', strtotime($caCallGroup->created)) ?></strong> about making an appointment<?= $isPatient ? '' : '<strong> for '.$patientName.'</strong>' ?>. Unfortunately, we were unable to speak with anyone at <strong><span class="locationTitle"></span></strong> to set that appointment. Were you able to connect with that clinic?
												</div>
											</div>
										</div>
										<?= $this->Form->control('ca_call_group.didClinicContactConsumer', [
											'options' => ['1'=>'Yes', '0'=>'No'],
											'empty' => 'Select One',
											'label' => 'Did they connect with clinic?',
											'required' => true
										]) ?>
										<div class="didClinicContactConsumerYes hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Was an appointment set?<br><br>
														<i class="text-muted">[Update score below. If an appointment was set, get date/time.]</i><br>
													</div>
												</div>
											</div>
										</div>
										<div class="didClinicContactConsumerNo hidden">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<div class="well blue-well">
														Would you like us to assist you in finding another clinic near you?
													</div>
												</div>
											</div>
											<?= $this->Form->control('ca_call_group.did_they_want_help', [
												'options' => ['1'=>'Yes', '0'=>'No'],
												'empty' => 'Select One',
												'label' => 'Does patient want help?',
												'required' => true
											]) ?>
											<div class="wantHelpNo hidden">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<div class="well blue-well">
															Okay, we understand. There are several other clinics in the directory for your area on our website, www.healthyhearing.com. Have a great day.
														</div>
													</div>
												</div>
											</div>
											<div class="wantHelpYes hidden">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<div class="well blue-well">
															Okay, just one moment and I'll help you with that.<br><br>
															<i class="text-muted">[Save this call. A new call will be created for this consumer.]</i>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="didTheyAnswerFollowupVm hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													<i class="text-muted">[Leave voicemail]</i><br />
													Hello, I'm calling for <strong><?= $callerName ?></strong>.<br>
													This is <?= $user['first_name'] ?> with Healthy Hearing on behalf of <strong><span class="locationTitle"></span></strong>. You contacted us on <strong><?= date('M d', strtotime($caCallGroup->created)) ?></strong> about making an appointment<?= $isPatient ? '' : '<strong> for '.$patientName.'</strong>' ?>. Unfortunately, we were unable to get ahold of anyone at <strong><span class="locationTitle"></span></strong> to set that appointment.<br>
													To find another clinic in your area, please go back to our website HealthyHearing.com and search our directory by zip code. Thank you. Have a great day.
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="followupForm hidden">
										<?= $this->element('ca_calls/outbound_followup_script') ?>
									</div>
									<div class="scheduled_call_date hidden">
										<?= $this->Form->control('ca_call_group.scheduled_call_date', [
											'label' => 'Next attempt to reach consumer ('.getEasternTimezone().')',
											'class' => 'form-control datepicker inline-date',
											'interval' => 15,
											'minYear' => '2016',
											'maxYear' => date("Y", strtotime('+2 years')),
										])
										?>
									</div>
									<div class="notes">
										<?php
										echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
											'label' => 'Add a note',
											'rows' => 3,
											'required' => false,
										]);
										echo $this->Form->control('ca_call_group.is_review_needed', [
											'label' => [
												'class' => 'control-label',
												'text' => 'Needs supervisor review'],
												'style' => 'margin-left:23%;',
												'class' => false,
										]);
										?>
									</div>
									<!--TODO: Does this id need to be renamed now that we don't do surveys? -->
									<div id="surveyComplete hidden">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<div class="well blue-well">
													Thank you very much. Have a great day.
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-actions tar">
								<input type="button" tabindex="1" value="Cancel and Unlock" class="btn btn-lg btn-danger" id="cancelBtn">
								<?php if ($caCallGroup->is_appt_request_form): ?>
									<input type="button" tabindex="1" value="Spam" class="btn btn-lg btn-default" id="spamBtn">
								<?php endif; ?>
								<input type="button" tabindex="1" value="Call disconnected / incomplete" class="btn btn-lg btn-default" id="disconnectedBtn">
								<input type="submit" tabindex="1" value="Save Call" class="btn btn-primary btn-lg" id="submitBtn">
							</div>
						</form>
						<?php $this->append('bs-modals'); ?>
							<div id="note-required" class="modal fade">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-body">
											Please fill in "Notes" field.
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
										</div>
									</div>
								</div>
							</div>
						<?php $this->end();?>
						<script type="text/javascript">
							// Global javascript variables
							var isCallDateSet = <?= json_encode(isset($caCallGroup->scheduled_call_date)) ?>,
								IS_CLINIC_LOOKUP_PAGE = false,
								IS_CALL_GROUP_EDIT_PAGE = false;
						</script>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>