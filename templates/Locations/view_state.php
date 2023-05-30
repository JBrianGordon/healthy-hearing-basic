<?php
use Cake\Core\Configure;

$cities = $cities->toArray();
$cityColumns = 3;
$cityCount = count($cities);
$chunkedData = [];
if ($cityCount) {
	$chunkedData = array_chunk($cities, ceil($cityCount / $cityColumns), true);
}
$this->Breadcrumbs->add([
    ['title' => 'Find a clinic', 'url' => ['controller' => 'locations', 'action' => 'states']],
    ['title' => $stateNice, 'url' => ''],
]);
?>
<header class="col-md-12 inverse">
	<?= $this->Breadcrumbs->render() ?>
</header>
<div id="top" class="col-md-9 page-content fap-cities">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section">
				<h1 class="text-primary">Hearing clinics in <?php echo $stateNice; ?></h1>
				<p>We found <?php echo $totalClinics; ?> hearing aid <?php echo Configure::read('regionalSpelling.center'); ?>s located <?php echo $totalClinics > 0 ? 'in or near ' . $cityCount . ' cities ' : ''; ?>in <?php echo $stateNice; ?><?php if ($showMobileClinics): ?>, including <?php echo $mobileClinicsInStateCount; ?> mobile clinic<?php echo ($mobileClinicsInStateCount > 1) ? 's' : ''; ?><?php endif; ?>.<?php if($totalClinics > 0) : ?> Please use the quick links to search for clinics in your <?php echo Configure::read('stateLabel'); ?>.<?php endif; ?></p>
			</div>
		</div>
	</section>
	<?php if($totalClinics > 0) : ?>
		<section id="quickLinkBar">
			<div class="container">
				<div id="linkBlock">
					<ul>
						<li class="quick-links">Quick links: </li>
						<li>
							<a href="#cities" class="quickLink">Clinics by city</a>
						</li>
						<?php if ($showMobileClinics): // Mobile Clinics quick link ?>
							<li>/</li>
							<li>
								<a href="#mobileClinics" class="quickLink">Mobile clinics</a>
							</li>
						<?php endif; ?>
						<?php if ($showTelehealthClinics): // Telehealth Clinics quick link ?>
							<!--<li>/</li>
							<li>
								<a href="#telehealthClinics" class="quickLink">Telehealth clinics</a>
							</li>-->
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<?php if (!empty($stateInfo)): // State Resources card ?>
		<section class="panel panel-primary">
			<div class="panel-heading text-center panel-section-header">
				<h2>Resources in <?php echo $stateNice; ?></h2>
			</div>
			<div class="panel-body">
				<div class="panel-section expanded">
					<?php echo $stateInfo; ?>
				</div>
			</div>
		</section>
	<?php endif ?>
	<?php if ($showMobileClinics): // Mobile Clinics card ?>
		<section id="mobileClinics" class="panel panel-primary">
			<div class="panel-heading text-center panel-section-header">
				<h2>Mobile hearing clinics</h2>
			</div>
			<div class="panel-body">
				<p class="mt40 pl20 pr20"><img class="pull-left" alt="mobile clinic icon" width="64" height="56" src="/img/ear-van.png">Mobile hearing clinics offer a wide variety of hearing healthcare services by audiologists and hearing aid specialists. These clinicians travel to your home or to a convenient site in your area, such as a senior <?php echo Configure::read('regionalSpelling.center'); ?>.</p>
				<div class="panel-section expanded">
					<div class="row">
						<?php foreach($mobileClinicsInState as $location): ?>
							<?php echo $this->element('locations/list_item_cities', ['location' => $location]); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
    <?php endif; ?>
	<?php //if ($showTelehealthClinics): // Telehealth Clinics card ?>
		<!--<section id="telehealthClinics" class="panel panel-primary">
			<div class="panel-heading text-center panel-section-header">
				<h2>Telehealth hearing clinics</h2>
			</div>
			<div class="panel-body">
				<p class="mt40 pl20 pr20"><img class="pull-left" alt="Telehealth services" width="64" height="64" src="/img/monitor.png">Telehealth hearing clinics allow audiologists and hearing aid specialists to provide care in satellite offices. At a clinic that offers tele-audiology, the hearing care professional conducts the visit by video with the help of a highly trained technician.</p>
				<div class="panel-section expanded">
					<div class="row">
						<?php //foreach($telehealthClinicsInState as $location): ?>
							<?php //echo $this->element('locations/list_item_cities', ['location' => $location]); ?>
						<?php //endforeach; ?>
					</div>
				</div>
			</div>
		</section>-->
    <?php //endif; ?>
    <?php if ($totalClinics > 0): ?> <!-- Don't show city section if there are no clinics in state/province -->
		<section id="cities" class="panel panel-primary">
			<div class="panel-heading text-center panel-section-header">
				<h2>Cities in <?php echo $stateNice; ?></h2>
			</div>
			<div class="panel-body">
				<p class="mt40 pl20 pr20">Select a city below for a listing of hearing <?php echo Configure::read('regionalSpelling.center'); ?>s that offer in-person care provided by an audiologist or hearing aid specialist.</p>
				<?php if ($totalClinics != 0): ?>
					<div class="panel-section expanded"> <!-- City listing -->
						<div class="row">
							<?php foreach ($chunkedData as $i => $chunkedElement): ?>
								<div class="col-md-<?php echo round(12 / $cityColumns); ?>">
									<ul class="no-bullets city-list">
										<?php foreach ($chunkedElement as $city): ?>
											<?php echo $this->Clinic->showCityLetterLine($city->city); ?>
											<li>
												<?php echo $this->Html->link("{$city->city}, {$city->state}",
													[
														'controller' => 'locations',
														'action' => 'index',
														'region' => $this->Clinic->stateSlug($city->state),
														'city' => slugifyCity($city->city)
													],
													['class' => 'text-link', 'escape' => false]
												);
												?>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endforeach; ?>
						</div>
						<?php if(Configure::read('country') == 'US'): ?>
						<h2 style="clear:both" class="text-primary">Tell us about your experience</h2>
						<p>If you visit one of the hearing clinics on our site, we encourage you to come back to our site and submit a review of your experience! With more than <?php echo $roundedReviews; ?> consumer reviews, our hearing care directory is the largest of its kind in the continental United States.<?php endif; ?></p>
					</div>  <!-- End city listing -->
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>
</div>
<!-- The right side of the content -->
<div class="col-md-3 noprint">
	<?php if (Configure::read('showAds') && $isMobileDevice): ?>
		<?php echo $this->element('render_ad', array('ad' => $ad)); ?>
	<?php endif; ?>
	<?php if (Configure::read('showHearingTest')): ?>
		<section class="panel">
			<a href="/help/online-hearing-test">
				<img loading="lazy" src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" class="img-responsive">
			</a>
		</section>
	<?php endif; ?>
	<?php echo $this->element('locations/preferred', array('type' => 'side')); ?>
	<?php if (Configure::read('showAds') && !$isMobileDevice): ?>
		<?php echo $this->element('render_ad', array('ad' => $ad)); ?>
	<?php endif; ?>
	<section class="panel panel-secondary">
		<header class="panel-heading text-center">
			<h4>Find a clinic</h4>
		</header>
		<div class="panel-body pt20 pl20 pr20 pb20">
			<?php echo $this->element('locations/search', array(
			'label' => 'Enter city'
			)); ?>
			<?php echo $this->element('fac_config_text', ["locationsPage" => false]); ?>
		</div>
	</section>
	<section class="panel panel-light blog-previews">
		<header class="panel-heading text-center">
			<h4 class="pl10 pr10">Learn more about hearing health</h4>
		</header>
		<div class="panel-body pt20 pl20 pr20 pb20">
			<p>If you're not ready to make that call, visit our <a href="/help">Hearing Help</a> pages for extensive information about <a href="/help/hearing-loss">hearing loss</a>, <a href="/help/hearing-aids">hearing aids</a>,
				<?php if (Configure::read('country') == 'CA'): ?>
					<a href="/help/hearing-loss/tinnitus-treatment"> tinnitus</a> and <a href="/help/hearing-aids/assistive-listening-devices">assistive listening devices</a>.
				<?php else: ?>
					<a href="/help/tinnitus"> tinnitus</a> and <a href="/help/assistive-listening-devices">assistive listening devices</a>.
				<?php endif; ?>
			</p>
		</div>
	</section>
</div>
<?php if (isFeatureOn('quick_pick')): ?>
	<?php //TODO: echo $this->element('responsive_slider'); ?>
<?php endif; ?>
<?php //TODO: $this->Html->addJs('/js/dist/cities.min.js?v='.Configure::read("tagVersion")); ?>
