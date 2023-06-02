<?php
	$locations = !empty($preferredClinicsNearMe) ? $preferredClinicsNearMe : [];
	$display = 'sameCountry';
	if (!empty($locations) && $this->Clinic->isDifferentCountry()) {
		$display = 'differentCountry';
	}
?>
<?php if(!empty($locations)): ?>
	<section class="panel panel-secondary">
		<header class="panel-heading text-center">
			<h3>Featured clinics near me</h3>
		</header>
		<div class="panel-body">
			<?php if ($display === 'sameCountry'): ?>
				<?php foreach($locations as $location): ?>
					<div class="panel-section condensed">
						<p class="text-small mb0">
							<?php echo $this->Clinic->addressLink($location); ?>
						</p>
					</div>
				<?php endforeach; ?>
				<div class="tac">
					<?php $nearMeLink = $this->Clinic->nearMeLink(); ?>
					<a href="<?php echo $nearMeLink; ?>" class="btn btn-primary btn-xs m10 pl10 pr10">See more clinics</a>
				</div>
			<?php elseif ($display === 'differentCountry'): ?>
				<div class="panel-section condensed">
					<?php echo $this->element('locations/near_me/different_country'); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
