<?php
/**
* Renders an Advertisement
*/
if (isset($ad) && !empty($ad) && pluckIsValid($ad,'Ad/id') && $show_ad) {
	$id = pluckValid($ad,'Ad/id');
	$type = pluckValid($ad,'Ad/type');
	$alt = (pluckValid($ad,'Ad/alt') ? pluckValid($ad,'Ad/alt') : 'hearing aids');
	$h = pluckValid($ad,'Ad/height');
	if (strpos($h,'%')===false && strpos($h,'px')===false) {
		$h = $h.'px';
	}
	$w = pluckValid($ad,'Ad/width');
	if (strpos($w,'%')===false && strpos($w,'px')===false) {
		$w = $w.'px';
	}
	# -----------------------------------------------------------
	# -- add tracking information for this ad
	// look at actual source
	$src = pluckValid($ad,'/Ad/src');
	$dest = pluckValid($ad,'/Ad/dest');
	// make passthrough - desc & src
	$dest = '/ads/click/'.$id;
	// IMG
	echo ''.
	'<section id="adPanel" class="panel mb0">'.
		'<a href="'.$dest.'" rel="sponsored nofollow noopener" class="img-responsive" title="'.$alt.'" id="adBlock" target="_blank">'.
			'<img id="adImage" '.($this->Js->isMobileDevice()?'loading="lazy" src="'.$src.'"':'src="'.$src.'"').' data-value="ViewBanner_'.$id.'" alt="'.$alt.'" border="0" '.
				($w ? 'width="'.$w.'" ' : '').
				($h ? 'height="'.$h.'" ' : '').
				'/>'.
		'</a>'.
		'<label for="adBlock" class="pull-right mb20"><i>Advertisement</i></label>'.
	'</section>'.
	'';
}
