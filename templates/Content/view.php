<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
 
 use Cake\Core\Configure;
 
$wikis = isset($wikis) ? $wikis : [];
$title = empty($seoTitle->title) ? $content->title : $seoTitle->title;
$subtitle = htmlentities(strip_tags($content->subtitle));
$altTitle = htmlentities(strip_tags($content->alt_title));
$altTitle = empty($altTitle) ? $title : $altTitle;
//$this->Content->setPrint(true);

$this->Breadcrumbs->add([
		['title' => 'Home', 'url' => '/'],
    ['title' => 'Report', 'url' => ['prefix'=>false, 'plugin'=>false, 'controller' => 'content', 'action' => 'report_index']],
    ['title' => $content->title, 'url' => '']
]);
$isPreview = isset($isPreview) ? $isPreview : false;

$meta = '<!--Facebook meta tags-->
    <meta property="og:url" content="https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="'.$content->facebook_title.'" />
    <meta property="og:description" content="'.$content->facebook_description.'" />
    <meta property="og:image" content="'.$content->facebook_image_url.'" />';

$this->assign('meta', $meta);

$contentSchema = '<script type="application/ld+json">{
	"@context": "https://schema.org",
	"@type": "Article",';
	$contentSchema .= '"about": {"@type": "Thing"';
	if (!empty($content->tags) && isset($content->tags[0]->ribbon_header)) {
		$contentSchema .= ', "name": "' . $content->tags[0]->ribbon_header . '"';
	}
	$contentSchema .= '},';
	$contentSchema .= '"mainEntityOfPage": {"@type": "MedicalWebPage", "@id": "https://www.' . Configure::read('siteUrl') . $_SERVER['REQUEST_URI'] . '"},';
	$contentSchema .= '"headline": "' . htmlentities(strip_tags($title)) . '",
	"alternativeHeadline": "' . $altTitle . '",';
	if (!empty($content->facebook_image)) {
		$contentSchema .= '"image": {
			"@type": "ImageObject", 
			"url": "' . $_SERVER['HTTP_HOST'] . $content->facebook_image . '"';
			if (isset($content->facebook_image_width)) {
				$contentSchema .= ', "width": "' . $content->facebook_image_width . '"';
			}
			if (isset($content->facebook_image_height)) {
				$contentSchema .= ', "height": "' . $content->facebook_image_height . '"';
			}
			if (isset($content->facebook_image_alt)) {
				$contentSchema .= ', "description": "' . htmlentities(strip_tags($content->facebook_image_alt)) . '"';
			}
		$contentSchema .= '},';
	}
	$contentSchema .= '"datePublished": "' . $content->date . '-05:00",
		"dateModified": "' . $content->last_modified . '-05:00",
		"description": "' . htmlentities(strip_tags($content->facebook_description)) . '",
		"copyrightYear": "' . date('Y', $content->last_modified->timestamp) . '",
		"wordCount": "' . str_word_count(strip_tags($content->body)) . '",
		"name": "' . htmlentities(strip_tags($title)) . '",
		"url": "https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '",
		"articleBody": "' . htmlentities(strip_tags(trim($content->body))) . '",';
		if (!empty($content->primary_author)) {
			$contentSchema .= '"author": {
				"@type": "Person",
				"name": "' . $content->primary_author->first_name . ' ' . $content->primary_author->last_name . '"';
				if (!empty($content->primary_author->title_dept_company)) {
					$contentSchema .= ', "jobTitle": "' . $content->primary_author->title_dept_company . '"';
				}
				if (!empty($content->primary_author->degrees)) {
					$contentSchema .= ', "honorificSuffix": "' . $content->primary_author->degrees . '"';
				}
				if (!empty($content->primary_author->company)) {
					$contentSchema .= ', "worksFor": "' . $content->primary_author->company . '",
					"affiliation": "' . $content->primary_author->company . '"';
				}
				if(!empty($content->primary_author->url)) {
					$contentSchema .= ', "url": "https://' . $_SERVER['HTTP_HOST'] . $content->primary_author->url . '"';
				}
			$contentSchema .= '},';
		}
		$contentSchema .= '"publisher": {
			"@type": "Organization",
			"name": "' . Configure::read('siteName') . '",
			"url": "https://' . $_SERVER['HTTP_HOST'] . '", ';
			if (isset($sameAsSocialLinks)) {
				$i = 1;
				$contentSchema .= '"sameAs": [';
				foreach ($sameAsSocialLinks as $platform => $link) {
					if($i >= count($sameAsSocialLinks)){
						$comma =  '';
					} else {
						$comma = ',';
					}
					$contentSchema .= '"' . $link . '"' . $comma;
					$i++;
				}
				$contentSchema .= '], ';
			}
			$contentSchema .= '"logo": {
				"@type": "ImageObject",
				"url": "https://www.' . Configure::read('siteUrl') . '/img/hh-symbol.png",
				"width": "400px",
				"height": "400px"
			}
		},';
		$contentSchema .= '"isPartOf" : {
			"@type": "WebPage",
			"name": "The Healthy Hearing Report",
			"mainEntityOfPage": "https://www.healthyhearing.com/report"
		}
	}</script>';

