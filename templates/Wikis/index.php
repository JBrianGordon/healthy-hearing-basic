<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki[]|\Cake\Collection\CollectionInterface $wikis
 */
 
$this->Html->script('dist/wiki.min', ['block' => true]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
	</div>
	<div class="container">

			<!-- ***TODO: Breadcrumb should be it's own dynamic element *** <div class="row pt0 pb0">-->
			<header class="col-md-12 inverse">
				<div class="row noprint pt0 pb0">
					<div class="col-sm-12 col-xs-9">
						<ul class="breadcrumb">
							<li>
								<a href="/"><span>Home</span></a>
							</li>
							<li>
								<a href="/help">
									<span>Healthy Hearing help: Hearing loss, hearing aids, tinnitus and more</span>
								</a>
							</li>
							<script type="application/ld+json">{"@context": "https://schema.org","@type": "BreadcrumbList","itemListElement": [{"@type": "ListItem", "position": "1", "item": {"@id": "/", "name": "Home"}},{"@type": "ListItem", "position": "2", "item": {"@id": "/help", "name": "Healthy Hearing help: Hearing loss, hearing aids, tinnitus and more"}}]}</script>
						</ul>
						<div id="ellipses">...</div>
					</div>
				</div>
			</header>
			<div class="col-md-9 panel-parent float-start pl10 pr10">
				<section class="panel panel-section expanded">
					<div class="p20 headline">
						<h1 class="text-primary"><?php //*** uncomment when Configure is built out, hard coding Healthy Hearing for now *** echo Configure::read('country') == 'CA' ? 'Hearing Directory' : 'Healthy Hearing'; ?>Healthy Hearing Help</h1>
						<p class="lead text-primary"><em>
							Welcome to our library of original reference materials to help you learn more about hearing health and hearing aids.
							<?php //*** uncomment when Configure is built out *** if(Configure::read('country') != 'CA'): ?>
								<br><br>Check out the <a href="/report">Healthy Hearing Report</a> for additional news, articles and interviews about hearing health.
							<?php //endif; ?>
						</em></p>
					</div>
					
					<div id="wikis" class="p20">
						<ul id="accordion" class="nav nav-tabs nav-stacked">
							<?php foreach ($wikis as $wiki): ?>
								<li class="parent" style="border-bottom: 1px solid #ddd;">
									<?= $this->Html->link($wiki->name, $wiki->hh_url) ?>
									<?php //*** uncomment when Wiki is built out *** echo $this->Wiki->getNavText($nav['parent']); ?>
								</li>
							<?php endforeach; ?>
							<?php //*** uncomment when Configure is built out *** if (Configure::read('showManufacturers')): ?>
								<!--<li class="parent">
									<?php //echo $this->Wiki->getNavManufText(); ?>
								</li>-->
							<?php //endif; ?>
						</ul>
					</div>
				</section>
			</div>
			<!-- ***TODO: Side panel should be it's own element*** -->
			<div class="col-md-3 col-lg-3 float-end noprint">
				<!-- Right content -->
				<?php //***TODO: uncomment when Configure added*** if (Configure::read('showAds') && $this->Content->isMobileDevice()): ?>
					<?php //echo $this->element('render_ad', array('ad' => $ad)); ?>
				<?php //endif; ?>
				<?php //***TODO: uncomment when locations/preferred element added*** if($this->App->isMobileDevice()){echo $this->element('locations/preferred');} ?>
				<?php if (!empty($contents)): ?>
				<section class="panel panel-light related-reports">
					<header class="panel-heading text-center">
						<h4>Related content</h4>
					</header>
					<div class="col-lg-12">
						<table class="table table-bordered" style="margin-bottom: 0;">
							<?php foreach ($contents as $content): ?>
								<tr>
									<td>
										<?php echo $this->Html->link($content['Content']['title'], $content['Content']['hh_url']); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</section>
				<?php endif; ?>
				<section class="panel panel-light blog-previews hidden">
					<header class="panel-heading text-center">
						<h4>The Healthy Hearing Report</h4>
					</header>
					<?php //***TODO: uncomment when $articles is defined*** foreach ($articles as $content): ?>
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
					<?php //endforeach; ?>
				</section>
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
			</div>

	</div>
</div>
<!-- *** Leaving this commented for now for future reference ***
<ul class="pagination">
    <?=
        $this->Paginator->options([
            'url' => [
                'controller' => 'wikis',
                'action' => 'index'
            ]
        ]);
    ?>
    <?= $this->Paginator->prev(); ?>
    <?= $this->Paginator->numbers(['modulus' => 2]); ?>
    <?= $this->Paginator->next(">>"); ?>
    <?= $this->Paginator->first("FIRST"); ?>
    <?= $this->Paginator->last("LAST"); ?>
</ul>-->