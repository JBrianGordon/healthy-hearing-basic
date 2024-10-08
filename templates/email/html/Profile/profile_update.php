<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
Dear <?= $clinicTitle ?> team, <br /><br />

You are being notified that your profile on <?= Configure::read('siteUrl') ?> has been updated.<br /><br />
 
View your profile online at <?= $this->Html->link(Router::url($url, true)) ?><br /><br />
	<br/>
If you have any questions or concerns <?= Configure::read('isCallAssistEnabled') ? "give us a call at " . Configure::read('phone') : "please email us at " . Configure::read('customer-support-email') ?>.<br />

<br/>
<?= $this->element('email/footer') ?>