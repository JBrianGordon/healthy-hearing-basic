<?php if (pluckIsValid($contact,"/Recipient/first_name")): ?>
<?= implode(' ',asArray([
	pluck($contact,'/Recipient/salutation'),
	pluck($contact,'/Recipient/first_name'),
	pluck($contact,'/Recipient/last_name'),
	])) ?>,<br/>
<br/>
<?php else: ?>
<?= implode(' ',asArray([
	pluck($contact,'/Contact/salutation'),
	pluck($contact,'/Contact/first_name'),
	pluck($contact,'/Contact/last_name'),
	])) ?>,<br/>
<br/>
<?php endif; ?>
