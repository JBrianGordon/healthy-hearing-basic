<?php
use Cake\Core\Configure;

$this->Breadcrumbs->add([
	['title' => 'Home', 'url' => '/'],
    ['title' => 'Find a clinic', 'url' => ''],
]);
$this->Html->script('dist/fac.min.js?v='.Configure::read("tagVersion"), ['block' => true, 'defer' => 'defer']);
?>
<div class="container-fluid site-body fap-results">
  <div class="row">
	<div class="backdrop backdrop-gradient backdrop-height"></div>
	<div class="container">
		<div class="row noprint">
			<header class="col-lg-12 inverse">
				<?= $this->Breadcrumbs->render() ?>
				<?= $this->element('breadcrumb_schema') ?>
			</header>
			<div class="col-lg-12 page-content float-start">
				<section class="panel">
					<div class="panel-body">
						<div class="panel-section expanded">
							<div class="row">
								<div class="col-md-12">
									<h1 class="text-primary">Find trusted hearing clinics near me</h1>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-7">
									<?= $this->element('locations/search', ['label' => 'Enter city or '.$zipShort]) ?>
									<?php if (Configure::read('showReviewsByCity')): ?>
										<p>Do you need help finding a provider for hearing loss or tinnitus? <?= $siteName ?> has the most comprehensive directory of audiologists, hearing instrument specialists and hearing clinics in <?= Configure::read('countryName') ?>. Read verified reviews for thousands of hearing <?= Configure::read('regionalSpelling.center') ?>s and find trusted professionals to help you on your journey to better hearing health.</p>
									<?php else: ?>
										<p>Do you need help finding a provider for hearing loss or tinnitus? <?= $siteName ?> has the most comprehensive directory of audiologists, hearing instrument specialists and hearing clinics in <?= Configure::read('countryName') ?>. Find trusted professionals to help you on your journey to better hearing health.</p>
									<?php endif; ?>
								</div>
								<div class="col-lg-5 tar">
									<?php if (!empty($clinicsNearMe)): ?>
										<p class="h3">Hearing clinics near me</p>
										<span id="nearme-locations_block">
											<?= $this->element($this->Clinic->nearMe($clinicsNearMe, 'details')) ?>
										</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12 d-none d-md-block">
									<br />
									<h2 class="h4">It's easy to get started. Select a <?= Configure::read('stateLabel') ?> from the map or the list below.</h2>
								</div>
							</div>
							<div data-hh-map class="d-none d-md-block"></div>
						</div>
					</div>
				</section>
				<section class="panel panel-secondary">
					<header class="panel-heading text-center">
						<h2 class="h3">Choose my <?= $stateLabel ?></h2>
					</header>
					<div class="panel-body">
						<table class="table choose-state">
							<?php
							$setCount = 1;
							$sets = $this->App->splitBy($states, $setCount);
							for($i = 0; $i < (count($states) / $setCount); $i++): ?>
								<tr class="col-12 col-md-4 p0">
									<?php for($j = 0; $j < $setCount; $j++): ?>
										<?php if (!empty($sets[$j])): ?>
											<td class="col-12 d-block">
												<?php
													$stateFull = reset($sets[$j]);
													$stateAbbr = key($sets[$j]);
													$region = $this->Clinic->stateSlug($stateFull);
													array_shift($sets[$j]);
													$link = [
														'controller' => 'locations',
														'action' => 'viewState',
														'region' => $region
													];
													if ($region == 'DC-Dist-Of-Columbia') {
														$link = [
															'controller' => 'locations',
															'action' => 'viewCityZip',
															'region' => $region,
															'city' => 'Washington'
														];
													}
													echo $this->Html->link(
														ucwords($stateFull),
														$link,
														['escape'=>false, 'class' => 'text-link']
													);
												?>
											</td>
										<?php endif; ?>
									<?php endfor; ?>
								</tr>
							<?php endfor; ?>
						</table>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
<?= /* Hide this for now : isFeatureOn('quick_pick') ?  $this->element('responsive_slider') : */ null ?>
