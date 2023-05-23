<?php use Cake\Core\Configure; ?>
<div class="col-md-3 float-end noprint">
	<!-- Right content -->
	<?php if (Configure::read('showHearingTest') && ($this->getRequest()->getParam('controller') != 'quiz_results')): ?>
		<section class="panel">
			<a href="/help/online-hearing-test">
			    <img src="/img/hh-hearing-check.svg" width="262" height="100" style="margin:0 auto" alt="Take our online Hearing Check" loading="lazy" class="img-responsive">
			</a>
		</section>
	<?php endif; ?>
	<?php if (Configure::read('showAds') && $isMobileDevice): ?>
		<?php echo $this->element('render_ad', ['ad' => $ad]); ?>
	<?php endif; ?>
	<?php //***TODO: uncomment when locations/preferred element added*** if($isMobileDevice){echo $this->element('locations/preferred');} ?>
	<section class="panel panel-light help-menu">
		<header class="panel-heading text-center">Help menu</header>
		<div class="panel-section condensed">
			<div class="col-lg-12">
				<?php
				//***TODO: uncomment when nav_box element added***echo $this->element('wikis/nav_box', [
					//'params' => [
					//	'navigation' => $navigation,
					//	'slug' => $wiki->slug,
					//	'align' => 'text-left'
					//]
				//]);
				?>
			</div>
		</div>
	</section>
	<?php //***TODO: uncomment when locations/preferred element added***if(!$isMobileDevice){echo $this->element('locations/preferred');} ?>
	<section class="panel panel-secondary">
		<header class="panel-heading text-center">
			<h4>Find a clinic</h4>
		</header>
		<div class="panel-body pt20 pl20 pr20">
			<?php //***TODO: uncomment when locations/preferred element added***echo $this->element('locations/search', array(
				//'label' => 'Enter city'
			//)); ?>
			<?php //***TODO: uncomment when locations/preferred element added*** echo $this->element('fac_config_text', ["locationsPage" => false]); ?>
		</div>
	</section>
	<?php if (!empty($contents)): ?>
		<section class="panel panel-light related-reports">
			<header class="panel-heading text-center">
				<h4>Related content</h4>
			</header>
			<table class="table table-bordered" style="margin-bottom: 0;">
				<?php foreach ($contents as $content): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($content->title, $content->hh_url); ?>
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
						<?php //***TODO: uncomment when $articles is defined*** echo $this->Content->dateHome($content, [
							//'large' => false
						//]); ?>
					</div>
					<div class="col-md-9">
						<div class="subtitle"><?php //***TODO: uncomment when Content is built*** echo $this->Content->getType(); ?></div>
						<?php //echo $this->Content->titleLink($content, ['class' => 'text-link text-small']); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
	<?php if (Configure::read('showAds') && !$isMobileDevice): ?>
		<?php echo $this->element('render_ad', ['ad' => $ad]); ?>
	<?php endif; ?>
</div>