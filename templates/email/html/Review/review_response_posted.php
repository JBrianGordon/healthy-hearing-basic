<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
Dear <?= $clinicTitle ?> team, <br /><br />

Thank you for submitting a response to a review of your clinic <?= $clinicTitle ?>. Your response has been posted on your profile. You can view it here: <?= $this->Html->link(Router::url($url, true)) ?>.<br /><br />

When a clinic receives a review that is less than positive, a sincere reply from the clinic can help build a positive reputation. The original reviewer is not notified if and when you submit a response. However, responding to a review is a great way to demonstrate to future profile visitors that your clinic team takes customer satisfaction seriously.<br /><br />

Reviews are an effective way to build your clinic’s online reputation and help this profile stand out amongst the competition; <?= Configure::read('siteName') ?> profiles with reviews get three times more calls and appointments than those without reviews. Don’t be shy about suggesting to all of your patients that they review your practice.<br /><br />

If you have any questions about reviews or would like suggestions about how to obtain more, please contact us at <?= $this->Html->link(Configure::read('customer-support-email'), 'mailto:' . Configure::read('customer-support-email')) ?>.<br /><br />

<?= $this->element('email/footer') ?>