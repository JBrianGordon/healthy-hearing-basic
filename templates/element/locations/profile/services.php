<?php
	$services = $location->services;
	$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($location->id);
?>
<?php if ($services && $isEnhancedOrPremier): ?>
<section id="clinicServices" class="panel panel-primary">
	<div id="earqServices"></div>
	<header class="panel-heading text-center">
		<h2 style="clear:both" id="services">Hearing care services</h2>
	</header>
	<div class="panel-body">
		<div class="panel-section">
			<?php echo $services; ?>
		</div>
	</div>
</section>
<?php endif; ?>