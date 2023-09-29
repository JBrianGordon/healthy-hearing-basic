<?php
use Cake\Routing\Router;
//*** TODO: Do we still need this file? ***/
$crumb_options = ['escape'=>false];
$class = isset($class) ? $class : 'col-sm-12 col-xs-9';
$this->Html->addCrumb('<span>Home</span>', '/', $crumb_options);
$crumbs = isset($crumbs) ? $crumbs : $this->Html->getCrumbsArray();
$print = isset($print) ? $print : $this->Html->showPrint();
if (isset($crumbs['Dist. of Columbia'])) {
	// Don't link to DC state page
	$crumbs['Dist. of Columbia'] = [];
}
if (!empty($crumbs)) {
	foreach($crumbs as $label => $url) {
		$label = str_replace("+",'',$label);
		$label = '<span>'.$label.'</span>';
		if (empty($url)) {
			$url = $this->getRequest()->getUri()->getPath();
		}
		$this->Html->addCrumb($label, $url, $crumb_options);
	}
} elseif ($this->Paginator->current() != 1) { //Handle pagination.
	$current = $this->Paginator->current();
	$title_parts = explode("|", $title_for_layout);
	$new_title = array_pop($title_parts);
	$new_title = '<span>'.trim($new_title).'</span>';
	$this->Html->addCrumb($new_title, str_replace("/page:$current", "", $this->getRequest()->getUri()->getPath()), $crumb_options);
	// Don't link to this page
	$page_title = '<span>Page '.$current.'</span>';
	$this->Html->addCrumb($page_title, null, $crumb_options);
} else {
	$title_for_layout = '<span>'.$title_for_layout.'</span>';
	$this->Html->addCrumb($title_for_layout, $this->getRequest()->getUri()->getPath(), $crumb_options);
}
?>
<div class="row noprint">
	<div class="<?= $class ?>">
		<ul class="breadcrumb">
			<?php
			$crumbsList = explode('&raquo;', $this->Html->getCrumbs());
			foreach ($crumbsList as $key => $crumb) {
				echo '<li>';
				echo $crumb;
				echo '</li>';
			}
			echo '<script type="application/ld+json">{';
				echo '"@context": "https://schema.org",';
				echo '"@type": "BreadcrumbList",';
				echo '"itemListElement": [';
					foreach ($crumbsList as $key => $crumb) {
						$url = explode('href="',$crumb);
						$link = explode('">',$url[1]);
						$fullUrl = Router::url($link[0], true);
						$name = htmlentities(strip_tags($crumb));
						if($key + 1 >= count($crumbsList)){
							$liComma =  '';
						} else {
							$liComma = ',';
						}
						echo '{"@type": "ListItem", "position": "' . ($key + 1) . '", "name": "' .$name. '", "item": "' .$fullUrl. '"}' . $liComma;
					}
				echo ']';
			echo '}</script>';
			?>
		</ul>
		<div id="ellipses">...</div>
	</div>
	<?php if ($print): ?>
		<div class="col-sm-3 text-right text-xs-left inverse">
		  <a href="?print=on" class="print-link"><span class="icon hh-icon-printer"></span>Print this page</a>
		</div>
	<?php endif; ?>
</div>
