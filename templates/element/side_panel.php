<?php use Cake\Core\Configure; ?>
<!-- *** TODO: Check the side_panel on state pages -->
<div class="col-lg-3 float-end noprint">
	<!-- Right content -->
	<?php if (Configure::read('showHearingTest') && ($this->getRequest()->getParam('controller') == 'Locations')): ?>
		<section class="panel">
			<a href="/help/online-hearing-test">
			    <img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive">
			</a>
		</section>
	<?php endif; ?>
	<?= $isMobileDevice ? $this->element('locations/preferred') : null ?>
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
	<?= $isMobileDevice ? null : $this->element('locations/preferred') ?>
	<?php if (Configure::read('showHearingTest') && ($this->getRequest()->getParam('controller') == 'Content' || $this->getRequest()->getParam('controller') == 'Wikis' || $this->getRequest()->getParam('controller') == 'Corps') && empty($wiki)): ?>
		<section class="panel">
			<a href="/help/online-hearing-test">
			    <img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive">
			</a>
		</section>
	<?php endif; ?>
	<?= (Configure::read('showAds') && !$isMobileDevice && $this->getRequest()->getParam('controller') != 'Wikis') ? $this->element('render_ad', ['ad' => $ad]) : null ?>
	<section class="panel panel-secondary">
		<header class="panel-heading text-center">
			<h4>Find a clinic</h4>
		</header>
		<div class="panel-body pt20 pl20 pr20">
			<?= $this->element('locations/search', ['label' => 'Enter city']) ?>
			<?= $this->element('fac_config_text', ["locationsPage" => false]) ?>
		</div>
	</section>
	<?php if (!empty($contents)): ?>
		<section class="panel panel-light related-reports">
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
	<?php if (!empty($articles) && empty($wiki)): ?>
		<section class="panel panel-light blog-previews hidden">
			<header class="panel-heading text-center">
				<h4>The Healthy Hearing Report</h4>
			</header>
			<?php foreach ($articles as $content): ?>
				<div class="panel-section condensed blog-preview">
					<div class="col-lg-3">
						<?= $this->Editorial->dateHome($content, ['large' => false]) ?>
					</div>
					<div class="col-lg-9">
						<div class="subtitle"><?= $this->Editorial->getType($content) ?></div>
						<?= $this->Editorial->titleLink($content, false, ['class' => 'text-link text-small']) ?>
					</div>
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
	<?= (Configure::read('showAds') && !empty($wiki) && !$isMobileDevice) ? $this->element('render_ad', ['ad' => $ad]) : null ?>
	<!--*** TODO: add recent articles for report view pages ***-->
</div>