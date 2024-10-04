<?php
use App\Model\Entity\CaCallGroup;

$body = strip_tags($note->body, '<div><ul><li><a><span><br>');
$status = isset(CaCallGroup::$statuses[$note->status]) ? CaCallGroup::$statuses[$note->status] : '';
?>
<div class="single_note m10">
	<table cellpadding="0" cellspacing="0" class="border-0 mb0">
		<tr>
			<td class="note_who border-0 p5" style="min-width:180px"><?= $this->App->getUserName($note->user_id) ?></td>
			<td class="status border-0 p5" style="min-width:200px"><?= $status ?></td>
			<td class="when border-0 p5" style="min-width:200px"><?= dateTimeCentralToEastern($note->created) ?></td>
			<td class="delete border-0 p5">
				<?= $this->Html->link('Delete', ['controller' => 'ca_call_group_notes', 'action' => 'delete', $note->id], ['class' => 'btn btn-danger btn-xs'], 'Are you sure?') ?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="body border-0 p5"><?= $body ?></td>
		</tr>
	</table>
</div>
