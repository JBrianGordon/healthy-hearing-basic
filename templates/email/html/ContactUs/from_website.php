<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>

<?php echo Configure::read('siteName') . ','; ?><br /><br />

<b>Message From Website</b><br />

<p><?php echo $contactInfo['message']; ?></p><br /><br />

<p><b>Contact Details:</p></p>
<!-- TO-DO: Contact Details -->

Thanks,<br />
<?php echo $contactInfo['first_name']; ?> <?php echo $contactInfo['last_name']; ?>