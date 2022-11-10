<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 */
 
$this->Html->script('dist/wiki.min', ['block' => true]);

//***TODO: uncomment when Wiki model is built
/*$this->Wiki->set($wiki);
$parts = explode("/", $wiki['Wiki']['slug']);
$crumbs = [
	'Help' => '/help',
	ucfirst(strtolower(humanize($parts[0]))) => '/help/' . $parts[0]
];
if (count($parts) > 1) {
	$key = ucfirst(strtolower(humanize($parts[1])));
	$crumbs[$key] = '/help/' . $parts[0] . '/' . $parts[1];
}

$isPreview = isset($isPreview) ? $isPreview : false;
$navigation = ClassRegistry::init('Wiki')->findNavBySlug($wiki['Wiki']['slug']);

$wikiSchema = '<script type="application/ld+json">{';
$wikiSchema .= '"@context": "https://schema.org", "@type": "Article", ';
$wikiSchema .= '"mainEntityOfPage": {"@type": "MedicalWebPage", "@id": "' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"';
if(!empty($wiki['Reviewer'])) {
	$wikiSchema .= ', "reviewedBy": {"@type": "Person", "name": "' . $wiki['Reviewer'][0]['first_name'] . ' ' . $wiki['Reviewer'][0]['last_name'] . '"';
	$wikiSchema .= ', "affiliation": {"@type": "Organization", "name": "' . Configure::read('siteName') . '"}';
	if (!empty($wiki['Reviewer'][0]['honorific_prefix'])) {
		$wikiSchema .= ', "honorificPrefix": "' . $wiki['Reviewer'][0]['honorific_prefix'] . '"';
	}
	if (!empty($wiki['Reviewer'][0]['alumni_of_1'])) {
		$wikiSchema .= ', "alumniOf": ["' . $wiki['Reviewer'][0]['alumni_of_1'] . '"';
		if (!empty($wiki['Reviewer'][0]['alumni_of_2'])) {
			$wikiSchema .= ', "' . $wiki['Reviewer'][0]['alumni_of_2'] . '"';
		}
		if (!empty($wiki['Reviewer'][0]['alumni_of_3'])) {
			$wikiSchema .= ', "' . $wiki['Reviewer'][0]['alumni_of_3'] . '"';
		}
		$wikiSchema .= ']';
	}
	if (!empty($wiki['Reviewer'][0]['degrees'])) {
		$wikiSchema .= ', "honorificSuffix": "' . $wiki['Reviewer'][0]['degrees'] . '"';
	}
	if (!empty($wiki['Reviewer'][0]['title_dept_company'])) {
		$wikiSchema .= ', "jobTitle": "' . $wiki['Reviewer'][0]['title_dept_company'] . '"';
	}
	if (!empty($wiki['Reviewer'][0]['company'])) {
		$wikiSchema .= ', "worksFor": "' . $wiki['Reviewer'][0]['company'] . '"';
	}
	if (!empty($wiki['Reviewer'][0]['short_bio'])) {
		$wikiSchema .= ', "description": "' . htmlentities(strip_tags($wiki['Reviewer'][0]['short_bio'])) . '"';
	}
	if (!empty($wiki['Reviewer'][0]['url'])) {
		$wikiSchema .= ', "url": "' . $_SERVER['HTTP_HOST'] . $wiki['Reviewer'][0]['url'] . '"';
	}
	$wikiSchema .= '}';
}
$wikiSchema .= ', "lastReviewed": "' . $wiki['Wiki']['last_modified'] . '"}, ';
$wikiSchema .= '"headline": "' . $wiki['Wiki']['title_h1'] . '", ';
$wikiSchema .= '"image": {"@type": "imageObject", "url": "' . $_SERVER['HTTP_HOST'] . $wiki['Wiki']['facebook_image'] . '", "width": "' . $wiki['Wiki']['facebook_image_width'] . '", "height": "' . $wiki['Wiki']['facebook_image_width'] . '", "description": "' . htmlentities($wiki['Wiki']['facebook_image_alt']) . '"}, ';
$wikiSchema .= '"datePublished": "' . $wiki['Wiki']['created'] . '", "dateModified": "' . $wiki['Wiki']['last_modified'] . '", "description": "' . htmlentities($wiki['Wiki']['meta_description']) . '", "copyrightYear": "' . $this->Wiki->date($wiki, 'Y') . '", "name": "' . $wiki['Wiki']['name'] . '", "url": "' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '", ';
$wikiSchema .= '"author": {"@type": "Person", "name": "' . $wiki['Author']['first_name'] . ' ' . $wiki['Author']['last_name'] . '", "jobTitle": "' . $wiki['Author']['title_dept_company'] . '", "url": "' . $_SERVER['HTTP_HOST'] . $wiki['Author']['url'] . '", ';
if (!empty($wiki['Author']['honorific_prefix'])) {
	$wikiSchema .= '"honorificPrefix": "' . $wiki['Author']['honorific_prefix'] . '", ';
}
if (!empty($wiki['Author']['alumni_of_1'])) {
	$wikiSchema .= '"alumniOf": ["' . $wiki['Author']['alumni_of_1'] . '", ';
	if (!empty($wiki['Author']['alumni_of_2'])) {
		$wikiSchema .= '"' . $wiki['Author']['alumni_of_2'] . '", ';
	}
	if (!empty($wiki['Author']['alumni_of_3'])) {
		$wikiSchema .= '"' . $wiki['Author']['alumni_of_3'] . '"';
	}
	$wikiSchema .= '], ';
}
if (!empty($wiki['Author']['degrees'])) {
	$wikiSchema .= '"honorificSuffix": "' . $wiki['Author']['degrees'] . '", ';
}
if(!empty($wiki['Author']['short_bio'])){
	$wikiSchema .= '"description": "' . htmlentities(strip_tags($wiki['Author']['short_bio'])) . '", ';
}
$wikiSchema .= '"worksFor": {"@type": "Organization", "name": "' . Configure::read('siteName') . '"}, ';
$wikiSchema .= '"affiliation": {"@type": "Organization", "name": "' . Configure::read('siteName') . '"}';
$wikiSchema .= '}, ';
$wikiSchema .= '"publisher": {"@type": "Organization", "name": "' . Configure::read('siteName') . '", "url": "' . $_SERVER['HTTP_HOST'] . '", ';
$wikiSchema .= '"brand": {"@type": "Thing", "name": "' . Configure::read('siteName') . '"}';
if (isset($sameAsSocialLinks)) {
	$i = 1;
	$wikiSchema .= ', "sameAs":[';
		foreach ($sameAsSocialLinks as $platform => $link) {
			if($i >= count($sameAsSocialLinks)){
				$comma =  '';
			} else {
				$comma = ',';
			}
			$wikiSchema .= '"' . $link . '"' . $comma;
			$i++;
		}
	$wikiSchema .= ']';
}
$wikiSchema .= ', "logo": {"@type": "ImageObject", "url": "' . $_SERVER['HTTP_HOST'] . '/img/hh-symbol.png", "width": "400px", "height": "400px"}';
$wikiSchema .= '}, ';
$wikiSchema .= '"audience": {"@type": "MedicalAudience", "audienceType": ["patient", "caregiver"]}';
$wikiSchema .= '}</script>';

echo $wikiSchema;
*/
?>
<div class="container-fluid site-body content-body secondary">
	<div class="row pt0 pb0">
		<a name="top"></a>
		<span style="display:none;" id="wiki-id"><?php //***TODO: uncomment when Wiki model is built*** echo $this->Wiki->get('id'); ?></span>
		<span style="display:none;" id="is-preview"><?php echo $isPreview; ?></span>
		<article class="container">
			<div class="backdrop-container noprint">
				<div class="backdrop backdrop-gradient backdrop-height"></div>
			</div>
			<div class="print-wrapper">
				<div class="print-head">
					<img src="<?php //***TODO: uncomment when Configure is built*** echo Configure::read('logo'); ?>" alt="<?php //***TODO: uncomment when Configure is built*** echo Configure::read('siteName'); ?>" class="print-logo" width="200" height="40">
					<p class="print-link"><?php //***TODO: uncomment when Configure is built*** echo "www.".Configure::read('siteUrl'); ?></p>
				</div>
					<header class="col-md-12 inverse">
						<div>
							<?php //***TODO: uncomment when breadcrumbs are built*** echo $this->element('layouts/breadcrumbs', array('crumbs' => $crumbs)); ?>
						</div>
							<div class="row header-content pt0 pb0">
								<div class="col-md-8">
									<div>
									<?php //***TODO: uncomment when isadmin is built*** if ($isadmin): ?>
										<?php //***TODO: uncomment when Wiki model is built*** echo $this->Html->link('Edit', ['admin' => true, 'controller' => 'wikis', 'action' => 'edit', $this->Wiki->get('id')], ['class' => 'btn btn-primary pull-right']); ?>
									<?php //endif; ?>
									<h1><?= $wiki->title_h1 ?></h1>
									<p class="text-caption">
										<em id="authorLine">By <?php //***TODO: uncomment when Content model is built*** echo $this->Content->author($wiki, ['schema' => false, 'local_anchor' => true]); ?></em>
										<?php //***TODO: uncomment when wiki is built*** if (!empty($wiki['Reviewer'])) : ?>
											<br><img src="/img/checked.png" alt="check mark" class="mr5" style="width:12px;position:relative;bottom:1px;">Reviewed by 
												<?php 
													/***TODO: uncomment wiki is built*** $reviewer = $wiki['Reviewer'][0]['first_name'] . ' ' . $wiki['Reviewer'][0]['last_name'] . '</a>';
													$shortBio = '';
													if (!empty($wiki['Reviewer'][0]['degrees'])) {
														$reviewer .= ', ' . $wiki['Reviewer'][0]['degrees'];
													}
													if (!empty($wiki['Reviewer'][0]['title_dept_company'])) {
														$reviewer .= ', ' . $wiki['Reviewer'][0]['title_dept_company'];
													}
													if (!empty($wiki['Reviewer'][0]['company'])) {
														$reviewer .= ', ' . $wiki['Reviewer'][0]['company'];
													}
													if (!empty($wiki['Reviewer'][0]['short_bio'])) {
														$shortBio = $wiki['Reviewer'][0]['short_bio'];
													}
													echo '<a class="text-link" data-toggle="popover" data-trigger="hover" data-content="' . $shortBio . '">' . $reviewer; */?>
										<?php //endif; ?>
										<br />Last updated on:
										<span><?php //***TODO: uncomment when Time is built*** echo $this->Time->format('F jS, Y', $wiki['Wiki']['last_modified']); ?></span>
									</p>
									<p class="lead">
										<?php //***TODO: uncomment when Wiki model is built*** echo $this->Wiki->get('short'); ?>
									</p>
									</div>
								</div>
							</div>
		
					</header>
							<div class="col-md-9 col-lg-9 float-start">
								<div class="panel pt0">
									<div class="panel-section expanded">
										<div class="row pt0 pb0">
											<div class="col-lg-12">
												<div id="wiki-body">
													<p><?= $wiki->body ?></p>
												</div>
											</div>
										</div>
									</div>
									<?php //***TODO: uncomment when share element added*** echo $this->element('content/share'); ?>
								</div>
							</div>
							<!-- ***TODO: Side panel should be it's own element*** -->
							<div class="col-md-3 col-lg-3 float-end noprint">
								<!-- Right content -->
								<?php //***TODO: uncomment when Configure added*** if (Configure::read('showAds') && $this->Content->isMobileDevice()): ?>
									<?php //echo $this->element('render_ad', array('ad' => $ad)); ?>
								<?php //endif; ?>
								<?php //***TODO: uncomment when locations/preferred element added*** if($this->App->isMobileDevice()){echo $this->element('locations/preferred');} ?>
								<section class="panel panel-light help-menu">
								<header class="panel-heading text-center">Help menu</header>
									<div class="panel-section condensed">
										<div class="row pt0 pb0">
											<div class="col-lg-12">
												<?php
												//***TODO: uncomment when nav_box element added***echo $this->element('wikis/nav_box', [
													//'params' => [
													//	'navigation' => $navigation,
													//	'slug' => $wiki['Wiki']['slug'],
													//	'align' => 'text-left'
													//]
												//]);
												?>
											</div>
										</div>
									</div>
								</section>
								<?php //***TODO: uncomment when locations/preferred element added***if(!$this->App->isMobileDevice()){echo $this->element('locations/preferred');} ?>
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
									<div class="row">
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
									</div>
								</section>
								<?php endif; ?>
								<section class="panel panel-light blog-previews hidden">
									<header class="panel-heading text-center">
										<h4>The Healthy Hearing Report</h4>
									</header>

										<?php //***TODO: uncomment when $articles is defined*** foreach ($articles as $content): ?>
											<div class="panel-section condensed blog-preview">
												<div class="row pt0 pb0">
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
											</div>
										<?php //endforeach; ?>

								</section>
								<?php //***TODO: uncomment when Configure added*** if (Configure::read('showAds') && !$this->Content->isMobileDevice()): ?>
									<?php //echo $this->element('render_ad', array('ad' => $ad)); ?>
								<?php //endif; ?>
							</div>
		</article>
	</div>
</div>       