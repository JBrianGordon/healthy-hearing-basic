<?php
/*
These buttons are displayed in the action bar for all Call Assist admin pages.
*/
$spamCount = isset($spamCount) ? $spamCount : 0;
// TODO: some features only for call supervisor or admin. Is there a better way to check this?
$user = $this->Identity->get();
$isCallSupervisor = $user['is_call_supervisor'] || $user['is_admin'];
?>
<?= $this->Html->link("<i class='bi bi-plus-lg'></i> Inbound call", ['controller' => 'ca_calls', 'action' => 'edit'], ['class' => 'btn btn-success', 'escape' => false]) ?>
<?= $this->Html->link("<i class='bi bi-plus-lg'></i> Call from clinic", ['controller' => 'ca_calls', 'action' => 'clinic_lookup'], ['class' => 'btn btn-success', 'escape' => false]) ?>
<?= $this->Html->link("<i class='bi bi-plus-lg'></i> Quick Pick", ['controller' => 'ca_calls', 'action' => 'quick_pick'], ['class' => 'btn btn-success', 'escape' => false]) ?>
<?php if ($spamCount): ?>
	<?php $class = $isCallSupervisor ? 'btn btn-danger' : 'btn btn-danger disabled'; ?>
	<?= $this->Html->link("Delete Spam (".$spamCount.")", ['controller' => 'ca_call_groups', 'action' => 'delete_spam'], ['class' => $class, 'escape' => false], 'Are you sure you want to delete '.$spamCount.' spam call groups?') ?>
<?php endif; ?>
<?= $this->Html->link("<i class='bi bi-megaphone-fill'></i> Outbound calls", ['controller' => 'ca_call_groups', 'action' => 'outbound'], ['class' => 'btn btn-default', 'escape' => false]) ?>
<?php /* HIDE SURVEYS #15351
<?= $this->Html->link("<i class='bi bi-megaphone-fill'></i> Survey Calls", ['controller' => 'ca_call_groups', 'action' => 'surveys'], ['class' => 'btn btn-default', 'escape' => false]) ?>
*/ ?>
<?php if ($isCallSupervisor): ?>
	<?= $this->Html->link("Calls", ['controller' => 'ca_calls', 'action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
	<?= $this->Html->link("Call groups", ['controller' => 'ca_call_groups', 'action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
<?php endif; ?>
