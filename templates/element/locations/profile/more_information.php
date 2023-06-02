<?php
	$about = $location->about_us;
	$services = $location->services;
	$slogan = $location->slogan;
	$isEnhancedOrPremier = $this->Clinic->isEnhancedOrPremierByLocationId($location->id);
?>
<?php if ($about || $services): ?>
	<section id="moreInformation" class="panel panel-primary">
		<header class="panel-heading text-center">
			<h2>Clinic details</h2>
		</header>
		<div class="panel-body">
			<div class="panel-section">
				<?php if($location->is_ida_verified): ?>
					<div class="ida-container tac">
						<a href="#idaAnchor" class="ida-link">
							<img loading="lazy" class="ida-badge" alt="Clinic badge from Ida Institute" src="/img/ida_badge.png"width="120" height="120">
						</a>
					</div>
				<?php endif; ?>
				<?php if ($about): ?>
						<div class="about-container">
						<?php if ($slogan): ?>
							<div class="slogan"><?php /*** TODO: uncomment when getSlogan built in clinic helper***: echo $this->Clinic->getSlogan($location);*/ ?></div>
						<?php endif; ?>
						<?php echo $about; ?>
						</div>
				<?php endif; ?>
				<?php if ($services && !$isEnhancedOrPremier): ?>
					<div id="earqServices"></div>
					<h2 style="clear:both" id="services">Hearing care services</h2>
					<?php echo $services; ?>
				<?php endif; ?>
		</div>
	</section>
<?php endif; ?>