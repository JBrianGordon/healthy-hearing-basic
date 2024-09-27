<?php
use App\Model\Entity\CaCallGroup;

$body = strip_tags($note->body, '<div><ul><li><a><span><br>');
$status = isset(CaCallGroup::$statuses[$note->status]) ? CaCallGroup::$statuses[$note->status] : '';
?>
<div class="single_note">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="note_who"><?php echo $this->Clinic->getUserName($note->user_id); ?></td>
			<td class="status"><?php echo $status; ?></td>
			<td class="when"><?php echo dateTimeCentralToEastern($note->created); ?></td>
			<td class="delete">
				<?php echo $this->Html->link('Delete', ['controller' => 'ca_call_group_notes', 'action' => 'delete', $note->id], ['class' => 'btn btn-danger btn-xs'], 'Are you sure?'); ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="body"><?php echo $body; ?></td>
		</tr>
	</table>
</div>
