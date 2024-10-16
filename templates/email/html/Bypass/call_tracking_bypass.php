<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
<?php $env = Configure::read('env'); ?>
<?= Configure::read('siteName') ?> Team,<br>

<?php if ($isCallTrackingBypassed): ?>
	<p>
		Call Tracking has been temporarily disabled for upgraded clinics. The FAC will now display the clinic's main phone number, rather than the call tracking number.
	</p>
<?php else: ?>
	<p>
		Call Tracking has been re-enabled for upgraded clinics.
	</p>
<?php endif; ?>
<?php if ($env != 'prod'): ?>
	<p>
		(Environment = <?= Configure::read('env') ?>)
	</p>
<?php endif; ?>