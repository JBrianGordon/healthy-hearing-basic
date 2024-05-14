<?php
	$crumbs = $this->Breadcrumbs->getCrumbs();
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 	$schemeDomain = $protocol . $_SERVER['HTTP_HOST'];
	echo '<script type="application/ld+json">{';
		echo '"@context": "https://schema.org",';
		echo '"@type": "BreadcrumbList",';
		echo '"itemListElement": [';
			foreach ($crumbs as $key => $crumb) {
				$url = $this->Url->build($crumb['url']);
				$fullUrl = $schemeDomain.$url;
				$name = $crumb['title'];
				if($key + 1 >= count($crumbs)){
					$liComma =  '';
					$fullUrl = $schemeDomain . $_SERVER['REQUEST_URI'];
				} else {
					$liComma = ',';
				}
				echo '{"@type": "ListItem", "position": "' . ($key + 1) . '", "name": "' .$name. '", "item": "' .$fullUrl. '"}' . $liComma;
			}
		echo ']';
	echo '}</script>';
?>