<?php
/**
* Renders an Advertisement
*/
if (!empty($ad->id) && $show_ad) {
	$id = $ad->id;
	$alt = (!empty($ad->alt) ? $ad->alt : 'hearing aids');
	// look at actual source
	$src = $ad->public_url;
	$dest = $ad->dest;
	// IMG
	echo ''.
	'<section id="adPanel" class="panel mb0" style="order:7">'.
		'<a href="'.$dest.'" rel="sponsored nofollow noopener" class="img-responsive" title="'.$alt.'" id="adBlock" target="_blank">'.
			'<img id="adImage" '.($isMobileDevice?'loading="lazy" src="'.$src.'"':'src="'.$src.'"').' data-value="ViewBanner_'.$id.'" alt="'.$alt.'" border="0" width="265" height="265"/>'.
		'</a>'.
		'<label for="adBlock" class="pull-right mb20"><i>Advertisement</i></label>'.
	'</section>'.
	'';
}
