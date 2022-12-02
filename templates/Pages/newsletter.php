<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Page $page
 * @var \App\Form\ContactUsForm $newsletterForm
 */
?>

<h1>Healthy Hearing newsletter</h1>

<?php
echo $this->Form->create($newsletterForm);
echo $this->Form->control('first_name', ['placeholder' => 'First name']);
echo $this->Form->control('last_name', ['placeholder' => 'Last name']);
echo $this->Form->control('email', [
    'label' => 'Email',
    'placeholder' => 'Email',
]);
echo $this->Recaptcha->display();
echo $this->Form->button('Send Message');
echo $this->Form->end();


echo $page->content;