<?php
use App\Model\Entity\CaCallGroup;
use Cake\Core\Configure;
?>
<?= $this->Form->control('ca_call_group.refused_name_quick_pick', [
	'type' => 'checkbox',
	'label' => [
		'class' => 'control-label',
		'text' => ' Refused to give name/address?'
	],
	'style' => 'margin-left: 23%;'
])
?>
<div class="refusedNameYesQuickPick hidden">
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					This service is for helping people select a clinic and make an appointment for a hearing test. I can help you set up a hearing test if you give me your name, phone number and address. Would you like to end this call or continue by giving me your name?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.refused_name_again_quick_pick', [
		'type' => 'checkbox',
		'label' => [
			'class' => 'control-label',
			'text' => ' Refused to give name/address again?'
		],
		'style' => 'margin-left: 23%;'
	]) ?>
</div>
<div class="refusedNameYesAgainQuickPick hidden">
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					I understand. I’m sorry we weren’t able to assist you today, and we wish you the best in your search for a hearing care professional.
				</div>
			</div>
		</div>
	<?php endif; ?>	
</div>
<div class="refusedNameNoQuickPick">
	<?= $this->Form->control('ca_call_group.caller_first_name', ['autocomplete' => 'autocomplete-off']) ?>
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					Thank you. May I please have the spelling of your last name?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.caller_last_name', ['autocomplete' => 'autocomplete-off']) ?>
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					Thanks. May I please have a good phone number for you in case I need to call you back?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.caller_phone', [
		'div' => 'form-group required',
		'autocomplete' => 'autocomplete-off',
		'required' => true,
	])
	?>
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					Are you calling on behalf of yourself or someone else?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.is_patient', [
		'label' => [
			'class' => 'control-label',
			'text' => 'Self'
		],
		'default' => true,
		'style' => 'margin-left: 23%;'
	])
	?>
	<div class="patient-data hidden">
		<?= $this->Form->control('ca_call_group.patient_first_name', ['autocomplete' => 'autocomplete-off']) ?>
		<?= $this->Form->control('ca_call_group.patient_last_name', ['autocomplete' => 'autocomplete-off']) ?>
	</div>

	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					May I please have <span class="self">your</span><span class="not-self hidden">the patient's</span> home address so I can find the closest hearing care practices to <span class="self">you</span><span class="not-self hidden">them</span>?
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?= $this->Form->control('ca_call_group.patient_address', ['autocomplete' => 'autocomplete-off']) ?>
	<?= $this->Form->control('ca_call_group.patient_city', ['autocomplete' => 'autocomplete-off']) ?>
	<?= $this->Form->control('ca_call_group.patient_state', [
			'type' => 'select',
			'options' => Configure::read('states'),
			'empty' => '(Choose a state)',
			'autocomplete' => 'autocomplete-off'
		])
	?>
	<?= $this->Form->control('ca_call_group.patient_zip', ['autocomplete' => 'autocomplete-off']) ?>
	<?= $this->Form->control('ca_call_group.patient_full_address', [
			'readonly' => true
		]) ?>
	<?php if ($showScript): ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					<p>Great, thank you! Wait just a few seconds and I will pull up the closest hearing care professionals to that address.</p>
					<em class="text-muted">[First clinic is pre-selected for you after search.]</em>
					<br>
					<br>
				</div>
			</div>	
		</div>
	<?php endif; ?>
	<?= $this->Form->button('Find closest locations', [
		'type' => 'button',
		'id' => 'findClosestLocations',
		'class' => 'mb20 col-md-offset-3 btn btn-primary btn-sm',
	])
	?>
	<div id="afterClinicFind" class="hidden">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div id="closestClinics" class="well blue-well">
				</div>
			</div>
		</div>
		<?= $this->Form->button('Load more clinics', [
			'type' => 'button',
			'id' => 'loadMoreClinics',
			'class' => 'mb20 col-md-offset-3 btn btn-primary btn-sm'
		])
		?>
		<?php if (isset($previousCalls)): ?>
			<div id="related-call-search">
				<?= $this->Form->control('group_search', [
					'class' => 'form-control group_search',
					'label' => [
						'class' => 'col col-md-3 control-label',
						'text' => 'Related to previous call?'
					],
					'type' => 'select',
					'options' => $previousCalls,
					'empty' => true,
				])
				?>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="col-md-6">
					<span class="locationLink"></span><br>
					<span class="locationAddress"></span><br>
					<span class="locationPhone"></span><br>
					<span class="locationMessage"></span><br>
					<strong><span class="locationLandmarks"></span></strong>
				</div>
				<div class="col-md-3">
					<span class="locationHours small"></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">

					<p class="firstClinic">It looks like <strong><span class="locationTitle">[selected clinic]</span></strong> at <strong><span class="scriptLocationAddress">[address]</span></strong> is the closest clinic to you. <span class ="hasDirections">It's <strong><span class="locationDistance"></span> (<span class="locationTime"></span>)</strong> from the address you gave me.</span></p>

					<p class="subsequentClinic hidden">I understand. The next closest clinic to you in our directory is <strong><span class="locationTitle">[selected clinic]</span></strong> at <strong><span class="scriptLocationAddress">[address]</span></strong>. <span class ="hasDirections">It's <strong><span class="locationDistance"></span> (<span class="locationTime"></span>)</strong> from the address you gave me.</span></p>

					<p>This clinic has <span class="locationRating"></span>. Would you like me to <span class="nonDirectBookQuickPick">call that clinic to</span> set an appointment for a hearing test?</p>
					<br>
					<em class="text-muted">[If yes.]</em>
					<p class="nonDirectBookQuickPick">Please hang on the line while I try to connect you with the appointment desk for that clinic.</p>
					<em class="directBookQuickPick text-muted">[Direct book appointment in green box below.]</em>
					<br>
					<br>
					<div id="purposeReminder hidden">
						<em class="text-muted">[If no.]</em>
						<p>This line is for helping people select a clinic and make an appointment for a hearing test. I can help you do that. Would you like to end this call or continue looking for a clinic?</p>
					</div>
					<em id="ifNoCall" class="text-muted">[If no, select the next clinic in line and read the revised script.]</em>
					<br>
				</div>
				<div class="nonDirectBookQuickPick well blue-well">
					<em class="text-muted">[Call clinic at <span class="locationPhone"></span>]</em><br>
				</div>
			</div>
		</div>
		<?= $this->Form->control('ca_call_group.is_direct_book_working', [
			'class' => 'form-control isDirectBookWorking',
			'label' => [
				'class' => 'isDirectBookWorking col col-md-3 control-label',
				'text' => 'Are you able to Direct Book?'
			],
			'type' => 'select',
			'options' => [
				0 => 'No',
				1 => 'Yes',
			],
			'default' => 1
		])
		?>
		<div class="directBookQuickPick hidden">
			<?php if ($showScript): ?>
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<div class="well green-well">
							I would be happy to help you set that appointment.<br><br>
							<div class="directBookDm">
								<i class="text-muted">Direct book appointment via DM: <a href="http://dm.us.atlas.demant.com/usretail/contact" target="_blank" rel="noopener">http://dm.us.atlas.demant.com/usretail/contact</a><br>
								Search by patient name: <strong><span class="patientName"></span></strong><br>
								Or clinic city/state/street: <strong><span class="locationCityStateStreet"></span></strong><br><br>
							</div>
							<div class="directBookBlueprintEarQ">
								<i class="text-muted">Direct book appointment via Blueprint/EarQ: <a href="" target="_blank" rel="noopener" id="directBookUrl" style="overflow-wrap:break-word;"></a><br><br>
								Clinic location: <strong><span class="locationCityStateStreet"></span></strong><br><br>
							</div>
							Come back to this window to save the results.</i><br>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="nonDirectBookQuickPick">
			<?= $this->Form->control('ca_call_group.did_clinic_answer', [
				'label' => [
					'class' => 'col col-md-3 control-label',
					'text' => 'Did clinic answer?'
				],
				'required' => true,
				'div' => 'form-group required',
				'empty' => true,
				'options' => [
					'yes' => 'Yes',
					'no' => 'No',
					'vm' => 'No, but leave voicemail',
					'cr' => 'Did not call clinic - caller refused'
				],
			])
			?>
			<!-- Clinic answered -->
			<div class="didClinicAnswerYes hidden">
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<div class="well blue-well">
								Hello, my name is <?= $user['first_name'] ?> and I'm with Healthy Hearing. This call is being recorded for quality assurance. I have a caller on the line who's interested in setting an appointment at your clinic and I will conference them in with us in a minute. Before I bring them in, can you please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Who am I speaking with?
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?= $this->Form->control(
					'ca_call_group.front_desk_name', [
						'autocomplete' => 'autocomplete-off'
					]
				)
				?>
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<div class="well blue-well">
								Thanks!
								The name of the caller is <strong><span class="callerFirstName"></span></strong>
								<span class="self"><strong><span class="callerLastName"></span></strong>.</span>
								<span class="not-self hidden">and they are setting an appointment for <strong><span class="patientName"></span></strong>.</span>
								Their main reason for calling is <strong>Hearing test / Hearing aid consultation</strong>.  I'll add <strong><span class="callerFirstName"></span></strong> to the line now. Here’s <strong><span class="callerFirstName"></span></strong>.<br>
								<i class="text-muted">[Conference in caller and clinic]</i><br>
								<strong><span class="callerFirstName"></span></strong>, thank you for holding! I have <strong><span class="frontDeskName"></span></strong> here from <strong><span class="locationTitle"></span></strong>.
								You are in good hands -- go ahead <strong><span class="frontDeskName"></span></strong>.<br>
								<i class="text-muted">[Mute and listen to appointment info]</i><br>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<!-- Clinic did not answer -->
			<div class="didClinicAnswerNo hidden">
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<div class="well blue-well">
								<i class="text-muted">[Return to caller]</i><br />
								Thank you for waiting, <strong><span class="callerFirstName"></span></strong>. I wasn’t able to reach anyone at the appointment desk for that clinic right now. Would you like me to try again and see if I can leave a message or try the next clinic on the list?
								<br>
								<i class="text-muted">[Change clinic selection above and read to them the details of the next clinic]</i>
							</div>
						</div>
					</div>
				<?php endif ?>
			</div>
			<!-- Leave a voicemail -->
			<div class="didClinicAnswerVm hidden">
				<?php if ($showScript): ?>
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<div class="well blue-well">
								<i class="text-muted">[Leave a voicemail]</i><br />
								This is <?php echo $user['first_name']; ?>  with Healthy Hearing. We tried to reach you today, <?= date('F d') ?> at <span class="locationCurrentTime"></span> because we had a consumer on the line trying to reach you to set an appointment for a hearing test.
								<span class="self">
								Their name is <strong><span class="callerFirstName"></span></strong> <strong><span class="callerLastName"></span></strong>. That spelling is <i class="text-muted">[spell caller first name, caller last name]</i>.
								</span>
								<span class="not-self hidden">
								The name of the caller is <strong><span class="callerFirstName"></span></strong>, and they are setting an appointment for <strong><span class="patientName"></span></strong>.  That spelling is <i class="text-muted">[spell patient first name, patient last name]</i>.
								</span>
								Their phone number is <strong><span class="callerPhone"></span></strong> and their main reason for calling is <strong>Hearing test / Hearing aid consultation</strong>. Please note in your system that this referral is from Healthy Hearing, as part of your paid membership. Please call us back at 732-412-1215 to verify that you've reached the consumer.
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
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
		<!-- Direct Book Hearing Test? -->
		<div class="wantsHearingTest hidden">
			<?php if ($showScript): ?>
				<div class="row">
						<div class="col-md-offset-3 col-md-9">
						<div class="well green-well">
							Do you need a hearing test?
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?= $this->Form->control('ca_call_group.wants_hearing_test', [
				'label' => [
					'class' => 'col col-md-3 control-label',
					'text' => 'Hearing test?'
				],
				'type' => 'select',
				'options' => [
					0 => 'No',
					1 => 'Yes',
				],
				'default' => 0
			])
			?>
		</div>


	</div>
	<!-- Is this a prospect call? -->
	<div class="prospectOptions">
		<?php
		$quickPickProspects = CaCallGroup::$prospectOptions;
		unset($quickPickProspects['prospect_unknown']);
		echo $this->Form->control('ca_call_group.prospect', [
			'label' => [
				'class' => 'col col-md-3 control-label',
				'text' => 'Prospect?'
			],
			'type' => 'select',
			'options' => $quickPickProspects,
			'default' => CaCallGroup::PROSPECT_YES,
		]);
		?>
	</div>
	<hr>
	<div class="prospectTopic">
		<?= $this->Form->control('ca_call_group.score', [
			'class' => 'form-control quickPickScore',
			'type' => 'select',
			'options' => CaCallGroup::$scores,
			'empty' => true,
		])
		?>
	</div>
	<!-- Appointment Date -->
	<div class="appt_date hidden">
		<div class="directBookQuickPick hidden">
			<?= $this->Form->control('ca_call_group.is_bringing_third_party', [
				'label' => [
					'class' => 'col col-md-3 control-label',
					'text' => 'Will patient bring a 3rd party?'
				],
				'type' => 'select',
				'options' => [
					0 => 'No',
					1 => 'Yes',
				],
				'default' => 0
			])
			?>
		</div>
		<?= $this->Form->control('ca_call_group.appt_date', [
			'class' => 'form-control datepicker inline-date',
			'interval' => 15,
			'minYear' => '2016',
			'maxYear' => date("Y", strtotime('+1 year')),
		])
		?>
	</div>

	<!-- Scheduled Call Date -->
	<div class="scheduled_call_date hidden">
		<?= $this->Form->control('ca_call_group.scheduled_call_date', [
			'class' => 'form-control datepicker inline-date',
			'interval' => 15,
			'minYear' => '2016',
			'maxYear' => date("Y", strtotime('+2 years')),
		])
		?>
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
echo $this->Form->control('ca_call_group.is_review_needed', [
	'label' => [
		'class' => 'control-label',
		'text' => ' Needs supervisor review'
	],
	'style' => 'margin-left: 23%;'
]);
?>
