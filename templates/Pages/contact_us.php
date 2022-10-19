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
    echo $this->Form->control('email', ['placeholder' => 'Email']);
    echo $this->Form->control('zip', [
        'label' => Configure::read('zipLabel'),
        'placeholder' => Configure::read('zipLabel')
    ]);
    echo $this->Form->control('message', ['maxlength' => '1000']);
    echo $this->Form->button('Submit');
    echo $this->Form->end();
?>

<?= $page->content ?>