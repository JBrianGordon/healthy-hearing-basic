<?php
    use Cake\Core\Configure;
?>
<?= Configure::read('siteName') . ',' ?><br /><br />

<b>Message From Website</b><br />

<p><?= $requestData['message'] ?></p><br /><br />

<p><b>Contact Details:</p></p>
<?= $this->element('email/contact', ['requestData' => $requestData]) ?><br /><br />

Thanks,<br />
<?= $requestData['first_name'] ?> <?= $requestData['last_name'] ?>