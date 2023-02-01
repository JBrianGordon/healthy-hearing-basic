<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

$this->Html->setCrumbsArray([
	'Help' => ['controller' => 'wikis', 'action' => 'index'],
	'Manufacturers' => ['controller' => 'corps', 'action' => 'index'],
	$corp->title => ['controller' => 'corps', 'action' => 'view', $corp->slug]
]);
 
$isPreview = isset($isPreview) ? $isPreview : false;
 
$manuSchema = '<script type="application/ld+json">{';
$manuSchema .= '"@context": "https://schema.org", "@type": "Article",';
$manuSchema .= '"mainEntityOfPage": {"@type": "WebPage", "@id": "https://www.' . Configure::read('siteUrl') . $_SERVER['REQUEST_URI'] . '"},';
$manuSchema .= '"headline": "' . $corp->title . '", "datePublished": "' . $corp->created . '", "dateModified": "' . $corp->modified . '", "image": "' . Router::url($corp->facebook_image, true) . '", "articleBody": "' . h(strip_tags($corp->description)) . '",';
/*** TODO : update controller to include author name ***/
$manuSchema .= '"author": {"@type": "Person", "name": "' . $corp->Author->first_name . ' ' . $corp->Author->last_name . '"';
if(!empty($corp->Author->degrees)) {
	$manuSchema .= ', "honorificSuffix": "' . $corp->Author->degrees . '"';
}
if(!empty($corp->Author->url)) {
	$manuSchema .= ', "url": "https://www.' . Configure::read('siteUrl') . $corp->Author->url . '"';
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
					<ul class="breadcrumb">
						<li>
							<a href="/"><span>Home</span></a></li><li><a href="/help"><span>Help</span></a>
						</li>
						<li>
							<a href="/hearing-aid-manufacturers"><span>Manufacturers</span></a>
						</li>
						<li>
							<a href="/oticon-hearing-aids"><span>Oticon hearing aids</span></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row page-content">
				<span style="display:none;" id="corp-id"><?= $corp->id; ?></span>
				<span style="display:none;" id="is-preview"><?= $isPreview; ?></span>
				<div class="col-md-9" style="min-height:100vh">
					<table class="print-wrapper">
						<thead class="print-head">
							<tr>
								<td>
									<img src="<?= Configure::read('logo'); ?>" alt="<?= Configure::read('siteName'); ?>" class="print-logo" width="200" height="40">
									<p class="print-link"><?= "www.".Configure::read('siteUrl'); ?></p>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<header class="panel">
										<div class="panel-body">
											<div class="panel-section expanded">
												<div class="row">
													<div class="col-md-8">
														<h1><?= $corp->title ?></h1>
														<!--*** TODO : update controller to include author name *** -->
														<p class="text-caption">
															<em>Contributed by AUTHOR</em>
														</p>
													</div>
													<div class="col-md-4 manuf-logo">
														<div style="display:none"><?= Router::url($corp->facebook_image, true); ?></div>
														<img src="<?= $corp->thumb_url ?>" loading="lazy" class="pull-right" alt="<?= $corp->facebook_title ?>" width="150" height="60">
														<?php if ($isadmin){
															echo $this->Html->link('Edit', ['controller' => 'admin/corps', 'action' => 'edit', $corp->id], ['class' => 'btn btn-default']);
														} ?>
													</div>
													<div class="col-md-12 gutter-above">
														<p>
														<?= $corp->short; ?>
														</p>
													</div>
												</div>
											</div>
										</div>
									</header>
									<section class="panel">
										<div class="panel-body">
											<div class="panel-section expanded">
												<?= $corp->description ?>
												<!--*** TODO : update controller to include author name *** -->
											</div>
										</div>
										<!--*** TODO : echo content/share when built *** -->
									</section>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- *** TODO: add sidebar layout when built out ***-->
			</div>
		</div>
	</div>
</div>