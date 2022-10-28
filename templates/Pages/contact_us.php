<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 * @var \App\Form\ContactUsForm $contactUsForm
 */

use Cake\Core\Configure;
?>

<?php
echo $this->Form->create($contactUsForm);
echo $this->Form->control('first_name', ['placeholder' => 'First name']);
echo $this->Form->control('last_name', ['placeholder' => 'Last name']);
echo $this->Form->control('phone', ['placeholder' => 'Phone']);
echo $this->Form->control('email', [
    'label' => 'Email*',
    'placeholder' => 'Email',
]);
echo $this->Form->control('zip', [
    'label' => Configure::read('zipLabel'),
    'placeholder' => Configure::read('zipLabel'),
]);
echo $this->Form->control('subscribe', [
    'checked' => true,
    'label' => 'Subscribe to our newsletter',
]);
echo $this->Form->control('hearing_care_professional', [
    'label' => 'I am a hearing care professional',
]);
echo $this->Form->control('message', [
    'label' => 'Message*',
    'maxlength' => '1000',
    'style' => 'min-height: 172px',
]);
echo $this->Form->button('Send Message');
echo $this->Form->end();

echo $page->content;
