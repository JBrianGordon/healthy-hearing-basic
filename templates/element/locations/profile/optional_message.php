<?php
	$optionalMessage = trim($location->optional_message);
	$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($location->id);
?>
<?php if ($isEnhancedOrPremier && !empty($optionalMessage)): ?>
	<section id="optionalMessage" class="panel panel-primary">
		<h2>A message from <?= $location->title ?>:</h2>
		<p class="mb0"><?= $optionalMessage ?></p>
	</section>
<?php endif; ?>