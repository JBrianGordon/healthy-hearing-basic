<?php
use Cake\Routing\Router;

if (isset($wiki)) {
	$description = empty($wiki->facebook_description) ? '' : $wiki->facebook_description;
	$image = empty($wiki->facebook_image) ? '/img/hh-symbol.png' : $wiki->facebook_image;
} elseif (isset($content)) {
	$description = empty($content->facebook_description) ? '' : $content->facebook_description;
	$image = empty($content->facebook_image) ? '/img/hh-symbol.png' : $content->facebook_image;
} else {
	$description = '';
	$image = '/img/hh-symbol.png';
}

$currentUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$encodedUrl = urlencode($currentUrl);
$image = Router::url($image, true);
?>
<footer class="panel-footer text-center btn-set noprint">
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v22.0"></script>
	<div id="fbBtn" class="btn btn-share btn-facebook fb-share-btn ml0" data-href="https://developers.facebook.com/docs/plugins/" data-layout="" data-size="">
		<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= $encodedUrl ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">
			<span class="hh-icon-facebook"></span> Share
		</a>
	</div>
	<a href="https://x.com/intent/tweet?url=<?= $encodedUrl ?>" class="btn btn-share btn-twitter twitter-share-button ml15" id="twitter-wjs" target="_blank" rel="noopener"><span class="hh-icon-x"></span> Tweet</a>
	<!-- LinkedIN JS -->
	<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
	<script type="IN/Share" data-url="<?= $encodedUrl ?>"></script>
	<a href="https://www.pinterest.com/pin/create/button/?media=<?= $image ?>&amp;url=<?= $encodedUrl ?>&amp;description=<?= $description ?>" class="btn btn-share btn-pinterest" target="_blank" rel="noopener">
		<span class="hh-icon-pinterest"></span> Pin
	</a>
	<button class="btn btn-print btn-light noprint ml15" onclick="window.print()"><span class="icon hh-icon-printer"></span> Print</button>
	<!-- Pinterest button JS -->
	<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js" data-pin-custom="true"></script>
</footer>