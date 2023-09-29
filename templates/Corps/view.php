<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corp $corp
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

$this->Breadcrumbs->add([
    ['title' => 'Help', 'url' => ['controller' => 'wikis', 'action' => 'index']],
    ['title' => 'Manufacturers', 'url' => ['controller' => 'corps', 'action' => 'index']],
    ['title' => $corp->title, 'url' => ''],
]);
 
$isPreview = isset($isPreview) ? $isPreview : false;
 
$manuSchema = '<script type="application/ld+json">{';
$manuSchema .= '"@context": "https://schema.org", "@type": "Article",';
$manuSchema .= '"mainEntityOfPage": {"@type": "WebPage", "@id": "https://www.' . Configure::read('siteUrl') . $_SERVER['REQUEST_URI'] . '"},';
$manuSchema .= '"headline": "' . $corp->title . '", "datePublished": "' . $corp->created . '", "dateModified": "' . $corp->modified . '", "image": "' . Router::url($corp->facebook_image, true) . '", "articleBody": "' . h(strip_tags($corp->description)) . '",';
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
				<span style="display:none;" id="is-preview"><?= $isPreview; ?></span>
				<div class="col-lg-9" style="min-height:100vh">
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
														<p class="text-caption">
															<em id="authorLine"><?= $this->Editorial->getAuthorsByline($corp->author, $corp->contributors) ?>
															<br>Last updated
															<span><?= date('F j, Y', strtotime($corp->last_modified)) ?></span></em>
														</p>
													</div>
													<div class="col-md-4 manuf-logo">
														<div style="display:none"><?= Router::url($corp->facebook_image, true); ?></div>
														<img src="<?= $corp->thumb_url ?>" loading="lazy" class="pull-right" alt="<?= $corp->facebook_title ?>" width="150" height="60">
														<?php if ($isAdmin){
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
												<div class="about-author">
													<?= $this->Editorial->getAuthorsBio($corp->author, $corp->contributors) ?>
												</div>
											</div>
										</div>
										<?= $this->element('content/share') ?>
									</section>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?= $this->element('side_panel') ?>
			</div>
		</div>
	</div>
</div>