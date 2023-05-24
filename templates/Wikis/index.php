<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki[]|\Cake\Collection\CollectionInterface $wikis
 */
 
$this->Html->script('dist/wiki.min', ['block' => true]);

use Cake\Core\Configure;

$this->Breadcrumbs->add([
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Healthy Hearing help: Hearing loss, hearing aids, tinnitus and more', 'url' => ''],
]);
?>
<div class="container-fluid site-body fap-cities">
	<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
	</div>
	<div class="container">
			<header class="col-md-12 inverse">
				<?= $this->Breadcrumbs->render() ?>
				<div id="ellipses">...</div>
			</header>
			<div class="col-md-9 panel-parent float-start">
				<section class="panel panel-section expanded">
					<div class="p20 headline">
						<h1 class="text-primary"><?php echo Configure::read('siteName'); ?> Help</h1>
						<p class="lead text-primary"><em>
							Welcome to our library of original reference materials to help you learn more about hearing health and hearing aids.
							<?php if (Configure::read('country') != 'CA'): ?>
								<br><br>Check out the <a href="/report">Healthy Hearing Report</a> for additional news, articles and interviews about hearing health.
							<?php endif; ?>
						</em></p>
					</div>
					
					<div id="wikis" class="p20">
						<ul id="accordion" class="nav nav-tabs nav-stacked">
							<?php foreach ($wikis as $wiki): ?>
								<li class="parent" style="border-bottom: 1px solid #ddd;">
									<?php echo $this->Wiki->getNavText($wiki['parent']); ?>
								</li>
							<?php endforeach; ?>
							<?php if (Configure::read('showManufacturers')): ?>
								<li class="parent">
									<?php echo $this->Wiki->getNavManufText(); ?>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</section>
			</div>
			<?= $this->element('side_panel') ?>
	</div>
</div>
