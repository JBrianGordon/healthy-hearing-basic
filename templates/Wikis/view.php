<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wiki $wiki
 */
 
$this->Html->script('dist/wiki.min', ['block' => true]);

use Cake\Core\Configure;
use Cake\Utility\Inflector;

$parts = explode("/", $wiki->slug);
$crumbs = [
	'Help' => '/help',
	ucfirst(strtolower(Inflector::humanize($parts[0]))) => '/help/' . $parts[0]
];
if (count($parts) > 1) {
	$key = ucfirst(strtolower(Inflector::humanize($parts[1])));
	$crumbs[$key] = '/help/' . $parts[0] . '/' . $parts[1];
}
$isPreview = isset($isPreview) ? $isPreview : false;
$navigation = $this->Wiki->findNavBySlug($wiki->slug);

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
?>
<div class="container-fluid site-body content-body secondary p0">
	<div class="row pt0 pb0">
		<a name="top"></a>
		<span style="display:none;" id="wiki-id"><?= $wiki->id ?></span>
		<span style="display:none;" id="is-preview"><?php echo $isPreview; ?></span>
		<article class="container">
			<div class="backdrop-container noprint">
				<div class="backdrop backdrop-gradient backdrop-height"></div>
			</div>
			<div class="print-wrapper">
				<div class="print-head">
					<img src="<?= Configure::read('logo'); ?>" alt="<?= Configure::read('siteName'); ?>" class="print-logo" width="200" height="40">
					<p class="print-link"><?= "www.".Configure::read('siteUrl'); ?></p>
				</div>
				<header class="col-md-12 inverse">
					<?php //***TODO: uncomment when breadcrumbs are built*** echo $this->element('layouts/breadcrumbs', array('crumbs' => $crumbs)); ?>
					<div class="row header-content pt0 pb0">
						<div class="col-md-8">
							<?php if ($isAdmin): ?>
								<?php echo $this->Html->link('Edit', ['prefix'=>'Admin', 'controller'=>'wikis', 'action'=>'edit', $wiki->id], ['class' => 'btn btn-primary pull-right']); ?>
							<?php endif; ?>
							<h1><?= $wiki->title_h1 ?></h1>
							<p class="text-caption">
								<em id="authorLine">By <?php echo $this->Editorial->author($wiki, ['schema' => false, 'localAnchor' => true]); ?></em>
								<?php if (!empty($wiki->reviewers)) : ?>
									<br><img src="/img/checked.png" alt="check mark" class="mr5" style="width:12px;position:relative;bottom:1px;">Reviewed by 
									<?php
										$reviewer = $wiki->reviewers[0]->first_name . ' ' . $wiki->reviewers[0]->last_name . '</a>';
										$shortBio = '';
										if (!empty($wiki->reviewers[0]->degrees)) {
											$reviewer .= ', ' . $wiki->reviewers[0]->degrees;
										}
										if (!empty($wiki->reviewers[0]->title_dept_company)) {
											$reviewer .= ', ' . $wiki->reviewers[0]->title_dept_company;
										}
										if (!empty($wiki->reviewers[0]->company)) {
											$reviewer .= ', ' . $wiki->reviewers[0]->company;
										}
										if (!empty($wiki->reviewers[0]->short_bio)) {
											$shortBio = $wiki->reviewers[0]->short_bio;
										}
										echo '<a class="text-link" data-toggle="popover" data-trigger="hover" data-content="' . $shortBio . '">' . $reviewer;
									?>
								<?php endif; ?>
								<br />Last updated on:
								<span><?= date('F jS, Y', strtotime($wiki->last_modified)) ?></span>
							</p>
							<p class="lead">
								<?= $wiki->short ?>
							</p>
							</div>
						</div>
					</div>
				</header>
				<div class="col-md-9 col-lg-9 float-start">
					<div class="panel panel-section expanded">
						<div id="wiki-body" class="col-lg-12 pr0 pl0">
							<?= $wiki->body ?>
							<?php echo $this->Editorial->getAuthorBio($wiki->author, $wiki->contributors); ?>
						</div>
						<?php //***TODO: uncomment when share element added*** echo $this->element('content/share'); ?>
					</div>
				</div>
				<?= $this->element('side_panel') ?>
			</div>
		</article>
	</div>
</div>