echo $contentSchema;
 
$this->Vite->script('content','common-vite');
?>

<div class="container-fluid site-body blog">
  <div class="row">
	<div class="backdrop backdrop-gradient backdrop-height"></div>
	<div class="container">
		<div class="row noprint">
			<div class="col-sm-9 inverse">
				<?= $this->Breadcrumbs->render(); ?>
				<?= $this->element('breadcrumb_schema') ?>
				<div id="ellipses">...</div>
			</div>
		</div>
		<div class="row page-content">
			<span style="display:none;" id="is-preview"><?= $isPreview ?></span>
			<div class="col-lg-9 float-start">
				<article class="panel">
					<div class="print-wrapper">
						<div class="print-head">
							<img src="<?= Configure::read('logo'); ?>" alt="<?= Configure::read('siteName');?>" class="print-logo" width="200" height="40">
							<p class="print-link"><?= "www.".Configure::read('siteUrl') ?></p>
						</div>
						<div class="panel-body">
							<div class="panel-section expanded">
								<?php if ($isPreview): ?>
									<div class="alert alert-warning mb-3" role="alert">
										This is not the greatest Report page in the world, no. <br />
										This is just a <strong><em>preview</em></strong>!
									</div>
								<?php endif; ?>
								<?=
									$this->AuthLink->link('Edit', [
										'prefix' => 'Admin',
										'controller' => 'content',
										'action' => 'edit',
										$content->id
									], [
										'class' => 'btn btn-primary pull-right',
										'style' => 'width:70px',
									])
								?>
								<h1 class="text-primary blog-title<?php if(isset($subtitle)){ echo " mb10"; } ?>">
									<?= $title ?>
								</h1>
								<?php if (isset($subtitle)): ?>
									<h2 class="text-primary mt0 mb30"><?= $subtitle ?></h2>
								<?php endif; ?>
								<p class="blog-byline text-caption">
									<?php if (!empty($content->primary_author) || !empty($content->contributors)): ?>
										<?= $this->Editorial->getAuthorImage($content->primary_author) ?>
										<em><?= $this->Editorial->getAuthorsByline($content->primary_author, $content->contributors) ?></em><br>
										<?= $this->Editorial->displayDate($content) ?>
									<?php else: ?>
										<span><em>Last updated <?= date_format($content->modified, 'F jS, Y') ?></em></span>
									<?php endif; ?>
								</p>
								<a href="#" class="btn btn-share btn-facebook top-btn mb10 mr5"><span class="hh-icon-facebook"></span><span class="visually-hidden">Facebook share</span></a>
								<a href="#" class="btn btn-share btn-twitter top-btn mb10 mr5"><span class="hh-icon-x"></span><span class="visually-hidden">X share</span></a>
								<a href="#" class="btn btn-share btn-linkedin top-btn mb10 mr5"><span class="hh-icon-linkedin"></span><span class="visually-hidden">LinkedIn share</span></span></a>
								<a href="#" class="btn btn-share btn-pinterest top-btn mb10 mr5 ml0"><span class="hh-icon-pinterest"></span><span class="visually-hidden">Pinterest share</span></a>
								<button class="btn btn-light btn-print top-btn mb10 mr5 mt0" onclick="window.print()"><span class="hh-icon-printer"></span><span class="visually-hidden">Print page</span></button>
								<div id="content_body" class="content-body">
									<?= $content->body ?>
								</div>
								<div class="about-author">
									<?= $this->Editorial->getAuthorsBio($content->primary_author, $content->contributors) ?>
								</div>
								<div class="blog-categories noprint mt30">
									Related Help Pages:
									<?php foreach ($wikis as $wiki): ?>
									    <?= $this->Html->link($wiki->name, $wiki->hh_url, ['class' => 'btn btn-default btn-xs']) ?>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>
					<?= $this->element('content/share') ?>
				</article>
			</div>
			<?= $this->element('responsive_slider') ?>
			<?= $this->element('side_panel') ?>
		</div>
	</div>
  </div>
</div>
