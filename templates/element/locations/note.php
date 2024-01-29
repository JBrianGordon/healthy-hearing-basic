<div class="single_note">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="note_who"><?= $note->user_id ?></td>
			<td class="when"><?= $note->created ?></td>
			<td>Delete</td>
		</tr>
		<tr>
			<td colspan="3" class="body"><?= $note->body ?></td>
		</tr>
	</table>
</div>