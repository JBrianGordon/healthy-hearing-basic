<?php
	$noteCount = isset($noteCount) ? $noteCount : 0;
	$inputDefaults = array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	);
?>

<div class="row">
	<div class="col-md-offset-3 col-md-9">
		<div class="well blue-well">
			<i class="text-muted">[Call consumer at <?php echo formatPhoneNumber($voicemailFrom); ?> (or number left in message)]</i>
		</div>
	</div>
</div>
<?php echo $this->Form->control('ca_call_group.did_they_answer_vm', [
	'options' => [
		'yes' => 'Yes',
		'no' => 'No',
		'vm' => 'No, but leave voicemail',
		'noAttempt' => 'Call not attempted'
	],
	'empty' => '(select one)',
	'label' => [
		'class' => 'col col-md-3 control-label',
		'text' => 'Did consumer answer?'
	],
	'required' => false
]); ?>
<div id="didTheyAnswerYes" style="display:none;">
	<div class="row">
		<div class="col-md-offset-3 col-md-9">
			<div class="well blue-well">
				Hello, this is <?php echo $user['first_name']; ?> returning your call to Healthy Hearing. You left us a voicemail <?php echo $this->CaCallGroup->formatDate(strtotime($voicemailTime)); ?>. This call is being recorded for quality assurance. Can you tell me the name of the clinic you're trying to reach so I can get you connected?<br>
				<i class="text-muted">If no, don't remember:</i>
				That's ok. I can help you find a clinic near your home.<br>
				<i class="text-muted ml40"><a href="/hearing-aids" target="_blank">Click here</a> to go to clinic directory. Ask for zip code and find the nearest T1 clinic.</i>
			</div>
		</div>
	</div>
	<?php echo $this->Form->control('location_search', [
		'class' => 'form-control location_search',
		'label' => [
			'class' => 'col col-md-3 control-label',
			'text' => 'Clinic search'
		],
		'div' => 'form-group'
	]); ?>
	<div class="row">
		<div class="col-md-offset-3 col-md-9">
			<div class="well blue-well">
				Great! Now may I please have your first name?
			</div>
		</div>
	</div>
	<?php echo $this->element('ca_calls/inbound_call_script', array('showScript'=>true)); ?>
</div>
<div id="didTheyAnswerNo">
	<div class="scheduled_call_date">
		<?php
		echo $this->Form->control('ca_call_group.scheduled_call_date', [
			'id' => 'NoAnswerScheduledCallDate',
			'label' => [
				'class' => 'col col-md-3 control-label',
				'text' => 'Next attempt to reach consumer ('.getEasternTimezone().')'
			],
			'class' => 'form-control datepicker inline-date',
			'interval' => 15,
			'minYear' => '2016',
			'maxYear' => date("Y", strtotime('+2 years')),
		]);
		?>
	</div>
	<?php
	echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
		'label' => [
			'class' => 'col col-md-3 control-label',
			'text' => 'Add a note'],
		'rows' => 3,
		'required' => false,
//		'value' => $caCallGroup->ca_call_group_notes->{$noteCount}->body
	]);
	?>
</div>
<div id="didTheyAnswerVm" style="display:none;">
	<div class="row">
		<div class="col-md-offset-3 col-md-9">
			<div class="well blue-well">
				Hello, this is <?php echo $user['first_name']; ?> returning your call to Healthy Hearing. You left us a voicemail <strong><?php echo $this->CaCallGroup->formatDate(strtotime($voicemailTime)); ?></strong> when you were trying to reach a hearing clinic in your area. If you still need help finding or reaching a hearing clinic, please visit our website at HealthyHearing.com and select the clinic you wish you reach, and call the phone number listed in their clinic profile. At Healthy Hearing, we answer our phones between 7am and 8pm Eastern time, Monday - Friday.
			</div>
		</div>
	</div>
	<?php
	echo $this->Form->control("ca_call_group.ca_call_group_notes.$noteCount.body", [
		'label' => [
			'class' => 'col col-md-3 control-label',
			'text' => 'Add a note'],
		'rows' => 3,
		'required' => false,
	]);
	?>
</div>
