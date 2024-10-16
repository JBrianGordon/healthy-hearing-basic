<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<p>Dear <?= $clinic->title ?> team,</p>

<p>Congratulations!</p>

<p>The <?= Configure::read('siteName') ?> profile for your clinic has just received a new review. You can view the profile and see the review here:</p>

<p><?= $this->Html->link(Router::url($clinic->hh_url, true)) ?></p>

<?php if (Configure::read('country') === 'US'): ?>
	<p>Reviews are an effective way to build your clinic’s online reputation and help this profile stand out amongst the competition; <?= Configure::read('siteName') ?> profiles with reviews get three times more calls and appointments than those without reviews. Don’t be shy about requesting reviews from your patients.</p>
	<p>You can respond to reviews by logging into your Healthy Hearing profile and clicking the Reviews button.</p>
<?php else: ?>
	<p>Reviews are an effective way to build your clinic’s online reputation and help this profile stand out amongst the competition so don’t be shy about requesting reviews from your patients.</p>
<?php endif ?>

<p>Please contact us by calling <?= Configure::read('phone') ?> or emailing <?= Configure::read('customer-support-email') ?> if you have any questions about reviews or would like suggestions about how to obtain more.</p>

<?= $this->element('email/footer') ?>