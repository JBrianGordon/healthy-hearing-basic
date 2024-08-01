<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
<?php $env = Configure::read('env'); ?>
<? $siteName ?> Team,<br>

<?php if ($isApptRequestBypassed): ?>
	<p>
		Appt Request Forms have been temporarily disabled.
	</p>
<?php else: ?>
	<p>
		Appt Request Forms have been re-enabled.
	</p>
<?php endif; ?>
<?php if ($env != 'prod'): ?>
	<p>
		(Environment = <?= Configure::read('env') ?>)
	</p>
<?php endif; ?>