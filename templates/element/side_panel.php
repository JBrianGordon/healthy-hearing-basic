<?php use Cake\Core\Configure; ?>
<div class="col-lg-3 float-end noprint">
	<!-- Right content -->
	<?php if (Configure::read('showHearingTest') && ($this->getRequest()->getParam('controller') != 'quiz_results')): ?>
		<section class="panel">
			<a href="/help/online-hearing-test">
			    <img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive">
			</a>
		</section>
	<?php endif; ?>
	<?php if (Configure::read('showAds') && $isMobileDevice): ?>
		<?= $this->element('render_ad', ['ad' => $ad]) ?>
	<?php endif; ?>
	<?= $isMobileDevice ? $this->element('locations/preferred') : null ?>
	<?php if (!empty($wiki)): ?>
		<section class="panel panel-light help-menu">
			<header class="panel-heading text-center">Help menu</header>
			<div class="panel-section condensed">
				<div class="col-lg-12">
					<?= $this->element('wikis/nav_box'); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
	<?= $isMobileDevice ? null : $this->element('locations/preferred') ?>
	<?php if (!empty($contents)): ?>
		<section class="panel panel-light related-reports">
			<header class="panel-heading text-center">
				<h4>Related content</h4>
			</header>
			<table class="table table-bordered" style="margin-bottom: 0;">
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
	<?php if (!empty($articles)): ?>
		<section class="panel panel-light blog-previews hidden">
			<header class="panel-heading text-center">
				<h4>The Healthy Hearing Report</h4>
			</header>
			<?php foreach ($articles as $content): ?>
				<div class="panel-section condensed blog-preview">
					<div class="col-md-3">
						<?= $this->Editorial->dateHome($content, ['large' => false]) ?>
					</div>
					<div class="col-md-9">
						<div class="subtitle"><?= $this->Editorial->getType($content) ?></div>
						<?= $this->Editorial->titleLink($content, false, ['class' => 'text-link text-small']) ?>
					</div>
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
	<?php if (Configure::read('showAds') && !$isMobileDevice): ?>
		<?= $this->element('render_ad', ['ad' => $ad]) ?>
	<?php endif; ?>
	<section class="panel panel-secondary">
		<header class="panel-heading text-center">
			<h4>Find a clinic</h4>
		</header>
		<div class="panel-body pt20 pl20 pr20">
			<?= $this->element('locations/search', ['label' => 'Enter city']) ?>
			<?= $this->element('fac_config_text', ["locationsPage" => false]) ?>
		</div>
	</section>
	<?php if (!empty($cities)): ?>
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
	<?php endif; ?>
</div>