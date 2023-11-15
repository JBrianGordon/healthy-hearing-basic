<?php
/**
* Renders an Advertisement
*/
if (!empty($ad->id) && $show_ad) {
	$id = $ad->id;
	$type = $ad->type;
	$alt = (!empty($ad->alt) ? $ad->alt : 'hearing aids');
	$h = $ad->height;
	if (strpos($h,'%')===false && strpos($h,'px')===false) {
		$h = $h.'px';
	}
	$w = $ad->width;
	if (strpos($w,'%')===false && strpos($w,'px')===false) {
		$w = $w.'px';
	}
	# -----------------------------------------------------------
	# -- add tracking information for this ad
	// look at actual source
	$src = $ad->src;
	$dest = $ad->dest;
	// make passthrough - desc & src
	$dest = '/ads/click/'.$id;
	// Order
	if((!empty($wiki) || !empty($content) || !empty($corp) || !empty($stateNice) || !empty($corps)  || !empty($page)) && !$isMobileDevice){
		$adOrder = '7';
	} else if ((!empty($wiki) || !empty($content) || !empty($corp) || !empty($stateNice) || !empty($corps)) && $isMobileDevice){
		$adOrder = '1';
	} else {
		$adOrder = '11';
	}
	// IMG
	echo ''.
	'<section id="adPanel" class="panel mb0" style="order:'.$adOrder.'">'.
		'<a href="'.$dest.'" rel="sponsored nofollow noopener" class="img-responsive" title="'.$alt.'" id="adBlock" target="_blank">'.
			'<img id="adImage" '.($isMobileDevice?'loading="lazy" src="'.$src.'"':'src="'.$src.'"').' data-value="ViewBanner_'.$id.'" alt="'.$alt.'" border="0" '.
				($w ? 'width="'.$w.'" ' : '').
				($h ? 'height="'.$h.'" ' : '').
				'/>'.
		'</a>'.
		'<label for="adBlock" class="pull-right mb20"><i>Advertisement</i></label>'.
	'</section>'.
	'';
}
