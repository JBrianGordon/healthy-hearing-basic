<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Content $content
 */
 
 $wikis = isset($wikis) ? $wikis : [];
//*** TODO: uncomment when Configure is built out ***
//$this->Content->set($content);
//$title = empty($seoTitle['SeoTitle']['title']) ? $this->Content->get('title') : $seoTitle['SeoTitle']['title'];
//$subtitle = htmlentities(strip_tags($this->Content->get('subtitle')));
//$altTitle = htmlentities(strip_tags($this->Content->get('alt_title')));
//$altTitle = empty($altTitle) ? $title : $altTitle;
//$description = htmlentities(strip_tags($this->Content->get('meta_description')));
if (!empty($seoMetaTags)) {
	foreach ($seoMetaTags as $seoMetaTag) {
		if ($seoMetaTag['SeoMetaTag']['name'] == 'description') {
			$description = $seoMetaTag['SeoMetaTag']['content'];
		}
	}
}
//$this->Content->setPrint(true);

//$this->Content->setCrumbsArray([
	//'Report' => ['controller' => 'content', 'action' => 'report_index'],
	//$this->Content->get('title') => $this->here
//]);
$isPreview = isset($isPreview) ? $isPreview : false;

/*$contentSchema = '<script type="application/ld+json">{
	"@context": "https://schema.org",
	"@type": "NewsArticle",
	"mainEntityOfPage": {
		"@type": "WebPage",';
		$contentSchema .= '"@id": "https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"
	},
	"headline": "' . htmlentities(strip_tags($title)) . '",
	"alternativeHeadline": "' . $altTitle . '",';
	if (!empty($content['Content']['facebook_image'])) {
		$contentSchema .= '"image": {
			"@type": "ImageObject", 
			"url": "' . $_SERVER['HTTP_HOST'] . $content['Content']['facebook_image'] . '"';
			if (isset($content['Content']['facebook_image_width'])) {
				$contentSchema .= ', "width": "' . $content['Content']['facebook_image_width'] . '"';
			}
			if (isset($content['Content']['facebook_image_height'])) {
				$contentSchema .= ', "height": "' . $content['Content']['facebook_image_height'] . '"';
			}
			if (isset($content['Content']['facebook_image_alt'])) {
				$contentSchema .= ', "description": "' . htmlentities(strip_tags($content['Content']['facebook_image_alt'])) . '"';
			}
		$contentSchema .= '},';
	}*/
	/*$contentSchema .= '"datePublished": "' . $content['Content']['created'] . '",
		"dateModified": "' . $content['Content']['last_modified'] . '",
		"description": "' . htmlentities(strip_tags($content['Content']['facebook_description'])) . '",
		"copyrightYear": "' . $this->Content->date($content, 'Y') . '",
		"wordCount": "' . str_word_count(strip_tags($content['Content']['body'])) . '",
		"name": "' . htmlentities(strip_tags($title)) . '",
		"url": "https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '",
		"articleBody": "' . htmlentities(strip_tags($this->Content->getBody())) . '",';
		if ($author = $this->Content->author($content, ['schema' => false, 'date' => true, 'format' => DateTime::ATOM, 'local_anchor' => true, 'dateNewLine' => true])) {
			$contentSchema .= '"author": {
				"@type": "Person",
				"name": "' . $content['Author']['first_name'] . ' ' . $content['Author']['last_name'] . '"';
				if(!empty($content['Author']['title_dept_company'])) {
					$contentSchema .= ', "jobTitle": "' . $content['Author']['title_dept_company'] . '"';
				}
				if(!empty($content['Author']['degrees'])) {
					$contentSchema .= ', "honorificSuffix": "' . $content['Author']['degrees'] . '"';
				}
				if(!empty($content['Author']['company'])) {
					$contentSchema .= ', "worksFor": "' . $content['Author']['company'] . '",
					"affiliation": "' . $content['Author']['company'] . '"';
				}
				if(!empty($content['Author']['url'])) {
					$contentSchema .= ', "url": "https://' . $_SERVER['HTTP_HOST'] . $content['Author']['url'] . '"';
				}
			$contentSchema .= '},';
		}*/
		/*$contentSchema .= '"publisher": {
			"@type": "Organization",
			"name": "' . /* //*** TODO: uncomment when Configure is built out *** Configure::read('siteName') . '",
			"url": "https://' . $_SERVER['HTTP_HOST'] . '", ';
			if (isset($sameAsSocialLinks)){
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
				"url": "https://www.' . /* //*** TODO: uncomment when Configure is built out *** Configure::read('siteUrl') . '/img/hh-symbol.png",
				"width": "400px",
				"height": "400px"
			}
		}
	}</script>'*/;

//echo $contentSchema;
 
$this->Html->script('dist/content.min', ['block' => true]);
?>

<?= $this->element('schema/person', ['author' => $content->primary_author]) ?>

<?= $this->element('side_panel') ?>

<span style="display:none;" id="is-preview"><?php echo $isPreview; ?></span>
<div class="col-md-9" style="min-height:100vh">
	<article class="panel">
		<table class="print-wrapper">
			<thead class="print-head">
				<tr>
					<td>
						<img src="<?php  //*** TODO: uncomment when Configure is built out ***echo Configure::read('logo'); ?>" alt="<?php  //*** uncomment when Configure is built out ***echo Configure::read('siteName'); ?>" class="print-logo" width="200" height="40">
						<p class="print-link"><?php  //*** uncomment when Configure is built out ***echo "www.".Configure::read('siteUrl'); ?></p>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="panel-body">
							<div class="panel-section expanded">
								<?php
									//if ($isadmin) {
									    //*** TODO: uncomment when Content is built out ***echo $this->Content->adminLink();
									//}
								?>
								<h1 class="text-primary blog-title<?php if(isset($subtitle)){ echo " mb10"; } ?>"><?= $content->title ?></h1>
								<?php if(isset($subtitle)) : ?>
									<h2 class="text-primary mt0 mb30"><?= $content->subtitle ?></h2>
								<?php endif; ?>
								<p class="blog-byline text-caption">
									<?php //*** TODO: uncomment when Content is built out ***if ($author = $this->Content->author($content, ['schema' => false, 'date' => true, 'format' => DateTime::ATOM, 'local_anchor' => true, 'dateNewLine' => true])): ?>
										<em>Contributed by <?= $content->primary_author ?></em>
									<?php //else: ?>
										<span><?= $content->modified ?></span>
									<?php //endif; ?>
								</p>
								<div id="content_body" class="content-body">
									<?= $content->body ?>
								</div>
								<?= $this->Editorial->getAuthorsByline($content->primary_author, $content->contributors) ?>
								<div class="blog-categories noprint mt30">
									<?php //*** TODO: uncomment when related_help_pages is built out ***echo $this->element('content/related_help_pages'); ?>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php //*** TODO: uncomment when content/share is built out ***echo $this->element('content/share'); ?>
		
	</article>
</div>