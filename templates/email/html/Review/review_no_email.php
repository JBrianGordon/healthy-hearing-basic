<?php $approvedDenied = $isDenied ? 'denied' : 'approved'; ?>

You <?= $isDenied ? 'denied' : 'approved' ?> a review for <?= $clinicName ?> (<?= $id ?>). 
<?php if (empty($url)): ?>
	They do not currently have a public profile. They were not sent an email regarding this new review.
<?php else: ?>
	<?= $clinicName ?> does not have an email address.<br /><br />
<?php endif; ?>