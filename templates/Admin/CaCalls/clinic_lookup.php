<?php
use App\Model\Entity\CaCallGroup;

echo $this->element('ca_calls/ca_call_js_variables');
$this->Html->script('dist/ca_call_edit.min', ['block' => true]);

echo $this->element('ca_calls/action_bar');

if (isset($caCall->user_id)) {
	$agentName = $this->App->getUserName($caCall->user_id);
}
$id = empty($caCall->id) ? "" : $caCall->id;
$groupId = empty($caCall->ca_call_group_id) ? "" : $caCall->ca_call_group_id;
$status = empty($caCall->ca_call_group->status) ? CaCallGroup::STATUS_NEW : $caCall->ca_call_group->status;
$callType = isset($caCall->call_type) ? $caCall->call_type : '';
$noteCount = isset($caCall->ca_call_group->ca_call_group_notes) ? count($caCall->ca_call_group->ca_call_group_notes) : 0;
?>

<h2>Return call from clinic</h2>
<?php echo $this->Form->create($caCall); ?>
	<?php
	echo $this->Form->hidden('id', ['id' => true]);
	echo $this->Form->hidden('ca_call_group_id', ['id' => true]);
	echo $this->Form->hidden('start_time', ['id' => true]);
	echo $this->Form->hidden('user_id', ['id' => true]);
	echo $this->Form->hidden('call_type', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.id', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.location_id', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.is_prospect_override', ['id' => true]);
	echo $this->Form->hidden('ca_call_group.status', ['id' => true]);
	?>
	<table class="table table-striped table-bordered table-condensed">
		<tr><th class="tar">Group ID</th>
			<td class="col-md-9">
				<span class="callGroupId"><?php echo $this->Html->link($groupId, array('controller' => 'ca_call_groups', 'action' => 'edit', $groupId)); ?></span>
			</td>
		</tr>
		<tr><th class="tar">Status</th>
			<td class="col-md-9">
				<span class="status"><?php echo CaCallGroup::$statuses[$status]; ?></span>
			</td>
		</tr>
		<?php if (isset($caCall->start_time)): ?>
			<tr><th class="tar">Start Time</th>
				<td class="col-md-9">
					<?php echo $caCall->start_time; ?>
				</td>
			</tr>
		<?php endif; ?>
		<?php if (!empty($caCall->duration)): ?>
			<tr><th class="tar">Duration</th>
				<td class="col-md-9">
					<?php echo gmdate('H:i:s', $caCall->duration); ?>
				</td>
			</tr>
		<?php endif; ?>
		<?php if (!empty($agentName)): ?>
			<tr><th class="tar">Agent</th>
				<td class="col-md-9">
					<?php echo $agentName; ?>
				</td>
			</tr>
		<?php endif; ?>
		<tr><th class="tar">Clinic</th>
			<td class="col-md-9" id="clinic-data">
				<div class="row">
					<div class="col-md-9">
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
			</td>
		</tr>
	</table>

	<div class="form_fields">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					Hello, this is Healthy Hearing and my name is <?php echo $user['first_name']; ?>. Thank you for returning our call. This call is being recorded for quality assurance. Can you tell me your Oticon ID number or your clinic name?
				</div>
			</div>
		</div>
		<?php echo $this->Form->control('location_search', ['label' => 'Clinic search']); ?>
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					And who am I speaking with?
				</div>
			</div>
		</div>
		<?php
		echo $this->Form->control('ca_call_group.front_desk_name', [
			'autocomplete' => 'off',
		]);
		?>
		<?php echo $this->element('ca_calls/lookup_script'); ?>
		<div class="group-found-buttons" style="display:none;">
			<div class="form-actions tar">
				<input type="button" tabindex="1" value="Call disconnected / incomplete" class="btn btn-lg btn-default" id="disconnectedBtn">
				<input type="submit" tabindex="1" value="Save Call" class="btn btn-primary btn-lg" id="submitBtn">
			</div>
		</div>
	</div>
</form>
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
	// Global javascript variables
	window.isCallDateSet = <?php echo json_encode(isset($caCall->ca_call_group->scheduled_call_date)); ?>;
	window.IS_CLINIC_LOOKUP_PAGE = <?php echo json_encode(true); ?>;
	window.IS_CALL_GROUP_EDIT_PAGE = <?php echo json_encode(false); ?>;
</script>
