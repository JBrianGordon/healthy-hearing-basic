<?php
use App\Model\Entity\CaCallGroup;
use Cake\Core\Configure;

$topicOptions = [
	CaCallGroup::TOPIC_WANTS_APPT => 'Hearing test or hearing aid consultation</span><span class="topic-label vwo-test-new-label pl5" style="display:none;">Difficulty hearing in certain situations',
	CaCallGroup::TOPIC_AID_LOST_OLD => 'Hearing aid lost or broken</span><span class="topic-label vwo-test-new-label pl5" style="display:none;">My hearing aid is lost or broken',
	CaCallGroup::TOPIC_APPT_FOLLOWUP => 'Follow-up after recent hearing aid fitting</span><span class="topic-label vwo-test-new-label pl5" style="display:none;">I need a follow-up appointment for adjustment to my hearing aids',
	CaCallGroup::TOPIC_TINNITUS => 'Ringing in the ear (tinnitus)</span><span class="topic-label vwo-test-new-label pl5" style="display:none;">Ringing, buzzing or hissing sounds in my ear(s)',
];
?>
<!-- Modal for online appointment request form -->
<div class="modal fade" id="apptRequestModal">
	<span id="apptRequestModalAnchor"></span>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<?= $this->Form->create(null, [
				'url' => [
					'controller' => 'CaCalls',
					'action' => 'ajaxApptRequest'
				],
				'class' => 'form-horizontal apptRequestForm',
			]) ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Request an appointment at <?= $location->title ?>:</h4>
				</div>
				<div class="modal-body">
					<?php
					echo $this->Form->hidden('CaCallGroup.location_id', ['value'=>$location->id]);
					echo $this->Form->hidden('CaCallGroup.is_patient', ['value'=>true]);
					echo $this->Form->hidden('CaCallGroup.is_appt_request_form', ['value'=>true]);
					echo $this->Form->hidden('CaCallGroup.traffic_source', ['value'=>'unknown']);
					echo $this->Form->hidden('CaCallGroup.traffic_medium', ['value'=>'unknown']);
					?>
					<div class='form-fields'>
						<?php
							echo $this->Form->input('CaCallGroup.caller_first_name', [
								'label' => 'Patient first name:',
								'placeholder' => 'First name',
								'required' => true,
								'autocomplete' => 'given-name',
								'maxlength' => 30
							]);
							echo $this->Form->input('CaCallGroup.caller_last_name', [
								'label' => 'Patient last name:',
								'placeholder' => 'Last name',
								'required' => true,
								'autocomplete' => 'family-name',
								'maxlength' => 30
							]);
							echo $this->Form->input('CaCallGroup.caller_phone', [
								'label' => 'Phone number:',
								'placeholder' => 'Phone number',
								'required' => true,
								'div' => 'form-group required',
								'autocomplete' => 'tel'
							]);
							echo $this->Form->input('CaCallGroup.email', [
								'type' => 'email',
								'label' => 'Email:',
								'placeholder' => 'Email address',
								'autocomplete' => 'email'
							]);
						?>
						<div class="form-group mb30">
							<label class="col col-md-3 control-label">Reason for appointment<br><small class="help-block">(Check all that apply)</small></label>
							<div class="col col-md-9">
								<div class="checkbox">
									<?php
									foreach ($topicOptions as $topicKey => $label) {
										echo $this->Form->control('CaCallGroup.'.$topicKey, [
											'type' => 'checkbox',
											'label' => [
												'class' => 'control-label pt0',
												'style' => 'text-align:left;',
												'text' => '<span class="topic-label vwo-test-old-label pl5">' . $label . '</span>',
											],
											'escape' => false,
											'wrapInput' => false,
											'div' => false,
										]);
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<p><small class="tac help-block"><?= Configure::read('siteName') ?> will contact you regarding your request as soon as possible.</small></p>
					<div class="row">
						<div class="col col-sm-12">
							<div id="apptRequestSubmitError" class="alert alert-danger tal hidden" role="alert">
								<button type="button" class="close" data-dismiss="alert">x</button>
								<span id="apptRequestSubmitErrorMessage">Error</span>
							</div>
						</div>
						<div class="col col-xs-12 col-sm-4 col-sm-offset-4">
							<button id="apptRequestSubmitBtn" type="submit" class="btn btn-secondary btn-block btn-lg">Submit</button>
						</div>
						<div class="g-recaptcha"
							 data-sitekey="<?= Configure::read('recaptchaPublicKey') ?>"
							 data-callback='submitApptRequest'
							 data-size="invisible">
						</div>
						<small class="help-block p20 tac">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" rel="noopener" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" rel="noopener" target="_blank">Terms of Service</a> apply.</small>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="apptRequestThankYouModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close pt10 pr10" data-dismiss="modal" aria-hidden="true">X</button>
				<h4 class="mt10 mb10">Thank you for requesting an appointment at <?= $location->title ?></h4>
			</div>
			<div class="modal-body">
				<p class="lead">
					<?= Configure::read('siteName') ?> will contact you as soon as possible to assist you.<br><br>
					Please note, submitting multiple forms on our site will result in you receiving multiple calls from our staff.
				</p>
			</div>
			<div class="modal-footer">
				<button id="renew-dismiss" class="btn btn-default btn-lg" data-dismiss="modal">Okay</button>
			</div>
		</div>
	</div>
</div>