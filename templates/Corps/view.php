<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

$this->Breadcrumbs->add([
	['title' => 'Home', 'url' => '/'],
    ['title' => 'Help', 'url' => '/help'],
    ['title' => 'Manufacturers', 'url' => '/hearing-aid-manufacturers'],
    ['title' => $corp->title, 'url' => ''],
]);
 
$isPreview = isset($isPreview) ? $isPreview : false;
 
$manuSchema = '<script type="application/ld+json">{';
$manuSchema .= '"@context": "https://schema.org", "@type": "Article",';
$manuSchema .= '"mainEntityOfPage": {"@type": "WebPage", "@id": "https://www.' . Configure::read('siteUrl') . $_SERVER['REQUEST_URI'] . '"},';
$manuSchema .= '"headline": "' . $corp->title . '", "datePublished": "' . $corp->created . '-05:00", "dateModified": "' . $corp->modified . '-05:00", "image": "' . Router::url($corp->facebook_image_url, true) . '", "articleBody": "' . h(strip_tags($corp->description)) . '",';
$manuSchema .= '"author": {"@type": "Person", "name": "' . $corp->author->first_name . ' ' . $corp->author->last_name . '"';
if(!empty($corp->author->degrees)) {
	$manuSchema .= ', "honorificSuffix": "' . $corp->author->degrees . '"';
}
if(!empty($corp->author->url)) {
	$manuSchema .= ', "url": "https://www.' . Configure::read('siteUrl') . $corp->author->url . '"';
}
$manuSchema .= '},';
$manuSchema .= '"publisher": {"@type": "Organization", "name": "' . Configure::read('siteName') . '", "logo": {"@type": "ImageObject", "url": "https://www.' . Configure::read('siteUrl') . '/img/hh-symbol.png", "width": "400px", "height": "400px"}';
if (isset($sameAsSocialLinks)){
	$i = 1;
	$manuSchema .= ', "sameAs": [';
	foreach ($sameAsSocialLinks as $platform => $link) {
		if($i >= count($sameAsSocialLinks)){
			$comma =  '';
		} else {
			$comma = ',';
		}
		$manuSchema .= '"' . $link . '"' . $comma;
		$i++;
	}
	$manuSchema .= ']';
}
$manuSchema .= '}, "description": "' . h(strip_tags($corp->facebook_description)) . '"';
$manuSchema .= '}</script>';

echo $manuSchema;

$this->Html->script('dist/common.min', ['block' => true]);
?>
<div class="container-fluid site-body blog">
	<div class="row">
		<div class="backdrop backdrop-gradient backdrop-height"></div>
		<div class="container">
			<div class="row noprint">
				<div class="col-sm-9 inverse">
					<?= $this->Breadcrumbs->render() ?>
					<?= $this->element('breadcrumb_schema') ?>
					<div id="ellipses">...</div>
				</div>
			</div>
			<div class="row page-content">
				<span style="display:none;" id="corp-id"><?= $corp->id; ?></span>
				<div class="col-lg-9" style="min-height:100vh">
					<?php if ($isPreview): ?>
						<div class="alert alert-warning mb-3" role="alert">
							This is not the greatest Manufacturer page in the world, no. <br />
							This is just a <strong><em>preview</em></strong>!
						</div>
					<?php endif; ?>
					<div class="print-wrapper">
						<div class="print-head">
							<img src="<?= Configure::read('logo'); ?>" alt="<?= Configure::read('siteName'); ?>" class="print-logo" width="200" height="40">
							<p class="print-link"><?= "www.".Configure::read('siteUrl'); ?></p>
						</div>
						<header class="panel">
							<div class="panel-body">
								<div class="panel-section expanded">
									<div class="row">
										<div class="col-md-8">
											<h1><?= $corp->title ?></h1>
											<p class="text-caption">
												<em id="authorLine"><?= $this->Editorial->getAuthorsByline($corp->author, $corp->contributors) ?>
												<br>Last updated
												<span><?= date('F j, Y', strtotime($corp->last_modified)) ?></span></em>
											</p>
										</div>
										<div class="col-md-4 manuf-logo">
											<div style="display:none"><?= Router::url($corp->facebook_image_url, true); ?></div>
											<img src="<?= $corp->logo_url ?>" loading="lazy" class="pull-right img-fluid" alt="<?= $corp->facebook_title ?>" width="150" height="60">
											<?=
												$this->AuthLink->link('Edit', [
													'prefix' => 'Admin',
													'controller' => 'corps',
													'action' => 'edit',
													$corp->id
												], [
													'class' => 'btn btn-default'
												])
											?>
										</div>
										<div class="col-md-12 gutter-above">
											<p>
											<?= $corp->short; ?>
											</p>
										</div>
									</div>
									<a href="#" class="btn btn-share btn-facebook top-btn mb10 mr5"><span class="hh-icon-facebook"></span></a>
									<a href="#" class="btn btn-share btn-twitter top-btn mb10 mr5"><span class="hh-icon-x"></span></a>
									<a href="#" class="btn btn-share btn-linkedin top-btn mb10 mr5"><span class="hh-icon-linkedin"></span></a>
									<a href="#" class="btn btn-share btn-pinterest top-btn mb10 mr5 ml0"><span class="hh-icon-pinterest"></span></a>
									<button class="btn btn-light btn-print top-btn mb10 mr5 mt0" onclick="window.print()"><span class="hh-icon-printer"></span></button>
								</div>
							</div>
						</header>
						<section class="panel">
							<div class="panel-body">
								<div class="panel-section expanded">
									<?= $corp->description ?>
									<div class="about-author">
										<?= $this->Editorial->getAuthorsBio($corp->author, $corp->contributors) ?>
									</div>
								</div>
							</div>
							<?= $this->element('content/share') ?>
						</section>
					</div>
				</div>
				<?= $this->element('side_panel') ?>
			</div>
		</div>
	</div>
</div>