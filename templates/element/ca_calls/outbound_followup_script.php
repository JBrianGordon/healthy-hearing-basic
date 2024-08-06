<?php
/*
This portion of the outbound call script for followup calls is reused in multiple places
*/
use App\Model\Entity\CaCallGroup;
?>
<?php
echo $this->Form->control('ca_call_group.caller_first_name');
echo $this->Form->control('ca_call_group.caller_last_name');
echo $this->Form->control('ca_call_group.caller_phone');
echo $this->Form->control('ca_call_group.is_patient', [
	'label' => 'Self',
	'default' => true,
]);
?>
<div class="patient-data" style="display:none;">
	<?php echo $this->Form->control('ca_call_group.patient_first_name'); ?>
	<?php echo $this->Form->control('ca_call_group.patient_last_name'); ?>
</div>
<div class="form-group mb30">
	<label class="col col-md-3 control-label">Topic</label>
	<div class="col col-md-9">
		<div class="row">
			<div class="col col-md-6">
				<?php echo $this->element('ca_calls/ca_call_topics'); ?>
			</div>
			<div class="checkbox col col-md-6">
				<?php
				foreach (CaCallGroup::$col2Topics as $topicKey => $label) {
					echo $this->Form->control('ca_call_group.'.$topicKey, array(
						'label' => [
							'class' => 'control-label pt0',
							'style' => 'text-align:left;',
							'text' => '<span class="topic-label">'.$label.'</span>'],
					));
				}
				?>
			</div>
		</div>
	</div>
</div>
<!-- Hearing Aid Age -->
<div class="aid_age_topic hidden">
	<?php
	$hearingAidAge = 'new';
	if (!empty($this->request->data['CaCallGroup']['topic_aid_lost_old']) || !empty($this->request->data['CaCallGroup']['topic_warranty_old'])) {
		$hearingAidAge = 'old';
	}
	echo $this->Form->control('ca_call_group.hearingAidAge', array(
		'label' => 'Hearing aid age?',
		'type' => 'select',
		'options' => [
			'new' => 'Hearing aid is under 3 years old',
			'old' => 'Hearing aid is 3 years or older',
		],
		'default' => $hearingAidAge
	));
	?>
</div>

<?php
echo $this->Form->control('ca_call_group.prospect', array(
	'label' => 'Prospect?',
	'type' => 'select',
	'options' => CaCallGroup::$prospectOptions,
	'default' => CaCallGroup::PROSPECT_NO,
));
?>
<div class="prospectTopic" style="display:none;">
	<?php
	echo $this->Form->control('ca_call_group.score', array(
		'type' => 'select',
		'options' => CaCallGroup::$scores,
		'empty' => true,
	));
	?>
</div>
<div class="appt_date" style="display:none;">
	<?php
	echo $this->Form->control('ca_call_group.appt_date', array(
		'class' => 'form-control datepicker inline-date',
		'interval' => 15,
		'minYear' => '2016',
		'maxYear' => date("Y", strtotime('+1 year')),
	));
	?>
</div>
