<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki[]|\Cake\Collection\CollectionInterface $wikis
 */
 
$this->Html->script('dist/wiki.min', ['block' => true]);

use Cake\Core\Configure;
?>
<div class="container-fluid site-body fap-cities">
	<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
	</div>
	<div class="container">

			<!-- ***TODO: Breadcrumb should be it's own dynamic element *** <div class="row pt0 pb0">-->
			<header class="col-md-12 inverse">
				<div class="row noprint pt0 pb0">
					<div class="col-sm-12 col-xs-9 pl0">
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
			<div class="col-md-9 panel-parent float-start">
				<section class="panel panel-section expanded">
					<div class="p20 headline">
						<h1 class="text-primary"><?php echo Configure::read('country') == 'CA' ? 'Hearing Directory' : 'Healthy Hearing'; ?> Help</h1>
						<p class="lead text-primary"><em>
							Welcome to our library of original reference materials to help you learn more about hearing health and hearing aids.
							<?php if(Configure::read('country') != 'CA'): ?>
								<br><br>Check out the <a href="/report">Healthy Hearing Report</a> for additional news, articles and interviews about hearing health.
							<?php endif; ?>
						</em></p>
					</div>
					
					<div id="wikis" class="p20">
						<ul id="accordion" class="nav nav-tabs nav-stacked">
							<?php foreach ($wikis as $wiki): ?>
								<li class="parent" style="border-bottom: 1px solid #ddd;">
									<a href="/help/<?= $wiki->hh_url['slug'] ?>">
										<div class="wiki-parent">
											<strong><?= $wiki->name ?></strong><br>
											<span class="short"><?= $wiki->short ?></span>
										</div>
									</a>
								</li>
							<?php endforeach; ?>
							<?php if (Configure::read('showManufacturers')): ?>
								<li class="parent">
									<!--*** TODO: uncomment when Wiki is built out ***-->
									<?php //echo $this->Wiki->getNavManufText(); ?>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</section>
			</div>
			<?= $this->element('side_panel') ?>
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