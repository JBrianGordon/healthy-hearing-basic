<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<p>Dear <?= $clinicTitle ?> team,</p>

<p>The <?= Configure::read('siteName') ?> profile for <?= $clinicTitle ?> at <?= $clinicAddress ?> can be viewed here:</p>

<p><?= Router::url($hhUrl, true) ?></p>

<p>To edit the profile for this location, please <?= $this->Html->link('click here', Router::url('/clinic', true)) ?>. Your account number is <strong><?= $clinicUsername ?></strong>.</p>

<p>To reset your login password, please <?= $this->Html->link('click here', Router::url('/clinic/reset/' . $resetUrl, true)) ?>. After you’ve reset your password, please <?= $this->Html->link('click here', Router::url('/clinic', true)) ?> then log in using <strong><?= $clinicUsername ?></strong> as your username and your new password. It only takes a few minutes to reset your password so you can edit or complete the clinic profile, so please do that as soon as possible. The link is good for 24 hours from the time this email was sent.</p>

<p>After you’re logged into this profile, please visit our <?= $this->Html->link('Frequently Asked Questions', Router::url('/clinic/pages/faq', true)) ?> section to learn more about about how this <?= Configure::read('siteName') ?> profile works to benefit your practice.</p>

<p>We are looking forward to helping more consumers find your practice. Remember, keeping your practice information complete and accurate in the profile helps more consumers find you, so please log in and complete or edit the profile as needed.</p>

<p>If you have any questions at all, please contact us at <?= Configure::read('customer-support-email') ?> or <?= Configure::read('phone') ?>.</p>

<?= $this->element('email/footer') ?>