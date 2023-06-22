<?php
use Cake\Core\Configure;

$this->Breadcrumbs->add([
	['title'=>'Home', 'url'=>'/'],
    ['title'=>'Find a clinic', 'url'=>['controller'=>'locations', 'action'=>'viewFac']],
]);
if (!empty($region)) {
	$this->Breadcrumbs->add($state, ['controller'=>'locations', 'action'=>'viewState', 'region'=>$region]);
}
if (!empty($city)) {
	$url = empty($zip) ? '' : ['controller'=>'locations', 'action'=>'viewCityZip', 'region'=>$region, 'city'=>$city];
	$this->Breadcrumbs->add(cleanCityName($city), $url);
}
if (!empty($zip)) {
	$this->Breadcrumbs->add($zip, '');
}
?>
<header class="col-md-12 inverse">
	<?= $this->Breadcrumbs->render() ?>
</header>
<div class="col-md-12 page-content">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<header class="row">
					<div class="col-md-12">
						<h1 class="text-primary">Hearing aids <?php echo (!empty($is_near)) ? 'near' : 'in'; ?> <?php echo $this->Clinic->nearText($region,$city,$zip); ?></h1>
					</div>
				</header>
				<p class="lead text-primary" id="filter-results">
					<?php if($state == "Quebec") : ?>
					<p>If you are looking for a clinic in Quebec, please visit the <a href="https://www.ordreaudio.qc.ca/chercher-un-audioprothesiste/" rel="noopener" target="_blank">Ordre des Audioprothésistes du Québec</a> website.</p>
					<?php elseif (empty($locations)): ?>
						We're sorry. We don't currently have any clinics within 60
						<?php echo (Configure::read('isMetric') ? ' km' : ' miles'); ?>
						of that city.<br><br>
						<h3 class="text-center text-primary"><em>Try searching in a different area.</em></h3>
						<div class="col-md-offset-3 col-md-6">
							<?php echo $this->element('locations/search', [
								'label' => "Search by city or ".$zipShort
							]); ?>
						</div>
					<?php else: ?>
						<i>
							<?php
							$clinicCount = count($locations);
							$s = ($clinicCount == 1) ? '' : 's';
							echo 'We found ' . $clinicCount . ' hearing aid clinic' . $s;
							if ($reviewCount) {
								$s = ($reviewCount == 1) ? '' : 's';
								echo ' with ' . $reviewCount . ' review' . $s;
							}
							?>
							within <?php echo $this->Clinic->highestDistance($locations); ?> of <?php echo $this->Clinic->nearText($region,$city,$zip); ?>.
							<?php $nearMeLink = $this->Clinic->nearMeLink(); ?>
							<?php if (stripos($_SERVER['REQUEST_URI'], $nearMeLink) === false): ?>
								Show clinics <a href="<?php echo $nearMeLink; ?>" class="text-secondary">near me</a>.
							<?php endif; ?>
						</i>
						<br>
						<p><?php echo $siteName; ?> provides listings from audiologists, hearing instrument specialists and hearing aid <?php echo Configure::read('regionalSpelling.center'); ?>s near you. If you need hearing aids or a hearing test, choose a clinic from the list below to schedule an appointment in your area.
						</p>
						<?php if ($isAdmin): ?>
							<?php
							$exportLink = "/admin/locations/export";
							$exportLink .= empty($region) ? "" : "/region:".$region;
							$exportLink .= empty($city) ? "" : "/city:".$city;
							$exportLink .= empty($zip) ? "" : "/zip:".str_replace(' ', '-', $zip);
							$exportLink .= ".csv";
							?>
							<a href=<?php echo $exportLink; ?> class="btn btn-default btn-xs">Export clinics for this area</a>
						<?php endif; ?>
					<?php endif; ?>
				</p>
			</div>
		</div>
	</section>

	<div id="clinic-results">
		<?php echo $this->element('locations/results', ['locations' => $locations]); ?>
	</div>
</div>

<?php if (isFeatureOn('quick_pick')): ?>
	<?php echo $this->element('responsive_slider'); ?>
<?php endif; ?>

<?php
	if (!empty($locations)) {
		// TODO: $this->Html->addJs('dist/location_results.min.js?v='.Configure::read("tagVersion"));
	}
?>
