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
$description = htmlentities(strip_tags($content->meta_description));
if (!empty($seoMetaTags)) {
	foreach ($seoMetaTags as $seoMetaTag) {
		if ($seoMetaTag->name == 'description') {
			$description = $seoMetaTag->content;
		}
	}
}
//$this->Content->setPrint(true);

$this->Breadcrumbs->add([
    ['title' => 'Report', 'url' => ['prefix'=>false, 'plugin'=>false, 'controller' => 'content', 'action' => 'report_index']],
    ['title' => $content->title, 'url' => '']
]);
$isPreview = isset($isPreview) ? $isPreview : false;

$contentSchema = '<script type="application/ld+json">{
	"@context": "https://schema.org",
	"@type": "NewsArticle",
	"mainEntityOfPage": {
		"@type": "WebPage",';
		$contentSchema .= '"@id": "https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"
	},
	"headline": "' . htmlentities(strip_tags($title)) . '",
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
	$contentSchema .= '"datePublished": "' . $content->created . '",
		"dateModified": "' . $content->last_modified . '",
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
		}
	}</script>';

echo $contentSchema;
 
$this->Html->script('dist/content.min', ['block' => true]);
?>

<?= $this->element('schema/person', ['author' => $content->primary_author]) ?>

<div class="container-fluid site-body blog">
	<div class="container">
	  <div class="row">
		<div class="backdrop backdrop-gradient backdrop-height"></div>
		<div class="container">
			<div class="row noprint">
				<div class="col-sm-9 inverse">
					<?= $this->Breadcrumbs->render(); ?>
				</div>
			</div>
			<div class="row page-content">
				<span style="display:none;" id="is-preview"><?php echo $isPreview; ?></span>
				<div class="col-md-9 float-start" style="min-height:100vh">
					<article class="panel">
						<div class="print-wrapper">
							<div class="print-head">
								<img src="<?= Configure::read('logo'); ?>" alt="<?= Configure::read('siteName'); ?>" class="print-logo" width="200" height="40">
								<p class="print-link"><?= "www.".Configure::read('siteUrl'); ?></p>
							</div>
							<div class="panel-body">
								<div class="panel-section expanded">
									<?php echo $this->Editorial->adminLink($content->id, $isAdmin);	?>
									<h1 class="text-primary blog-title<?php if(isset($subtitle)){ echo " mb10"; } ?>">
										<?= $title ?>
									</h1>
									<?php if (isset($subtitle)): ?>
										<h2 class="text-primary mt0 mb30"><?= $subtitle ?></h2>
									<?php endif; ?>
									<p class="blog-byline text-caption">
										<?php if (!empty($content->primary_author) || !empty($content->contributors)): ?>
											<em><?= $this->Editorial->getAuthorsByline($content->primary_author, $content->contributors) ?></em><br>
											<?= $this->Editorial->displayDate($content) ?>
										<?php else: ?>
											<span><em>Last updated <?= date_format($content->modified, 'F jS, Y') ?></em></span>
										<?php endif; ?>
									</p>
									<div id="content_body" class="content-body">
										<?= $content->body ?>
									</div>
									<div class="about-author">
										<?= $this->Editorial->getAuthorsBio($content->primary_author, $content->contributors) ?>
									</div>
									<div class="blog-categories noprint mt30">
										Related Help Pages:
										<?php foreach ($wikis as $wiki): ?>
										    <?php echo $this->Html->link($wiki->name, $wiki->hh_url, ['class' => 'btn btn-default btn-xs']); ?>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
						<?php echo $this->element('content/share'); ?>
					</article>
				</div>
				<?= $this->element('side_panel') ?>
			</div>
		</div>
	  </div>
	</div>
</div>
