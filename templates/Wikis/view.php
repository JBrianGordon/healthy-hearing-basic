<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 */

use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Routing\Router;

$parts = explode("/", $wiki->slug);
$this->Breadcrumbs->add([['title' => 'Home', 'url' => '/'], ['title' => 'Help', 'url' => '/help']]);
if (!empty($parts[0])) {
	$url = '/help/'.$parts[0];
	$url = ($url == $_SERVER['REQUEST_URI']) ? '' : $url;
	$this->Breadcrumbs->add(ucfirst(str_replace('-', ' ', $parts[0])), $url);
}
if (!empty($parts[1])) {
	$this->Breadcrumbs->add(ucfirst(str_replace('-', ' ', $parts[1])), '');
}

$isPreview = isset($isPreview) ? $isPreview : false;

$wikiSchema = '<script type="application/ld+json">{';
$wikiSchema .= '"@context": "https://schema.org", "@type": "Article", ';
$wikiSchema .= '"mainEntityOfPage": {"@type": "MedicalWebPage", "@id": "' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"';
if(!empty($wiki->reviewers)) {
	$wikiSchema .= ', "reviewedBy": {"@type": "Person", "name": "' . $wiki->reviewers[0]->first_name . ' ' . $wiki->reviewers[0]->last_name . '"';
	$wikiSchema .= ', "affiliation": {"@type": "Organization", "name": "' . Configure::read('siteName') . '"}';
	if (!empty($wiki->reviewers[0]->honorific_prefix)) {
		$wikiSchema .= ', "honorificPrefix": "' . $wiki->reviewers[0]->honorific_prefix . '"';
	}
	if (!empty($wiki->reviewers[0]->alumni_of_1)) {
		$wikiSchema .= ', "alumniOf": ["' . $wiki->reviewers[0]->alumni_of_1 . '"';
		if (!empty($wiki->reviewers[0]->alumni_of_2)) {
			$wikiSchema .= ', "' . $wiki->reviewers[0]->alumni_of_2 . '"';
		}
		if (!empty($wiki->reviewers[0]->alumni_of_3)) {
			$wikiSchema .= ', "' . $wiki->reviewers[0]->alumni_of_3 . '"';
		}
		$wikiSchema .= ']';
	}
	if (!empty($wiki->reviewers[0]->degrees)) {
		$wikiSchema .= ', "honorificSuffix": "' . $wiki->reviewers[0]->degrees . '"';
	}
	if (!empty($wiki->reviewers[0]->title_dept_company)) {
		$wikiSchema .= ', "jobTitle": "' . $wiki->reviewers[0]->title_dept_company . '"';
	}
	if (!empty($wiki->reviewers[0]->company)) {
		$wikiSchema .= ', "worksFor": "' . $wiki->reviewers[0]->company . '"';
	}
	if (!empty($wiki->reviewers[0]->short_bio)) {
		$wikiSchema .= ', "description": "' . htmlentities(strip_tags($wiki->reviewers[0]->short_bio)) . '"';
	}
	if (!empty($wiki->reviewers[0]->url)) {
		$wikiSchema .= ', "url": "' . $_SERVER['HTTP_HOST'] . $wiki->reviewers[0]->url . '"';
	}
	$wikiSchema .= '}';
}
$wikiSchema .= ', "lastReviewed": "' . $wiki->last_modified . '"}, ';
$wikiSchema .= '"headline": "' . $wiki->title_h1 . '", ';
$wikiSchema .= '"image": {"@type": "imageObject", "url": "' . $_SERVER['HTTP_HOST'] . $wiki->facebook_image . '", "width": "' . $wiki->facebook_image_width . '", "height": "' . $wiki->facebook_image_width . '", "description": "' . htmlentities($wiki->facebook_image_alt) . '"}, ';
$wikiSchema .= '"datePublished": "' . $wiki->created . '", "dateModified": "' . $wiki->last_modified . '", "description": "' . htmlentities($wiki->meta_description) . '", "copyrightYear": "' . date('Y', strtotime($wiki->last_modified)) . '", "name": "' . $wiki->name . '", "url": "' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '", ';
$wikiSchema .= '"author": {"@type": "Person", "name": "' . $wiki->author->first_name . ' ' . $wiki->author->last_name . '", "jobTitle": "' . $wiki->author->title_dept_company . '", "url": "' . $_SERVER['HTTP_HOST'] . $wiki->author->url . '", ';
if (!empty($wiki->author->honorific_prefix)) {
	$wikiSchema .= '"honorificPrefix": "' . $wiki->author->honorific_prefix . '", ';
}
if (!empty($wiki->author->alumni_of_1)) {
	$wikiSchema .= '"alumniOf": ["' . $wiki->author->alumni_of_1 . '", ';
	if (!empty($wiki->author->alumni_of_2)) {
		$wikiSchema .= '"' . $wiki->author->alumni_of_2 . '", ';
	}
	if (!empty($wiki->author->alumni_of_3)) {
		$wikiSchema .= '"' . $wiki->author->alumni_of_3 . '"';
	}
	$wikiSchema .= '], ';
}
if (!empty($wiki->author->degrees)) {
	$wikiSchema .= '"honorificSuffix": "' . $wiki->author->degrees . '", ';
}
if(!empty($wiki->author->short_bio)){
	$wikiSchema .= '"description": "' . htmlentities(strip_tags($wiki->author->short_bio)) . '", ';
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

$this->Html->script('dist/wiki.min', ['block' => true]);
?>
<div class="container-fluid site-body content-body secondary p0">
	<div class="row pt0 pb0">
		<a name="top"></a>
		<span style="display:none;" id="wiki-id"><?= $wiki->id ?></span>
		<span style="display:none;" id="is-preview"><? $isPreview ?></span>
		<article class="container">
			<div class="backdrop-container noprint">
				<div class="backdrop backdrop-gradient backdrop-height"></div>
			</div>
			<div class="print-wrapper">
				<div class="print-head">
					<img src="<?= Configure::read('logo'); ?>" alt="<?= Configure::read('siteName'); ?>" class="print-logo" width="200" height="40">
					<p class="print-link"><?= "www.".Configure::read('siteUrl'); ?></p>
				</div>
				<header class="col-sm-12 inverse">
					<div class="col-sm-12 col-xs-9">
						<?= $this->Breadcrumbs->render() ?>
						<?= $this->element('breadcrumb_schema') ?>
						<div id="ellipses">...</div>
					</div>
					<div class="row header-content col-sm-8">
						<?php if ($isAdmin): ?>
							<?= $this->Html->link('Edit', ['prefix'=>'Admin', 'controller'=>'wikis', 'action'=>'edit', $wiki->id], ['class' => 'btn btn-primary pull-right', 'style' => 'width:66px']) ?>
						<?php endif; ?>
						<h1 class="p0"><?= $wiki->title_h1 ?></h1>
						<p class="text-caption p0">
							<em id="authorLine"><?= $this->Editorial->getAuthorsByline($wiki->author, $wiki->contributors, 'By') ?></em>
							<?= $this->Editorial->getReviewersByline($wiki->reviewers) ?>
							<br>Last updated on:
							<span><?= date('F jS, Y', strtotime($wiki->last_modified)) ?></span>
						</p>
						<p class="lead p0">
							<?= $wiki->short ?>
						</p>
						</div>
					</div>
				</header>
				<div class="row">
					<div class="col-sm-9 float-start mb70">
						<div class="panel panel-section expanded mb0">
							<div id="wiki-body">
								<?= $wiki->body ?>
								<div class="about-author">
									<?= $this->Editorial->getAuthorsBio($wiki->author, $wiki->contributors) ?>
								</div>
							</div>
						</div>
						<?= $this->element('content/share') ?>
					</div>
					<?= $this->element('side_panel') ?>
				</div>
			</div>
		</article>
	</div>
</div>
