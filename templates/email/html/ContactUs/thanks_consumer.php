<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

$locations = TableRegistry::getTableLocator()->get('Locations');
//$zipUrl = Router::url($locations->findUrlByZip($contact['zip']), true); 
?>
<?= $this->element('email/header') ?>
Thank you for contacting <?= $siteName ?>. We are a website that provides information about hearing loss and hearing aids. Our customer support team works Monday - Friday, 8am to 5pm Eastern time. You will be contacted by phone or email in response to your question as soon as we are available to respond.
<br /><br />
Please note -- your message has gone to <?= $siteName ?>, not a hearing clinic. If you're trying to reach a hearing clinic, please use the find a clinic feature on our website to find the phone number for a local hearing clinic in your area and call them to ask your questions. Here is what we found based on the <?= strtolower(Configure::read('zipLabel')) ?> you provided: 

<br /><br />
<?= $this->element('email/footer-no-ps') ?>