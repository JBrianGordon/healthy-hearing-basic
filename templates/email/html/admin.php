<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$greeting = empty($username) ? 'Hi,' : 'Hi '.$username.',';
$content = explode("\n", $content);
$filesize = empty($filesize) ? 0 : $filesize;
?>

<?= $greeting ?><br><br>

<?php foreach ($content as $line): ?>
	<p><?= $line ?></p>
<?php endforeach; ?>

<?php if ($filesize > 5000000): ?>
	<br>
	<strong>I'm sorry, but your file was larger than 5MB and could not be attached. Please try sending a smaller file.</strong>
<?php elseif ($filesize > 0): ?>
	<br>
	<strong>(File attached)</strong>
<?php endif; ?>

<br><br>
Sincerely,<br>
<?= Configure::read('siteName') ?>
