<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
Dear <?= $clinicTitle ?> team, <br /><br />

You are being notified that the Healthy Hearing profile for your office has been updated.<br /><br />

You can view the profile here: <?= $this->Html->link(Router::url($url, true)) ?><br /><br />

This profile is currently a basic profile. For a low monthly or annual fee, an upgraded Healthy Hearing profile can boost your office’s online visibility. Upgraded profiles average significantly more calls than basic profiles. When you’re ready to start setting your profile(s) apart, find more information on our site at <a href="https://healthyhearing.com/clinic" target="_blank">https://healthyhearing.com/clinic</a>. Questions before you commit? Please give us a call at 1 800 567 1692 or respond to this email.<br /><br />
<?= $this->element('email/footer') ?>