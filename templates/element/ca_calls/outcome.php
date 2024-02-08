<?php
/*
This outcome section may be used in multiple places
*/
use \App\Model\Entity\CaCallGroup;
?>
<div id="outcome" style="display:none;">
	<hr>
	<h4 class="col-sm-offset-3 col-sm-9">Outcome</h4>
	<?php
	echo $this->Form->control('ca_call_group.question_visit_clinic', [
		'options' => CaCallGroup::$questionVisitClinicAnswers,
		'empty' => 'Select One',
		'label' => 'Did patient visit clinic?',
		'required' => false
	]);
	echo $this->Form->control('ca_call_group.question_what_for', [
		'options' => CaCallGroup::$questionWhatForAnswers,
		'empty' => 'Select One',
		'label' => 'What was the appt for?',
		'required' => false
	]);
	echo $this->Form->control('ca_call_group.question_purchase', [
		'options' => CaCallGroup::$questionPurchaseAnswers,
		'empty' => 'Select One',
		'label' => 'Did they purchase hearing aid?',
		'required' => false
	]);
	echo $this->Form->control('ca_call_group.question_brand', [
		'options' => CaCallGroup::$questionBrandAnswers,
		'empty' => 'Select One',
		'label' => 'What brand?',
		'required' => false
	]);
	echo $this->Form->control('ca_call_group.question_brand_other', [
		'label' => 'Other',
		'required' => false,
		'placeholder' => '(fill in brand)'
	]);
	?>
	<hr>
</div>
