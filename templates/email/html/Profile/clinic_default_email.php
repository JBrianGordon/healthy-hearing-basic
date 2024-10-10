<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<p>Dear <?= $clinicTitle; ?> team,</p>

<p>
<?php
	if ($isUS) {
		$listingAndSite = ' ';
		if(isset($emailArray) && isset($emailArray['listingType'])) {
			$listingAndSite .= $emailArray['listingType'] . ' ';
		}
		$listingAndSite .= $siteName;
		echo 'The ' . $listingAndSite . ' profile for ' . $clinicTitle . ' at ' . $clinicAddress . ' is here:</p>';
	} else {
		echo "Your clinic has a profile in the Find a Clinic directory on " . Configure::read('siteUrl') . ", as a complimentary perk for loyal Oticon customers. The " . Configure::read('siteName') . " profile for " . $clinicTitle . " at " . $clinicAddress . " is here:</p>";
	}
 ?>

<p><?= Router::url($hhUrl, true) ?></p>

<?php if ($isUS): ?>
<p><?= Configure::read('siteName') ?> is the internet's leading source of consumer information about hearing loss and hearing aids, with millions and millions of visitors a year. It’s also a valuable lead-generating resource for hearing clinics; we send consumer telephone calls to hearing clinics listed in our directory, resulting in thousands of appointments set and hearing aids sold each year.</p>
<?php endif ?>

<p>To maximize the referral-generating potential of this <?= Configure::read('siteName') ?> profile for your clinic, please ensure that the profile is completed and kept up to date so consumers can find your clinic online.</p>

<p><?php if ($isUS){echo '<strong>';}?>To log in and edit the profile for this location, please <?= $this->Html->link('click here', Router::url('/clinic', true)) ?>. Your <?= Configure::read('siteName') ?> account number is <?php if (!$isUS){echo '<strong>';}?><?= $clinicUsername ?><?php if (!$isUS){echo '</strong>';}?>. Your <?= Configure::read('siteName') ?> password is <?php if (!$isUS){echo '<strong>';}?><?= $defaultPassword ?><?php if (!$isUS){echo '</strong>';}?> and it is case-sensitive. Please keep this username and password someplace handy so you can log back in later and check on your calls and reviews, as well as make updates to the profile as necessary.<?php if ($isUS){echo '</strong>';}?></p>

<p>Please check all of the sections of the clinic profile and complete or edit them as needed, including a description of the clinic, a list of services offered, hearing care practitioner names, credentials, biographies and photos, your clinic website and social media URLs, as well as the hours of operation and payment types accepted. If you need to make changes to the clinic address or the phone number where your referral calls are sent, please reply to this email and we will assist you.</p>

<p>After you’re logged into this profile, please visit our <?= $this->Html->link('Frequently Asked Questions', Router::url('/clinic/pages/faq', true)) ?> section to learn more about how this <?= Configure::read('siteName') ?> profile works to benefit your practice.</p>

<p>We are looking forward to helping more consumers find your practice. Remember, keeping your practice information complete and accurate in the profile helps more consumers find you, so please log in and complete or edit the profile as needed. If you have any questions at all, please contact us at <?= Configure::read('customer-support-email') ?> or <?= Configure::read('phone') ?>.</p>

<?= $this->element('email/footer') ?>