<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
Hi <?= $clinicTitle ?> team, <br><br>

Here’s a quick snapshot of the activity on the Healthy Hearing profile for <?= $clinicTitle ?> at <?= $clinicAddress ?>:<br><br>
 
<strong>Last month (<?= date("F", strtotime("last month")) ?>) &ndash;</strong><br>
This Healthy Hearing profile was visited <strong><?= $profileViewsForMonth ?></strong> 
<?= simplePluralize(['time'], $profileViewsForMonth) ?>.<br>
<?php if ($callsForMonth['all_calls']['total'] > 0): ?>
	The unique tracking phone number for this Healthy Hearing profile received <strong><?= $callsForMonth['all_calls']['total'] ?></strong> <?= simplePluralize(['call'], $callsForMonth['all_calls']['total']) ?>.<br>
	<?php if ($callsForMonth['prospect_calls']['total'] > 0): ?>
		Of those calls, <strong><?= $callsForMonth['prospect_calls']['total'] ?></strong>
<?= simplePluralize([' was a prospect', ' were prospects'], $callsForMonth['prospect_calls']['total']) ?> (people who were potentially in the market for a hearing aid).<br>
	<?php endif ?>
	<?php if ($callsForMonth['appointment_calls']['total'] > 0): ?>
	 	<strong><?= $callsForMonth['appointment_calls']['total'] ?></strong> of those prospects set an appointment.<br>
	<?php endif ?>
<?php endif ?>
<br>

<?php if ($januaryReport): ?>
	<strong>Last year (<?= date("Y",strtotime("last year")) ?>) &ndash;</strong><br>
<?php else: ?>
	<strong>Year to date (since January 1st, <?= date("Y",strtotime("this year")) ?>) &ndash;</strong><br>
<?php endif ?>
This Healthy Hearing profile was visited <strong><?= $profileViewsYTD ?></strong> 
<?= simplePluralize(['time'], $profileViewsYTD) ?>.<br>
<?php if ($callsYTD['all_calls']['total'] > 0): ?>
	The unique tracking phone number for this Healthy Hearing profile received <strong><?= $callsYTD['all_calls']['total'] ?></strong> <?= simplePluralize(['call'], $callsYTD['all_calls']['total']) ?>.<br>
	<?php if ($callsYTD['prospect_calls']['total'] > 0): ?>
		Of those calls, <strong><?= $callsYTD['prospect_calls']['total'] ?></strong> 
<?= simplePluralize([' was a prospect', ' were prospects'], $callsYTD['prospect_calls']['total']) ?> (people who were potentially in the market for a hearing aid).<br>
	<?php endif ?>
	<?php if ($callsYTD['appointment_calls']['total'] > 0): ?>
	 	<strong><?= $callsYTD['appointment_calls']['total'] ?></strong> of those prospects set an appointment.<br>
	<?php endif ?>
<?php endif ?><br>

<em>Please note:</em> As of summer 2023, your Healthy Hearing profile's traffic data is being pulled from an updated version of Google Analytics (G4) and our site began allowing users to opt out of tracking. We can only collect and share page views from users who were opted in to tracking. These changes may affect your previous results. The conversion metrics (your calls, prospects and appointments) are not affected by this change.<br><br>

<?= $this->Html->link('Click here', Router::url($clinicUrl, true)) ?> to check out the current profile for <?= $clinicTitle ?>.<br><br>
 
This profile currently has <strong><?= $reviewsApproved ?></strong>
<?php if ($reviewsApproved > 0): ?>
 	<?= simplePluralize(['review'], $reviewsApproved) ?> and an average review rating of <strong><?= $averageRating ?></strong>. The date of the most recent review published on this profile was <strong><?= $this->Time->format($lastReviewDate, '%B %e, %G') ?></strong>.
<?php else: ?>
	reviews.
<?php endif ?> For ideas about how to get more reviews, please <?= $this->Html->link('contact us', 'mailto:contacthh@healthyhearing.com?subject=Healthy Hearing profile reviews - ' . $clinicUsername) ?>.<br><br>
 
For more information or to make changes to the profile, please <?= $this->Html->link('click here', Router::url('clinic', true)) ?> and log in with 

<?php if (empty($clinicPassword)): ?>
	your username: <strong><?= $clinicUsername ?></strong><br>
<?php else: ?>
	these credentials &ndash; Username: <strong><?= $clinicUsername ?></strong>, Password: <strong><?= $clinicPassword ?></strong><br>
<?php endif ?>
After logging in, you can edit the profile, click "Reporting" to see more details about calls, or click "Reviews" to see more information about reviews.<br><br>

<?php if (!is_null($clinicLastLogin)): ?>
Our records show that the last login by clinic staff for this profile was on  <strong><?= $this->Time->format($clinicLastLogin, '%B %e, %G') ?></strong>.<br><br>
<?php endif ?>

If you have any questions or need assistance with this Healthy Hearing profile, please contact us at <?= $this->Html->link('contacthh@healthyhearing.com', 'mailto:contacthh@healthyhearing.com?subject=Healthy Hearing profile inquiry - ' . $clinicUsername) ?> or <a href="tel:+1-800-567-1692">1-800-567-1692</a>.<br><br>
 
Thanks for partnering with Healthy Hearing!<br>
<?php
	echo $this->Html->image(
		Configure::read('logo'), [
			'alt' => 'Healthy Hearing logo',
			'fullBase' => true,
			'width' => '200px'
		]
	);
?>