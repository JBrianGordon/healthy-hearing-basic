<?php
$body = strip_tags($note->body, '<div><ul><li><a><span><br><u>');
?>
<div class="single_note">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td class="note_who">
                <?php $username = $this->App->getUserName($note->user_id); ?>
                <?php if (!empty($username)): ?>
                    <?= $this->Html->link($username, ['controller' => 'users', 'action' => 'edit', $note->user_id]) ?>
                <?php endif; ?>
            </td>
            <td class="when">
                <?= dateTimeCentralToEastern($note->created) ?>
            </td>
            <td class="delete">
                <?= $this->Form->postLink(
                    'Delete',
                    ['controller' => 'location_notes', 'action' => 'delete', $note->id],
                    ['class' => 'btn btn-danger btn-xs'],
                    'Are you sure?')
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="body"><?= $body ?></td>
        </tr>
    </table>
</div>
