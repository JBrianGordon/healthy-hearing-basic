<?php $approvedDenied = $isDenied ? 'denied' : 'approved'; ?>

You <?= $isDenied ? 'denied' : 'approved' ?> a review for <?= $clinic->title ?> (<?= $clinic->id ?>).
<br><br>
<?php if ($clinic->is_active === false || $clinic->is_show === false): ?>
	They do not currently have a public profile. They were not sent an email regarding this new review.
<?php else: ?>
	This clinic does not have an email address.<br /><br />
<?php endif; ?>