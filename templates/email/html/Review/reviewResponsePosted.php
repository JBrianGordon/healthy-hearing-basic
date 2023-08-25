<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>

<?php echo Configure::read('siteName') . ','; ?><br /><br />

<b>Hi! Your review response was posted!</b><br />

<p>
   <?php print_r($reviewData); ?>
</p>