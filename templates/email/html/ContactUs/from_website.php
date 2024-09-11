<?= $siteName . ',' ?><br /><br />

<b>Message From Website</b><br />

<p><?= $message ?></p><br /><br />

<p><b>Contact Details:</p></p>
<?= $this->element('email/contact', ['contact' => $contact]) ?><br /><br />

Thanks,<br />
<?= $contact['Contact']['first_name'] ?> <?= $contact['Contact']['last_name'] ?>