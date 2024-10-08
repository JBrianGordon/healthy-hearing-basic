<?php
use \App\Model\Entity\CaCallGroup;

$noteCount = isset($noteCount) ? $noteCount : 0;
$showScript = isset($showScript) ? $showScript : true;
$copyPage = isset($copyPage) ? $copyPage : false;
if ($copyPage) {
	// Don't show script on the first part of the copy page
	$showScript = false;
}
?>
<?= $this->Form->control('ca_call_group.refused_name', [
	'type' => 'checkbox',
	'label' => ' Refused to give name?',
	'style' => 'margin-left:23%;',
]) ?>
<div class="refusedNameNo">
	<?= $this->Form->control('ca_call_group.caller_first_name', ['label' => ['class' => 'ml10']]) ?>
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					Thank you. May I please have the spelling of your last name?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.caller_last_name', ['label' => ['class' => 'ml10']]) ?>
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					Thanks. May I please have a good phone number for you in case I need to call you back?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.caller_phone', [
		'required' => true, 'label' => ['class' => 'ml10']]) ?>
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					Are you calling on behalf of yourself or someone else?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.is_patient', [
		'type' => 'checkbox',
		'label' => ['class' => 'ml10', 'text' => ' Self'],
		'default' => true,
		'style' => 'margin-left:23%;',
	])?>
	<div class="patient-data" style="display:none;">
		<?= $this->Form->control('ca_call_group.patient_first_name', ['label' => ['class' => 'ml10']]) ?>
		<?= $this->Form->control('ca_call_group.patient_last_name', ['label' => ['class' => 'ml10']]) ?>
	</div>
</div>
<div class="refusedNameYes" style="display:none;">
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					No problem. May I please have a good phone number for you in case I need to call you back?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.caller_phone', ['label' => ['class' => 'ml10']]) ?>
</div>
<?php if (!empty($previousCalls)): ?>
	<div id="group-search">
		<?= $this->Form->control('group_search', [
			'class' => 'form-control group_search',
			'label' => [
				'class' => 'col col-md-3 control-label ml10',
				'text' => 'Related to previous call?'
			],
			'type' => 'select',
			'options' => $previousCalls,
			'empty' => true,
		])?>
	</div>
<?php endif; ?>
<?php if ($showScript): ?>
	<div class="row">
		<div class="col-md-9 offset-md-3">
			<div class="well blue-well">
				Now, how can I help you today?
			</div>
		</div>
	</div>
<?php endif; ?>
<?php $this->Form->setTemplates([
    // Temporarily remove offset from checkbox containers
    'checkboxContainer' => '<div{{containerAttrs}} class="{{containerClass}}form-group form-check{{variant}} {{type}}{{required}}">{{content}}{{help}}</div>',
]); ?>
<div class="form-group mb30">
	<label class="col col-md-3 control-label">Topic</label>
	<div class="col col-md-9">
		<div class="row">
			<div class="col col-md-6">
				<?= $this->element('ca_calls/ca_call_topics') ?>
			</div>
			<div class="checkbox col col-md-6">
				<?php
				foreach (CaCallGroup::$col2Topics as $topicKey => $label) {
					echo $this->Form->control('ca_call_group.'.$topicKey, [
						'type' => 'checkbox',
						'label' => [
							'style' => 'text-align:left;',
							'text' => '<span class="topic-label">'.$label.'</span>',
						],
						'escape' => false
					]);
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php $this->Form->setTemplates([
    // Add offset to checkbox containers
    'checkboxContainer' => '<div{{containerAttrs}} class="offset-md-3 {{containerClass}}form-group form-check{{variant}} {{type}}{{required}}">{{content}}{{help}}</div>',
]); ?>

<!-- Hearing Test? -->
<div class="wantsHearingTest" style="display:none;">
	<?php if ($showScript): ?>
		<div class="row">
				<div class="col-md-9 offset-md-3">
				<div class="well green-well">
					Do you need a hearing test?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.wants_hearing_test', [
		'label' => [
			'class' => 'col col-md-3 control-label ml10',
			'text' => 'Hearing test?'
		],
		'type' => 'select',
		'options' => [
			0 => 'No',
			1 => 'Yes',
		],
		'default' => 0
	])?>
</div>

