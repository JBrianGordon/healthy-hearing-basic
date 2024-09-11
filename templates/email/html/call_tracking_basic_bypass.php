<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
<?php $env = Configure::read('env'); ?>
<?= $siteName ?> Team,<br>

<?php if ($isCallTrackingBasicBypassed): ?>
	<p>
		Call Tracking has been temporarily disabled for basic clinics. The FAC will now display the clinic's main phone number, rather than the call tracking number.
	</p>
<?php else: ?>
	<p>
		Call Tracking has been re-enabled for basic clinics.
	</p>
<?php endif; ?>
<?php if ($env != 'prod'): ?>
	<p>
		(Environment = <?= Configure::read('env') ?>)
	</p>
<?php endif; ?>