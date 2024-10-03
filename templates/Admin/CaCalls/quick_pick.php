<?php
use App\Model\Entity\CaCallGroup;

$status = empty($caCall->ca_call_group->status) ? CaCallGroup::STATUS_NEW : $caCall->ca_call_group->status;
$callType = isset($caCall->call_type) ? $caCall->call_type : '';
$isWrongNumber = ($status == CaCallGroup::STATUS_WRONG_NUMBER) ? true : false;

echo $this->element('ca_calls/ca_call_js_variables');
$this->Html->script('dist/ca_call_quick_pick.min', ['block' => true]);

echo $this->element('ca_calls/action_bar');
?>
<h2>Inbound Call - Clinic Quick Pick</h2>
<?php
echo $this->Form->create($caCall);
?>
	<?php
	echo $this->Form->hidden('ca_call_group_id', ['id' => true]);
	echo $this->Form->hidden('start_time', ['id' => true]);
	echo $this->Form->hidden('user_id', ['id' => true]);
	echo $this->Form->hidden('call_type', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.id', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.location_id', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.is_prospect_override', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.status', ['id' => true]);
	?>

	<div class="form_fields">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					Thank you for calling Healthy Hearing! We are a resource for people with hearing loss. My name is <?php echo $user['first_name']; ?> and I’m here to help you set up a hearing test appointment with a hearing care professional near you! In order to get started, may I please have your first name?
				</div>
			</div>
		</div>
		<?php
		echo $this->Form->control('is_wrong_number', [
			'type' => 'checkbox',
			'label' => [
				'class' => 'control-label',
				'text' => 'Wrong number?'],
			'default' => $isWrongNumber,
		]);
		?>
		<div class="valid_number">
			<?php
			echo $this->element('ca_calls/quick_pick_call_script', [
				'showScript'=>true,
				'noteCount'=>0
			]);
			?>
		</div>
	</div>
	<div class="form-actions tar">
		<input type="button" tabindex="1" value="Call disconnected / incomplete" class="btn btn-lg btn-default" id="disconnectedBtn">
		<input type="submit" tabindex="1" value="Save Call" class="btn btn-primary btn-lg" id="submitBtn">
	</div>
<?php echo $this->Form->end(); ?>
<?php $this->append('bs-modals'); ?>
	<div id="note-required" class="modal fade">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body">
					<?php echo 'Please fill in \'Notes\' field.'; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Okay</button>
				</div>
			</div>
		</div>
	</div>
<?php $this->end();?>
<script type="text/javascript">
	window.IS_CLINIC_LOOKUP_PAGE = false;
	window.IS_CALL_GROUP_EDIT_PAGE = false;
</script>
