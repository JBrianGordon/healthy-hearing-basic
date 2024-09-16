<?php if (pluckIsValid($requestData,"/Recipient/first_name")): ?>
<?= implode(' ',asArray([
	pluck($requestData,'/Recipient/salutation'),
	pluck($requestData,'/Recipient/first_name'),
	pluck($requestData,'/Recipient/last_name'),
	])) ?>,<br/>
<br/>
<?php else: ?>
<?= implode(' ',asArray([
	pluck($requestData,'/Contact/salutation'),
	pluck($requestData,'/Contact/first_name'),
	pluck($requestData,'/Contact/last_name'),
	])) ?>,<br/>
<br/>
<?php endif; ?>
