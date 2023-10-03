<?php
use Cake\Core\Configure;
$controller = $this->getRequest()->getParam('controller');

$locations = !empty($preferredClinicsNearMe) ? $preferredClinicsNearMe : [];
$display = 'sameCountry';
if (!empty($locations) && $this->Clinic->isDifferentCountry()) {
	$display = 'differentCountry';
}

//Set panel order depending on page, using flex
//Hearing test panel
if (Configure::read('showHearingTest') && ($controller == 'Locations')) {
	$hearingTestDisplay = ' style="order:1"';
} else if(Configure::read('showHearingTest') && in_array($controller, ['Content', 'Wikis', 'Corps'])) {
	$hearingTestDisplay = ' class="panel" style="order:4"';
} else {
	$hearingTestDisplay = ' class="hidden"';
}

//Preferred clinics panel
$preferredDisplay = ($isMobileDevice) ? ' style="order:2"' : ' style="order:5"';

//Corp page display
if($controller == 'Corps' || $controller == 'Pages'){
	$facDisplay = "8";
	$reportDisplay = "9";
} else {
	$facDisplay = "9";
	$reportDisplay = "8";
}
?>
<div id="sidePanel" class="col-lg-3 float-end noprint flex">
	<!-- Right content -->
	<?php if (Configure::read('showHearingTest') && ($controller == 'Locations')): ?>
		<section<?= $hearingTestDisplay ?>>
			<a href="/help/online-hearing-test">
			    <img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive">
			</a>
		</section>
	<?php endif; ?>
	<?php if(!empty($locations)): ?>
		<section class="panel panel-secondary"<?= $preferredDisplay ?>>
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
	<?php if (!empty($wiki)): ?>
		<section class="panel panel-light help-menu" style="order:4">
			<header class="panel-heading text-center">Help menu</header>
			<div class="panel-section condensed pl0 pr0">
				<div class="col-lg-12">
					<?= $this->element('wikis/nav_box'); ?>
				</div>
			</div>
		</section>
	<?php else: ?>
		<section class="panel" style="order:6">
			<a href="/help/online-hearing-test">
			    <img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive block">
			</a>
		</section>
	<?php endif; ?>
	<?= (Configure::read('showAds') && $controller != 'Wikis' && $controller != 'Pages') ? $this->element('render_ad', ['ad' => $ad]) : null ?>
	<?php if (!empty($articles) && empty($wiki)): ?>
		<section class="panel panel-light blog-previews" style="order:<?= $reportDisplay ?>">
			<header class="panel-heading text-center">
				<h4>The Healthy Hearing Report</h4>
			</header>
			<?php foreach ($articles as $content): ?>
				<div class="panel-section condensed blog-preview">
					<div class="row">
						<div class="col-lg-3">
							<?= $this->Editorial->dateHome($content, ['large' => false]) ?>
						</div>
						<div class="col-lg-9">
							<div class="subtitle"><?= $this->Editorial->getType($content) ?></div>
							<?= $this->Editorial->titleLink($content, false, ['class' => 'text-link']) ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
	<section class="panel panel-secondary" style="order:<?= $facDisplay ?>">
		<header class="panel-heading text-center">
			<h4>Find a clinic</h4>
		</header>
		<div class="panel-body pt20 pl20 pr20">
			<?= $this->element('locations/search', ['label' => 'Enter city']) ?>
			<?= $this->element('fac_config_text', ["locationsPage" => false]) ?>
		</div>
	</section>
	<?= isset($stateNice) ? $this->element('learn_more') : null; ?>
	<?php if (!empty($contents)): ?>
		<section class="panel panel-light related-reports" style="order:10">
			<header class="panel-heading text-center">
				<h4>Related content</h4>
			</header>
			<table class="table table-bordered mb0">
				<?php foreach ($contents as $content): ?>
					<tr>
						<td>
							<?= $this->Html->link($content->title, $content->hh_url) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</section>
	<?php endif; ?>
	<?= (Configure::read('showAds') && !empty($wiki)) ? $this->element('render_ad', ['ad' => $ad]) : null ?>
</div>