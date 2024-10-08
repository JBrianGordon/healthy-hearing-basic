<?php
/*
This portion of the script is reused in multiple places.
It is for looking up calls that need followup with a given clinic.
*/
?>
<div class="have-location-and-front-desk" style="display:none;">
	<div class="found-no-calls" style="display:none;">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					I'm sorry. I don't see any calls pending for your clinic. We must have made a mistake or taken care of that appointment already. Have a good day.
				</div>
			</div>
		</div>
	</div>
	<div class="found-multiple-calls" style="display:none;">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					I actually found <strong><span class="callCount">multiple</span></strong> calls that we recently made to your clinic. Let's start with the first one. If we get disconnected after the first one, then one of our agents will call you back to handle the next missed call.
				</div>
			</div>
		</div>
		<div id="group-search">
			<?php
			echo $this->Form->control('group_search', [
				'id' => 'CaCallGroupSearch',
				'class' => 'form-control group_search',
				'label' => [
					'class' => 'col col-md-3 control-label',
					'text' => 'Calls that need followup'
				],
				'type' => 'select',
				'empty' => true,
			]);
			?>
		</div>
	</div>
	<div class="lock-error" style="display:none;">
		<div class="row">
			<div class="col-md-offset-3 col-md-9">
				<div class="well blue-well">
					I'm sorry. That call seems to be locked. One of our other agents must be trying to set that appointment. Please hold while I determine whether I can unlock it.<br />
					<i class="text-muted">
						[Place clinic on hold]<br />
						Call is locked by: <span class="lockedBy"></span> - <span class="lockTime"></span>. Please verify it is safe to unlock.<br />
						<input type="button" tabindex="1" value="Unlock" class="btn btn-sm btn-default" id="unlockBtn">
					</i>
				</div>
			</div>
		</div>
	</div>
	<div class="group-found" data-group-id="0"></div>
</div>
