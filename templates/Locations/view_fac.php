<?php
use Cake\Core\Configure;

$this->Breadcrumbs->add([
	['title' => 'Home', 'url' => '/'],
    ['title' => 'Find a clinic', 'url' => ''],
]);
?>
<header class="col-md-12 inverse">
	<?= $this->Breadcrumbs->render() ?>
</header>
<div class="col-md-12 page-content">
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
						<?php echo $this->element('locations/search', array(
							'label' => 'Enter city or '.$zipShort
						)); ?>
						<?php if (Configure::read('showReviewsByCity')): ?>
							<p>Do you need help finding a provider for hearing loss or tinnitus? <?php echo $siteName; ?> has the most comprehensive directory of audiologists, hearing instrument specialists and hearing clinics in <?php echo Configure::read('countryName'); ?>. Read verified reviews for thousands of hearing <?php echo Configure::read('regionalSpelling.center'); ?>s and find trusted professionals to help you on your journey to better hearing health.</p>
						<?php else: ?>
							<p>Do you need help finding a provider for hearing loss or tinnitus? <?php echo $siteName; ?> has the most comprehensive directory of audiologists, hearing instrument specialists and hearing clinics in <?php echo Configure::read('countryName'); ?>. Find trusted professionals to help you on your journey to better hearing health.</p>
						<?php endif; ?>
					</div>
					<div class="col-lg-5 text-right">
						<?php if (!empty($clinicsNearMe)): ?>
							<h4>Hearing clinics near me</h4>
							<span id="nearme-locations_block">
								<?php echo $this->element($this->Clinic->nearMe($clinicsNearMe, 'details')); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 hidden-sm hidden-xs">
						<br />
						<h4>It's easy to get started. Select a <?php echo Configure::read('stateLabel'); ?> from the map or the lists below.</h4>
					</div>
				</div>
				<?php if (Configure::read('country') == 'US'): ?>
					<div data-hh-map class="hidden-sm hidden-xs"></div>
				<?php else: ?>
					<center>
						<object data="<?php echo Configure::read('map'); ?>" type="image/svg+xml" id="interactiveMap" style="width: 600px;" class="hidden-sm hidden-xs"></object>
					</center>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<section class="panel panel-secondary">
		<header class="panel-heading text-center">
			<h3>Choose my <?php echo $stateLabel; ?></h3>
		</header>
		<div class="panel-body">
			<table class="table choose-state">
				<?php
				$setCount = 1;
				$sets = $this->App->splitBy($states, $setCount);
				for($i = 0; $i < (count($states) / $setCount); $i++): ?>
					<tr class="col-md-4">
						<?php for($j = 0; $j < $setCount; $j++): ?>
							<?php if (!empty($sets[$j])): ?>
								<td>
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
										array('escape'=>false, 'class' => 'text-link')
									);
									$clinicCount = $this->Clinic->getCount($stateAbbr, 'clinics');
									echo ' (' . $clinicCount;
									echo ($clinicCount == 1) ? ' clinic' : ' clinics';
									echo ')';
									?>
								</td>
							<?php endif; ?>
						<?php endfor; ?>
					</tr>
				<?php endfor; ?>
			</table>
		</div>
	</section>
	<?php if(count($cities) > 0): ?>
		<section class="panel panel-secondary">
			<header class="panel-heading text-center">
				<h3>Choose a city near me</h3>
			</header>
			<div class="panel-body">
				<table class="table choose-city">
					<?php
						$setCount = 1;
						$rows = floor(count($cities) / $setCount);
						if(count($cities) % $setCount != 0) {
							$rows++;
						}
						$sets = $this->App->splitBy($cities, $setCount);
					?>
					<?php for($i = 0; $i < $rows; $i++): ?>
						<tr class="col-md-4">
							<?php for($j = 0; $j < $setCount; $j++): ?>
								<td>
								<?php if(!empty($sets[$j])): ?>
									<?php
									$cityRow = reset($sets[$j]);
									$stateAbbr = $cityRow['state'];
									$name = $cityRow['city'];
									array_shift($sets[$j]);
									if(!empty($name)) {
										echo $this->Html->link(
											ucwords($name) . ', ' . $stateAbbr,
											[
												'controller' => 'locations',
												'action' => 'viewCityZip',
												'region' => $this->Clinic->stateSlug($stateAbbr),
												'city' => slugifyCity($name)
											],
											['escape' => false, 'class' => 'text-link']
										);
										$clinicCount = $this->Clinic->getCount($name, 'clinics', 'city', $stateAbbr);
										echo ' (' . $clinicCount;
										echo ($clinicCount == 1) ? ' clinic' : ' clinics';
										echo ')';
									}
									?>
								<?php endif; ?>
								</td>
							<?php endfor; ?>
						</tr>
					<?php endfor; ?>
				</table>
			</div>
		</section>
	<?php endif; ?>
</div>
<?php echo $this->Html->script('dist/common.min.js?v='.Configure::read("tagVersion"), ['defer' => 'defer']); ?>
<?php if (isFeatureOn('quick_pick')): ?>
	<?php echo $this->element('responsive_slider'); ?>
<?php endif; ?>