<!-- Hearing Aid Age -->
<div class="aid_age_topic hidden">
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					How old is your current hearing aid?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php 
	$hearingAidAge = 'new';
	if (!empty($caCall->ca_call_group->topic_aid_lost_old) || !empty($caCall->ca_call_group->topic_warranty_old)) {
		$hearingAidAge = 'old';
	}
	echo $this->Form->control('ca_call_group.hearing_aid_age', [
		'label' => [
			'class' => 'col col-md-3 control-label ml10',
			'text' => 'Hearing aid age?'
		],
		'type' => 'select',
		'options' => [
			'new' => 'Hearing aid is under 3 years old',
			'old' => 'Hearing aid is 3 years or older',
		],
		'default' => $hearingAidAge
	]);
	?>
</div>

<!-- Is this a prospect call? -->
<?= $this->Form->control('ca_call_group.prospect', [
	'label' => [
		'class' => 'col col-md-3 control-label ml10',
		'text' => 'Prospect?'
	],
	'type' => 'select',
	'options' => CaCallGroup::$prospectOptions,
	'default' => CaCallGroup::PROSPECT_NO,
])?>

<!-- Prospects -->
<div class="prospectTopic" style="display:none;">
	<div class="nonDirectBook" style="display:none;">
		<?php
		if ($copyPage) {
			// On the copy page, show script from here on
			$showScript = true;
		}
		?>
		<?php if ($showScript): ?>
			<div class="row">
				<div class="col-md-9 offset-md-3">
					<div class="well blue-well">
						<?php if (!$copyPage): ?>
							It sounds like you need an appointment with the hearing care practitioner at <strong><span class="locationTitle"></span></strong>. I'd be happy to help you with that.
						<?php endif; ?>
						I'm going to send you over to the appointment desk now to get that scheduled. May I have your consent to stay on the line once we get you connected?<br><br>
						<i class="text-muted">[Call clinic at <span class="locationPhone"></span>]</i><br>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?= $this->Form->control('ca_call_group.consumer_consent', [
			'label' => ['text' => 'Did they consent?', 'class' => 'ml10'],
			'required' => true,
			'empty' => true,
			'options' => [
				'yes' => 'Yes',
				'no' => 'No'
			],
		]) ?>
		<div class="consumerConsentYes" style="display:none;">
			<?php if ($showScript): ?>
				<div class="row">
					<div class="col-md-9 offset-md-3">
						<div class="well blue-well">
							Thanks! Please hold briefly while I get them on the phone.
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="consumerConsentNo" style="display:none;">
			<?php if ($showScript): ?>
				<div class="row">
					<div class="col-md-9 offset-md-3">
						<div class="well blue-well">
							Ok, I understand. Please hold briefly while I transfer you.
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?= $this->Form->control('ca_call_group.did_clinic_answer', [
			'label' => ['text' => 'Did clinic answer?', 'class' => 'ml10'],
			'required' => true,
			'empty' => true,
			'options' => [
				'yes' => 'Yes',
				'no' => 'No',
				'vm' => 'No, but leave voicemail'
			],
		]) ?>
		<!-- Clinic answered -->
		<div class="didClinicAnswerYes" style="display:none;">
			<?php if ($showScript): ?>
				<div class="row">
					<div class="col-md-9 offset-md-3">
						<div class="well blue-well">
							Hello, my name is <?= $user['first_name'] ?> and I'm with Healthy Hearing. This call is being recorded for quality assurance. I have a caller on the line who's interested in setting an appointment at your clinic and I will conference them in with us in a minute. Before I bring them in, can you please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Who am I speaking with?
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?= $this->Form->control('ca_call_group.front_desk_name', ['autocomplete' => 'off']) ?>
			<div class="refusedNameNo">
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-9 offset-md-3">
							<div class="well blue-well">
								Thanks! 
								The name of the caller is <strong><span class="callerFirstName"></span></strong>
								<span class="self"><strong><span class="callerLastName"></span></strong>.</span>
								<span class="not-self">and they are setting an appointment for <strong><span class="patientName"></span></strong>.</span>
								Their main reason for calling is <strong><span class="callerTopics"></span></strong>.  I'll add <strong><span class="callerFirstName"></span></strong> to the line now. Here’s <strong><span class="callerFirstName"></span></strong>.<br>
								<i class="text-muted">[Conference in caller and clinic]</i><br>
								<strong><span class="callerFirstName"></span></strong>, thank you for holding! I have <strong><span class="frontDeskName"></span></strong> here from <strong><span class="locationTitle"></span></strong>. 
								You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br>
								<i class="text-muted"><span class="callTransferInstructions">[Mute and listen to appointment info]</span></i><br>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="refusedNameYes" style="display:none;">
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-9 offset-md-3">
							<div class="well blue-well">
								Thanks! I don't have a lot of information about the caller, but I know that their main reason for calling is <strong><span class="callerTopics"></span></strong>. I'll add them to the line now. Here they are.<br>
								<i class="text-muted">[Conference in caller and clinic]</i><br>
								Thank you for holding! I have <strong><span class="frontDeskName"></span></strong> here from <strong><span class="locationTitle"></span></strong>. You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br>
								<i class="text-muted">[Mute and listen for information about the call. You can uncheck "refused to answer" to fill in the caller's name. Be sure to update the topic, prospect field and score as appropriate.]</i><br>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<!-- Clinic did not answer -->
		<div class="didClinicAnswerNo" style="display:none;">
			<div class="refusedNameNo">
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-9 offset-md-3">
							<div class="well blue-well">
								<i class="text-muted">[Return to caller]</i><br />
								Thank you for waiting, <strong><span class="callerFirstName"></span></strong>. I wasn’t able to reach anyone at the <strong><span class="locationTitle"></span></strong> appointment desk right now, but I know that they will want to speak with you right away. We will try calling them back until we reach them so they can get you scheduled. I will take care of this from here so you don’t have to do anything else; someone will get back to you as soon as possible. Thank you so much for calling today. I’m looking forward to assisting you with this process.
							</div>
						</div>
					</div>
				<?php endif ?>
			</div>
			<div class="refusedNameYes" style="display:none;">
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-9 offset-md-3">
							<div class="well blue-well">
								<i class="text-muted">[Do not leave a message with clinic. Return to caller.]</i><br />
								Thank you for waiting. I wasn’t able to reach anyone at the <strong><span class="locationTitle"></span></strong> appointment desk right now, but I know that they will want to speak with you right away. I'm going to give you their direct phone number so you can try calling them back directly.<br>
								<strong><span class="locationPhone"></span></strong><br>
								Have a great day.
							</div>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
		<!-- Leave a voicemail -->
		<div class="didClinicAnswerVm" style="display:none;">
			<?php if ($showScript): ?>
				<div class="row">
					<div class="col-md-9 offset-md-3">
						<div class="well blue-well">
							<i class="text-muted">[Leave a voicemail]</i><br />
							This is <?= $user['first_name'] ?>  with Healthy Hearing. We tried to reach you today, <?= date('F d') ?> at <span class="locationCurrentTime"></span> because we had a consumer on the line trying to reach you to set an appointment for a hearing test.
							<span class="self">
							Their name is <strong><span class="callerFirstName"></span></strong> <strong><span class="callerLastName"></span></strong>. That spelling is <i class="text-muted">[spell caller first name, caller last name]</i>.
							</span>
							<span class="not-self">
							The name of the caller is <strong><span class="callerFirstName"></span></strong>, and they are setting an appointment for <strong><span class="patientName"></span></strong>.  That spelling is <i class="text-muted">[spell patient first name, patient last name]</i>.
							</span>
							Their phone number is <strong><span class="callerPhone"></span></strong> and their main reason for calling is <strong><span class="callerTopics"></span></strong>. Please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Please call us back at 732-412-1215 to verify that you've reached the consumer.
						</div>
					</div>
				</div>
			<?php endif ?>
			<?php if ($showScript): ?>
				<div class="row">
					<div class="col-md-9 offset-md-3">
						<div class="well blue-well">
							<i class="text-muted">[Return to caller]</i><br />
							Thank you for waiting, <strong><span class="callerFirstName"></span></strong>. I wasn’t able to reach anyone at the <strong><span class="locationTitle"></span></strong> appointment desk right now, but I know that they will want to speak with you right away. I was able to leave them a detailed voicemail, so they will be calling you back as soon as possible to get you scheduled. Thank you so much for calling today.<br><br>
							<i class="text-muted">[Score as 'Tentative appointment'.]</i><br />
						</div>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
	<div class="directBookDm" style="display:none;">
		<?php if ($showScript): ?>
			<div class="row">
				<div class="col-md-9 offset-md-3">
					<div class="well green-well">
						I would be happy to help you set that appointment.<br><br>
						<i class="text-muted">Direct book appointment via DM: <a href="http://dm.us.atlas.demant.com/usretail/contact" target="_blank" rel="noopener">http://dm.us.atlas.demant.com/usretail/contact</a><br>
						Search by patient name: <strong><span class="patientName"></span></strong><br>
						Or clinic city/state/street: <strong><span class="locationCityStateStreet"></span></strong><br><br>
						Come back to this window to save the results.</i><br>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div class="directBookBlueprintEarQ" style="display:none;">
		<?php if ($showScript): ?>
			<div class="row">
				<div class="col-md-9 offset-md-3">
					<div class="well green-well">
						I would be happy to help you set that appointment.<br><br>
						<i class="text-muted">Direct book appointment via Blueprint/EarQ: <a href="" target="_blank" rel="noopener" id="directBookUrl" style="overflow-wrap:break-word;"></a><br><br>
						Clinic location: <strong><span class="locationCityStateStreet"></span></strong><br><br>
						Come back to this window to save the results.</i><br>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<hr>
	<?= $this->Form->control('ca_call_group.score', [
		'type' => 'select',
		'options' => CaCallGroup::$scores,
		'empty' => true,
	])?>
</div>

<!-- Prospect Unknown -->
<div class="prospectUnknownTopic" style="display:none;">
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					Okay, I'm going to send you over to the appointment desk now to get some assistance. Please hold briefly while I get them on the phone.<br>
					<i class="text-muted">[Call clinic at <span class="locationPhone"></span>]</i>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.did_clinic_answer_unknown', [
		'label' => ['text' => 'Did clinic answer?', 'class' => 'ml10'],
		'required' => true,
		'empty' => true,
		'options' => [
			'yes' => 'Yes',
			'no' => 'No'
		],
	])?>
	<!-- Clinic answered -->
	<div class="didClinicAnswerYes" style="display:none;">
		<?php if ($showScript): ?>
			<div class="row">
				<div class="col-md-9 offset-md-3">
					<div class="well blue-well">
						Hello, my name is <?= $user['first_name'] ?> and I'm with Healthy Hearing. This call is being recorded for quality assurance. I have a caller on the line who's interested in speaking to your clinic and I will conference them in with us in a minute. Before I bring them in, can you please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Who am I speaking with?
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?= $this->Form->control('ca_call_group.front_desk_name', ['autocomplete' => 'off', 'label' => ['class' => 'ml10']]) ?>
		<?php if ($showScript): ?>
			<div class="row">
				<div class="col-md-9 offset-md-3">
					<div class="well blue-well">
						Thanks! I don't have a lot of information about their reason for calling but I know they wanted to be connected to you. I'll add them to the line now.<br>
						<i class="text-muted">[Conference in caller and clinic]</i><br>
						Thank you for holding! I have <strong><span class="frontDeskName"></span></strong> here from <strong><span class="locationTitle"></span></strong>. You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br>
						<i class="text-muted">[Mute and listen for information about the call. You can uncheck "refused to answer" to fill in the caller's name. Be sure to update the topic, prospect field and score as appropriate.]</i><br>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<!-- Clinic did not answer -->
	<div class="didClinicAnswerNo" style="display:none;">
		<?php if ($showScript): ?>
			<div class="row">
				<div class="col-md-9 offset-md-3">
					<div class="well blue-well">
						<i class="text-muted">[Do not leave a message with clinic. Return to caller.]</i><br />
						Thank you for waiting. I wasn’t able to reach anyone at the <strong><span class="locationTitle"></span></strong> appointment desk right now, but I know that they will want to speak with you right away. I'm going to give you their direct phone number so you can try calling them back directly.<br>
						<strong><span class="locationPhone"></span></strong><br>
						Have a great day.
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>

<!-- Non-Prospects -->
<div class="nonProspectTopic">
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					Okay, I can go ahead and transfer you over to the appointment desk now.<br>
					Before I transfer you, let me give you a callback number so you can reach the appointment desk directly if you get disconnected. Let me know when you're ready: <strong><span class="locationPhone"></span></strong><br>
					Please hang on the line while I try to connect you with the desk.<br><br>
					<i class="text-muted">[Call clinic at <span class="locationPhone"></span>]</i>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.did_clinic_answer', [
		'label' => ['text' => 'Did clinic answer?', 'class' => 'ml10'],
		'required' => true,
		'empty' => true,
		'options' => [
			'yes' => 'Yes',
			'no' => 'No',
			'vm' => 'No, but leave voicemail'
		],
	]) ?>
	<!-- Clinic answered -->
	<div class="didClinicAnswerYes" style="display:none;">
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					Hi, I have a patient on the line to transfer to you. This is <?php echo $user['first_name']; ?> from Healthy Hearing and before I transfer the call and hang up, I wanted to let you know this call is being recorded for quality assurance.<br><br>
					Caller name: <strong><span class="callerFirstName"></span> <span class="callerLastName"></span></strong><br>
					Caller phone: <strong><span class="callerPhone"></span></strong><br>
					Reason for calling: <strong><span class="callerTopics"></span></strong><br><br>
					<i class="text-muted">[Hang up so call transfers to the clinic]</i>
				</div>
			</div>
		</div>
	</div>
	<!-- Clinic did not answer -->
	<div class="didClinicAnswerNo" style="display:none;">
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					<div class="refusedNameYes" style="display:none;">
						<i class="text-muted">[Do not leave a message with clinic. Return to caller.]</i><br />
					</div>
					Thanks for holding. The appointment desk is unavailable at this time.
					<span class="locationHoursToday"></span>
					You are welcome to try calling them back directly at <strong><span class="locationPhone"></span></strong>.<br>
					Have a great day.
				</div>
			</div>
		</div>
	</div>
	<!-- Leave a voicemail -->
	<div class="didClinicAnswerVm" style="display:none;">
		<div class="row">
			<div class="col-md-9 offset-md-3">
				<div class="well blue-well">
					This is <?= $user['first_name'] ?> from Healthy Hearing. I had <strong><span class="callerFirstName"></span> <span class="callerLastName"></span></strong> on the line. They were calling you for <strong><span class="callerTopics"></span></strong>. Please call them back directly at <strong><span class="callerPhone"></span></strong><br><br>
					<i class="text-muted">[Return to caller]</i><br />
					Thanks for holding. The clinic is unavailable at this time. I left them a voicemail message asking them to call you back directly.
					<span class="locationHoursToday"></span>
					Their direct number is <strong><span class="locationPhone"></span></strong>.<br>
					Have a great day.
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Appointment Date -->
<div class="appt_date" style="display:none;">
	<div class="directBook" style="display:none;">
		<?= $this->Form->control('ca_call_group.is_bringing_third_party', [
			'label' => [
				'class' => 'col col-md-3 control-label ml10',
				'text' => 'Will patient bring a 3rd party?'
			],
			'type' => 'select',
			'options' => [
				0 => 'No',
				1 => 'Yes',
			],
			'default' => 0
		])?>
	</div>
	<?= $this->Form->control('ca_call_group.appt_date', [
		'type' => 'datetime-local',
		'min' => '2016-01-01T00:00',
		'max' => date("Y-m-d\TH:i", strtotime('+1 year')),
		'step' => 60, //minutes
		'label' => ['id' => 'appt-date-label', 'class' => 'ml10'],
	])?>
</div>

<!-- Scheduled Call Date -->
<div class="scheduled_call_date" style="display:none;">
	<?= $this->Form->control('ca_call_group.scheduled_call_date', [
		'type' => 'datetime-local',
		'min' => '2016-01-01T00:00',
		'max' => date("Y-m-d\TH:i", strtotime('+1 year')),
		'step' => 60, //minutes
		'label' => ['id' => 'scheduled-call-date-label', 'class' => 'ml10'],
	])?>
</div>

<?php
echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
	'label' => [
		'class' => 'col col-md-3 control-label ml10',
		'text' => 'Add a note'],
	'rows' => 3,
	'required' => false,
]);
echo $this->Form->control('ca_call_group.is_review_needed', [
	'label' => ['text' => 'Needs supervisor review', 'class' => 'ml10']
]);
?>
