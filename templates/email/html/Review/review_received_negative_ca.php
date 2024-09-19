<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<p>Dear <?= $clinicTitle ?> team,</p>

<p>The <?= $siteName ?> profile for <?= $clinicTitle ?> at <?= $clinicAddress ?> just received a new review.</p>

<p>At <?= $siteName ?>, we get many consumer reviews of clinics and the vast majority of them are positive. As we all know, though, it's not possible to please everyone. Sometimes consumers submit reviews that are less than positive or express mixed feelings.</p>

<p>To read this review, please visit the profile at:</p>

<?= $this->Html->link(Router::url($url, true)) ?>

<p>We strongly encourage you to respond to a negative review. A recent survey by BrightLocal found that 89% of consumers read local businesses’ responses to reviews. In fact, even our own user testing revealed that how the clinic responded to a negative review was more important than the negative review itself.</p>

<p>To write a response to this review, please <?= $this->Html->link('click here', $this->Html->url('/clinic', true)) ?>. Your <?= $siteName ?> account number is <strong><?= $clinicUsername ?></strong>. After you are logged in, click on the Reviews tab to see and respond to this review.</p>

<p>Here are some suggestions for responding to a negative review:</p>
<ul>
	<li>Don’t take it personally or become angry. Negative reviews can actually build your business if you respond appropriately.</li>
	<li>Be sincere and apologetic.</li>
	<li>If the complaint is specific, address the details from the negative review so the complainer knows that he or she has been heard.</li>
	<li>Proofread. Make sure your response is clear, articulate and professional.</li>
	<li>Be mindful of patient privacy – don’t reveal anything specific about a patient's health information. Suggest that the complainer contact you personally to discuss their situation privately if necessary.</li>
</ul>

<p>Please remember that the original reviewer is not notified directly if and when you submit a response. Responding to a review is a way to demonstrate to future profile visitors that your office team cares about customer satisfaction.</p>

<p>If you have any questions, please contact the <?= $siteName ?> team at <?= Configure::read('phone') ?> or <?= Configure::read('customer-support-email') ?>. We would be happy to give you one on one help with this.</p>

<?= $this->element('email/footer') ?>
