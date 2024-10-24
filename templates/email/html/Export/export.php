<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$username = empty($username) ? Configure::read('siteName') : $username;
?>

<?= $username . ',' ?><br><br>

<?php if ($filesize > 5000000): ?>
	Hi! I'm sorry, but your <?= $table ?> export was larger than 5MB and could not be sent. Please try exporting a smaller set of data.<br><br>
<?php else: ?>
	Hi! Your <?= $table ?> export is attached.<br><br>
<?php endif; ?>

Sincerely,<br>
<?= Configure::read('siteName') ?>