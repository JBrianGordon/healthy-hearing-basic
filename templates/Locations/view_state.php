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
	['title' => 'Home', 'url' => '/'],
    ['title' => 'Find a clinic', 'url' => ['controller' => 'locations', 'action' => 'viewFac']],
    ['title' => $stateNice, 'url' => ''],
]);

$this->Html->script('/js/dist/cities.min.js?v='.Configure::read("tagVersion"), ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop backdrop-gradient backdrop-height"></div>
		<div class="container">
			<div class="row" id="result_content">
				<header class="col-md-12 inverse">
					<?= $this->Breadcrumbs->render() ?>
					<?= $this->element('breadcrumb_schema') ?>
					<div id="ellipses">...</div>
				</header>
				<div id="top" class="col-lg-9 page-content fap-cities float-start">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section">
								<h1 class="text-primary">Hearing clinics in <?= $stateNice ?></h1>
								<p>Each <?= $stateLabel ?> has resources available for people with hearing loss. For your convenience, we've gathered together links to useful resources for residents of <?= $stateNice ?>.<?php if($hasAtLeastOneClinic) : ?> Looking for clinics in a specific city? Jump to <a href="#cities" class="quickLink">clinics by city</a><?= $showMobileClinics ? ' or <a href="#mobileClinics" class="quickLink">mobile clinics</a>' : '' ?>.<?php endif; ?></p>
							</div>
						</div>
					</section>
					<?php if (!empty($stateInfo)): // State Resources card ?>
						<section class="panel panel-primary">
							<div class="panel-heading text-center panel-section-header">
								<h2>Resources in <?= $stateNice ?></h2>
							</div>
							<div class="panel-body anchor-underline">
								<div class="panel-section expanded">
									<?= $stateInfo ?>
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
								<p class="mt40 pl20 pr20"><img class="pull-left" alt="mobile clinic icon" width="64" height="56" src="/img/ear-van.png">Mobile hearing clinics offer a wide variety of hearing healthcare services by audiologists and hearing aid specialists. These clinicians travel to your home or to a convenient site in your area, such as a senior <?= Configure::read('regionalSpelling.center') ?>.</p>
								<div class="panel-section expanded">
									<div class="row">
										<?php foreach($mobileClinicsInState as $location): ?>
											<?= $this->element('locations/list_item_cities', ['location' => $location]) ?>
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
				    <?php if ($hasAtLeastOneClinic): ?> <!-- Don't show city section if there are no clinics in state/province -->
						<section id="cities" class="panel panel-primary">
							<div class="panel-heading text-center panel-section-header">
								<h2>Cities in <?= $stateNice ?></h2>
							</div>
							<div class="panel-body">
								<p class="mt40 pl20 pr20">Select a city below for a listing of hearing <?= Configure::read('regionalSpelling.center') ?>s that offer in-person care provided by an audiologist or hearing aid specialist.</p>
								<?php if ($hasAtLeastOneClinic): ?>
									<div class="panel-section expanded"> <!-- City listing -->
										<div class="row">
											<?php foreach ($chunkedData as $i => $chunkedElement): ?>
												<div class="col-md-<?php echo round(12 / $cityColumns); ?>">
													<ul class="no-bullets city-list">
														<?php foreach ($chunkedElement as $city): ?>
															<?= $this->Clinic->showCityLetterLine($city->city) ?>
															<li>
																<?= $this->Html->link("{$city->city}, {$city->state}",
																	[
																		'controller' => 'locations',
																		'action' => 'viewCityZip',
																		'region' => $this->Clinic->stateSlug($city->state),
																		'city' => slugifyCity($city->city)
																	],
																	['class' => 'text-link', 'escape' => false]
																)
																?>
															</li>
														<?php endforeach; ?>
													</ul>
												</div>
											<?php endforeach; ?>
										</div>
										<?php if(Configure::read('country') == 'US'): ?>
										<h2 style="clear:both" class="text-primary">Tell us about your experience</h2>
										<p>If you visit one of the hearing clinics on our site, we encourage you to come back to our site and submit a review of your experience! With more than <?= $roundedReviews ?> consumer reviews, our hearing care directory is the largest of its kind in the continental United States.<?php endif; ?></p>
									</div>  <!-- End city listing -->
								<?php endif; ?>
							</div>
						</section>
					<?php endif; ?>
				</div>
				<?= $this->element('side_panel') ?>
			</div>
		</div>
	</div>
</div>
<a id="backToTop" class="row noprint quickLink back-to-top-link btn btn-light btn-sm" href="#top">
	<p>Back to top</p>
</a>
<?php if (isFeatureOn('quick_pick')): ?>
	<?= $this->element('responsive_slider') ?>
<?php endif; ?>
