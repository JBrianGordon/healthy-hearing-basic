<?php
use Cake\Core\Configure;

$controller = $this->getRequest()->getParam('controller');

$locations = !empty($preferredClinicsNearMe) ? $preferredClinicsNearMe : [];
$display = 'sameCountry';
if (!empty($locations) && $this->Clinic->isDifferentCountry()) {
	$display = 'differentCountry';
}
?>
<div id="sidePanel" class="col-lg-3 float-end noprint flex">
	<!-- Right content -->
	<?php if(!empty($locations)): ?>
		<section class="panel panel-secondary">
			<header class="panel-heading text-center">
				<h2 class="h3">Featured clinics near me</h2>
			</header>
			<div class="panel-body">
				<?php if ($display === 'sameCountry'): ?>
					<?php foreach($locations as $location): ?>
						<div class="panel-section condensed">
							<p class="text-small mb0">
								<?= $this->Clinic->addressLink($location) ?>
							</p>
						</div>
					<?php endforeach; ?>
					<div class="tac">
						<?php $nearMeLink = $this->Clinic->nearMeLink(); ?>
						<a href="<?= $nearMeLink ?>" class="btn btn-primary btn-xs m10 pl10 pr10">See more clinics</a>
					</div>
				<?php elseif ($display === 'differentCountry'): ?>
					<div class="panel-section condensed">
						<?= $this->element('locations/near_me/different_country') ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>
	<?php if (Configure::read('showHearingTest')): ?>
		<section class="mb20">
			<a href="/help/online-hearing-test">
			    <img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive bg-white w-100">
			</a>
		</section>
	<?php endif; ?>
	<section class="panel panel-secondary" style="overflow:visible">
		<header class="panel-heading text-center">
			<h2 class="h4">Find a clinic</h2>
		</header>
		<div class="panel-body p20">
			<?= $this->element('locations/search', ['label' => 'Enter city']) ?>
			<?= $this->element('fac_config_text', ["locationsPage" => false]) ?>
		</div>
	</section>
	<?php if (!empty($wiki)): ?>
		<section class="panel panel-light help-menu">
			<header class="panel-heading text-center">Help menu</header>
			<div class="panel-section condensed pl0 pr0">
				<div class="col-lg-12">
					<?= $this->element('wikis/nav_box'); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<?= (Configure::read('showAds') && $controller != 'Wikis' && !isset($errorPage)) ? $this->element('render_ad', ['ad' => $ad]) : null ?>
	<?= $this->element('learn_more') ?>
	<?php if (!empty($contents)): ?>
		<section class="panel panel-light related-reports">
			<header class="panel-heading text-center">
				<h2 class="h4">Related content</h2>
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
	<?php if (Configure::read('showReports') && ($controller != 'QuizResults') && !empty($articles)): ?>
		<section class="panel panel-light blog-previews">
		<header class="panel-heading text-center">
		  <h2>The Healthy Hearing Report</h2>
		</header>
		<div class="panel-body">
		  <?php foreach ($articles as $content): ?>
		    <div class="panel-section condensed blog-preview">
		      <div class="row">
		        <div class="col-sm-3">
		          <?= $this->Editorial->dateHome($content, ['large' => false]); ?>
		        </div>
		        <div class="col-sm-9">
		          <div class="subtitle"><?= $this->Editorial->getType($content); ?></div>
		          <?= $this->Editorial->titleLink($content, false, ['class' => 'text-link']); ?>
		        </div>
		      </div>
		    </div>
		  <?php endforeach; ?>
		</div>
		</section>
	<?php endif; ?>
</div>